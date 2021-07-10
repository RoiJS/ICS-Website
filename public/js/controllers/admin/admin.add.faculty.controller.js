app.controller('adminAddFacultyController', ['$scope', 'adminFacultyService', function ($scope, adminFacultyService) {

    var systemHelper = $scope.systemHelper;
    var imageFileHelper = $scope.imageFileHelper;
    var dialogHelper = $scope.dialogHelper;
    var userHelper = $scope.userHelper;
    var activityLogHelper = $scope.activityLogHelper;

    // Initialize default user photo
    imageFileHelper.displayDefaultUserImage();

    $scope.faculty = {};
    $scope.faculty.email_address = '';

    $scope.saveNewFaculty = () => {

        $scope.faculty.username = setUsername();

        if ($scope.facultyForm.$valid) {

            verifyTeacherIdExists($scope.faculty.faculty_id).then(exists => {

                if (!exists) {
                    
                    var title = 'Create new teacher';
                    var message = 'Are you sure to save new faculty information?';

                    dialogHelper.showConfirmation(title, message, (result) => {
                        if (result) {
                            $scope.faculty.birthdate = setBirthdate();
                            adminFacultyService.saveNewFaculty($scope.faculty).then((res) => {
                                if (res.data.status[0] && res.data.status[1] == true) {
                                    activityLogHelper.registerActivity(`Faculty: Created new faculty (${$scope.faculty.faculty_id}) ${userHelper.getPersonFullname({
                                        first_name: $scope.faculty.firstname,
                                        last_name: $scope.faculty.lastname,
                                        middle_name: $scope.faculty.middlename
                                    })}`).then(status => {
                                        if (status) {
                                            dialogHelper.showSuccess('New faculty information has been successfully ', () => {
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
                    dialogHelper.showError('Invalid faculty id', 'Faculty id you have entered already exists. Please enter other faculty id.');
                }
            });

        } else {
            dialogHelper.showError('Invalid inputs', 'Please double check the details you have entered.');
        }
    }

    setUsername = () => {
        if ($scope.faculty.firstname && $scope.faculty.lastname) {
            var fname = new String($scope.faculty.firstname);
            var lname = new String($scope.faculty.lastname);
            return fname.toLowerCase().replace(" ", "") + "." + lname.toLowerCase().replace(" ", "");
        } else {
            return "";
        }
    }

    setBirthdate = () => {
        var date = new Date($scope.faculty.birthdate);
        return date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate()
    }

    verifyTeacherIdExists = (facultyId) => {
        return adminFacultyService.verifyTeacherIdExists(facultyId);
    }
}]);