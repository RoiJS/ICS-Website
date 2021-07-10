app.controller('adminAddAnnouncmentsController', ['$scope', 'adminAnnouncementsService', function ($scope, adminAnnouncementsService) {

    var systemHelper = $scope.systemHelper;
    var dialogHelper = $scope.dialogHelper;
    var activityLogHelper = $scope.activityLogHelper;

    systemHelper.getOfficialLogo();
    $scope.announcement = {};

    $scope.submitNewAnnouncement = function () {

        if ($scope.announcementForm.$valid) {

            var title = "Add new announcement";
            var message = "Are you sure to save new announcement?";

            dialogHelper.showConfirmation(title, message, (result) => {
                if (result) {
                    adminAnnouncementsService.saveNewAnnouncement($scope.announcement).then((res) => {
                        if (res.data.status) {
                            activityLogHelper.registerActivity(`Announcement: Create new announcement ${$scope.announcement.title}.`).then(status => {
                                dialogHelper.showSuccess("New announcement has been successfully saved.", () => {
                                    window.location = '/admin/announcements';
                                });
                            });
                        }
                    }, (err) => {
                        dialogHelper.showError("Error occured", "Failed to save new announcement. Please try again later.");
                    });
                }
            });
        } else {
            dialogHelper.showError("Invalid inputs", "Process cannot be done for a field that is of great importance seems to be empty!");
        }
    }
}]);