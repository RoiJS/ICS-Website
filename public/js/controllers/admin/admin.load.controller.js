app.controller('adminLoadController', [
    '$scope',
    '$timeout',
    'adminLoadService',
    'adminFacultyService',
    'adminCoursesService',
    'adminSubjectsService',
    'adminCurriculumService',
    'adminSemestersService',
    'adminSchoolYearService',

    function ($scope,
        $timeout,
        adminLoadService,
        adminFacultyService,
        adminCoursesService,
        adminSubjectsService,
        adminCurriculumService,
        adminSemestersService,
        adminSchoolYearService
    ) {

        var systemHelper = $scope.systemHelper;
        var dialogHelper = $scope.dialogHelper;
        var datetimeHelper = $scope.datetimeHelper;
        var activityLogHelper = $scope.activityLogHelper;
        var notificationHelper = $scope.notificationHelper;

        var semester_id = null,
            school_year_id = null,
            faculty_id = null;

        $scope.load = {
            selected_faculty: null,
            selected_course: null,
            selected_curriculum_school_year: null,
            selected_curriculum_subject: null
        }

        $scope.status = {
            is_subject_set: false,
            subject_loading: false,
            has_curriculum_subjects: false,
            is_subject_sort: false
        }

        $scope.faculties = [];
        $scope.courses = [];
        // $scope.curriculum_school_years = [];
        $scope.curriculum_years = [];
        $scope.curriculum_subjects = [];
        $scope.c_sem = 'Loading...';
        $scope.c_sy = 'Loading...';

        $scope.faculty_subjects = [];
        $scope.sections = [];

        displaySections = () => {
            adminLoadService.getSections().then((res) => {
                $scope.sections = res.data.sections;
            });
        }

        displayFaculties = () => {
            adminFacultyService.getFaculty().then((res) => {
                $scope.faculties = res.data.faculties;
            })
        }

        displayCourses = () => {
            adminCoursesService.getCourses().then((res) => {
                $scope.courses = res.data.courses;
            });
        }

        displayCurriculumSubjects = (course, curriculum_year, semester) => {
            $scope.status.is_subject_sort = true;
            adminCurriculumService.getCurriculumSubjects(course, curriculum_year, null, semester).then((curriculum_subjects) => {
                $scope.curriculum_subjects = curriculum_subjects;

                $scope.curriculum_subjects.map(cs => {
                    cs.subject_details = `${cs.subject_code}-${cs.subject_description} (${cs.year_level_name} year)`;
                    cs.subject_details_id = `${cs.curriculum_subject_id}-${cs.subject_id}`;
                });

                $scope.status.is_subject_sort = false;
            });
        }

        displayCurriculumYears = () => {
            adminCurriculumService.getCurriculumYears().then((curriculum_years) => {
                $scope.curriculum_years = curriculum_years;
            });
        }

        displayCurrentSemester = () => {
            adminSemestersService.getCurrentSemester().then((res) => {
                semester_id = res.data.current_semester.semester_id;
                $scope.c_sem = res.data.current_semester.semester;
            });
        }

        displayCurrentSchoolYear = () => {
            adminSchoolYearService.getCurrentSchoolYear().then((res) => {
                school_year_id = res.data.current_school_year.school_year_id;
                $scope.c_sy = `${res.data.current_school_year.sy_from} -  ${res.data.current_school_year.sy_to}`;
            });
        }

        /**
         * Display list of subjects based on the given parameters
         * @param {number} faculty_id Id of the selected faculty
         * @param {number} semester_id Id of the current semester
         * @param {number} school_year_id Id of the current school year
         * @return {void}
         */
        displayFacultySubjects = (faculty_id, semester_id, school_year_id) => {

            // Set to true indicating that the loading of faculty subjects is still on the process before rendering it to the user
            $scope.status.subject_loading = true;

            // Set to true indicating that the user clicked the "Set" button, meaning the user started querying list of subjects
            $scope.status.is_subject_set = true;

            adminLoadService.getFacultyLoad(faculty_id, semester_id, school_year_id).then((faculty_subjects) => {
                convertSubjectsTime(faculty_subjects);
                setSubjectOpenEditor(faculty_subjects);
                $scope.status.subject_loading = false;
                $scope.status.has_curriculum_subjects = !!$scope.faculty_subjects.length;

                $scope.faculty_subjects.map(s => {
                    s.day_schedule = displayDays(s);
                    s.subject_start_time = datetimeHelper.timeToString(s.start_time);
                    s.subject_end_time = datetimeHelper.timeToString(s.end_time);
                });

                systemHelper.scrollToView("box-subject-list");
            });
        }

        /**
         * Converts subject start and end time to javascript Date Object
         * @param {Array<FacultySubject>} subjects List of faculty subjects 
         * @returns {void}
         */
        convertSubjectsTime = (subjects) => {
            subjects.map((subject) => {
                subject.edit = !!!subject.section;
                if (subject.start_time && subject.end_time) {
                    subject.start_time = datetimeHelper.timeParseReverse(subject.start_time);
                    subject.end_time = datetimeHelper.timeParseReverse(subject.end_time);
                }
            });
        }

        /**
         * Sort list of faculty subjects based on the "edit" property. 
         * Subject/s which contains true value on "edit" property must displayed at the top of the list
         * @param {Array<FacultySubject>} subjects List of faculty subjects 
         * @returns {void} 
         */
        setSubjectOpenEditor = (subjects) => {

            // Set to empty array
            $scope.faculty_subjects = [];

            subjects.forEach((subject) => {
                if (subject.edit) {
                    $scope.faculty_subjects.push(subject);
                }
            });

            subjects.forEach((subject) => {
                if (!subject.edit) {
                    $scope.faculty_subjects.push(subject);
                }
            });

        }

        verifyIfSubjectAlreadyExists = function (subject_id) {
            return new Promise((resolve) => {
                isExists = false;
                $scope.faculty_subjects.forEach(subject => {
                    if (subject_id === subject.subject_id) {
                        isExists = true;
                    }
                });
                resolve(isExists);
            });
        }

        displayCurrentSemester();
        displayCurrentSchoolYear();

        displaySections();
        displayFaculties();
        displayCourses();
        displayCurriculumYears();

        /**
         * Calls Api that gets list of subjects based on selected faculty, current semester and current school year
         * @returns void
         */
        $scope.setFacultyLoad = () => {
            if (validateSetFacultyLoad()) {
                faculty_id = parseInt($("#faculty").val());
                displayFacultySubjects(faculty_id, semester_id, school_year_id);
            }
        }

        $scope.sortSubject = () => {

            var course = {
                course_id: parseInt($("#course").val())
            };
            var curriculum_year = parseInt($("#curriculum_school_year").val())

            var semester = {
                semester_id
            };

            if (course.course_id && curriculum_year) {
                displayCurriculumSubjects(course, curriculum_year, semester);
            }
        }

        $scope.resetFacultySubjects = () => {

            $scope.status.is_subject_set = false;
            $scope.faculty_subjects = [];

            $elemFacultyControl = $("#faculty");
            $elemCurriculumSchoolYear = $("#curriculum_school_year");
            $elemCourse = $("#course");
            $elemSubjects = $("#subjects");

            $selectFacultyControl = $elemFacultyControl.data("select2");
            $selectCurriculumSchoolYearControl = $elemCurriculumSchoolYear.data("select2");
            $selectCourseControl = $elemCourse.data("select2");
            $selectSubjectsControl = $elemSubjects.data("select2");

            $selectFacultyControl.val('0');
            $selectCurriculumSchoolYearControl.val('0');
            $selectCourseControl.val('0');
            $selectSubjectsControl.val('0');

            systemHelper.removeInvalidControlTemplate($elemFacultyControl.next());
            systemHelper.removeInvalidControlTemplate($elemCurriculumSchoolYear.next());
            systemHelper.removeInvalidControlTemplate($elemCourse.next());
            systemHelper.removeInvalidControlTemplate($elemSubjects.next());
        }

        /**
         * TODO:
         *  (1) Extract static strings
         */
        $scope.saveNewFacultySubject = () => {

            if (validateSetFacultyLoad()) {
                validateSetSubjectFilterSettings().then(result => {
                    if (result) {

                        var faculty_id = parseInt($("#faculty").val());
                        var course_id = parseInt($("#course").val());
                        var subject_details_id = $("#subjects").val().split("-");
                        var curriculum_subject_id = parseInt(subject_details_id[0]);
                        var subject_id = parseInt(subject_details_id[1]);

                        // verifyIfSubjectAlreadyExists(subject_id).then((result) => {
                        //     if (!result) {

                        var title = 'Add selected subject';
                        var message = 'Are you sure to add this subject to the faculty loading list?';

                        dialogHelper.showConfirmation(title, message, (result) => {
                            if (result) {
                                adminLoadService.saveNewFacultySubject({
                                    faculty_id,
                                    semester_id,
                                    school_year_id,
                                    course_id,
                                    subject_id,
                                    curriculum_subject_id,
                                }).then((data) => {
                                    if (data.status === true) {

                                        notificationHelper.registerNotification(getAddSubjectNotificationObject(data.classId)).then(status => {
                                            activityLogHelper.registerActivity(getAddSubjectActivityLogDescription()).then(status => {
                                                if (status) {
                                                    displayFacultySubjects(faculty_id, semester_id, school_year_id);
                                                }
                                            });
                                        });
                                    }
                                })
                            }
                        });
                        // } else {
                        //     dialogHelper.showError('Add new subject failed', 'Selected subject already exists in the list. Please select other subject.');
                        // }
                        // });
                    }
                });
            } else {
                dialogHelper.showError('No selected instructor', 'Please select instructor from the above list first before adding subject.');
            }
        }

        displayDays = (subject) => {
            var days = [];

            if (subject.monday) {
                days.push("Mon");
            }

            if (subject.tuesday) {
                days.push("Tue");
            }

            if (subject.wednesday) {
                days.push("Wed");
            }

            if (subject.thursday) {
                days.push("Thu");
            }

            if (subject.friday) {
                days.push("Fri");
            }

            if (subject.saturday) {
                days.push("Sat");
            }

            return days.join().toString().replace(/,/g, ", ").toString();
        }

        /**
         * Calls Api for saving or updating faculty subject information
         * @param {int} index position of the subject information to be saved or update from the list faculty subjects  
         * @returns {void}
         * 
         * TODO:
         *  (1) Extract static strings
         */
        $scope.saveUpdateFacultySubject = (index) => {

            // Faculty subject object based from the index
            var subject = $scope.faculty_subjects[index];

            if (chekSubjectInfo(subject)) {
                adminLoadService.verifyIfSubjectExistFromOtherFaculty(faculty_id, subject.curriculum_subject_id, subject.section).then((result) => {
                    if (result && !result.length) {

                        var title = 'Add new subject';
                        var message = 'Are you sure to save changes?';

                        dialogHelper.showConfirmation(title, message, (result) => {
                            if (result) {
                                var start_time = datetimeHelper.timeParse(subject.start_time, true);
                                var end_time = datetimeHelper.timeParse(subject.end_time, true);
                                subject._new_start_time = start_time;
                                subject._new_end_time = end_time;

                                adminLoadService.saveUpdateFacultySubject(subject).then((status) => {
                                    if (status) {
                                        activityLogHelper.registerActivity(getUpdateSubjectActivityLogDescription(index)).then(status => {
                                            if (status) {
                                                displayFacultySubjects(faculty_id, semester_id, school_year_id);
                                            }
                                        });
                                    }
                                });
                            }
                        });
                    } else {
                        dialogHelper.showError(
                            'Failed to add subject',
                            `This subject under section ${subject.section} has already been assigned to other faculty. Please enter other section.`,
                            () => {
                                displayFacultySubjects(faculty_id, semester_id, school_year_id);
                            });
                    }
                });
            } else {
                dialogHelper.showError('Incomplete information', 'Please complete the load information.');
            }
        }

        /**
         * Checks subject information if they are all filled out
         * @param {FacultySubject} subject Faculty subject object
         * @returns {boolean} Results based on the evaluation
         */
        chekSubjectInfo = (subject) => {
            return !!(
                subject.section &&
                (
                    subject.monday ||
                    subject.tuesday ||
                    subject.wednesday ||
                    subject.thursday ||
                    subject.friday ||
                    subject.saturday
                ) &&
                subject.start_time &&
                subject.end_time &&
                subject.room
            );
        }

        /**
         * TODO:
         *  (1) Extract static strings
         */
        $scope.removeFacultySubject = (index) => {
            var id = $scope.faculty_subjects[index].load_id;

            var title = 'Remove subject';
            var message = 'Are you sure to remove selected subject from the list?';

            dialogHelper.showConfirmation(title, message, function (result) {
                if (result) {
                    adminLoadService.removeFacultySubject(id).then((res) => {
                        if (res.data.status === 1) {
                            activityLogHelper.registerActivity(getRemoveSubjectActivityLogDescription(index)).then(status => {
                                if (status) {
                                    notificationHelper.registerNotification(getRemoveSubjectNotificationObject(index)).then(status => {
                                        displayFacultySubjects(faculty_id, semester_id, school_year_id);
                                    });
                                }
                            });
                        }
                    });
                }
            });
        }

        /**
         * Validates faculty load set up
         * @return {boolean}
         * 
         * TODO: 
         *  (1) Extract static strings
         */
        validateSetFacultyLoad = () => {

            var $facultyControl = $("#faculty");

            var facultyValue = $facultyControl.val();

            facultyValue = facultyValue !== "?" ? parseInt(facultyValue) : "";

            if (!facultyValue) {
                systemHelper.removeInvalidControlTemplate($facultyControl.next());
                systemHelper.addInvalidControlProps($facultyControl.next(), 'Please select faculty from the list.');
            } else {
                systemHelper.removeInvalidControlTemplate($facultyControl.next(), 'Please select faculty from the list.');
            }

            return (facultyValue);
        }

        /**
         * TODO:
         *  (2) Extract static strings
         */
        validateSetSubjectFilterSettings = () => {

            return new Promise((resolve) => {

                var $curriculumSchoolYearControl = $("#curriculum_school_year");
                var $courseControl = $("#course");
                var $subjectControl = $("#subjects");

                var curriculumSchoolYearValue = systemHelper.getSelectControlValue($curriculumSchoolYearControl); // (1)
                var courseValue = systemHelper.getSelectControlValue($courseControl);
                var subjectValue = systemHelper.getSelectControlValue($subjectControl);

                if (!curriculumSchoolYearValue) {
                    systemHelper.removeInvalidControlTemplate($curriculumSchoolYearControl.next());
                    systemHelper.addInvalidControlProps($curriculumSchoolYearControl.next(), 'No school year curriculum.');
                } else {
                    systemHelper.removeInvalidControlTemplate($curriculumSchoolYearControl.next(), 'No school year curriculum.');
                }

                if (!courseValue) {
                    systemHelper.removeInvalidControlTemplate($courseControl.next());
                    systemHelper.addInvalidControlProps($courseControl.next(), 'No course selected.');
                } else {
                    systemHelper.removeInvalidControlTemplate($courseControl.next(), 'No course selected.');
                }

                if (!subjectValue) {
                    systemHelper.removeInvalidControlTemplate($subjectControl.next());
                    systemHelper.addInvalidControlProps($subjectControl.next(), 'No subject selected.');
                } else {
                    systemHelper.removeInvalidControlTemplate($subjectControl.next(), 'No subject selected.');
                }

                resolve(!!(curriculumSchoolYearValue && courseValue && subjectValue));
            })
        }

        getAddSubjectActivityLogDescription = () => {
            var faculty_name = $("#faculty").next().find("span#select2-faculty-container").text() || "";
            var subject_name = $("#subjects").next().find("span#select2-subjects-container").text() || "";

            return `Faculty Load: Assigned new subject ${subject_name} to ${faculty_name}`;
        }

        getUpdateSubjectActivityLogDescription = (index) => {

            var faculty_name = $("#faculty").next().find("span#select2-faculty-container").text() || "";
            var subject_name = $("#subject-" + index).find("td.subject-name").text() || "";
            var subject_code = $("#subject-" + index).find("td.subject-code").text() || "";

            return `Faculty Load: Update class details of subject ${subject_code}-${subject_name} which is assigned to ${faculty_name}.`;
        }

        getAddSubjectNotificationObject = (classId) => {

            var faculty_id = parseInt($("#faculty").val());
            var subject_name = $("#subjects").next().find("span#select2-subjects-container").text() || "";
            var path = notificationHelper.notificationPaths.teacherClass(classId);
            var description = `Assigned you as intructor to class ${subject_name}`;

            return {
                notify_to: faculty_id,
                notify_to_user_type: 'teacher',
                description: description,
                path: path,
            };
        }

        getRemoveSubjectActivityLogDescription = (index) => {

            var faculty_name = $("#faculty").next().find("span#select2-faculty-container").text() || "";
            var subject_name = $("#subject-" + index).find("td.subject-name").text() || "";
            var subject_code = $("#subject-" + index).find("td.subject-code").text() || "";

            return `Faculty Load: Remove subject ${subject_code}-${subject_name} which is assigned to ${faculty_name}.`;
        }

        getRemoveSubjectNotificationObject = (index) => {

            var faculty_id = parseInt($("#faculty").val());
            var subject_name = $("#subject-" + index).find("td.subject-name").text() || "";
            var subject_code = $("#subject-" + index).find("td.subject-code").text() || "";
            var path = notificationHelper.notificationPaths.teacherHome();
            var description = `Removed you as instructor from class ${subject_code}-${subject_name}`;

            return {
                notify_to: faculty_id,
                notify_to_user_type: 'teacher',
                description: description,
                path: path,
            };
        }
    }
]);