app.controller('studentHomeworksController', ['$scope', 'accountHomeworksService', function($scope, accountHomeworksService){

    var systemHelper = $scope.systemHelper;
    
    var class_id = ClassGlobalVariable.currentClassId;
    
    $scope.homeworks = [];

    $scope.status = {
        homeworks_loading: false,
        has_homeworks: false
    }

    displayHomeworks = (callback) => {
        $scope.status.homeworks_loading = true;
        accountHomeworksService.getStudentHomeworks(class_id).then((res) => {
            $scope.status.homeworks_loading = false;
            $scope.homeworks = res.data.homeworks;
            $scope.status.has_homeworks = $scope.homeworks.length > 0 ? true : false;
        });
    }

    displayHomeworks(() => {
        systemHelper.removePageLoadEffect();
    });
}]);