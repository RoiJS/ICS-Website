app.controller('adminSchoolYearController', ['$scope', 'adminSchoolYearService', function ($scope, adminSchoolYearService) {

    var systemHelper = $scope.systemHelper;
    var dialogHelper = $scope.dialogHelper;
    var activityLogHelper = $scope.activityLogHelper;

    var syTxtsHelper = $scope.syTxtsHelper;

    var $txtSchoolYearFrom = $("#ctrl-year-from");
    var $txtSchoolYearTo = $("#ctrl-year-to");

    $scope.data = {
        loading: true
    }

    $scope.school_years = {};
    $scope.selected_year_start = null;
    $scope.selected_year_end = null;

    $scope.year_start = 0
    $scope.year_end = 0;

    $scope.current_school_year = {};

    function getDefaultYearStartEnd() {
        $scope.year_start = adminSchoolYearService.getYearStart();
        $scope.year_end = adminSchoolYearService.getYearEnd();
    }

    function displaytSchoolYearList() {
        adminSchoolYearService.getSchoolYear().then((res) => {
            $scope.data.loading = false;
            $scope.school_years = res.data.school_years;
            $scope.school_years.map((school_year) => {
                school_year.edit = false;
                school_year.from_to = school_year.sy_from + ' - ' + school_year.sy_to;
                if (school_year.is_current_sy == 1) $scope.current_school_year = school_year;
            });
        });
    }

    /**
     * Called first to initialize controller logic
     */
    function initialize() {
        displaytSchoolYearList();
        getDefaultYearStartEnd();
    }

    /**
     * TODO: 
     *  (1) Extract static strings
     */
    $scope.setCurrentSchoolyear = (index) => {

        var title = 'Set new school year';
        var message = 'Are you sure to set new school year?';
        var currentSchoolYear = $scope.school_years[index];
        var school_year = `${currentSchoolYear.sy_from} - ${currentSchoolYear.sy_to}`;
        
        dialogHelper.showConfirmation(title, message, (res) => {
            if (res) {
                adminSchoolYearService.setNewSchoolYear(currentSchoolYear.school_year_id).then((status) => {
                    if (status) {
                        activityLogHelper.registerActivity(`Settings: Set '${school_year}' as default school year.`).then(status => {
                            if (status) {
                                dialogHelper.showSuccess('New current school year has been set.', () => {
                                    displaytSchoolYearList();
                                });
                            }
                        });
                    }
                });
            }
        });
    }

    $scope.setYearEnd = () => {
        $scope.selected_year_end = parseInt($scope.selected_year_start) + 1;
    }

    $scope.setYearStart = () => {
        $scope.selected_year_start = parseInt($scope.selected_year_end) - 1;
    }

    $scope.setYearEndEdit = (index) => {
        $scope.school_years[index].sy_to = $scope.school_years[index].sy_from + 1;
    }

    $scope.setYearStartEdit = (index) => {
        $scope.school_years[index].sy_from = $scope.school_years[index].sy_to - 1;
    }

    /**
     * TODO:
     *  (1) Extract static texts
     */
    $scope.saveNewSchoolYear = () => {

        if (validateAddSchoolYearControls()) {
            if (!validateSchoolYearExists()) {
                var title = syTxtsHelper.SAVE_SY_DIALOG_TITLE;
                var message = syTxtsHelper.SAVE_SY_DIALOG_MESSAGE;

                dialogHelper.showConfirmation(title, message, (result) => {
                    if (result) {
                        adminSchoolYearService.saveNewSchoolYear($scope.selected_year_start, $scope.selected_year_end).then((status) => {
                            if (status === true) {
                                activityLogHelper.registerActivity(`School year: Create new school year ${$scope.selected_year_start}-${$scope.selected_year_end}.`).then(status => {
                                    dialogHelper.showSuccess(syTxtsHelper.SAVE_SY_SUCCESS_DIALOG_MESSAGE, () => {
                                        displaytSchoolYearList();
                                        $scope.selected_year_start = null;
                                        $scope.selected_year_end = null;
                                    });
                                });
                            }
                        }, (err) => {
                            dialogHelper.showError(
                                syTxtsHelper.SAVE_SY_FAILED_DIALOG_TITLE,
                                syTxtsHelper.SAVE_SY_FAILED_DIALOG_MESSAGE
                            );
                        });
                    }
                });
            } else {
                dialogHelper.showError(
                    syTxtsHelper.INVALID_SY_DIALOG_TITLE,
                    syTxtsHelper.INVALID_SY_DIALOG_MESSAGE
                );
            }
        }
    }

    $scope.getSchoolYear = (school_year) => {
        return `${school_year.sy_from} - ${school_year.sy_to}`;
    }

    /**
     * TODO:
     *  (1) Extract static texts
     */
    $scope.removeSchoolYear = (index) => {

        var id = $scope.school_years[index].school_year_id;
        var school_year_from = $scope.school_years[index].sy_from;
        var school_year_to = $scope.school_years[index].sy_to;

        validateUsedSchoolYear(id).then(status => {
            if (!status) {
                var title = "Remove school year";
                var message = "Are you sure to remove selected school year from the list?";

                dialogHelper.showRemoveConfirmation(title, message, (result) => {
                    adminSchoolYearService.removeSchoolYear(id).then((status) => {
                        if (status) {
                            activityLogHelper.registerActivity(`School year: Remove school year ${school_year_from}-${school_year_to}.`).then(status => {
                                if (status) {
                                    dialogHelper.showSuccess("Selected school year has been successfully removed from the list.", () => {
                                        $scope.school_years.splice(index, 1);
                                        displaytSchoolYearList();
                                    });
                                }
                            });
                        }
                    }, (err) => {
                        dialogHelper.showError("Remove school year failed", "Failed to remove selected school year. Please try it again later.");
                    });
                });
            } else {
                dialogHelper.showError("Remove school restricted", "Failed to remove selected school year because it is being assigned to classes or curriculum.");
            }
        });
    }

    /**
     * TODO:    
     *  (1) Extract static texts
     */
    $scope.saveUpdateSchoolYear = (index) => {

        var title = "Update school year";
        var message = "Are you sure to update selected school year?";

        dialogHelper.showConfirmation(title, message, (result) => {
            if (result) {
                adminSchoolYearService.saveUpdateSchoolYear($scope.school_years[index]).then((status) => {
                    if (status) {
                        activityLogHelper.registerActivity(`School year: Edit school year ${$scope.school_years[index].sy_from}-${$scope.school_years[index].sy_to}.`).then(status => {
                            if (status) {
                                dialogHelper.showSuccess("Selected school year has been successfully updated.", () => {
                                    $scope.school_years[index].edit = false;
                                });
                            }
                        });
                    }
                }, (err) => {
                    dialogHelper.showError("Update school year failed", "Failed to update selected school year. Please try it again later.");
                });
            } else {
                $scope.school_years[index].edit = false;
                displaytSchoolYearList();
            }
        });
    }

    /**
     * Validates if controls for school year from and to are not empty
     * @return {boolean} 
     * 
     * TODO:
     *  (1) Extract static texts
     */
    validateAddSchoolYearControls = () => {

        var $schoolYearFrom = $txtSchoolYearFrom;
        var $schoolYearTo = $txtSchoolYearTo;

        var schoolYearFromValue = parseInt($schoolYearFrom.val().split(":")[1]);
        var schoolYearToValue = parseInt($schoolYearTo.val().split(":")[1]);

        if (!schoolYearFromValue) {
            systemHelper.removeInvalidControlTemplate($schoolYearFrom.parents(".input-group.date"));
            systemHelper.addInvalidControlProps($schoolYearFrom.parents(".input-group.date"), "Please select year.");
        } else {
            systemHelper.removeInvalidControlTemplate($schoolYearFrom.parents(".input-group.date"));
        }

        if (!schoolYearToValue) {
            systemHelper.removeInvalidControlTemplate($schoolYearTo.parents(".input-group.date"));
            systemHelper.addInvalidControlProps($schoolYearTo.parents(".input-group.date"), "Please select year.");
        } else {
            systemHelper.removeInvalidControlTemplate($schoolYearTo.parents(".input-group.date"));
        }

        return (schoolYearFromValue && schoolYearToValue);
    }

    validateSchoolYearExists = () => {
        var result = false;
        var schoolYearFromValue = parseInt($txtSchoolYearFrom.val().split(":")[1]);
        var schoolYearToValue = parseInt($txtSchoolYearTo.val().split(":")[1]);

        for (var index in $scope.school_years) {
            var school_year_from = $scope.school_years[index].sy_from;
            var school_year_to = $scope.school_years[index].sy_to;

            if (school_year_from === schoolYearFromValue &&
                school_year_to === schoolYearToValue) {
                result = true;
            }
        }

        return result;
    }

    validateUsedSchoolYear = (schoolYearId) => {
        return adminSchoolYearService.validateAssignedSchoolYear(schoolYearId);
    }

    initialize();
}]);