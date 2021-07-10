app.controller('accountNotificationsPanelController', ['$scope', function ($scope) {

    var notificationHelper = $scope.notificationHelper;
    var datetimeHelper = $scope.datetimeHelper;
    var imageFileHelper = $scope.imageFileHelper;
    var dialogHelper = $scope.dialogHelper;

    var panelLazyLoadingSettings = {
        notificationFrom: 1,
        notificationTo: 20,
        notificationsPerRequests: 20
    };

    $scope.panel_notifications = [];
    $scope.panel_absoluteCount = 0;
    $scope.panel_unreadNotificationsCount = 0;
    $scope.panel_status = {
        loading: false
    };

    $scope.panelSeeMoreNotifications = () => {
        panelLazyLoadingSettings.notificationFrom += panelLazyLoadingSettings.notificationsPerRequests;
        panelLazyLoadingSettings.notificationTo += panelLazyLoadingSettings.notificationsPerRequests;
        panelGetNotifications();
    }

    $scope.panelGoToPath = (index) => {
        var notificationObj = $scope.panel_notifications[index];

        notificationHelper.readNotification(notificationObj.notification_id).then(status => {
            if (status) window.location.href = notificationObj.path;
        });
    }

    $scope.panelClearAllNotifications = () => {
        var title = "Clear All Notifications";
        var message = "Are you sure to clear all notifications?";

        dialogHelper.showConfirmation(title, message, (result) => {
            if (result) {
                notificationHelper.clearNotifications().then(status => {
                    if (status) {
                        panelResetLazyLoadingSettings();
                    }
                });
            }
        });
    }

    $scope.panelMarkAllAsRead = () => {

        var title = "Mark All Notifications As Read";
        var message = "Are you sure to mark all notifications as read?";

        dialogHelper.showConfirmation(title, message, (result) => {
            if (result) {
                notificationHelper.readNotification().then(status => {
                    if (status) {
                        panelReadAllNotifications();
                    }
                });
            }
        });
    }

    panelLesetLazyLoadingSettings = () => {
        panelLazyLoadingSettings.notificationFrom = 1;
        panelLazyLoadingSettings.notificationTo = 20;
        $scope.panel_absoluteCount = 0;
        $scope.panel_unreadNotificationsCount = 0;
        $scope.panel_notifications = [];
    }

    panelReadAllNotifications = () => {
        $scope.panel_notifications.map(n => {
            n.is_read = 1;
        });
        $scope.panel_unreadNotificationsCount = 0;
    }

    panelGetNotifications = () => {
        $scope.panel_status.loading = true;
        notificationHelper.getNotifcations(panelLazyLoadingSettings.notificationFrom, panelLazyLoadingSettings.notificationTo).then((data) => {
            $scope.panel_absoluteCount = data.absoluteCount;
            $scope.panel_unreadNotificationsCount = data.unreadNotificationsCount;

            data.notifications.map(a => {
                a.datetime = datetimeHelper.convertToTimeAgo(a.datetime);
                a.userfullname = a.notification_from_user_fullname;
                a.userimage = imageFileHelper.getUserImage(a.notification_from_user_type, a.notification_from_user_image)
            });

            panelAddNotifications(data.notifications);
            
            $scope.panel_status.loading = false;
        });
    }

    panelAddNotifications = (notifications) => {
        for (var pos = 0; pos < notifications.length; pos++) {
            $scope.panel_notifications.push(notifications[pos]);
        }
    }

    panelLoad = () => {
        panelGetNotifications();
    }

    panelLoad();
}]);