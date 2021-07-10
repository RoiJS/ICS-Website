app.service('accountHomeworksService', ['$http', function($http){
    
    var main_uri = "/homeworks";

    this.saveNewHomework = (homework) => {
        var form = new FormData();

        for(var key in homework){
            if(key != "files")
                form.append(key, homework[key]);
            else{
                var files = [];
                var file_form = new FormData()

                for(var ctr = 0; ctr < homework[key].length; ctr++){
                    files.push(homework[key][ctr])
                }
                form.append(key, files)
            }
        }

        return $http.post(`${main_uri}/save_new_homework`, form, {
            transformRequest : angular.identity,
            headers : {
                'Content-Type' : undefined
            }
        });
    }

    this.uploadFile = (homework_id, file) => {

        var form = new FormData();
        form.append('homework_id', homework_id);
        form.append('file', file);

        return $http.post(`${main_uri}/upload_homework_file`, form, {
            transformRequest : angular.identity,
            headers : {
                'Content-Type' : undefined
            }
        });
    }

    this.getHomeworks = (class_id) => {
        return $http.post(`${main_uri}/get_homeworks`, {class_id});
    }

    this.sendHomework = (homework_id) => {
        return $http.put(`${main_uri}/send_homework`, {homework_id});
    }

    this.unsendHomework = (homework_id) => {
        return $http.put(`${main_uri}/unsend_homework`, {homework_id});
    }

    this.removeHomework = (homework_id) => {
        return $http.delete(`${main_uri}/${homework_id}`);
    }

    this.getHomeworkDetails = (homework_id) =>{
        return $http.post(`${main_uri}/get_homework_details`, {homework_id});
    }

    this.saveUpdateHomework = (homework) => {
        return $http.put(`${main_uri}/save_update_homework`, {homework});
    }

    this.getSubmittedHomeworks = (homework_id) => {
        return $http.post(`${main_uri}/get_submitted_homeworks`, {homework_id});
    }

    this.approvedHomework = (submitted_homework_id, approved_status) => {
        return $http.put(`${main_uri}/approved_homework`, {submitted_homework_id, approved_status});
    }

    this.getStudentHomeworks = (class_id) =>{
        return $http.post(`${main_uri}/get_student_homeworks`, {class_id});
    }

    this.submitFile = (homework_id, file) => {
        var form = new FormData();
        form.append('homework_id', homework_id);
        form.append('file', file);

        return $http.post(`${main_uri}/submit_file`, form, {
            transformRequest : angular.identity,
            headers : {
                'Content-Type' : undefined
            }
        });
    }
}]);