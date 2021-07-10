app.controller('teacherHomeworksController', ['$scope', 'accountHomeworksService', function ($scope, accountHomeworksService) {

    var dialogHelper = $scope.dialogHelper;
    var dataTableHelper = $scope.dataTableHelper;
    var systemHelper = $scope.systemHelper;
    var datetimeHelper = $scope.datetimeHelper;
    var activityLogHelper = $scope.activityLogHelper;
    var notificationHelper = $scope.notificationHelper;

    var class_id = ClassGlobalVariable.currentClassId;

    $scope.tableHomeworksList = null;

    $scope.status = {
        homeworks_loading: false,
        has_homeworks: false
    }

    $scope.homeworks = [];

    displayHomeworks = () => {
        $scope.status.homeworks_loading = true;
        accountHomeworksService.getHomeworks(class_id).then((res) => {
            $scope.homeworks = res.data.homeworks;
            $scope.status.has_homeworks = $scope.homeworks.length > 0 ? true : false;
            $scope.status.homeworks_loading = false;

            $scope.homeworks.map((h) => {
                h.show_title = systemHelper.trimString(h.title, 20);
                h.show_due_at = datetimeHelper.parseDate(h.due_at);
                h.show_send_at = datetimeHelper.parseDate(h.send_at);
            });

            $scope.tableHomeworksList = dataTableHelper.initializeDataTable({}, {
                dataset: $scope.homeworks
            });

            // Remove loader 
            systemHelper.removePageLoadEffect();
        });
    }

    $scope.sendHomework = (homework_id) => {

        var title = "Send homework";
        var message = "Are you sure to send this homework to class?";
        var homework_title = $(`.homework-id-${homework_id} td.homework-title`).data("homework-title");

        dialogHelper.showConfirmation(title, message, (result) => {
            if (result) {
                accountHomeworksService.sendHomework(homework_id).then((res) => {
                    if (res.data.status) {
                        activityLogHelper.registerActivity(`Homework: Send homework '${homework_title}'.`).then(status => {
                            if (status) {
                                notificationHelper.registerSendUnsendHomeworkNotification(getSendHomeworkNotificationObject(class_id, homework_id)).then(status => {
                                    displayHomeworks()
                                });
                            }
                        });
                    }
                });
            }
        });
    }

    getSendHomeworkNotificationObject = (class_id, homework_id) => {

        var homework_title = $(`.homework-id-${homework_id} td.homework-title`).data("homework-title");
        var description = `Assigned you a homework entitled ${homework_title}`;
        var path = notificationHelper.notificationPaths.studentHomework(class_id, homework_id);

        return {
            class_id: class_id,
            description: description,
            path: path
        }
    }

    getUnsendHomeworkNotificationObject = (class_id, homework_id) => {

        var homework_title = $(`.homework-id-${homework_id} td.homework-title`).data("homework-title");
        var description = `Remove homework entitled ${homework_title}`;
        var path = notificationHelper.notificationPaths.studentHomeworkHome(class_id);

        return {
            class_id: class_id,
            description: description,
            path: path
        }
    }

    $scope.unsendHomework = (homework_id) => {

        var title = "Unsend homework";
        var message = "Are you sure to unsend homework?";
        var homework_title = $(`.homework-id-${homework_id} td.homework-title`).data("homework-title");

        dialogHelper.showConfirmation(title, message, (result) => {
            if (result) {
                accountHomeworksService.unsendHomework(homework_id).then((res) => {
                    if (res.data.status) {
                        activityLogHelper.registerActivity(`Homework: Unsend homework '${homework_title}'.`).then(status => {
                            if (status) {
                                notificationHelper.registerSendUnsendHomeworkNotification(getUnsendHomeworkNotificationObject(class_id, homework_id)).then(status => {
                                    displayHomeworks()
                                });
                            }
                        });
                    }
                });
            }
        });
    }

    $scope.removeHomework = (homework_id) => {

        var title = "Remove homework";
        var message = "Are you sure to remove selected homework?";
        var homework_title = $(`.homework-id-${homework_id} td.homework-title`).data("homework-title");

        dialogHelper.showRemoveConfirmation(title, message, (result) => {
            if (result) {
                accountHomeworksService.removeHomework(homework_id).then((res) => {
                    if (res.data.status) {
                        activityLogHelper.registerActivity(`Homework: Delete homework '${homework_title}'.`).then(status => {
                            if (status) {
                                displayHomeworks()
                            }
                        });
                    }
                });
            }
        });
    }

    displayHomeworks();
}]);