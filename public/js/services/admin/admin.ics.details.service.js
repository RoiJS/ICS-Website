app.service('adminICSDetailsService', ['$http', function($http){

    var main_uri = '/admin/ics_details';
    
    this.getDetails = () => {
        return $http.get(`${main_uri}/get_details`);
    }

    this.saveNewDetails = (detail_type, new_data) => {
        return $http.post(`${main_uri}/save_new_details`, {
            detail_type,
            new_data
        });
    }

    this.saveNewLogo = (logo) => {
        var form = new FormData();
        form.append('logo', logo);

        return $http.post(`${main_uri}/save_new_logo`, form, {
            transaformRequest : angular.identity,
            headers : {
                'Content-Type' : undefined
            }
        });
    }
}]);