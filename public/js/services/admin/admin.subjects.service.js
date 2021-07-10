app.service('adminSubjectsService', ['$http', function($http){

    var main_uri = "/admin/subjects";

   this.getSubjects = () => {
       return $http.get(`${main_uri}/get_subjects`).then((res) => {
            return res.data.subjects;
       });
   }

   this.getCurrentSubject = (subject_id) => {
       return $http.get(`${main_uri}/${subject_id}`).then((res) => {
           return res.data.subject;
       });
   }

   this.saveNewSubject = (subject) => {
        return $http.post(`${main_uri}/save_new_subject`, {subject}).then((res) => {
            return res.data.status;
        });
   }

   this.removeSubject = (id) => {
        return $http.delete(`${main_uri}/${id}`);
   }

   this.saveUpdateSubject = (subject) => {
        return $http.post(`${main_uri}/save_update_subject`, { subject });
   }

   this.verifySubjectLoaded = (subjectId) => {
        return $http.post(`${main_uri}/verify_subject_loaded`, { subjectId }).then((res) => {
            return res.data.status;
        });
   }
}]);