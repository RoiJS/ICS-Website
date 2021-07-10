app.service('adminAnnouncementsService',['$http', function($http){
    
    var main_uri = '/admin/announcements';

    this.getAnnouncementsList = () => {
        return $http.get(`${main_uri}/get_announcements`);
    }

    this.saveNewAnnouncement = (data) => {
        var form = new FormData();

        for(var key in data){
            form.append(key, data[key]);
        }

        return $http.post(`${main_uri}/save_new_announcement`, form, {
            transformRequest : angular.identity,
            headers : {
                'Content-Type' : undefined
            }
        });
    }

    this.getCurrentAnnouncement = (announcement_id) => {
        return $http.post(`${main_uri}/get_current_announcement/`, {announcement_id});
    }

    this.saveUpdateAnnouncement = (data) => {
        var form = new FormData();

        for(var key in data){
            form.append(key, data[key]);
        }

        return $http.post(`${main_uri}/save_update_announcement`, form, {
            transformRequest : angular.identity,
            headers : {
                'Content-Type' : undefined
            }
        });
    }

    this.removeAnnouncement = (id) => {
       return $http.delete(`${main_uri}/${id}`);
    }
}]);