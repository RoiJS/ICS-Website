app.controller('teacherClassListController', ['$scope', 'accountClassListService', function ($scope, accountClassListService) {

    var dialogHelper = $scope.dialogHelper;
    var userHelper = $scope.userHelper;
    var imageFileHelper = $scope.imageFileHelper;
    var datetimeHelper = $scope.datetimeHelper;
    var systemHelper = $scope.systemHelper;
    var activityLogHelper = $scope.activityLogHelper;
    var notificationHelper = $scope.notificationHelper;

    var class_id = ClassGlobalVariable.currentClassId;

    $scope.class_lists = [];

    $scope.status = {
        has_class_lists: false,
        class_list_loading: false
    }

    displayClassList = (callback) => {
        $scope.status.class_list_loading = true;
        accountClassListService.getClassList(class_id).then((res) => {
            $scope.status.class_list_loading = false;
            $scope.class_lists = res.data.classes;
            $scope.status.has_class_lists = ($scope.class_lists.length > 0);

            $scope.class_lists.map((c) => {
                c.trimname = systemHelper.trimString(userHelper.getPersonFullname(c), 15);
                c.fullname = userHelper.getPersonFullname(c);
                c.image_source = imageFileHelper.setStudentImage(c.image);
                c.birthdate = datetimeHelper.parseDate(c.birthdate);
            });

            if (callback) callback();
        });
    }

    $scope.removeStudent = (class_index) => {
        var class_list_id = $scope.class_lists[class_index].class_list_id;
        var student_name = $scope.class_lists[class_index].fullname;

        var title = "Unenroll student";
        var message = "Are you sure to remove selected student from the official class list?";

        dialogHelper.showRemoveConfirmation(title, message, (result) => {
            if (result) {
                accountClassListService.removeStudent(class_list_id).then((res) => {
                    if (res.data.status === 1) {
                        activityLogHelper.registerActivity(`Class List: Unenroll student '${student_name}'.`).then(status => {
                            if (status) {
                                notificationHelper.registerNotification(getRemoveStudentToClassNotificationObject(class_index)).then(status => {
                                    dialogHelper.showSuccess("Selected student has been successfully removed from the official class list", () => {
                                        $scope.class_lists.splice(class_index, 1);
                                    });
                                });
                            }
                        });
                    }
                }, (err) => {
                    dialogHelper.showError("Error occured", "Failed to unenroll selected student. Please try again later.");
                });
            }
        });
    }

    getRemoveStudentToClassNotificationObject = (index) => {

        var student_id = $scope.class_lists[index].stud_id;
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
    displayClassList(() => {
        systemHelper.removePageLoadEffect();
    });
}]);