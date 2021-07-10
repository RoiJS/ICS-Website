app.service('accountDetailsService', ['$http', function($http) {
    var service = {};

    service.getAccountDetails = () => {
        return $http({
            url : '/access/get_account_details',
            method : 'GET'
        });
    }
    return service;
}]);