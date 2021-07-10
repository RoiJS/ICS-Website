app.service('adminStudentsService', ['$http', function ($http) {

    var main_uri = '/admin/students';

    this.saveNewStudent = (student) => {
        var form = new FormData();

        for (var key in student) {
            if (key == "birthdate") {
                var bdate = new Date(student[key]);
                student[key] = bdate.getFullYear() + "-" + (bdate.getMonth() + 1) + "-" + bdate.getDate();
            }
            form.append(key, student[key]);
        }

        return $http.post(`${main_uri}/save_new_student`, form, {
            transformRequest: angular.identity,
            headers: {
                'Content-Type': undefined
            }
        });
    }

    this.getStudents = (student_id) => {
        return $http.post(`${main_uri}/get_students`, { student_id : parseInt(student_id) }).then(res => {
            return res.data.students;
        });
    }

    this.getCurrentStudent = (id) => {
        return $http.post(`${main_uri}/get_current_student`, { id });
    }

    this.getStudentSubjects = (id) => {
        $http.post(`${main_uri}/get_students_subjects`, { id });
    }

    this.removeStudent = (id) => {
        return $http.delete(`${main_uri}/${id}`);
    }

    this.deactivateStudent = function(studentId) {
        return $http.post(`${main_uri}/deactivate_student`, { studentId}).then(res => {
            return res.status;
        });
    }
    
    this.activateStudent = function(studentId) {
        return $http.post(`${main_uri}/activate_student`, { studentId}).then(res => {
            return res.status;
        });
    }

    this.saveUpdateStudent = (student) => {
        var form = new FormData();

        for (var key in student) {
            if (key == "birthdate") {
                var bdate = new Date(student[key]);
                student[key] = bdate.getFullYear() + "-" + (bdate.getMonth() + 1) + "-" + bdate.getDate();
            }
            form.append(key, student[key]);
        }

        return $http.post(`${main_uri}/save_update_student`, form, {
            transformRequest: angular.identity,
            headers: {
                'Content-Type': undefined
            }
        });
    }

    this.verifyStudentIdExists = (studentId) => {
        return $http.post(`${main_uri}/verify_student_id_exists`, { studentId }).then((res) => {
            return res.data.result;
        });
    }
}]);