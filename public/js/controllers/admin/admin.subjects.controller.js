app.controller('adminSubjectsController', ['$scope', 'adminSubjectsService', function ($scope, adminSubjectsService) {

    var systemHelper = $scope.systemHelper;
    var dialogHelper = $scope.dialogHelper;
    var dataTableHelper = $scope.dataTableHelper;
    var activityLogHelper = $scope.activityLogHelper;

    var subjTxtsHelper = $scope.subjTxtsHelper;

    $scope.status = {
        data_loading: true
    }

    $scope.tableSubjectList = null;

    $scope.subjects = {};

    $scope.subject = {
        subject_code: "",
        subject_description: "",
        lec_unit: 0,
        lab_unit: 0
    };

    /**
     * Display list of subjects
     */
    displaySubjectList = () => {
        adminSubjectsService.getSubjects().then((subjects) => {
            $scope.status.data_loading = false;
            $scope.subjects = subjects;
            $scope.tableSubjectList = dataTableHelper.initializeDataTable({}, {
                dataset: subjects
            });
        });
    }

    /**
     * Validates if subject code entered by the user already exists in the list
     * @returns {bool}
     */
    validateSubjectCode = () => {

        var subjectList = $scope.tableSubjectList.data;
        var $subjectCodeElem = $("#subject-code");
        var subjectCode = $subjectCodeElem.val().toString().trim();

        var isExists = subjectList.findIndex((subject) => {
            return subject.subject_code === subjectCode;
        });

        return Boolean(isExists + 1);
    }

    /**
     * Validates subject form controls
     * @returns {boolean} Returns true if all controls are properly filled out, otherwise false
     */
    validationSubjectInformation = () => {

        var $subjectCode = $("#subject-code");
        var $description = $("#description");
        var $lecUnit = $("#lec-unit");
        var $labUnit = $("#lab-unit");

        resetErrorControl({
            $subjectCode,
            $description,
            $lecUnit,
            $labUnit
        });

        if ($scope.subject.subject_code) {
            systemHelper.removeInvalidControlTemplate($subjectCode);
        } else {
            systemHelper.addInvalidControlProps($subjectCode, subjTxtsHelper.ENTER_MISSING_SUBJECT_CODE);
        }

        if ($scope.subject.subject_description) {
            systemHelper.removeInvalidControlTemplate($description);
        } else {
            systemHelper.addInvalidControlProps($description, subjTxtsHelper.ENTER_MISSING_SUBJECT_DESCRIPTION);
        }

        return ($scope.subject.subject_code && $scope.subject.subject_description);
    }

    validateLoadedSubjects = (subjectId) => {
        return adminSubjectsService.verifySubjectLoaded(subjectId);
    }

    /**
     * Reset control to initial state 
     * @returns {void}
     */
    resetErrorControl = (controls) => {
        systemHelper.removeInvalidControlTemplate(controls.$subjectCode);
        systemHelper.removeInvalidControlTemplate(controls.$description);
        systemHelper.removeInvalidControlTemplate(controls.$lecUnit);
        systemHelper.removeInvalidControlTemplate(controls.$labUnit);
    }

    /**
     * Reset form controls content
     */
    $scope.resetForm = () => {
        $scope.subject.subject_code = '';
        $scope.subject.subject_description = '';
        $scope.subject.lec_unit = '';
        $scope.subject.lab_unit = '';
    }

    /**
     * Removes selected subject information
     * @param {*} index Position of the selected subject information from the list
     * 
     * 
     * Implement validation before removing subject
     */
    $scope.removeSubject = (index) => {

        var subjectList = $scope.tableSubjectList.data;
        var id = subjectList[index].subject_id;
        var description = subjectList[index].subject_description;

        validateLoadedSubjects(id).then((status) => {
            if (!status) {
                dialogHelper.showRemoveConfirmation(
                    subjTxtsHelper.REMOVE_SUBJECT_DIALOG_TITLE,
                    subjTxtsHelper.REMOVE_SUBJECT_DIALOG_MESSAGE,
                    (res) => {
                        adminSubjectsService.removeSubject(id).then((res) => {
                            dialogHelper.showSuccess(subjTxtsHelper.REMOVE_SUBJECT_SUCCESS, () => {
                                activityLogHelper.registerActivity(`Subject: Deleted subject ${description}.`).then(status => {
                                    if (status) {
                                        displaySubjectList();
                                    }
                                });
                            });
                        }, (err) => {
                            dialogHelper.showError(
                                subjTxtsHelper.REMOVE_SUBJECT_FAILED_DIALOG_TITLE,
                                subjTxtsHelper.SAVE_NEW_SUBJECT_DIALOG_MESSAGE
                            );
                        });
                    });
            } else {
                dialogHelper.showError(
                    subjTxtsHelper.REMOVE_ENROLLED_SUBJECT_DIALOG_TITLE,
                    subjTxtsHelper.REMOVE_ENROLLED_SUBJECT_DIALOG_MESSAGE
                );
            }
        });
    }

    /**
     * Save new subject information
     */
    $scope.saveNewSubject = () => {

        if (validationSubjectInformation()) {
            if (!validateSubjectCode()) {
                dialogHelper.showConfirmation(
                    subjTxtsHelper.SAVE_NEW_SUBJECT_DIALOG_TITLE,
                    subjTxtsHelper.SAVE_NEW_SUBJECT_DIALOG_MESSAGE,
                    (result) => {
                        if (result) {
                            adminSubjectsService.saveNewSubject($scope.subject).then((status) => {
                                if (status) {
                                    dialogHelper.showSuccess(subjTxtsHelper.SAVE_NEW_SUBJECT_SUCCESS, () => {
                                        activityLogHelper.registerActivity(`Subject: Created new subject ${$scope.subject.subject_description}.`).then(status => {
                                            if (status) {
                                                displaySubjectList();
                                                $scope.resetForm();
                                            }
                                        });
                                    });
                                } else {
                                    dialogHelper.showError(
                                        subjTxtsHelper.SAVE_NEW_SUBJECT_FAILED_DIALOG_TITLE,
                                        subjTxtsHelper.SAVE_NEW_SUBJECT_FAILED_DIALOG_MESSAGE
                                    );
                                }
                            }, (err) => {
                                dialogHelper.showError(
                                    subjTxtsHelper.SAVE_NEW_SUBJECT_FAILED_DIALOG_TITLE,
                                    subjTxtsHelper.SAVE_NEW_SUBJECT_FAILED_DIALOG_MESSAGE
                                );
                            });
                        }
                    });
            } else {
                dialogHelper.showError(
                    subjTxtsHelper.DUPLICATE_SUBJECT_CODE_DIALOG_TITLE,
                    subjTxtsHelper.DUPLICATE_SUBJECT_CODE_DIALOG_MESSAGE
                );
            }
        } else {
            dialogHelper.showError(
                subjTxtsHelper.INCOMPLETE_SUBJECT_INFORMATION_DIALOG_TITLE,
                subjTxtsHelper.INCOMPLETE_SUBJECT_INFORMATION_DIALOG_MESSAGE
            );
        }
    }

    displaySubjectList();

}]);