app.controller('homeReadAnnouncementController', ['$scope', 'homeAnnouncementsService', function($scope, homeAnnouncementsService ){

    var datetimeHelper = $scope.datetimeHelper;
    var systemHelper = $scope.systemHelper;

    $scope.announcement = {};

    homeAnnouncementsService.getAnnouncementDetails(announcement_id).then((res) => {
        $scope.announcement = res.data.announcement;

        $scope.announcement.posted_date = datetimeHelper.parseDate($scope.announcement.created_at);
        $scope.announcement.description = systemHelper.viewStringAsHtml($scope.announcement.description);
    });

}]);