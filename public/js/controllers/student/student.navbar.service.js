app.service('studentNavbarService',['$http', function($http){

    var main_uri = '/student/navbar';

    this.getStudentSubjects = () => {
        return $http.get(`${main_uri}/get_student_subjects`);
    }

    this.getNumberOfSubjects = () =>{
        return $http.get(`${main_uri}/get_number_of_subjects`);
    }
}]);