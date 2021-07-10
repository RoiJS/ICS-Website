app.service('studentEnrollSubjectsService', ['$http', function($http){

    var main_uri = "/student/enroll_subjects"
    this.getSubjects = () => {
        return $http.get(`${main_uri}/get_subjects`);
    }

    this.enrollSubject = (class_id) => {
        return $http.post(`${main_uri}/enroll_subject`, {class_id});
    }

    this.unenrollSubject = (class_id) => {
        return $http.post(`${main_uri}/unenroll_subject`, {class_id});
    }
}]);