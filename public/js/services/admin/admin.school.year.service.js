app.service('adminSchoolYearService',['$http', function($http){

    var main_uri = '/admin/school_year';

    var year_start = 1985, 
        year_end = 2030;

    this.getSchoolYear = () => {
        return $http.get(`${main_uri}/get_school_year`);
    }

    this.getYearStart = () => {
        return year_start;
    }

    this.getYearEnd = () => {
        return year_end;
    }

    this.getCurrentSchoolYear = () => {
        return $http.get(`${main_uri}/get_current_school_year`);
    }

    this.saveNewSchoolYear = (start, end) => {
        return $http.post(`${main_uri}/save_new_school_year`, {start, end}).then((res) => {
            return res.data.status;
        });
    }

    this.removeSchoolYear = (id) => {
        return $http.delete(`${main_uri}/${id}`).then((res) => {
            return res.data.status;
        });
    }

    this.saveUpdateSchoolYear = (school_year) => {
        return $http.put(`${main_uri}/save_update_school_year`, {school_year}).then((res) => {
            return res.data.status;
        });
    }

    this.setNewSchoolYear = (school_year_id) => {
        return $http.post(`${main_uri}/set_new_school_year`,{school_year_id}).then((res) => {
            return res.data.status;
        });
    }

    this.validateAssignedSchoolYear = (schoolYearId) => {
        return $http.post(`${main_uri}/validate_used_school_year`, { schoolYearId }).then(res => {
            return res.data.status;
        });
    }

}]);