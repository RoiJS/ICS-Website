app.controller('homeAnnouncementController', ['$scope', 'homeAnnouncementsService', function($scope, homeAnnouncementsService){

    var systemHelper = $scope.systemHelper;
    var datetimeHelper = $scope.datetimeHelper;
    var dataTableHelper = $scope.dataTableHelper;

    $scope.tableAnnouncementList = null;
    
    $scope.announcements = [];

    homeAnnouncementsService.getAllAnnouncements().then((res) => {
        $scope.announcements = res.data.announcements;

        $scope.announcements.map(a => {
            a.image_path = systemHelper.viewAnnouncementImage(a.generated_filename);
            a.description = systemHelper.trimString(systemHelper.viewHTMLAsText(a.description), 200);
            a.posted_date = datetimeHelper.parseDate(a.post_date);
        });

        $scope.tableAnnouncementList = dataTableHelper.initializeDataTable({}, {
            dataset: $scope.announcements
        });
    });

}]);