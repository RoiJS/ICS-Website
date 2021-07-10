app.controller('studentViewHomeworkController', ['$scope', 'accountHomeworksService', function ($scope, accountHomeworksService) {

    var datetimeHelper = $scope.datetimeHelper;
    var systemHelper = $scope.systemHelper;
    var imageFileHelper = $scope.imageFileHelper;
    var dialogHelper = $scope.dialogHelper;
    var activityLogHelper = $scope.activityLogHelper;
    var notificationHelper = $scope.notificationHelper;

    $scope.homework = null;
    $scope.file = null;

    var fileItem = null;

    accountHomeworksService.getHomeworkDetails(homework_id, true).then((res) => {

        var homework = res.data.homework;
        var homework_files = res.data.files;
        var submitted_homework = res.data.submitted_homework;

        $scope.homework = homework;
        $scope.homework.files = homework_files;

        $scope.homework.files.map((f) => {
            f.file_path = `${imageFileHelper.getFileSrc().homeworks.send}${f.generated_file_name}`;
        });

        $scope.homework.due_date = datetimeHelper.parseDate($scope.homework.due_at);
        $scope.homework.description = systemHelper.viewStringAsHtml($scope.homework.description);

        if (submitted_homework.original_file_name && submitted_homework.generated_file_name) {
            $scope.file = submitted_homework;
            $scope.file.name = $scope.file.original_file_name;
            $scope.file.fileFormattedSize = imageFileHelper.getFileSize($scope.file);
        }

        // Remove loader 
        systemHelper.removePageLoadEffect();
    });

    $scope.submitFile = () => {

        var title = "Submit file";
        var message = "Are you sure to submit file?";

        if (fileItem) {
            dialogHelper.showConfirmation(title, message, (result) => {
                if (result) {
                    accountHomeworksService.submitFile($scope.homework.homework_id, fileItem).then((res) => {
                        activityLogHelper.registerActivity(`Homework: Submitted file on homework '${$scope.homework.title}'.`).then(status => {
                            if (status) {
                                notificationHelper.registerNotification(getSubmitHomeworkNotificationObject()).then(status => {
                                    window.location.reload();
                                });
                            }
                        });
                    });
                }
            });
        } else {
            dialogHelper.showError("Empty file", "Please select file to upload.");
        }
    }

    getSubmitHomeworkNotificationObject = () => {

        var description = `Submitted file on homework '${$scope.homework.title}'.`;
        var path = notificationHelper.notificationPaths.teacherHomework(ClassGlobalVariable.currentClassId, $scope.homework.homework_id);

        return {
            notify_to: ClassGlobalVariable.currentClassTeacherId,
            notify_to_user_type: 'teacher',
            description: description,
            path: path
        }
    }

    $scope.selectFiles = (fileElem) => {

        var fileItems = fileElem.files;

        if (fileItems.length > 0) {
            for (var pos = 0; pos < fileItems.length; pos++) {
                $scope.file = {
                    fileFormattedSize: imageFileHelper.getFileSize(fileItems[pos]),
                    name: fileItems[pos].name
                };

                fileItem = fileItems[pos];
            }
        }
    }

    $scope.clearFile = () => {
        $scope.file = null;
        fileItem = null;
    }
}]);