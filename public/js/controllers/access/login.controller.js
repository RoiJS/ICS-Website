app.controller('login-controller', ['$scope', 'LoginService', ($scope, LoginService) => {

    $scope.login = {
        username : '',
        password : '',
        authenticating : false,
        error : false,
        errorMessage : ''
    };

    $scope.authenticate = () => {

        $scope.login.authenticating = true;
        
        LoginService.authenticateAccount($scope.login.username, $scope.login.password).then((data) => {
           
            if(data.status){
                if(data.type === 'admin'){
                     window.location = '/admin';
                }else if(data.type === 'student'){
                    window.location = '/student';
                }else if(data.type === 'teacher'){
                    window.location = '/teacher';
                }
            }else{
                $scope.login.authenticating = false;
                $scope.login.error = true;
                $scope.login.errorMessage = data.message;
                $scope.login.username = '';
                $scope.login.password = '';  
            }
        }, (err) => {
            $scope.error = true;
            $scope.errorMessage = err.data;
        });
    }
}]);