app.service('accountClassListService', ['$http', function($http){

    var main_uri = "/classes";

    this.getClassList = (class_id) => {
        return $http.post(`${main_uri}/get_class_list`,{class_id});
    }

    this.removeStudent = (class_list_id) => {
        return $http.delete(`${main_uri}/${class_list_id}`);
    }

    this.getStudentList = (class_id) => {
        return $http.post(`${main_uri}/get_student_list`,{class_id});
    }

    this.removeStudentClass = (class_list_id) => {
        return $http.delete(`${main_uri}/${class_list_id}`);
    }

    this.enrollStudent = (enrollment_info) => {
        return $http.post(`${main_uri}/enroll_student`, {enrollment_info});
    }

    this.unenrollStudent = (enrollment_info) => {
        return $http.post(`${main_uri}/unenroll_student`, {enrollment_info});
    }
}]);