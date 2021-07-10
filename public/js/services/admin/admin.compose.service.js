app.service('adminComposeService',['$http', function($http){
    var main_uri = "/admin/messages";

    this.sendMessage = (message) => {
        return $http.post(`${main_uri}/send_message`, {message});
    }
}]);
