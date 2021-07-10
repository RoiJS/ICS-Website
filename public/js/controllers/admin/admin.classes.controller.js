app.controller('adminClassesController', [
    '$scope',
    'adminClassesService',
    'adminCoursesService',
    'adminCurriculumService',
    'adminSubjectsService',
    'adminSemestersService',
    'adminSchoolYearService',
    'adminLoadService',
    'adminStudentsService',
    function ($scope, adminClassesService, adminCoursesService, adminCurriculumService, adminSubjectsService, adminSemestersService, adminSchoolYearService, adminLoadService, adminStudentsService) {

        var dataTableHelper = $scope.dataTableHelper;
        var systemHelper = $scope.systemHelper;
        var dialogHelper = $scope.dialogHelper;
        var datetimeHelper = $scope.datetimeHelper;
        var userHelper = $scope.userHelper;
        var activityLogHelper = $scope.activityLogHelper;
        var notificationHelper = $scope.notificationHelper;

        var semester_id = null,
            school_year_id = null,
            faculy_id = null;

        $scope.tableOfficialClassList = null;

        $scope.status = {

            is_subject_sort: false,

            is_class_detail_set: false,
            details_loading: false,
            has_details: null,

            students_loading: false,
            has_students: null,

            official_student_loading: false,
            has_official_list: null
        };

        $scope.courses = [];
        $scope.curriculum_school_year = [];
        $scope.curriculum_subjects = [];
        $scope.c_sem = 'Loading...';
        $scope.c_sy = 'Loading...';
        $scope.sections = [];
        $scope.students_list_options = [];
        $scope.students = [];
        $scope.class_students = [];
        $scope.class_details = {};
        $scope.official_student_list = [];

        $scope.class = {
            course: null,
            curriculum_school_year: null,
            subject: null,
            student: null,
            section: null
        }

        /**
         * GENERAL TODO: 
         *  (1) Simplify return value from service promise methods
         */
        displaySections = () => {
            adminClassesService.getSections().then((res) => {
                $scope.sections = res.data.sections;
            });
        }

        displayCourses = () => {
            adminCoursesService.getCourses().then((res) => {
                $scope.courses = res.data.courses;
            });
        }

        displayCurriculumYears = () => {
            adminCurriculumService.getCurriculumYears().then((curriculum_years) => {
                $scope.curriculum_years = curriculum_years;
            });
        }

        displayCurriculumSubjects = (course, school_year, semester) => {
            $scope.status.is_subject_sort = true;
            adminCurriculumService.getCurriculumSubjects(course, school_year, null, semester).then((curriculum_subjects) => {
                $scope.status.is_subject_sort = false;
                $scope.curriculum_subjects = curriculum_subjects;

                $scope.curriculum_subjects.map(cs => {
                    cs.subject_details = `${cs.subject_code}-${cs.subject_description} (${cs.year_level_name} year)`;
                    cs.subject_details_id = `${cs.curriculum_subject_id}-${cs.subject_id}`;
                });
            })
        }

        /**
         * Display overall student list
         * @param {int} student_id Id of the student (used when filtering the list)
         * @returns {void}
         */
        displayStudents = (student_id) => {
            $scope.status.students_loading = true;

            adminStudentsService.getStudents(student_id).then((students) => {
                $scope.status.students_loading = false;
                $scope.students = students;
                $scope.status.has_students = !!$scope.students.length;

                systemHelper.scrollToView("details-panel");
            });
        }

        /**
         * Get overall student list
         * @returns {void}
         */
        getOverallStudentListOptions = (curriculum_year) => {
            adminStudentsService.getStudents(null, curriculum_year).then((students) => {
                $scope.students_list_options = students;
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
         * Display class details like the assigned faculty and the list of students
         * @param {int} course_id Id of the selected course
         * @param {int} subject_id Id of the selected subject
         * @param {int} semester_id Id of the current semester
         * @param {int} school_year_id Id of the current school year
         * @param {string} section Section
         * @returns {void}
         */
        setClassDetails = (course_id, curriculum_subject_id, semester_id, school_year_id, section, curriculum_year) => {
            $scope.status.details_loading = true;

            adminClassesService.setClassDetails({
                course_id,
                curriculum_subject_id,
                semester_id,
                school_year_id,
                section
            }).then((class_details) => {

                $scope.status.details_loading = false;
                $scope.status.is_class_detail_set = true;
                $scope.class_details = class_details;

                if ($scope.class_details) {
                    // Set teacher fullname
                    $scope.class_details.teacher_fullname = userHelper.getPersonFullname(class_details);

                    // Set class days schedule
                    $scope.class_details.days_schedule = displayDays($scope.class_details);

                    // Set class time schedule
                    $scope.class_details.start_time = datetimeHelper.timeParseReverse($scope.class_details.start_time);
                    $scope.class_details.end_time = datetimeHelper.timeParseReverse($scope.class_details.end_time);
                    $scope.class_details.time_schedule = `${datetimeHelper.timeParse($scope.class_details.start_time)} - ${datetimeHelper.timeParse($scope.class_details.end_time)}`;

                    getOverallStudentListOptions(curriculum_year);
                    displayStudents();
                    displayClassList($scope.class_details.class_id);
                }
            });
        }

        displayClassList = (class_id) => {
            $scope.status.official_student_loading = true;
            adminClassesService.getOfficialClassList(class_id).then((res) => {
                $scope.status.official_student_loading = false;
                $scope.official_student_list = res.data.class_list;
                $scope.status.has_official_list = !!$scope.official_student_list.length;

                $scope.official_student_list.map((s) => {
                    s.fullname = userHelper.getPersonFullname(s);
                });

                $scope.tableOfficialClassList = dataTableHelper.initializeDataTable({}, {
                    dataset: $scope.official_student_list
                });
            });
        }

        /**
         * Verify if Course, Curriculum, Subject & Section fields are empty or not
         * @returns {boolean} Returns true if all fields has value, otherwise false.
         * 
         * 
         * TODO:
         *  (1) Extract static string 
         */
        validateClassDetailsOptions = () => {

            var $courseControl = $("#course");
            var $curriculumSchoolYearControl = $("#curriculum_school_year");
            var $subjectControl = $("#subject");
            var $sectionControl = $("#section");

            var course_id = parseInt($courseControl.val());
            var curriculum_school_year = parseInt($curriculumSchoolYearControl.val());
            var subject_id = parseInt($subjectControl.val());


            var section = systemHelper.getSelectControlValue($sectionControl);

            if (!course_id) {
                systemHelper.removeInvalidControlTemplate($courseControl.next());
                systemHelper.addInvalidControlProps($courseControl.next(), "Empty course field."); // (2)
            } else {
                systemHelper.removeInvalidControlTemplate($courseControl.next());
            }

            if (!curriculum_school_year) {
                systemHelper.removeInvalidControlTemplate($curriculumSchoolYearControl.next());
                systemHelper.addInvalidControlProps($curriculumSchoolYearControl.next(), "Empty Curriculum field."); // (2)
            } else {
                systemHelper.removeInvalidControlTemplate($curriculumSchoolYearControl.next());
            }

            if (!subject_id) {
                systemHelper.removeInvalidControlTemplate($subjectControl.next());
                systemHelper.addInvalidControlProps($subjectControl.next(), "Empty subject field."); // (2)
            } else {
                systemHelper.removeInvalidControlTemplate($subjectControl.next());
            }

            if (!section) {
                systemHelper.removeInvalidControlTemplate($sectionControl.next());
                systemHelper.addInvalidControlProps($sectionControl.next(), "Empty section field."); // (2)
            } else {
                systemHelper.removeInvalidControlTemplate($sectionControl.next());
            }

            return (course_id && curriculum_school_year && subject_id && section);
        }

        /**
         * Validates if selected student is already on the official student list of the class
         * @returns {boolean} If returned true, student is already on the list, otherwise student doesn't exists.
         */
        validateIfStudentIsOnClassList = (student_id) => {

            var result = false;
            var table = $('table#tbl-official-student-list');
            var tableRows = table.find('tbody tr');

            $.each(tableRows, (idx, row) => {
                var currentStudentId = $($(row).find('td')[0]).text();

                if (student_id === currentStudentId) {
                    result = true;
                }
            });

            return result;
        }

        /**
         * Sort student list
         * @param {*} e Select control from the interface
         * @returns {void}
         */
        sortOverallStudentList = (e) => {
            var studentId = e.value;
            displayStudents(studentId);
        }

        sortSubject = () => {
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

        $scope.setClassDetails = () => {

            var course_id = parseInt($("#course").val());
            var subject_details_id = $("#subject").val().split(",");
            var subject_id = parseInt(subject_details_id[1]);
            var curriculum_subject_id = parseInt(subject_details_id[0]);
            var section = $("#section").val();
            var curriculum_year = $("#curriculum_school_year").val();

            if (validateClassDetailsOptions()) {
                setClassDetails(course_id, curriculum_subject_id, semester_id, school_year_id, section, curriculum_year)
            }
        }

        displayDays = (subject) => {

            var days = [];

            if (subject.monday === 1) {
                days.push("Mon");
            }

            if (subject.tuesday === 1) {
                days.push("Tue");
            }

            if (subject.wednesday === 1) {
                days.push("Wed");
            }

            if (subject.thursday === 1) {
                days.push("Thu");
            }

            if (subject.friday === 1) {
                days.push("Fri");
            }

            if (subject.saturday === 1) {
                days.push("Sat");
            }

            return days.join().toString().replace(/,/g, ", ").toString();
        }

        /**
         * TODO:
         *  (1) Extract static strings
         */
        $scope.addStudentClass = (index) => {
            var id = $scope.students[index].stud_id;
            var student_id = $scope.students[index].student_id;

            if (!validateIfStudentIsOnClassList(student_id)) {
                dialogHelper.showConfirmation('Add studdent', 'Are you sure to add selected student to the official class list?', (result) => { // (1)
                    if (result) {
                        adminClassesService.addStudentClass(id, $scope.class_details.class_id).then((status) => {
                            if (status) {

                                activityLogHelper.registerActivity(getAddStudentToClassActivityLogDescription(index)).then(status => {
                                    if (status) {
                                        notificationHelper.registerNotification(getAddStudentToClassNotificationObject(index)).then(status => {
                                            displayClassList($scope.class_details.class_id);
                                        });
                                    }
                                });
                            } else {
                                dialogHelper.showError('Failed operation', 'Failed to add selected student to the official class list.'); // (1)
                            }
                        }).catch((err) => {
                            dialogHelper.showError('Failed operation', 'Something went wrong. Please try again later.'); // (1)
                        });
                    }
                });
            } else {
                dialogHelper.showError('Student already exist', 'Selected student already on the official student list for this class.'); // (1)
            }
        }

        getAddStudentToClassActivityLogDescription = (index) => {

            var student_code = $("tr#overall-student-" + index).find("td.student-id").text() || "";
            var student_name = $("tr#overall-student-" + index).find("td.student-name").text() || "";
            var subject = $("#subject").next().find("span#select2-subject-container").text() || "";

            return `Class: Assign student (${student_code}) ${student_name} to class ${subject}`;
        }

        getAddStudentToClassNotificationObject = (index) => {

            var student_id = $scope.students[index].stud_id;
            var class_id = $scope.class_details.class_id;

            var subject = $("#subject").next().find("span#select2-subject-container").text() || "";
            var description = `You have been enrolled to class ${subject}`;
            var path = notificationHelper.notificationPaths.studentClass(class_id);

            return {
                notify_to: student_id,
                notify_to_user_type: 'student',
                description: description,
                path: path
            }
        }

        getRemoveStudentFromClassActivityLogDescription = (index) => {

            var student_code = $("tr#official-student-" + index).find("td.student-id").text() || "";
            var student_name = $("tr#official-student-" + index).find("td.student-name").text() || "";
            var subject = $("#subject").next().find("span#select2-subject-container").text() || "";

            return `Class: Remove student (${student_code}) ${student_name} from class ${subject}`;
        }

        getRemoveStudentToClassNotificationObject = (index) => {

            var student_id = $scope.students[index].stud_id;
            var class_id = $scope.class_details.class_id;

            var subject = $("#subject").next().find("span#select2-subject-container").text() || "";
            var description = `You have been removed from class ${subject}`;
            var path = notificationHelper.notificationPaths.studentHome();

            return {
                notify_to: student_id,
                notify_to_user_type: 'student',
                description: description,
                path: path
            }
        }

        /**
         * TODO:
         *  (1) Extract static strings
         */
        $scope.removeStudentClass = (index) => {
            var class_list = $scope.tableOfficialClassList.data;
            var id = class_list[index].class_list_id;

            dialogHelper.showRemoveConfirmation(
                'Remove student from official list',
                'Removing student from the official class list will remove all of its information from the class and there is no way to revert it. Are you sure to remove selected student from the official class list?', () => { // (1)
                    adminClassesService.removeStudentClass(id).then((status) => {
                        if (status) {

                            activityLogHelper.registerActivity(getRemoveStudentFromClassActivityLogDescription(index)).then(status => {
                                if (status) {
                                    notificationHelper.registerNotification(getRemoveStudentToClassNotificationObject(index)).then(status => {
                                        displayClassList($scope.class_details.class_id);
                                    });
                                }
                            });
                        } else {
                            dialogHelper.showError('Failed operation', 'Failed to remove selected student from the official class list.'); // (1)
                        }
                    }).catch((err) => {
                        dialogHelper.showError('Failed operation', 'Something went wrong. Please try again later.'); // (1)
                    });
                });
        }

        displayCurrentSemester();
        displayCurrentSchoolYear();

        displaySections();
        displayCourses();
        displayCurriculumYears();
    }
]);