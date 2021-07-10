app.controller('adminViewStudentController', ['$scope', 'adminStudentsService', function ($scope, adminStudentsService) {

    var dialogHelper = $scope.dialogHelper;
    var userHelper = $scope.userHelper;
    var datetimeHelper = $scope.datetimeHelper;
    var imageFileHelper = $scope.imageFileHelper;
    var activityLogHelper = $scope.activityLogHelper;

    $scope.student = new Student();

    $scope.student_subjects = {};

    $scope.isDetailsLoading = true;

    adminStudentsService.getCurrentStudent(student_id).then((res) => {

        $scope.isDetailsLoading = false;

        $scope.student = res.data.student;

        // Set fullname
        $scope.student.fullname = userHelper.getPersonFullname($scope.student);

        // Set image source
        $scope.student.image_source = imageFileHelper.setStudentImage($scope.student.image);

        // Format birthdate
        $scope.student.birthdate = datetimeHelper.parseDate($scope.student.birthdate);

        $scope.student.subjects.map((subj) => {
            subj.start_time = datetimeHelper.timeParseReverse(subj.start_time);
            subj.end_time = datetimeHelper.timeParseReverse(subj.end_time);
            subj.schedule = `${datetimeHelper.timeParse(subj.start_time)} - ${datetimeHelper.timeParse(subj.end_time)}`;
            subj.total_units = (subj.lec_units + subj.lab_units)
        });
    });

    $scope.deactivateStudent = () => {
        var title = 'Deactivate student';
        var message = 'Deactivating student status will cause the student to not be able to use his/her account and enrolled in any classes but information will be kept in the system. Are you really sure to deactivate selected student?';

        dialogHelper.showWarningConfirmation(title, message, (result) => {
            if (result) {
                adminStudentsService.deactivateStudent($scope.student.stud_id).then((res) => {
                    if (res) {
                        activityLogHelper.registerActivity(`Student: Deactivate student (${$scope.student.student_id}) ${userHelper.getPersonFullname($scope.student)}.`).then(status => {
                            if (status) {
                                dialogHelper.showSuccess('Student account has been deactivated', () => {
                                    $scope.student.is_active = 0;
                                    $scope.$apply();
                                });
                            }
                        });
                    }
                }, (err) => {
                    dialogHelper.showError('Error', 'Failed to deactivate student. Please try again later.');
                });
            }
        });
    }

    $scope.activateStudent = () => {

        var title = 'Activate student';
        var message = 'Are you sure to activate selected student?';

        dialogHelper.showConfirmation(title, message, (result) => {
            if (result) {
                adminStudentsService.activateStudent($scope.student.stud_id).then((res) => {
                    if (res) {
                        activityLogHelper.registerActivity(`Student: Activate student (${$scope.student.student_id}) ${userHelper.getPersonFullname($scope.student)}.`).then(status => {
                            if (status) {
                                dialogHelper.showSuccess('Student account has been activated', () => {
                                    $scope.student.is_active = 1;
                                    $scope.$apply();
                                });
                            }
                        });
                    }
                }, (err) => {
                    dialogHelper.showError('Error', 'Failed to activate student. Please try again later.');
                });
            }
        });
    }
}]);