app.controller('accountNotificationsMenuController', ['$scope', function ($scope) {

    var notificationHelper = $scope.notificationHelper;
    var datetimeHelper = $scope.datetimeHelper;
    var imageFileHelper = $scope.imageFileHelper;
    var dialogHelper = $scope.dialogHelper;

    var lazyLoadingSettings = {
        notificationFrom: 1,
        notificationTo: 20,
        notificationsPerRequests: 20
    };

    $scope.notifications = [];
    $scope.absoluteCount = 0;
    $scope.unreadNotificationsCount = 0;
    $scope.status = {
        loading: false
    };

    $scope.seeMoreNotifications = () => {
        lazyLoadingSettings.notificationFrom += lazyLoadingSettings.notificationsPerRequests;
        lazyLoadingSettings.notificationTo += lazyLoadingSettings.notificationsPerRequests;
        getNotifications();
    }

    $scope.goToPath = (index) => {
        var notificationObj = $scope.notifications[index];

        notificationHelper.readNotification(notificationObj.notification_id).then(status => {
            if (status) window.location.href = notificationObj.path;
        });
    }

    $scope.clearAllNotifications = () => {
        var title = "Clear All Notifications";
        var message = "Are you sure to clear all notifications?";

        dialogHelper.showConfirmation(title, message, (result) => {
            if (result) {
                notificationHelper.clearNotifications().then(status => {
                    if (status) {
                        resetLazyLoadingSettings();
                    }
                });
            }
        });
    }

    $scope.markAllAsRead = () => {

        var title = "Mark All Notifications As Read";
        var message = "Are you sure to mark all notifications as read?";

        dialogHelper.showConfirmation(title, message, (result) => {
            if (result) {
                notificationHelper.readNotification().then(status => {
                    if (status) {
                        readAllNotifications();
                    }
                });
            }
        });
    }

    resetLazyLoadingSettings = () => {
        lazyLoadingSettings.notificationFrom = 1;
        lazyLoadingSettings.notificationTo = 20;
        $scope.absoluteCount = 0;
        $scope.unreadNotificationsCount = 0;
        $scope.notifications = [];
    }

    readAllNotifications = () => {
        $scope.notifications.map(n => {
            n.is_read = 1;
        });
        $scope.unreadNotificationsCount = 0;
    }

    getNotifications = (callback) => {
        $scope.status.loading = true;
        notificationHelper.getNotifcations(lazyLoadingSettings.notificationFrom, lazyLoadingSettings.notificationTo).then((data) => {
            $scope.absoluteCount = data.absoluteCount;
            $scope.unreadNotificationsCount = data.unreadNotificationsCount;

            data.notifications.map(a => {
                a.datetime = datetimeHelper.convertToTimeAgo(a.datetime);
                a.userfullname = a.notification_from_user_fullname;
                a.userimage = imageFileHelper.getUserImage(a.notification_from_user_type, a.notification_from_user_image)
            });

            addNotifications(data.notifications);

            $scope.status.loading = false;

            if (callback) callback();
        });
    }

    addNotifications = (notifications) => {
        for (var pos = 0; pos < notifications.length; pos++) {
            $scope.notifications.push(notifications[pos]);
        }
    }

    monitorNewNotifications = () => {

        notificationHelper.monitorNewNotifications($scope.absoluteCount).then(status => {
            if (status) {
                resetLazyLoadingSettings();
                getNotifications(() => {
                    monitorNewNotifications();
                });
            } else {
                monitorNewNotifications();
            }
        });
    }

    load = () => {
        getNotifications(() => {
            monitorNewNotifications();
        });
    }

    load();
}]);