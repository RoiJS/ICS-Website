app.service('accountPostService', ['$http', function($http){

    var main_uri = "/posts";
    this.uploadPost = (post_details) => {
        return $http.post(`${main_uri}/save_new_post`, {post_details});
    }

    this.getPosts = (classId, postFrom, postTo) => {
        return $http.post(`${main_uri}/get_posts`, {
            post_from: postFrom, 
            post_to: postTo,
            class_id: classId 
        });
    }

    this.removePost = (post_id) => {
        return $http.delete(`${main_uri}/${post_id}`);
    }

    this.saveUpdatePost = (post) => {
        return $http.put(`${main_uri}/save_update_post`, {post});
    }

    this.getPostDetails = (post_id) => {
        return $http.post(`${main_uri}/get_post_details`, {post_id});
    }
}]);