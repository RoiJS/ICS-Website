app.service('adminCurriculumService', ['$http', function($http){

    var main_uri = '/admin/curriculum';

    this.getCurriculumSubjects = (course, school_year, year_level, semester) => {
        return $http.post(`${main_uri}/get_curriculum_subjects`, {course, school_year, year_level, semester}).then((res) => {
            return res.data.curriculum_subjects;
        });   
    }

    this.getCurriculumSchoolYear = () => {
        return $http.get(`${main_uri}/get_curriculum_school_years`);
    }
    
    this.getCurriculumYears = () => {
        return $http.get(`${main_uri}/get_curriculum_years`).then((res) => {
            return res.data.curriculum_years;
        });
    }

    this.saveNewCurriculumSubject = (subject, course, school_year, year_level, semester) => {
        return $http.post(`${main_uri}/save_curriculum_subjects`, {subject, course, school_year, year_level, semester});
    }
    
    this.removeCurriculumSubject = (id) => {
        return $http.delete(`${main_uri}/${id}`).then((res) => {
            return res.data.status;
        });
    }

    this.verifySubjectExist = (details) => {
        return $http.post(`${main_uri}/verify_subject_exists`, { details }).then(res => {
            return res.data.result;
        });
    }

    this.verifySubjectInLoadsExistsInLoads = (curriculum_subject_id) => {
        return $http.post(`${main_uri}/verify_subject_exists_in_loads`, { curriculum_subject_id }).then(res => {
            return res.data.result;
        });
    }
}]);