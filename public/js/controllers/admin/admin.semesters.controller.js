app.controller('adminSemestersController', ['$scope', 'adminSemestersService', function ($scope, adminSemestersService) {

    var utility = $scope.helper;

    var systemHelper = $scope.systemHelper;
    var dialogHelper = $scope.dialogHelper;
    var activityLogHelper = $scope.activityLogHelper;

    $scope.data = {
        loading: true
    }

    $scope.semester = {};
    $scope.semesters = {};
    $scope.current_semester = null;

    displaySemesters = () => {
        adminSemestersService.getSemesters().then((res) => {
            $scope.data.loading = false;
            $scope.semesters = res.data.semesters;
            $scope.semesters.map((semester) => {
                if (semester.is_current_semester == 1) {
                    $scope.current_semester = semester;
                }
                semester.edit = false;
            });
        });
    }

    displaySemesters();

    /**
     * Save new semester
     * @return {boolean}
     */
    $scope.saveNewSemester = () => {

        if (validateAddSemesterControls()) {

            var title = 'Save semester';
            var message = 'Are you sure to save new semester?';
            dialogHelper.showConfirmation(title, message, (res) => {
                if (res) {
                    adminSemestersService.saveNewSemester($scope.semester).then((status) => {
                            if (status) {
                                activityLogHelper.registerActivity(`Semester: Save new semester ${$scope.semester.semester}.`).then(status => {
                                    if (status) {
                                        dialogHelper.showSuccess('New semester has been successfully saved.', () => {
                                            $scope.semester.is_current_semester = 0
                                            $scope.semester.edit = false;
                                            $scope.semesters.push($scope.semester);
                                            $scope.semester = {};
                                            $scope.$apply();
                                        });
                                    }
                                });
                            }
                        })
                        .catch((err) => {
                            dialogHelper.showError('Error', 'Failed to save new semester. Please try it again later.');
                            console.error(err);
                        });
                }
            });
        }
    }

    /**
     * Sets new current semester
     * @return {boolean} 
     */
    $scope.saveCurrentSemester = (index) => {

        var currentSemester = $scope.semesters[index];
        var title = 'Set new semester';
        var message = 'Are you sure to update current semester?';

        dialogHelper.showConfirmation(title, message, (res) => {
            if (res) {
                adminSemestersService.saveUpdateCurrentSemester(currentSemester).then((status) => {
                        if (status) {
                            activityLogHelper.registerActivity(`Settings: Set '${currentSemester.semester}' as default semester.`).then(status => {
                                if (status) {
                                    dialogHelper.showSuccess('New current semester has been set.', () => {
                                        displaySemesters();
                                    });
                                }
                            });
                        }
                    })
                    .catch(err => {
                        dialogHelper.showError('Error', 'Failed to set new semester. Please try again later.');
                    });
            } else {
                displaySemesters();
            }
        });
    }

    /**
     * Update semester information
     * @return {boolean}   
     */
    $scope.saveUpdateSemester = (index) => {

        if (validateUpdateSemesterControls()) {
            var title = 'Update semester';
            var message = 'Are you sure to update selected semester?';
            var currentSemester = $scope.semesters[index];

            dialogHelper.showConfirmation(title, message, (res) => {
                if (res) {
                    adminSemestersService.saveUpdateSemester(currentSemester).then((status) => {

                            activityLogHelper.registerActivity(`Semester: Update semester ${currentSemester.semester}.`).then(status => {
                                if (status) {
                                    dialogHelper.showSuccess('Selected semester has been successully updated.', () => {
                                        $scope.semesters[index].edit = false;
                                        $scope.$apply();
                                    });
                                }
                            });
                        })
                        .catch((err) => {
                            dialogHelper.showError('Error', 'Failed to update selected semester. Please try it again later.');
                            console.error(err);
                        });
                }
            });
        }
    }

    /**
     * Remove selected semester
     */
    $scope.removeSemester = (index) => {

        var id = $scope.semesters[index].semester_id;
        var semester = $scope.semesters[index].semester;

        validateUsedSemester(id).then(status => {
            if (!status) {
                var title = 'Remove semester';
                var message = 'Are you sure to remove selected semester?';

                dialogHelper.showRemoveConfirmation(title, message, (res) => {
                    if (res) {
                        adminSemestersService.removeSemester(id).then((status) => {
                                if (status) {
                                    activityLogHelper.registerActivity(`Semester: Delete semester ${semester}.`).then(status => {
                                        if (status) {
                                            dialogHelper.showSuccess('Selected semester has been successully removed from the list.', () => {
                                                $scope.semesters.splice(index, 1);
                                                $scope.$apply();
                                            });
                                        }
                                    });
                                }
                            })
                            .catch((err) => {
                                dialogHelper.showError('Error', 'Failed to remove semester. Please it again later.');
                            });
                    }
                });
            } else {
                dialogHelper.showError('Remove semester restricted', 'Failed to remove semester because it is being assigned to classes.');
            }
        });

    }

    /**
     * Validates if textbox for adding new semester is empty or not
     * @return {boolean} 
     */
    validateAddSemesterControls = () => {

        var $semesterControl = $("#new-semester");

        var semesterControlValue = $semesterControl.val().toString().trim();

        if (!semesterControlValue) {
            systemHelper.removeInvalidControlTemplate($semesterControl);
            systemHelper.addInvalidControlProps($semesterControl, 'Please enter semester');
        } else {
            systemHelper.removeInvalidControlTemplate($semesterControl);
        }

        return (semesterControlValue);
    }

    /**
     * Validates update semester control if empty or not
     * @return {boolean}
     */
    validateUpdateSemesterControls = () => {

        var $semesterControl = $("#update-semester");

        var semesterControlValue = $semesterControl.val().toString().trim();

        if (!semesterControlValue) {
            systemHelper.removeInvalidControlTemplate($semesterControl);
            systemHelper.addInvalidControlProps($semesterControl, 'Please enter semester');
        } else {
            systemHelper.removeInvalidControlTemplate($semesterControl);
        }

        return (semesterControlValue);
    }

    validateUsedSemester = (semesterId) => {
        return adminSemestersService.validateAssignedSemester(semesterId);
    }
}]);