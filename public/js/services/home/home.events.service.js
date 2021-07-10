app.service('homeEventsService', ['$http', function($http){

    var main_uri = "/events";
    this.getLatestEvents = () => {
        return $http.get(`${main_uri}/get_latest_events`);
    }

    this.getAllEvents = () => {
        return $http.get(`${main_uri}/get_all_events`);
    }
}]);