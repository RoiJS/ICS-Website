app.service('homeAnnouncementsService', ['$http', function($http){

    var main_uri = "/announcements";

    this.getLatestAnnouncments = () => {
        return $http.get(`${main_uri}/get_latest_announcments`);
    }

    this.getAllAnnouncements = () => {
        return $http.get(`${main_uri}/get_all_announcements`);
    }

    this.getAnnouncementDetails = (announcement_id) => {
        return $http.post(`${main_uri}/get_announcement_details`, {announcement_id});
    }
}]);