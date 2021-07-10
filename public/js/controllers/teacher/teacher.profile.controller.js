app.controller('teacherProfileController', ['$scope', 'teacherProfileService', function ($scope, teacherProfileService) {

    var userHelper = $scope.userHelper;
    var dialogHelper = $scope.dialogHelper;
    var activityLogHelper = $scope.activityLogHelper;
    var systemHelper = $scope.systemHelper;

    var errorMessage = $('.error-preview .display-error-text');

    $scope.profile = {};
    $scope.new_password = "";
    $scope.confirm_new_password = "";

    /**
     * TODO:
     *  (2) Extract static texts
     */
    $scope.saveNewProfilePic = () => {

        if (isValidImage()) {
            var title = 'Update profile picture';
            var message = 'Are you sure to update your new profile picture?';

            dialogHelper.showConfirmation(title, message, function (result) {
                if (result) {
                    teacherProfileService.saveNewLogo($scope.profile.image).then((res) => {
                        if (res.data.status === 1) {
                            activityLogHelper.registerActivity(`Profile: Updated profile picture.`).then(status => {
                                dialogHelper.showSuccess('New profile picture has been successfully set.', function () {
                                    window.location = '/teacher/profile';
                                });
                            });
                        }
                    });
                }
            });
        } else {
            dialogHelper.showError('Invalid image', 'Please select other image.');
        }
    }

    $scope.saveNewPersonalInformation = () => {

        if ($scope.facultyForm.$valid) {

            var title = 'Update personal information';
            var message = 'Are you sure to update your personal information?';

            dialogHelper.showConfirmation(title, message, function (result) {
                if (result) {

                    var date = new Date($scope.profile.birthdate);
                    $scope.profile.birthdate = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
                    teacherProfileService.saveUpdatePersonalInfo($scope.profile).then((res) => {

                        if (res.data.status === 1) {
                            activityLogHelper.registerActivity(`Profile: Updated personal information.`).then(status => {
                                if (status) {
                                    dialogHelper.showSuccess('New personal information has been successfully updated.', function () {
                                        window.location = '/teacher/profile';
                                    });
                                }
                            });
                        }
                    }, (err) => {
                        dialogHelper.showError('Error occured', 'Failed to update personal information. Please try it again later.');
                    });
                }
            });
        } else {
            dialogHelper.showError("Invalid inputs", "Please fill out all required fields.");
        }
    }

    $scope.saveUpdateAccountInformation = () => {

        if (isFormValid()) {
            var title = 'Update account information';
            var message = 'Are you sure to update your account information?';

            dialogHelper.showConfirmation(title, message, function (result) {
                if (result) {

                    if ($scope.new_password) $scope.profile.password = $scope.new_password;

                    teacherProfileService.saveUpdateAccountInfo($scope.profile).then((res) => {
                        if (res.data.status === 1) {
                            activityLogHelper.registerActivity(`Profile: Updated account information.`).then(status => {
                                if (status) {
                                    dialogHelper.showSuccess('Your account information has been successfully updated.', function () {
                                        window.location = '/teacher/profile';
                                    });
                                }
                            });
                        }
                    }, (err) => {
                        dialogHelper.showError('Error occured', 'Failed to update you account information. Please try it again later.');
                    });
                }
            });
        } else {
            dialogHelper.showError("Invalid inputs", "Please double check information you have entered.");
        }
    }

    isPasswordMatched = () => {
        if ($scope.new_password !== "") {
            if ($scope.new_password === $scope.confirm_new_password) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    isFormValid = () => {
        return $scope.accountProfileForm.$valid && isPasswordMatched();
    }

    isValidImage = () => {
        return !!!errorMessage.html() && $scope.profile.image;
    }

    initialize = () => {
        userHelper.getCurrentAccountProfilePic();

        teacherProfileService.getTeacherProfile().then((res) => {
            $scope.profile = res.data.profile;
            $scope.profile.birthdate = new Date($scope.profile.birthdate);
            $scope.profile.image = null;

            systemHelper.removePageLoadEffect();
        });
    }

    initialize();
}]);