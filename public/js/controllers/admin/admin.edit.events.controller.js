app.controller('adminEditEventsController', ['$scope', 'adminEventsService', function ($scope, adminEventsService) {

    var dialogHelper = $scope.dialogHelper;
    var activityLogHelper = $scope.activityLogHelper;

    $scope.event = {};

    $scope.event = {
        description: undefined,
        color: undefined
    }

    $scope.isValid = {
        description: true,
        color: true,
        dates: true
    }

    adminEventsService.getCurrentEvent(event_id).then((res) => {
        $scope.event = res.data.event;
    });

    $scope.saveUpdateEvent = () => {
        var date = $('#daterange-btn span').html();
        $scope.event.dates = !date.match(/Date range picker/i) ? date : '';

        $scope.isValid.description = !angular.isUndefined($scope.event.description) ? true : false;
        $scope.isValid.dates = ($scope.event.dates != '') ? true : false;
        $scope.isValid.color = !angular.isUndefined($scope.event.color) ? true : false;

        if ($scope.isValid.description === true && $scope.isValid.dates === true && $scope.isValid.color === true) {

            dialogHelper.showConfirmation(
                'Update event',
                'Are you sure to save changes',
                (result) => {
                    if (result) {
                        adminEventsService.saveUpdateEvent($scope.event).then((res) => {
                            if (res.data.status === 1) {
                                activityLogHelper.registerActivity(`Event: Update event ${$scope.event.description}.`).then(status => {
                                    if (status) {
                                        dialogHelper.showSuccess('Selected event has been successfully updated.', () => {
                                            window.location = '/admin/events';
                                        });
                                    }
                                });
                            }
                        }, (err) => {
                            dialogHelper.showError('Error occured', 'Failed to save update event. Please try it again later.');
                        });
                    }
                }
            );
        }
    }
}]);