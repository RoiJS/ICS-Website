app.controller('adminEditAnnouncementsController', ['$scope', 'adminAnnouncementsService', function ($scope, adminAnnouncementsService) {

    var systemHelper = $scope.systemHelper;
    var dialogHelper = $scope.dialogHelper;
    var imageFileHelper = $scope.imageFileHelper;
    var datetimeHelper = $scope.datetimeHelper;
    var activityLogHelper = $scope.activityLogHelper;

    $scope.announcement = {};

    adminAnnouncementsService.getCurrentAnnouncement(announcement_id).then((res) => {
        $scope.announcement = res.data.announcement;
        $scope.announcement.file = imageFileHelper.getFileSrc().announcements + $scope.announcement.generated_filename;
    });

    $scope.saveUpdateAnnouncement = () => {
        if ($scope.announcementEditForm.$valid) {

            var title = "Save changes";
            var message = "Are you sure to update selected announcement?";

            dialogHelper.showConfirmation(title, message, (result) => {
                if (result) {
                    adminAnnouncementsService.saveUpdateAnnouncement($scope.announcement).then((res) => {

                        activityLogHelper.registerActivity(`Announcment: Updated announcement ${$scope.announcement.title} information.`).then(status => {
                            if (status) {
                                dialogHelper.showSuccess("Selected announcement has been successfully updated", () => {
                                    window.location = '/admin/announcements';
                                });
                            }
                        });
                    }, (error) => {
                        dialogHelper.showError("Error occured", "Failed to update announcement. Please try again later.");
                    });
                }
            });
        }
    }
}]);