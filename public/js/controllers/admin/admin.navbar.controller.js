app.controller('admin-navbar-controller',['$scope', ($scope) => {
    
    var systemHelper = $scope.systemHelper;
    var userHelper = $scope.userHelper;

    $scope.status = [];

    function initialize() {
        userHelper.getCurrentAccountProfilePic();
    }

    var getModulebadgesStatus = function(){

       return new Promise(function(resolve, reject){
            var promises = [];

            ['announcements', 
            'events',
            'students',
            'teachers', 
            'classes', 
            'subjects', 
            'courses', 
            'curriculum'].forEach((el) => {
                promises.push(systemHelper.staticStatus(el));
            });

            Promise.all(promises).then((res) => {
                resolve(res);
            });
        }); 
    }

    initialize();
}]);