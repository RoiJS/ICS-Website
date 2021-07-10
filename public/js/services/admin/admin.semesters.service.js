app.service('adminSemestersService', ['$http', function($http){

    var main_uri = "/admin/semester";

    this.getSemesters = () => {
        return $http.get(`${main_uri}/get_semesters`);
    }

    this.getCurrentSemester = () => {
        return $http.get('/admin/semester/get_current_semester');
    }

    this.saveUpdateCurrentSemester = (semester) => {
        return $http.put(`${main_uri}/save_update_current_semester`, {semester}).then((res) => {
            return res.data.status;
        }); 
    }

    this.saveNewSemester = (semester) => {
        return $http.post(`${main_uri}/save_new_semester`, {semester}).then((res) => {
            return res.data.status;
        });
    }

    this.removeSemester = (id) => {
        return $http.delete(`${main_uri}/${id}`).then(res => {
            return res.data.status;
        });
    }

    this.saveUpdateSemester = (semester) => {
        return $http.put(`${main_uri}/save_update_semester`,{semester}).then(res => {
            return res.data.status;
        });
    }

    this.validateAssignedSemester = (semesterId) => {
        return $http.post(`${main_uri}/validate_assigned_semested`,{semesterId}).then(res => {
            return res.data.status;
        });
    }

    
}]);