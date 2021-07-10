app.controller('homeSideAnnouncementController', ['$scope', 'homeAnnouncementsService', function($scope, homeAnnouncementsService){

    var systemHelper = $scope.systemHelper;
    var datetimeHelper = $scope.datetimeHelper;

    $scope.announcements = [];

    homeAnnouncementsService.getLatestAnnouncments().then((res) => {
        $scope.announcements = res.data.announcements;

        $scope.announcements.map(a => {
            a.title = systemHelper.trimString(a.title);
            a.image_path = systemHelper.viewAnnouncementImage(a.generated_filename);
            a.description = systemHelper.trimString(systemHelper.viewHTMLAsText(a.description), 200);
            a.posted_date = datetimeHelper.parseDate(a.post_date);
        });
    });
}]);
   