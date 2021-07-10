app.controller('registerAccountController', ['$scope', 'registerAccountService', function ($scope, registerAccountService) {

    var dialogHelper = $scope.dialogHelper;

    $scope.isStudentIdValid = true;

    $scope.account = {
        student_id: null,
        firstname: null,
        middlename: null,
        lastname: null,
        gender: null,
        birthdate: null,
        emailaddress: null,
        username: null,
        password: null
    };

    $scope.validateStudentId = function (studentId) {
        if (studentId === "^[a-zA-Z\s]*$") {
            $scope.isStudentIdValid = false;
        } else {
            $scope.isStudentIdValid = true;
        }
    }

    $scope.saveNewAccount = () => {

        if ($scope.registerForm.$valid) {

            verifyStudentIdExists($scope.account.student_id).then(exists => {
                if (!exists) {
                    var title = 'Sign up';
                    var message = 'Are you sure to create this new account?';

                    dialogHelper.showConfirmation(title, message, (result) => {
                        if (result) {
                            var bdate = new Date($scope.account.birthdate);
                            $scope.account.birthdate = bdate.getFullYear() + "-" + (bdate.getMonth() + 1) + "-" + bdate.getDate();

                            registerAccountService.saveNewAccount($scope.account).then((res) => {
                                if (res.data.status === true) {
                                    dialogHelper.showSuccess('Your account has been created but not yet approved. Just wait for the approval of system administrator in order for you to access it.', () => {
                                        window.location = '/access';
                                    });
                                }
                            }, (err) => {
                                dialogHelper.showError('Error occured', 'Failed to save student information. Please try it again later.');
                            });
                        }
                    });
                } else {
                    dialogHelper.showError('Invalid student id', 'Student id you have entered already exists. Please enter other student id.');
                }
            });
        } else {
            dialogHelper.showError('Invalid inputs', 'Please double check the details you have entered. Fill out all required fields.');
        }
    }

    verifyStudentIdExists = (studentId) => {
        return registerAccountService.verifyStudentIdExists(studentId);
    }
}]);