app.controller('adminCurriculumController', [
    '$scope',
    'adminCoursesService',
    'adminSubjectsService',
    'adminSemestersService',
    'adminSchoolYearService',
    'adminCurriculumService',
    function ($scope, adminCoursesService, adminSubjectsService, adminSemestersService, adminSchoolYearService, adminCurriculumService) {

        var systemHelper = $scope.systemHelper;
        var dialogHelper = $scope.dialogHelper;
        var dataTableHelper = $scope.dataTableHelper;
        var activityLogHelper = $scope.activityLogHelper;

        $scope.hasCurriculumSelected = false;

        $scope.status = {
            subjects_loading: false,
            is_curriculum_set: false
        }

        $scope.tableCurriculumSubjects = null;

        $scope.selectedCourse = null;
        $scope.selectedSubject = null;
        $scope.selectedSemester = null;
        $scope.selectedSchoolYear = null;

        $scope.courses = [];
        $scope.subjects = [];
        $scope.semesters = [];
        $scope.school_years = [];
        $scope.curriculum_years = [];

        adminCoursesService.getCourses().then((res) => {
            $scope.courses = res.data.courses;
        });

        adminSubjectsService.getSubjects().then((subjects) => {
            $scope.subjects = subjects;
        });

        adminSemestersService.getSemesters().then((res) => {
            $scope.semesters = res.data.semesters;
        });

        adminCurriculumService.getCurriculumYears().then((curriculum_years) => {
            $scope.curriculum_years = curriculum_years;
        });

        /**
         * Gets subjects based from the curriculum settings
         * @return {void}
         */
        $scope.getCurriculumSubjects = () => {

            if (validateCurriculumSettings()) {

                $scope.status.subjects_loading = true;
                $scope.status.is_curriculum_set = true;
                $scope.hasCurriculumSelected = true;

                adminCurriculumService.getCurriculumSubjects(
                    $scope.selectedCourse,
                    $scope.selectedSchoolYear,
                    $scope.selectedYearLevel,
                    $scope.selectedSemester
                ).then((curriculum_subjects) => {

                    $scope.status.subjects_loading = false;
                    $scope.hasCurriculumSelected = !!curriculum_subjects.length;
                    $scope.curriculum_subjects = curriculum_subjects;

                    $scope.tableCurriculumSubjects = dataTableHelper.initializeDataTable({}, {
                        dataset: $scope.curriculum_subjects
                    });

                    // setTimeout(() => {
                    //     systemHelper.scrollToView("subjects-section");
                    // }, 200);

                });
            }
        }

        $scope.printCurriculum = () => {
            var selectedCourse = $scope.selectedCourse;
            var selectedSchoolYear = $scope.selectedSchoolYear;

            if (selectedCourse && selectedSchoolYear) {
                window.open(`/admin/curriculum/print_curriculum_page/${selectedCourse.description}/${selectedCourse.course_id}/${selectedSchoolYear}`);
            } else {
                dialogHelper.showError("No course and curriculum selected", "Please select course and curriculum from where the curriculum details is to be printed.");
            }
        }

        /**
         * Resets curriculum settings
         * @return {void}
         */
        $scope.resetCurriculumSubjects = () => {
            $scope.status.is_curriculum_set = false;
            $scope.selectedCourse = null;
            $scope.selectedSubject = null;
            $scope.selectedSemester = null;
            $scope.selectedSchoolYear = null;
        }

        /**
         * Add selected subject on 
         * 
         * TODO: 
         *  (1) Extract statis strings
         */
        $scope.addNewSubjectInCurriculum = () => {

            var $subjectControl = $("#subject_id");
            var $courseField = $("#course-field");
            var $schoolYearField = $("#schoolyear-field");
            var $semesterField = $("#semester-field");

            var selectControl = $subjectControl.data("select2");

            var subjectId = parseInt($subjectControl.val());
            var courseId = parseInt($courseField.val());
            var schoolyear = parseInt($schoolYearField.val());
            var semesterId = parseInt($semesterField.val());

            if (validateAddSelectedSubject()) {

                validateSubjectExists({
                    subjectId,
                    courseId,
                    schoolyear,
                    semesterId
                }).then(result => {

                    if (!result) {
                        var id = parseInt($subjectControl.val());

                        var title = 'Add selected subject';
                        var message = 'Are you sure to add selected subject from the list?';
                        var errorMessage = 'Failed to add selected subject. Please try again later.';

                        dialogHelper.showConfirmation(title, message, (result) => {
                            if (result) {
                                adminCurriculumService.saveNewCurriculumSubject(id, $scope.selectedCourse, $scope.selectedSchoolYear, $scope.selectedYearLevel, $scope.selectedSemester).then((res) => {
                                    activityLogHelper.registerActivity(generateAddNewSubjectActivityLogDescription()).then(status => {
                                        if (status) {
                                            $scope.getCurriculumSubjects();
                                            selectControl.val(0); // Clear selected value        
                                        }
                                    });
                                }, (err) => {
                                    dialogHelper.showError(errorMessage);
                                });
                            }
                        });

                    } else {

                        var title = "Failed to add subject";
                        var message = "Selected subject already exists on the current curriculum settings. Please select other subject.";

                        dialogHelper.showError(title, message);
                    }
                });
            }
        }

        $scope.removeCurriculumSubject = (index) => {

            var subjects = $scope.tableCurriculumSubjects.data;
            var id = subjects[index].curriculum_subject_id;
            var subject_description = subjects[index].subject_description;

            verifySubjectInLoadsExistsInLoads(id).then(result => {

                if (!result) {
                    var title = "Remove subject";
                    var message = "Are you sure to remove selected subject from the list?";

                    dialogHelper.showRemoveConfirmation(title, message, (status) => {
                        adminCurriculumService.removeCurriculumSubject(id).then((status) => {
                            if (status) {
                                activityLogHelper.registerActivity(generateRemoveSubjectActivityLogDescription(subject_description)).then(status => {
                                    if (status) {
                                        dialogHelper.showSuccess("Selected subject has been successfully removed from the list.", () => {
                                            subjects.splice(index, 1);
                                        });
                                    }
                                });
                            }
                        }, (err) => {
                            dialogHelper.showError("Failed to remove subject.", "Failed to removed subject from the list. Please try it again later.");
                        });
                    });
                } else {
                    var title = "Failed to remove subject";
                    var message = "Selected subject cannot be deleted because it is currently in used on class list module.";

                    dialogHelper.showError(title, message);
                }
            });

        }

        generateAddNewSubjectActivityLogDescription = () => {
            var course = $("#course-field option:selected").html() || "";
            var curriculumYear = $("#schoolyear-field").val() || "";
            var yearLevel = $("#yearlevel-field option:selected").html() || "";
            var semester = $("#semester-field option:selected").html() || "";
            var subject = $("#subject_id").next().find("span#select2-subject_id-container").text() || "";

            return `Curriculum: Assigned subject '${subject}' to curriculum year ${curriculumYear} (Course: ${course}; Year Level: ${yearLevel}; Semester: ${semester}).`;
        }
        generateRemoveSubjectActivityLogDescription = (subject) => {
            var course = $("#course-field option:selected").html() || "";
            var curriculumYear = $("#schoolyear-field").val() || "";
            var yearLevel = $("#yearlevel-field option:selected").html() || "";
            var semester = $("#semester-field option:selected").html() || "";

            return `Curriculum: Removed subject '${subject}' from curriculum year ${curriculumYear} (Course: ${course}; Year Level: ${yearLevel}; Semester: ${semester}).`;
        }
        /**
         * Validates curriculum settings
         * @return {boolean}  
         * 
         * TODO: 
         *  (1) Extract statis strings
         */
        validateCurriculumSettings = () => {

            var $courseField = $("#course-field");
            var $schoolYearField = $("#schoolyear-field");
            var $yearLevelField = $("#yearlevel-field");
            var $semesterField = $("#semester-field");

            var courseId = parseInt($courseField.val());
            var schoolyearId = parseInt($schoolYearField.val());
            var yearLevelId = $yearLevelField.val() !== '?' ? $yearLevelField.val() : '';
            var semesterId = parseInt($semesterField.val());

            if (!courseId) {
                systemHelper.removeInvalidControlTemplate($courseField);
                systemHelper.addInvalidControlProps($courseField, "Empty course field.");
            } else {
                systemHelper.removeInvalidControlTemplate($courseField);
            }

            if (!schoolyearId) {
                systemHelper.removeInvalidControlTemplate($schoolYearField);
                systemHelper.addInvalidControlProps($schoolYearField, "Empty school year field.");
            } else {
                systemHelper.removeInvalidControlTemplate($schoolYearField);
            }

            if (!yearLevelId) {
                systemHelper.removeInvalidControlTemplate($yearLevelField);
                systemHelper.addInvalidControlProps($yearLevelField, "Empty year level field.");
            } else {
                systemHelper.removeInvalidControlTemplate($yearLevelField);
            }

            if (!semesterId) {
                systemHelper.removeInvalidControlTemplate($semesterField);
                systemHelper.addInvalidControlProps($semesterField, "Empty semester field.");
            } else {
                systemHelper.removeInvalidControlTemplate($semesterField);
            }

            return (courseId && schoolyearId && yearLevelId && semesterId);
        }

        /**
         * Validates selected subject
         * @return {boolean}
         * 
         * TODO: 
         *  (1) Extract statis strings
         */
        validateAddSelectedSubject = () => {

            var $subjectControl = $("#subject_id");
            var selectControl = $subjectControl.data("select2");

            var subjectId = parseInt($subjectControl.val());

            if (!subjectId) {
                systemHelper.removeInvalidControlTemplate($subjectControl.next());
                systemHelper.addInvalidControlProps($subjectControl.next(), "No selected subject. Please select from the list.");
            } else {
                systemHelper.removeInvalidControlTemplate($subjectControl.next());
            }

            return (subjectId);
        }

        validateSubjectExists = (subject_id) => {
            return adminCurriculumService.verifySubjectExist(subject_id);
        }

        verifySubjectInLoadsExistsInLoads = (curriculum_subject_id) => {
            return adminCurriculumService.verifySubjectInLoadsExistsInLoads(curriculum_subject_id);
        }
    }
]);