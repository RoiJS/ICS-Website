app.controller('accountActivityLogsController', ['$scope', function ($scope) {

    var activityLogHelper = $scope.activityLogHelper;
    var datetimeHelper = $scope.datetimeHelper;
    var dialogHelper = $scope.dialogHelper;

    var lazyLoadingSettings = {
        activityFrom: 1,
        activityTo: 20,
        activitiesPerRequests: 20
    };

    $scope.activities = [];
    $scope.absoluteCount = 0;
    
    getActivities = () => {
        activityLogHelper.getActivities(lazyLoadingSettings.activityFrom, lazyLoadingSettings.activityTo).then((data) => {
            addActivities(data.activities);
            $scope.absoluteCount = data.absoluteCount;

            $scope.activities.map(a => {
                a.datetime = datetimeHelper.convertToTimeAgo(a.activity_datetime);
            });
        });
    }

    $scope.seeMoreActivities = () => {
        lazyLoadingSettings.activityFrom += lazyLoadingSettings.activitiesPerRequests;
        lazyLoadingSettings.activityTo += lazyLoadingSettings.activitiesPerRequests;
        getActivities();
    }

    $scope.clearActivities = () => {

        var title = "Clear activities";
        var message = "Are you sure to clear all activities?";

        dialogHelper.showRemoveConfirmation(title, message, (result) => {
            if (result) {
                activityLogHelper.clearAllActivities().then(status => {
                    if (status) {
                        window.location.reload();
                    }
                });
            }
        });
    }

    addActivities = (activities) => {
        for (var pos = 0; pos < activities.length; pos++) {
            $scope.activities.push(activities[pos]);
        }
    }

    load = () => {
        getActivities();
    }

    load();
}]);