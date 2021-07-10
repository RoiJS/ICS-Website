app.controller('aboutUsController', ['$scope', 'homeAnnouncementsService', function($scope, homeAnnouncementsService){
    
    var systemHelper = $scope.systemHelper;
    var datetimeHelper = $scope.datetimeHelper;
    
    $scope.ics_details = {};
    $scope.announcements = [];

    systemHelper.getICSDetails().then((res) => {
        $scope.ics_details = res.data.ics_details;

        // Parse string html
        $scope.ics_details.history = systemHelper.viewStringAsHtml($scope.ics_details.history);
        $scope.ics_details.mission = systemHelper.viewStringAsHtml($scope.ics_details.mission);
        $scope.ics_details.vision = systemHelper.viewStringAsHtml($scope.ics_details.vision);
        $scope.ics_details.objectives = systemHelper.viewStringAsHtml($scope.ics_details.objectives);
        $scope.ics_details.goals = systemHelper.viewStringAsHtml($scope.ics_details.goals);
    });
}]);