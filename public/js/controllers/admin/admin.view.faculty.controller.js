app.controller('adminViewFacultyController', ['$scope', 'adminFacultyService', function ($scope, adminFacultyService) {

    var datetimeHelper = $scope.datetimeHelper;
    var dialogHelper = $scope.dialogHelper;
    var imageFileHelper = $scope.imageFileHelper;
    var userHelper = $scope.userHelper;
    var activityLogHelper = $scope.activityLogHelper;

    $scope.faculty = new Faculty();

    $scope.isDetailsLoading = false;

    $scope.load = function () {
        $scope.isDetailsLoading = true;
        adminFacultyService.getCurrentFaculty(teacher_id).then((res) => {

            $scope.isDetailsLoading = false;

            // Set faculty object
            $scope.faculty = res.data.faculty;

            // Format faculty birthdate
            $scope.faculty.birthdate = datetimeHelper.parseDate($scope.faculty.birthdate);

            // Set faculty image source
            $scope.faculty.image_source = imageFileHelper.setFacultyImage($scope.faculty.image);

            $scope.faculty.subjects.map((subj) => {
                subj.start_time = datetimeHelper.timeParseReverse(subj.start_time);
                subj.end_time = datetimeHelper.timeParseReverse(subj.end_time);
                subj.schedule = `${datetimeHelper.timeParse(subj.start_time)} - ${datetimeHelper.timeParse(subj.end_time)}`;
                subj.total_units = (subj.lec_units + subj.lab_units)
            });
        });
    }

    /**
     * Activate faculty status
     */
    $scope.activateFaculty = () => {
        var title = 'Activate teacher';
        var message = 'Are you sure to activate selected teacher?';

        dialogHelper.showConfirmation(title, message, (result) => {
            if (result) {
                adminFacultyService.activateFaculty(teacher_id).then((status) => {
                    if (status) {
                        activityLogHelper.registerActivity(`Faculty: Activate faculty (${$scope.faculty.faculty_id}) ${userHelper.getPersonFullname($scope.faculty)}`).then(status => {
                            if (status) {
                                dialogHelper.showSuccess('Teacher account has been activated', () => {
                                    $scope.faculty.is_active = 1;
                                    $scope.$apply();
                                });
                            }
                        });
                    }
                }, (err) => {
                    dialogHelper.showError('Error', 'Failed to activate teacher. Please try again later.');
                });
            }
        });
    }

    /**
     * Deactivate faculty status
     */
    $scope.deactivateFaculty = () => {
        var title = 'Deactivate teacher';
        var message = 'Deactivating faculty status will cause the teacher to not be able to use his/her account and assign to any classes but information will be kept in the system. Are you really sure to deactivate selected teacher?';

        dialogHelper.showWarningConfirmation(title, message, (result) => {
            if (result) {
                adminFacultyService.deactivateFaculty(teacher_id).then((status) => {
                    if (status) {
                        activityLogHelper.registerActivity(`Faculty: Deactivate faculty (${$scope.faculty.faculty_id}) ${userHelper.getPersonFullname($scope.faculty)}`).then(status => {
                            if (status) {
                                dialogHelper.showSuccess('Teacher account has been deactivated', () => {
                                    $scope.faculty.is_active = 0;
                                    $scope.$apply();
                                });
                            }
                        });
                    }
                }, (err) => {
                    dialogHelper.showError('Error', 'Failed to deactivate teacher. Please try again later.');
                });
            }
        });
    }

    $scope.load();
}]);