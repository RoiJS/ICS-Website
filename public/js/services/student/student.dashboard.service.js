app.service('studentDashboardService', ['$http', function($http){

    var main_uri = '/student/dashboard';

    this.getStudentSubjects = () => {
        return $http.get(`${main_uri}/get_student_subjects`);
    }
}]);