app.service('accountCommentsService', ['$http', function($http){

    var main_uri = "/comments";
    
    this.getComments = (post_id) => {
        return $http.post(`${main_uri}/get_comments`,{post_id});
    }

    this.sendComment = (comment) => {
        return $http.post(`${main_uri}/send_new_comment`, {comment});
    }

    this.saveEditComment = (comment) => {
        return $http.put(`${main_uri}/save_edit_comment`, {comment});
    }

    this.removeComment = (comment_id) => {
        return $http.delete(`${main_uri}/${comment_id}`);
    }
}]);