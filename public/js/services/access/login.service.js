app.factory('LoginService',['$http', ($http) => {

    return {
        authenticateAccount : (username, password) => {
            return $http({
                url : `/access/authenticate`,
                method : 'POST',
                data : {
                    username, password
                }
            }).then((res) => {
                return res.data;
            });
        }
    }
}]);