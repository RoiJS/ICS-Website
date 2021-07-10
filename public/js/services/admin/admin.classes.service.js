app.service('adminClassesService',['$http', function($http){
    var main_uri = "/admin/classes";

    this.setClassDetails = (class_details) => {
        return $http.post(`${main_uri}/set_class_details`, {class_details})
            .then((res) => {
                return res.data.class_details;
            });
    }

    this.getOfficialClassList = (class_id) => {
        return $http.get(`${main_uri}/${class_id}`);
    }

    this.addStudentClass = (stud_id, class_id) => {
        return $http.post(`${main_uri}/add_student_class`,{stud_id, class_id}).then((res) => {
            return res.data.status;
        });
    }

    this.getSections = () => {
        return $http.post(`${main_uri}/get_sections`);
    }

     this.removeStudentClass = (class_list_id) => {
        return $http.delete(`${main_uri}/${class_list_id}`).then((res) => {
            return res.data.status;
        });
    }
}]);