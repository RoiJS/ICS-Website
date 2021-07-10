app.controller('adminEventsController', ['$scope', 'adminEventsService', function ($scope, adminEventsService) {

    var dialogHelper = $scope.dialogHelper;
    var dataTableHelper = $scope.dataTableHelper;
    var datetimeHelper = $scope.datetimeHelper;
    var systemHelper = $scope.systemHelper;
    var activityLogHelper = $scope.activityLogHelper;

    $scope.tableEvents = null;

    $scope.event = {
        description: undefined,
        color: undefined
    }

    $scope.isValid = {
        description: true,
        dates: true,
        color: true,
    }

    $scope.status = {
        data_loading: true
    }

    load = () => {
        adminEventsService.getEvents().then((res) => {

            $scope.status.data_loading = false;

            var events = res.data.events;

            events.map((e) => {
                e.date_from = datetimeHelper.parseDate(e.date_from);
                e.date_to = datetimeHelper.parseDate(e.date_to);
                e.event_date = `${e.date_from} - ${e.date_to}`;
                e.description = systemHelper.trimString(e.description, 40);
            });

            $scope.tableEvents = dataTableHelper.initializeDataTable({}, {
                dataset: events
            });
        });
    }

    $scope.saveNewEvent = () => {
        var date = $('#daterange-btn span').html();
        $scope.event.dates = !date.match(/Date range picker/i) ? date : '';

        $scope.isValid.description = !angular.isUndefined($scope.event.description) ? true : false;
        $scope.isValid.dates = ($scope.event.dates != '') ? true : false;
        $scope.isValid.color = !angular.isUndefined($scope.event.color) ? true : false;

        if ($scope.isValid.description == true && $scope.isValid.dates == true && $scope.isValid.color == true) {

            var title = 'Create event';
            var message = 'Are you sure to save new event?';

            dialogHelper.showConfirmation(title, message, (result) => {
                if (result) {
                    adminEventsService.saveNewEvent($scope.event).then((res) => {
                        if (res.data.status == true) {
                            activityLogHelper.registerActivity(`Event: Create new event ${$scope.event.description}.`).then(status => {
                                if (status) {
                                    dialogHelper.showSuccess('New Event has been successfully saved.', () => {
                                        window.location.reload();
                                    });
                                }
                            });
                        }
                    }, (err) => {
                        dialogHelper.showError('Error occured', 'Failed to save new event. Please try it again later.');
                    });
                }
            });
        }
    }

    $scope.removeEvent = (index) => {
        var events = $scope.tableEvents.data;
        var id = events[index].event_id;
        var event_title = events[index].description;

        var title = 'Remove event';
        var message = 'Are you sure to remove selected event?';

        dialogHelper.showConfirmation(title, message, (result) => {
            if (result) {
                adminEventsService.removeEvent(id).then((res) => {
                    if (res.data.status == 1) {
                        activityLogHelper.registerActivity(`Event: Remove event ${event_title}.`).then(status => {
                            if (status) {
                                dialogHelper.showSuccess('Selected event has been successfully removed from the list.', () => {
                                    window.location.reload();
                                });
                            }
                        });
                    }
                }, (err) => {
                    dialogHelper.showError('Error occured', 'Failed to remove selected event. Please try it again later.');
                });
            }
        });
    }

    load();
}]);