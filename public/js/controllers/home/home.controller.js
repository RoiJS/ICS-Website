app.controller('homeController', ['$scope', '$compile', 'homeAnnouncementsService', 'homeEventsService', function ($scope, $compile, homeAnnouncementsService, homeEventsService) {

    var systemHelper = $scope.systemHelper;
    var dateTimeHelper = $scope.dateTimeHelper;

    $scope.announcements = [];
    $scope.events = [];
    
    this.loadAnnouncements = () => {
        homeAnnouncementsService.getLatestAnnouncments().then((res) => {
            $scope.announcements = res.data.announcements;

            $scope.announcements.map(a => {
                a.image_path = systemHelper.viewAnnouncementImage(a.generated_filename);
                a.description = systemHelper.viewStringAsHtml(a.description);
                a.posted_date = $scope.datetimeHelper.parseDate(a.post_date);
            });
        });
    }

    this.loadEvents = (start, end, timezone, callback) => {

        homeEventsService.getLatestEvents().then((res) => {

            $scope.events = res.data.events;

            $scope.events.map(e => {
                e.has_date_from = !!e.date_from;
                e.has_date_to = (e.date_from !== e.date_to);

                if (e.has_date_from) {
                    var dateFrom = new Date(e.date_from);
                    e.date_from_no = dateFrom.getDate();
                    e.date_from_month_name = dateFrom.toLocaleDateString('en-us', { month: 'short' });
                }

                if (e.has_date_to) {
                    var dateTo = new Date(e.date_to);
                    e.date_to_no = dateTo.getDate();
                    e.date_to_month_name = dateTo.toLocaleDateString('en-us', { month: 'short' });
                }
            });

            var events = $scope.events.map(e => {

                // Add additional 1 day to render properly on calendar
                var dateTo = new Date(e.date_to);
                dateTo.setDate(dateTo.getDate() + 1);

                return {
                    title: e.description,
                    start: new Date(e.date_from),
                    end: dateTo,
                    backgroundColor: e.color,
                    allDay: false
                }
            });

            callback(events);
        });
    }

    this.initializeCalendar = () => {
        $scope.uiConfig = {
            calendar: {
                height: '100%',
                displayEventTime: false
            },
            eventRender: (event, element, view) => {
                element.attr({'tooltip': event.title, 'tooltip-append-to-body': true});
                $compile(element)($scope)
            },
            displayEventTime: false
        };
    }

    this.load = () => {

        $scope.eventSources = [this.loadEvents];

        this.initializeCalendar();
        this.loadAnnouncements();
    }

    // Intialize announcement and event list
    this.load();
}]);