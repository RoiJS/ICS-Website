app.controller('adminAddStudentController', ['$scope', 'adminStudentsService', 'adminCurriculumService', function ($scope, adminStudentsService, adminCurriculumService) {

    var systemHelper = $scope.systemHelper;
    var imageFileHelper = $scope.imageFileHelper;
    var dialogHelper = $scope.dialogHelper;
    var userHelper = $scope.userHelper;
    var activityLogHelper = $scope.activityLogHelper;

    $scope.curriculum_years = [];

    this.load = () => {
        this.displayCurriculumYears();

        // Initialize default user image
        imageFileHelper.displayDefaultUserImage();
    };

    this.displayCurriculumYears = () => {
        adminCurriculumService.getCurriculumYears().then((curriculum_years) => {
            $scope.curriculum_years = curriculum_years;
        });
    }

    $scope.student = {
        student_id: ''
    };

    $scope.student.email_address = '';

    $scope.saveNewStudent = () => {

        if (!$scope.student.username) $scope.student.username = setUsername();

        if (isFormValid()) {

            verifyStudentIdExists($scope.student.student_id).then(exists => {
                if (!exists) {
                    var title = 'Save new student information';
                    var message = 'Are you sure to save new student information?';

                    dialogHelper.showConfirmation(title, message, (result) => {
                        if (result) {

                            var studentObj = {
                                student_id: $scope.student.student_id,
                                last_name: $scope.student.last_name,
                                first_name: $scope.student.first_name,
                                middle_name: $scope.student.middle_name,
                                gender: $scope.student.gender,
                                birthdate: $scope.student.birthdate,
                                enrolled_curriculum_year: $scope.student.enrolled_curriculum_year.curriculum_year,
                                username: $scope.student.username,
                                email_address: $scope.student.email_address,
                                password: $scope.student.password,
                                image: $scope.student.image
                            };

                            adminStudentsService.saveNewStudent(studentObj).then((res) => {
                                if (res.data.status[0] && res.data.status[1] === true) {

                                    activityLogHelper.registerActivity(`Student: Create new student (${studentObj.student_id}) ${userHelper.getPersonFullname(studentObj)}.`).then(status => {
                                        if (status) {
                                            dialogHelper.showSuccess('New student information has been successfully saved', () => {
                                                window.location = '/admin/students';
                                            });
                                        }
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
            dialogHelper.showError('Invalid inputs', 'Please double check the details you have entered.');
        }
    }

    isFormValid = () => {
        return $scope.studentForm.$valid;
    }

    setUsername = () => {
        if ($scope.student.first_name && $scope.student.last_name) {
            var fname = new String($scope.student.first_name);
            var lname = new String($scope.student.last_name);
            return fname.toLowerCase().replace(" ", "") + "." + lname.toLowerCase().replace(" ", "");
        } else {
            return "";
        }
    }

    verifyStudentIdExists = (studentId) => {
        return adminStudentsService.verifyStudentIdExists(studentId);
    }

    this.load();
}]);