app.controller('teacherAddPostController', ['$scope', 'accountPostService', function ($scope, accountPostService) {

    var dialogHelper = $scope.dialogHelper;
    var activityLogHelper = $scope.activityLogHelper;
    var systemHelper = $scope.systemHelper;
    
    var class_id = ClassGlobalVariable.currentClassId;

    $scope.post_details = {};
    $scope.post_details.class_id = class_id;

    $scope.sendPost = () => {

        var title = "Save post";
        var message = "Are you sure to save this post?";

        dialogHelper.showConfirmation(title, message, (result) => {
            accountPostService.uploadPost($scope.post_details).then((res) => {
                if (res.data.status) {
                    activityLogHelper.registerActivity(`Post: Created new post.`).then(status => {
                        if (status) {
                            dialogHelper.showSuccess("Your post has been posted.", () => {
                                window.location = `/teacher/subject/${class_id}/posts`;
                            });
                        }
                    });
                }
            }, (err) => {
                dialogHelper.showError("Error occured", "Failed to save post. Please try again later.");
            });
        });
    }

    load = () => {
        systemHelper.removePageLoadEffect();
    }

    load();
}]);