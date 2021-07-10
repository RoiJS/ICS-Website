app.service('teacherSubjectApprovalService',['$http', function($http){

    var main_uri = "/teacher/subjects_approval";

    this.getSubjectApproval = () => {
        return $http.get(`${main_uri}/get_subjects_approval`);
    }

    this.approveSubject = (class_list_id) => {
        return $http.post(`${main_uri}/approve_subject`,{class_list_id});
    }
}]);