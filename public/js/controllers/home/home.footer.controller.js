app.controller('homeFooterController',['$scope', function($scope){
    
    var systemHelper = $scope.systemHelper;
    var imageFileHelper = $scope.imageFileHelper;
    
    $scope.ics_details = {};

    systemHelper.getICSDetails().then((res) => {
        $scope.ics_details = res.data.ics_details;
        $scope.ics_details.image_path = imageFileHelper.getFileSrc().ics_logo + $scope.ics_details.ics_logo;
        $scope.ics_details.history = systemHelper.trimString($scope.ics_details.history, 200);
    });
}]);