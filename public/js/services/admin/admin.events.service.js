app.service('adminEventsService',['$http', function($http){
    var main_uri = '/admin/events';

    var events = [
        {
            event_id : 1,
            description : 'Western Mindanao State University Palaro',
            date_from : '2017-04-12',
            date_to : '2017-05-01',
            color : 'orange',
            status : 1
        },
        {
            event_id : 2,
            description : 'Western Mindanao State University Palaro',
            date_from : '2017-04-12',
            date_to : '2017-05-01',
            color : 'orange',
            status : 1
        },
        {
            event_id : 3,
            description : 'Western Mindanao State University Palaro',
            date_from : '2017-04-12',
            date_to : '2017-05-01',
            color : 'orange',
            status : 1
        },
        {
            event_id : 4,
            description : 'Western Mindanao State University Palaro',
            date_from : '2017-04-12',
            date_to : '2017-05-01',
            color : 'orange',
            status : 1
        },
        {
            event_id : 5,
            description : 'Western Mindanao State University Palaro',
            date_from : '2017-04-12',
            date_to : '2017-05-01',
            color : 'orange',
            status : 1
        },
        {
            event_id : 6,
            description : 'Western Mindanao State University Palaro',
            date_from : '2017-04-12',
            date_to : '2017-05-01',
            color : 'orange',
            status : 1
        },
        {
            event_id : 7,
            description : 'Western Mindanao State University Palaro',
            date_from : '2017-04-12',
            date_to : '2017-05-01',
            color : 'orange',
            status : 1
        },
        {
            event_id : 8,
            description : 'Western Mindanao State University Palaro',
            date_from : '2017-04-12',
            date_to : '2017-05-01',
            color : 'orange',
            status : 1
        },
        {
            event_id : 9,
            description : 'Western Mindanao State University Palaro',
            date_from : '2017-04-12',
            date_to : '2017-05-01',
            color : 'orange',
            status : 1
        },
        {
            event_id : 10,
            description : 'Western Mindanao State University Palaro',
            date_from : '2017-04-12',
            date_to : '2017-05-01',
            color : 'orange',
            status : 1
        }

    ];

    this.getEvents = () => {
        return $http.get(`${main_uri}/get_events`);
    }

    this.getCurrentEvent = (id) => {
        return $http.get(`${main_uri}/${id}`);
    }
    
    this.saveNewEvent = (event) => {
        return $http.post(`${main_uri}/save_new_event`, {event});
    }

    this.removeEvent = (id) => {
        return $http.delete(`${main_uri}/${id}`);
    }

    this.saveUpdateEvent = (event) => {
        return $http.put(`${main_uri}/save_update_event`, {event});
    }
}]);