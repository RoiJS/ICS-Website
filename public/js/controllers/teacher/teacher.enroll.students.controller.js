app.controller('teacherEnrollStudentsController', ['$scope', 'accountClassListService', function ($scope, accountClassListService) {

    var dialogHelper = $scope.dialogHelper;
    var imageFileHelper = $scope.imageFileHelper;
    var userHelper = $scope.userHelper;
    var datetimeHelper = $scope.datetimeHelper;
    var dataTableHelper = $scope.dataTableHelper;
    var activityLogHelper = $scope.activityLogHelper;
    var notificationHelper = $scope.notificationHelper;
    var systemHelper = $scope.systemHelper;

    var class_id = ClassGlobalVariable.currentClassId;

    $scope.students = [];
    $scope.tableStudentList = null;

    $scope.status = {
        students_loading: false,
        has_students: false
    }

    $scope.displayStudents = (callback) => {
        $scope.status.students_loading = true;
        accountClassListService.getStudentList(class_id).then((res) => {
            $scope.status.students_loading = false;
            $scope.students = res.data.students;
            $scope.status.has_students = ($scope.students.length > 0);

            $scope.students.map((s) => {
                s.image_source = imageFileHelper.setStudentImage(s.image);
                s.fullname = userHelper.getPersonFullname(s);
                s.birthdate = datetimeHelper.parseDate(s.birthdate);
            });

            $scope.tableStudentList = dataTableHelper.initializeDataTable({}, {
                dataset: $scope.students
            });

            if (callback) callback();
        });
    }

    $scope.displayStudents(() => {
        systemHelper.removePageLoadEffect();
    });

    $scope.enrollStudent = (index) => {
        var studentList = $scope.tableStudentList.data;
        var student_id = studentList[index].stud_id;
        var student_name = studentList[index].fullname;

        var title = "Enroll student";
        var message = "Are you sure to enroll selected student?";

        dialogHelper.showConfirmation(title, message, (result) => {
            if (result) {
                accountClassListService.enrollStudent({
                    class_id,
                    student_id
                }).then((res) => {
                    if (res.data.status) {

                        activityLogHelper.registerActivity(`Class List: Enrolled student '${student_name}'.`).then(status => {
                            if (status) {
                                notificationHelper.registerNotification(getAddStudentToClassNotificationObject(index)).then(status => {
                                    studentList[index].is_enrolled = true;
                                    $scope.$apply();
                                });
                            }
                        });
                    }
                }, (err) => {
                    dialogHelper.showError("Error occured", "Failed to enroll selected student. Please try again later.");
                })
            }
        });
    }

    getAddStudentToClassNotificationObject = (index) => {

        var studentList = $scope.tableStudentList.data;
        var student_id = studentList[index].stud_id;
        var class_id = ClassGlobalVariable.currentClassId;
        var subject_name = ClassGlobalVariable.currentClassDescription;
        var subject_code = ClassGlobalVariable.currentClassCode;
        var description = `You have been enrolled to class (${subject_code}) ${subject_name}`;
        var path = notificationHelper.notificationPaths.studentClass(class_id);

        return {
            notify_to: student_id,
            notify_to_user_type: 'student',
            description: description,
            path: path
        }
    }

    $scope.unenrollStudent = (index) => {

        var studentList = $scope.tableStudentList.data;
        var student_id = studentList[index].stud_id;
        var student_name = studentList[index].fullname;

        var title = "Unenroll student";
        var message = "Are you sure to unenroll selected student?";

        dialogHelper.showRemoveConfirmation(title, message, (result) => {
            if (result) {
                accountClassListService.unenrollStudent({
                    class_id,
                    student_id
                }).then((res) => {
                    if (res.data.status) {

                        activityLogHelper.registerActivity(`Class List: Unenrolled student '${student_name}'.`).then(status => {
                            if (status) {
                                notificationHelper.registerNotification(getRemoveStudentToClassNotificationObject(index)).then(status => {
                                    studentList[index].is_enrolled = false;
                                    $scope.$apply();
                                });
                            }
                        });
                    }
                }, (err) => {
                    dialogHelper.showError("Error occured", "Failed to unenroll selected student. Please try again later.");
                })
            }
        });
    }

    getRemoveStudentToClassNotificationObject = (index) => {

        var studentList = $scope.tableStudentList.data;
        var student_id = studentList[index].stud_id;
        var class_id = ClassGlobalVariable.currentClassId;
        var subject_name = ClassGlobalVariable.currentClassDescription;
        var subject_code = ClassGlobalVariable.currentClassCode;
        var description = `You have been removed from class (${subject_code}) ${subject_name}`;
        var path = notificationHelper.notificationPaths.studentHome();

        return {
            notify_to: student_id,
            notify_to_user_type: 'student',
            description: description,
            path: path
        }
    }
}]);