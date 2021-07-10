app.controller('adminEditSubjectController', ['$scope', 'adminSubjectsService', function ($scope, adminSubjectsService) {

    var systemHelper = $scope.systemHelper;
    var dialogHelper = $scope.dialogHelper;
    var activityLogHelper = $scope.activityLogHelper;

    $scope.subject = {};

    /**
     * Get subject information
     */
    adminSubjectsService.getCurrentSubject(subject_id).then((subject) => {
        $scope.subject = subject;
    });

    /**
     * Save update subject information 
     * 
     *  TODO: 
     *      (1) Extract statis strings
     */
    $scope.saveUpdateSubject = () => {

        if (validationSubjectInformation()) {
            dialogHelper.showConfirmation('Update subject', 'Are you sure to update changes?', (result) => {
                if (result) {
                    adminSubjectsService.saveUpdateSubject($scope.subject).then((res) => {
                        activityLogHelper.registerActivity(`Subject: Updated subject ${$scope.subject.subject_description} information.`).then(status => {
                            if (status) {
                                dialogHelper.showSuccess('Selected subject has been successfully updated.', () => {
                                    window.location = '/admin/subjects';
                                });
                            }
                        });
                    }, (err) => {
                        dialogHelper.showError('Error', 'Failed to update subject. Please try it again later.');
                    });
                }

            });
        }
    }

    /**
     * Validates subject form controls
     * @returns {boolean} Returns true if all controls are properly filled out, otherwise false
     * 
     * TODO:
     *  (1) Extract static strings
     */
    validationSubjectInformation = () => {
        var $subjectCode = $("#subject-code");
        var $description = $("#description");
        var $lecUnit = $("#lec-unit");
        var $labUnit = $("#lab-unit");

        if ($scope.subject.subject_code) {
            systemHelper.removeInvalidControlTemplate($subjectCode);
        } else {
            systemHelper.addInvalidControlProps($subjectCode, "Please enter subject code.");
        }

        if ($scope.subject.subject_description) {
            systemHelper.removeInvalidControlTemplate($description);
        } else {
            systemHelper.addInvalidControlProps($description, "Please enter subject description.");
        }

        return ($scope.subject.subject_code && $scope.subject.subject_description);
    }
}]);