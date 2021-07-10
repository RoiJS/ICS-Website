app.service('registerAccountService', ['$http', function($http){
    
    var main_uri = "/access"
    this.saveNewAccount = (account) => {
        return $http.post(`${main_uri}/save_new_account`,{account})
    }
}]);