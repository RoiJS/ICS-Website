app.controller('adminEditStudentController', ['$scope', 'adminStudentsService', 'adminCurriculumService', function ($scope, adminStudentsService, adminCurriculumService) {

    var dialogHelper = $scope.dialogHelper;
    var imageFileHelper = $scope.imageFileHelper;
    var userHelper = $scope.userHelper;
    var activityLogHelper = $scope.activityLogHelper;

    $scope.student = {};
    $scope.new_password = "";
    $scope.confirm_new_password = "";
    $scope.curriculum_years = [];

    this.getCurrentStudentInformation = () => {
        adminStudentsService.getCurrentStudent(student_id).then((res) => {
            $scope.student = res.data.student;
            $scope.student.birthdate = new Date($scope.student.birthdate);
            $scope.student.image_source = imageFileHelper.setStudentImage($scope.student.image);
            $scope.student.curriculum_year = {
                curriculum_year: $scope.student.curriculum_year
            }
        });
    }

    this.displayCurriculumYears = () => {
        adminCurriculumService.getCurriculumYears().then((curriculum_years) => {
            $scope.curriculum_years = curriculum_years;
        });
    }

    this.load = () => {
        this.getCurrentStudentInformation();
        this.displayCurriculumYears();
    }

    $scope.saveUpdateStudent = () => {

        if (isFormValid()) {
            var title = 'Save changes';
            var message = 'Are you sure to save changes?';
            dialogHelper.showConfirmation(title, message, (result) => {
                if (result) {

                    // If entered new password, replace the old one.
                    if ($scope.new_password) $scope.student.password = $scope.new_password;

                    var studentObj = {
                        stud_id: $scope.student.stud_id,
                        student_id: $scope.student.student_id,
                        last_name: $scope.student.last_name,
                        first_name: $scope.student.first_name,
                        middle_name: $scope.student.middle_name,
                        gender: $scope.student.gender,
                        birthdate: $scope.student.birthdate,
                        enrolled_curriculum_year: $scope.student.curriculum_year.curriculum_year,
                        username: $scope.student.username,
                        email_address: $scope.student.email_address,
                        password: $scope.student.password,
                        image: $scope.student.image
                    };

                    adminStudentsService.saveUpdateStudent(studentObj).then((res) => {
                        activityLogHelper.registerActivity(`Student: Updated student (${studentObj.student_id}) ${userHelper.getPersonFullname(studentObj)}.`).then(status => {
                            if (status) {
                                dialogHelper.showSuccess('Changes has been successfully saved.', () => {
                                    window.location = '/admin/students';
                                });
                            }
                        });
                    }, (err) => {
                        dialogHelper.showError('Error occured', 'Failed to save changes. Please try it again later.');
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
        return $scope.studentEditForm.$valid && isPasswordMatched();
    }

    this.load();
}]);