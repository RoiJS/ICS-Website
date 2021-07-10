app.controller('teacherPostsController', ['$scope', 'accountPostService', 'accountCommentsService', function ($scope, accountPostService, accountCommentsService) {

    var dialogHelper = $scope.dialogHelper;
    var systemHelper = $scope.systemHelper;
    var userHelper = $scope.userHelper;
    var datetimeHelper = $scope.datetimeHelper;
    var userHelper = $scope.userHelper;
    var activityLogHelper = $scope.activityLogHelper;

    var currentUser = null;

    var class_id = ClassGlobalVariable.currentClassId;

    var lazyLoadingSettings = {
        postFrom: 1,
        postTo: 10,
        postPerRequests: 10
    };

    $scope.absoluteCount = 0;

    $scope.posts = [];

    $scope.status = {
        post_loading: false,
        has_posts: false
    }

    getPosts = (class_id) => {
        $scope.status.post_loading = true;
        accountPostService.getPosts(class_id, lazyLoadingSettings.postFrom, lazyLoadingSettings.postTo).then((res) => {
            $scope.status.post_loading = false;

            addPosts(res.data.posts);
            $scope.absoluteCount = res.data.absoluteCount;

            $scope.posts.map(post => {
                post.user_image = systemHelper.displayChatImage(post.poster.type, post.poster.image);
                post.poster_name = userHelper.getPersonFullname(post.poster);
                post.post_date = datetimeHelper.parseDate(post.post_at, 'medium');
                post.post_description = systemHelper.viewStringAsHtml(post.description);

                post.comments.map(comment => {
                    comment.user_image = systemHelper.displayChatImage(comment.commenter.type, comment.commenter.image);
                    comment.commenter_name = userHelper.getPersonFullname(comment.commenter);
                    comment.comment_date = datetimeHelper.parseDate(comment.commented_at, 'medium');
                });
            });

            // Display user photo
            userHelper.getCurrentAccountProfilePic();

            // Remove loader 
            systemHelper.removePageLoadEffect();

        });
    }



    $scope.removePost = (index) => {

        var post_id = $scope.posts[index].post_id;

        var title = "Remove post";
        var message = "Are you sure to remove this post?";

        dialogHelper.showRemoveConfirmation(title, message, (result) => {
            if (result) {
                accountPostService.removePost(post_id).then((res) => {
                    if (res.data.status === 1) {

                        activityLogHelper.registerActivity(`Post: Delete post.`).then(status => {
                            if (status) {
                                dialogHelper.showSuccess('Selected post has been successfully removed.', () => {
                                    window.location.reload();
                                });
                            }
                        });
                    }
                }, (err) => {
                    dialogHelper.showError("Error occured", "Failed to remove post. Please try again later.");
                });
            }
        });
    }

    addPosts = (posts) => {
        for (var pos = 0; pos < posts.length; pos++) {
            $scope.posts.push(posts[pos]);
        }
    }

    $scope.seeMorePosts = () => {
        lazyLoadingSettings.postFrom += lazyLoadingSettings.postPerRequests;
        lazyLoadingSettings.postTo += lazyLoadingSettings.postPerRequests;
        getPosts(class_id);
    }

    this.load = () => {
        getPosts(class_id);
    }

    this.load();
}]);