app.controller('studentEditPostController', ['$scope', 'accountPostService', function ($scope, accountPostService) {

    var dialogHelper = $scope.dialogHelper;
    var activityLogHelper = $scope.activityLogHelper;
    var systemHelper = $scope.systemHelper;

    var class_id = ClassGlobalVariable.currentClassId;

    $scope.post_details = {};
    $scope.post_details.post_id = post_id;

    accountPostService.getPostDetails(post_id).then((res) => {
        $scope.post_details = res.data.post;
    });

    $scope.saveUpdatePost = () => {

        var title = "Update post";
        var message = "Are you sure to update this post?";

        dialogHelper.showConfirmation(title, message, (result) => {
            if (result) {
                accountPostService.saveUpdatePost($scope.post_details).then((res) => {
                    if (res.data.status) {
                        activityLogHelper.registerActivity(`Post: Updated post.`).then(status => {
                            if (status) {
                                dialogHelper.showSuccess("Your post has been updated.", () => {
                                    window.location = `/student/subject/${class_id}/posts`;
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