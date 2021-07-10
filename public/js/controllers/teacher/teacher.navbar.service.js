app.service('teacherNavbarService',['$http', function($http){

    var main_uri = '/teacher/navbar';

    this.getFacultySubjects = () => {
        return $http.get(`${main_uri}/get_faculty_subjects`);
    }

    this.getNumberOfSubjects = () =>{
        return $http.get(`${main_uri}/get_number_of_subjects`);
    }
}]);