app.controller('studentCommentsCotroller', ['$scope', '$filter', 'accountCommentsService', function($scope, $filter, accountCommentsService){

    var userHelper = $scope.userHelper;
    var systemHelper = $scope.systemHelper;
    var datetimeHelper = $scope.datetimeHelper;

    $scope.account_details = {};
    $scope.user_info = {};
    
    $scope.comment = {
        account_id : null,
        comment : null,
        comment_id : null,
        commented_at : $filter('date')(new Date(), 'medium'),
        commenter : {
                last_name : null,
                first_name : null,
                middle_name : null,
                type : null,
                image : null
            },
        is_comment : true,
        is_edit : false,
        post_id : null,
        updated_at : null
    };

    // userHelper.getCurrentAccount().then((res) => {
    //     $scope.account_details = res.data.account;
    //     $scope.comment.account_id = $scope.account_details.account_id;
        
    //     userHelper.getCurrentUserInfo($scope.account_details.account_id).then((res) => {
    //         $scope.user_info = res.data.user_info;
    //         $scope.comment.commenter.last_name = $scope.user_info.last_name;
    //         $scope.comment.commenter.first_name = $scope.user_info.first_name;
    //         $scope.comment.commenter.middle_name = $scope.user_info.middle_name;
    //         $scope.comment.commenter.type = $scope.user_info.type;
    //         $scope.comment.commenter.image = $scope.user_info.image;
    //     });
    // });

    $scope.sendComment = (postIndex) => {
        var post_id = $scope.posts[postIndex].post_id;

        if($scope.comment){
            var comment = $.extend({}, $scope.comment);
            comment.post_id = post_id;
            accountCommentsService.sendComment(comment).then((res) => {
                if(res.data.comment){
                    var newComment = res.data.comment;
                    newComment.user_image = systemHelper.displayChatImage(newComment.commenter.type, newComment.commenter.image);
                    newComment.commenter_name = userHelper.getPersonFullname(newComment.commenter);
                    newComment.comment_date = datetimeHelper.parseDate(newComment.commented_at, 'medium');
                    $scope.posts[postIndex].comments.push(newComment);
                    $scope.comment.comment = ""; // Clear comment
                }
            });
        }
    }

    $scope.saveEditComment = (post_index, comment_index) => {
        var post_id = $scope.posts[post_index].post_id;
        var comment_id = $scope.posts[post_index].comments[comment_index].comment_id;
        var comment = $scope.posts[post_index].comments[comment_index].comment;

        accountCommentsService.saveEditComment({comment_id, comment}).then((res) => {
            $scope.posts[post_index].comments[comment_index].is_edit = false;
        });
    }

    $scope.removeComment = (post_index, comment_index) => {
        var comment_id = $scope.posts[post_index].comments[comment_index].comment_id;
        
        accountCommentsService.removeComment(comment_id).then((res) => {
            if(res.data.status == 1){
                $scope.$parent.posts[post_index].comments.splice(comment_index,1);
            }
        });
    }


}]);