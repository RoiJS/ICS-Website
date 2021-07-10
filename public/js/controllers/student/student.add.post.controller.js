app.controller('studentAddPostController', ['$scope', 'accountPostService', function ($scope, accountPostService) {

    var dialogHelper = $scope.dialogHelper;
    var activityLogHelper = $scope.activityLogHelper;
    var systemHelper = $scope.systemHelper;

    var class_id = ClassGlobalVariable.currentClassId;

    $scope.post_details = {};
    $scope.post_details.class_id = class_id;

    $scope.sendPost = () => {

        var title = "Create post";
        var message = "Are you sure to upload this post?";

        dialogHelper.showConfirmation(title, message, (result) => {
            if (result) {
                accountPostService.uploadPost($scope.post_details).then((res) => {
                    if (res.data.status === true) {
                        activityLogHelper.registerActivity(`Post: Created a post.`).then(status => {
                            if (status) {
                                dialogHelper.showSuccess("New post has been successfully saved.", () => {
                                    window.history.back()
                                });
                            }
                        });
                    }
                }, () => {
                    dialogHelper.showError("Error occured", "Unable to save post. Please try again later.");
                });
            }
        });
    }

    load = () => {
        systemHelper.removePageLoadEffect();
    }

    load();
}]);