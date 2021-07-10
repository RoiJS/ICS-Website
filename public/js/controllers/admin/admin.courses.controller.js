app.controller('adminCoursesController', ['$scope', 'adminCoursesService', function ($scope, adminCoursesService) {

    var systemHelper = $scope.systemHelper;
    var dialogHelper = $scope.dialogHelper;
    var dataTableHelper = $scope.dataTableHelper;
    var activityLogHelper = $scope.activityLogHelper;

    var courseTxtsHelper = $scope.courseTxtsHelper;

    $txtCourseName = $("#courseName");

    $scope.tableCourseList = null;

    $scope.status = {
        data_loading: true
    }

    $scope.courses = {};
    $scope.course = {};

    /**
     * Save new course information
     * @return {void}
     */
    $scope.saveNewCourse = () => {

        if (validateCourseInfo()) {

            var confirmationTitle = courseTxtsHelper.SAVE_COURSE_DIALOG_TITLE;
            var confirmationMessage = courseTxtsHelper.SAVE_COURSE_DIALOG_MESSAGE;

            dialogHelper.showConfirmation(confirmationTitle, confirmationMessage, (result) => {
                if (result) {
                    adminCoursesService.saveNewCourse($scope.course).then((status) => {
                        if (status) {
                            activityLogHelper.registerActivity(`Course: Create new course ${$scope.course.description}.`).then(status => {
                                if (status) {
                                    dialogHelper.showSuccess(courseTxtsHelper.SAVE_COURSE_SUCCESS_DIALOG_TITLE, () => {
                                        $txtCourseName.val("");
                                        getCourseList();
                                    });
                                }
                            });
                        }
                    }, (err) => {
                        dialogHelper.showError(
                            courseTxtsHelper.SAVE_COURSE_FAILED_DIALOG_TITLE,
                            courseTxtsHelper.SAVE_COURSE_FAILED_DIALOG_MESSAGE
                        );
                    });
                }
            });
        }
    }

    /**
     * Update course information
     * @param {int} index Index position of the course information that is to be updated.
     * @return {void} 
     */
    $scope.saveUpdateCourse = (index) => {

        if (validateCourseInfoOnUpdate()) {

            var courseList = $scope.tableCourseList.data;
            var confirmationTitle = courseTxtsHelper.UPDATE_COURSE_DIALOG_TITLE;
            var confirmationMessage = courseTxtsHelper.UPDATE_COURSE_DIALOG_MESSAGE;
            var courseInfo = courseList[index];

            dialogHelper.showConfirmation(confirmationTitle, confirmationMessage, (result) => {
                if (result) {
                    adminCoursesService.saveUpdateCourse(courseInfo).then((status) => {
                        if (status) {
                            activityLogHelper.registerActivity(`Course: Update course ${courseInfo.description}.`).then(status => {
                                if (status) {
                                    dialogHelper.showSuccess(courseTxtsHelper.UPDATE_COURSE_SUCCESS_DIALOG_MESSAGE, () => {
                                        getCourseList();
                                    });
                                }
                            });
                        }
                    }, (err) => {
                        dialogHelper.showError(
                            courseTxtsHelper.UPDATE_COURSE_FAILED_DIALOG_TITLE,
                            courseTxtsHelper.UPDATE_COURSE_FAILED_DIALOG_MESSAGE
                        );
                    });
                }
            });
        }
    }

    /**
     * Delete course information
     * @param {int} index Index position of the course that is to be deleted
     * @return {void}
     */
    $scope.deleteCourse = (index) => {
        var courseList = $scope.tableCourseList.data;
        var courseId = courseList[index].course_id;
        var course_name = courseList[index].description;

        verifyDesignatedCourse(courseId).then((status) => {
            if (!status) {
                var confirmationTitle = courseTxtsHelper.REMOVE_COURSE_DIALOG_TITLE;
                var confirmationMessage = courseTxtsHelper.REMOVE_COURSE_DIALOG_MESSAGE;

                dialogHelper.showRemoveConfirmation(confirmationTitle, confirmationMessage, (result) => {
                    adminCoursesService.deleteCourse(courseId).then((status) => {
                        if (status) {
                            activityLogHelper.registerActivity(`Course: Delete course ${course_name}.`).then(status => {
                                if (status) {
                                    dialogHelper.showSuccess(courseTxtsHelper.REMOVE_COURSE_SUCCESS_DIALOG_TITLE, () => {
                                        getCourseList();
                                    });
                                }
                            });
                        }
                    });
                }, (err) => {
                    dialogHelper.showError(
                        courseTxtsHelper.REMOVE_COURSE_FAILED_DIALOG_TITLE,
                        courseTxtsHelper.REMOVE_COURSE_FAILED_DIALOG_MESSAGE
                    );
                });
            } else {
                dialogHelper.showError(
                    courseTxtsHelper.REMOVE_COURSE_RESTRICTED_DIALOG_TITLE,
                    courseTxtsHelper.REMOVE_COURSE_RESTRICTED_DIALOG_MESSAGE
                )
            }
        });
    }

    /**
     * Get and display list of courses
     * @return {void}
     */
    getCourseList = () => {
        adminCoursesService.getCourses().then((res) => {

            $scope.status.data_loading = false;

            $scope.courses = res.data.courses;

            $scope.courses.map((course) => {
                course.edit = false;
            });

            $scope.tableCourseList = dataTableHelper.initializeDataTable({}, {
                dataset: $scope.courses
            });
        });
    }

    validateCourseInfo = () => {

        var $courseDescriptionControl = $txtCourseName;
        var courseDescription = $courseDescriptionControl.val();

        if (!courseDescription) {
            systemHelper.removeInvalidControlTemplate($courseDescriptionControl);
            systemHelper.addInvalidControlProps($courseDescriptionControl, courseTxtsHelper.ENTER_MISSING_COURSE_NAME);
        } else {
            systemHelper.removeInvalidControlTemplate($courseDescriptionControl);
        }

        return Boolean(courseDescription);
    }

    validateCourseInfoOnUpdate = () => {

        var $courseDescriptionControl = $('#edit-description');
        var courseDescription = $courseDescriptionControl.val();

        if (!courseDescription) {
            systemHelper.removeInvalidControlTemplate($courseDescriptionControl);
            systemHelper.addInvalidControlProps($courseDescriptionControl, courseTxtsHelper.ENTER_MISSING_COURSE_NAME);
        } else {
            systemHelper.removeInvalidControlTemplate($courseDescriptionControl);
        }

        return Boolean(courseDescription);
    }

    verifyDesignatedCourse = (courseId) => {
        return adminCoursesService.verifyDesignatedCourse(courseId);
    }

    getCourseList();

}]);