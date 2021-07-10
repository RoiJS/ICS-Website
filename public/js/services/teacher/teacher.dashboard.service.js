app.service('teacherDashboardService', ['$http', function($http){

    var main_uri = '/teacher/dashboard';

    this.getFacultySubjects = () => {
        return $http.get(`${main_uri}/get_faculty_subjects`);
    }
}]);