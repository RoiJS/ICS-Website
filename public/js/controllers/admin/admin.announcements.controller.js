app.controller('adminAnnouncementController', ['$scope', '$filter', 'adminAnnouncementsService', 'NgTableParams', ($scope, $filter, adminAnnouncementsService, NgTableParams) => {

    var systemHelper = $scope.systemHelper;
    var dialogHelper = $scope.dialogHelper;
    var imageFileHelper = $scope.imageFileHelper;
    var datetimeHelper = $scope.datetimeHelper;
    var activityLogHelper = $scope.activityLogHelper;

    $scope.tableParams = null;
    $scope.status = {
        data_loading: true
    }

    load = () => {
        adminAnnouncementsService.getAnnouncementsList().then((res) => {
            $scope.status.data_loading = false;
            var announcements = res.data.announcements;

            announcements.map((a) => {
                a.thumbnail = imageFileHelper.getFileSrc().announcements + a.generated_filename;
                a.trimmedTitle = systemHelper.trimString(a.title, 50);
                a.trimmedDescription = systemHelper.trimString(systemHelper.viewHTMLAsText(a.description), 200);
                a.created_at = datetimeHelper.parseDate(a.created_at);
                a.post_date = datetimeHelper.parseDate(a.post_date);
                a.updated_at = datetimeHelper.parseDate(a.updated_at);
            });

            $scope.tableParams = new NgTableParams({}, {
                dataset: announcements,
            });

            // Attach search text beside search text input
            attachSearchText();
        });
    }

    $scope.removeAnnouncement = (index) => {

        var announcements = $scope.tableParams.data;
        var id = announcements[index].announcement_id;
        var announcement_title = announcements[index].title;

        var title = 'Remove announcement';
        var message = 'Are you sure to remove selected announcement?';

        dialogHelper.showRemoveConfirmation(title, message, (result) => {
            if (result) {
                adminAnnouncementsService.removeAnnouncement(id).then((res) => {
                    if (res.data.status == 1) {
                        dialogHelper.showSuccess('Selected announcement has been successfully removed.', () => {
                            activityLogHelper.registerActivity(`Announcement: Remove announcement ${announcement_title}.`).then(status => {
                                if (status) {
                                    announcements.splice(index, 1);
                                    $scope.$apply();
                                }
                            });
                        });
                    }
                }, (err) => {
                    dialogHelper.showError('Error occured', 'Failed to remove seleceted announcement. Please try again later.');
                });
            }
        });
    }

    $scope.postUnpostAnnouncement = (index, status) => {

        var announcements = $scope.tableParams.data;
        var id = announcements[index].announcement_id;
        var statusText = status ? "Post" : "Unpost";
        var title = announcements[index].title;

        systemHelper.postUnpostModule('announcements', 'announcement_id', id, status, 'post_date').then(res => {
            dialogHelper.showSuccess(`Selected announcement has been successfully ${statusText}.`, () => {

                activityLogHelper.registerActivity(`Announcement: ${statusText} announcement ${title}.`).then(status => {
                    if (status) {
                        announcements[index].post_status = status;
                        announcements[index].post_date = status === 1 ? new Date().toString() : null;
                        if (announcements[index].post_date) {
                            announcements[index].post_date = datetimeHelper.parseDate(announcements[index].post_date);
                        }
                        $scope.$apply();
                    }
                });
            });
        });
    }

    attachSearchText = () => {
        var $searchControlContainer = $("table.table-announcements th div.filter-cell");
        $searchControlContainer.prepend("<span class='search-text'>Search <span class='fa fa-save'></span></span>");
    }

    // Initialize list
    load();
}]);