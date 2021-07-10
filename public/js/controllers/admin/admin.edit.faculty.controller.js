app.controller('adminEditFacultyController', ['$scope', 'adminFacultyService', function ($scope, adminFacultyService) {

    var imageFileHelper = $scope.imageFileHelper;
    var dialogHelper = $scope.dialogHelper;
    var userHelper = $scope.userHelper;
    var activityLogHelper = $scope.activityLogHelper;

    $scope.faculty = {};
    $scope.new_password = "";
    $scope.confirm_new_password = "";

    adminFacultyService.getCurrentFaculty(faculty_id).then((res) => {
        $scope.faculty = res.data.faculty;
        $scope.faculty.birthdate = new Date($scope.faculty.birthdate);
        $scope.faculty.image_source = imageFileHelper.setFacultyImage($scope.faculty.image);
    });

    $scope.saveUpdateFaculty = () => {

        if (isFormValid()) {

            var title = 'Save changes';
            var message = 'Are you sure to save new faculty information?';

            dialogHelper.showConfirmation(title, message, (result) => {
                if (result) {
                    $scope.faculty.birthdate = formatBirthdate();
                    adminFacultyService.saveUpdateFaculty($scope.faculty).then((res) => {
                        if (res.data.status[0] === 1 || res.data.status[1] === 1 || res.data.status[2] === 1) {
                            activityLogHelper.registerActivity(`Faculty: Updated faculty (${$scope.faculty.faculty_id}) ${userHelper.getPersonFullname($scope.faculty)}`).then(status => {
                                if (status) {
                                    dialogHelper.showSuccess('Changes has been successully saved.', () => {
                                        window.location = '/admin/faculty';
                                    });
                                }
                            });
                        }
                    }, (err) => {
                        dialogHelper.showError('Error occured', 'Failed to save faculty information. Please try it again later.');
                    });
                }
            });
        } else {
            dialogHelper.showError('Invalid information', 'Please check the details you have entered.');
        }
    }

    isPasswordMatched = () => {
        return $scope.new_password === $scope.confirm_new_password;
    }

    isFormValid = () => {
        return $scope.facultyForm.$valid && isPasswordMatched();
    }

    formatBirthdate = () => {
        var date = new Date($scope.faculty.birthdate);
        return date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
    }
}]);