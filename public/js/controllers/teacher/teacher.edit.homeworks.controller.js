app.controller('teacherEditContoller', ['$scope', '$interval', 'accountHomeworksService', function ($scope, $interval, accountHomeworksService) {

    var imageFileHelper = $scope.imageFileHelper;
    var dialogHelper = $scope.dialogHelper;
    var activityLogHelper = $scope.activityLogHelper;
    var systemHelper = $scope.systemHelper;

    $scope.homework = {};
    $scope.newFiles = [];

    $scope.status = {
        files_loading: false,
        has_files: false,
        saving: false
    }

    accountHomeworksService.getHomeworkDetails(homework_id, false).then((res) => {
        $scope.homework = res.data.homework;
        $scope.homework.due_date = new Date(res.data.homework.due_at);
        $scope.homework.is_submit = res.data.homework.send_status == 1 ? true : false;
        $scope.homework.files = res.data.files;

        $scope.homework.files.map((file) => {
            file.name = file.original_file_name;
            file.fileFormattedSize = imageFileHelper.getFileSize(file);
        });
        $scope.status.has_files = ($scope.homework.files.length > 0);

        systemHelper.removePageLoadEffect();
    });

    $scope.saveUpdateHomework = () => {

        var title = "Update homework";
        var message = "Are you sure to update selected homework?";

        dialogHelper.showConfirmation(title, message, (result) => {
            if (result) {
                $scope.status.saving = true;
                var due_at = $scope.homework.due_date;
                $scope.homework.due_date = due_at.getFullYear() + "-" + (due_at.getMonth() + 1) + "-" + due_at.getDate();
                accountHomeworksService.saveUpdateHomework($scope.homework).then((res) => {
                    uploadFiles(res.data.homework_id);
                }, err => {
                    dialogHelper.shoError("Error occured", "Failed to update homework details. Please try again later.");
                });
            }
        });
    }

    uploadFiles = (homework_id) => {

        // upload all files
        for (var i = 0; i < $scope.newFiles.length; i++) {
            accountHomeworksService.uploadFile(homework_id, $scope.newFiles[i]).then((res) => {});
        }

        $scope.status.saving = false;
        activityLogHelper.registerActivity(`Homework: Updated homework '${$scope.homework.title}'.`).then(status => {
            if (status) {
                dialogHelper.showSuccess("Homework has been updated", () => {
                    window.location = `/teacher/subject/${$scope.homework.class_id}/homeworks`;
                });
            }
        });
    }

    $scope.selectFiles = (fileElem) => {

        var fileItems = fileElem.files;

        if (fileItems.length > 0) {
            $scope.status.files_loading = true;

            for (var pos = 0; pos < fileItems.length; pos++) {

                var tempFileItems = {
                    fileFormattedSize: imageFileHelper.getFileSize(fileItems[pos]),
                    name: fileItems[pos].name,
                };

                $scope.homework.files.push(tempFileItems);

                // Store new files
                $scope.newFiles.push(fileItems[pos]);
            }

            $scope.$apply();
            $scope.status.files_loading = false;
        }
    }

    $scope.removeFile = (index) => {

        var title = "Remove file";
        var message = "Are you sure to remove selected file?";

        dialogHelper.showRemoveConfirmation(title, message, (result) => {
            if (result) {
                $scope.homework.files.splice(index, 1);
                $scope.$apply();
            }
        });
    }

    $scope.clearFiles = () => {
        // Empty files
        $scope.homework.files = [];
    }
}]);