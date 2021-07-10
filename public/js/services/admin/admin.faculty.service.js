app.service('adminFacultyService', ['$http', function ($http) {

    var main_uri = '/admin/faculty';

    this.getFaculty = () => {
        return $http.post(`${main_uri}/get_faculty`);
    }

    this.saveNewFaculty = (faculty) => {
        var form = new FormData();

        for (var key in faculty) {
            form.append(key, faculty[key]);
        }

        return $http.post(`${main_uri}/save_new_faculty`, form, {
            transformRequest: angular.identity,
            headers: {
                'Content-Type': undefined
            }
        });
    }

    this.saveUpdateFaculty = (faculty) => {
        var form = new FormData();

        for (var key in faculty) {
            form.append(key, faculty[key]);
        }

        return $http.post(`${main_uri}/save_update_faculty`, form, {
            transformRequest: angular.identity,
            headers: {
                'Content-Type': undefined
            }
        });
    }

    this.getCurrentFaculty = (id) => {
        return $http.post(`${main_uri}/get_current_faculty`, { id });
    }

    this.activateFaculty = (id) => {
        return $http.post(`${main_uri}/activate_faculty`, { id }).then((res) => {
            return res.data.status;
        });
    }

    this.deactivateFaculty = (id) => {
        return $http.post(`${main_uri}/deactivate_faculty`, { id }).then((res) => {
            return res.data.status;
        });
    }

    this.verifyTeacherIdExists = (teacherId) => {
        return $http.post(`${main_uri}/verify_teacher_id_exists`, { teacherId }).then((res) => {
            return res.data.result;
        });
    }
}]);