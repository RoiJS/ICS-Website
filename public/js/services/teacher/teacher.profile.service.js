app.service('teacherProfileService', ['$http', function($http){
    
    var main_uri = "/teacher/profile";

    this.getTeacherProfile = () => {
        return $http.get(`${main_uri}/get_teacher_profile`);
    }

    this.saveNewLogo = (image) => {
        var form = new FormData();
        form.append('image', image);
        console.log(image);
        
        return $http.post(`${main_uri}/save_update_logo`, form, {
            transformRequest : angular.identity,
            headers : {
                'Content-Type' : undefined
            }
        });
    }

    this.saveUpdatePersonalInfo = (info) => {
        return $http.put(`${main_uri}/save_update_personal_info`, {info});
    }

    this.saveUpdateAccountInfo = (info) => {
        return $http.put(`${main_uri}/save_update_account_info`, {info});
    }
}]);