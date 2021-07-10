app.controller('teacherAddHomeworksController', ['$scope', '$interval', 'accountHomeworksService', function ($scope, $interval, accountHomeworksService) {

    var dialogHelper = $scope.dialogHelper;
    var imageFileHelper = $scope.imageFileHelper;
    var activityLogHelper = $scope.activityLogHelper;
    var systemHelper = $scope.systemHelper;
    
    $scope.homework = {
        class_id: ClassGlobalVariable.currentClassId,
        title: null,
        description: null,
        is_submit: true,
        due_date: null,
        files: []
    };

    $scope.status = {
        files_loading: false,
        has_files: false,
        saving: false
    }

    $scope.saveNewHomework = () => {

        if ($scope.newHomeworkForm.$valid) {

            var title = "New homework";
            var message = "Are you sure to save new homework?";
            
            dialogHelper.showConfirmation(title, message, (result) => {
                if (result) {
                    $scope.status.saving = true;
                    var due_at = $scope.homework.due_date;
                    $scope.homework.due_date = due_at.getFullYear() + "-" + (due_at.getMonth() + 1) + "-" + due_at.getDate();
                    accountHomeworksService.saveNewHomework($scope.homework).then((res) => {
                        uploadFiles(res.data.homework_id);
                    }, err => {
                        dialogHelper.shoError("Error occured", "Failed to update homework details. Please try again later.");
                    });
                }
            });
        } else {
            dialogHelper.showError("Invalid inputs", "Please fill out all fields.");
        }
    }

    uploadFiles = (homework_id) => {

        // upload all files
        for (var i = 0; i < $scope.homework.files.length; i++) {
            accountHomeworksService.uploadFile(homework_id, $scope.homework.files[i]).then((res) => {});
        }

        $scope.status.saving = false;
        dialogHelper.showSuccess("New Homework has been saved", () => {

            activityLogHelper.registerActivity(`Homework: Created new homework '${$scope.homework.title}'.`).then(status => {
                if (status) {
                    window.location = `/teacher/subject/${$scope.homework.class_id}/homeworks`;
                }
            });
        });
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

    $scope.selectFiles = (fileElem) => {

        var fileItems = fileElem.files;

        if (fileItems.length > 0) {
            $scope.status.files_loading = true;

            for (var pos = 0; pos < fileItems.length; pos++) {
                $scope.homework.files.push(fileItems[pos]);
                $scope.homework.files[pos].fileFormattedSize = imageFileHelper.getFileSize(fileItems[pos]);
            }

            $scope.$apply();
            $scope.status.files_loading = false;
        }
    }

    $scope.clearFiles = () => {
        // Empty files
        $scope.homework.files = [];
    }

    load = () => {
        systemHelper.removePageLoadEffect();
    }

    load();
}]);