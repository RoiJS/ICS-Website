app.service('studentEnrollSubjectsService', ['$http', function ($http) {

    var main_uri = "/student/enroll_subjects"

    this.getSubjects = (course, yearLevel) => {
        course = course || 0;
        yearLevel = yearLevel || 0;
        return $http.get(`${main_uri}/get_subjects/${course}/${yearLevel}`);
    }

    this.enrollSubject = (class_id) => {
        return $http.post(`${main_uri}/enroll_subject`, {
            class_id
        });
    }

    this.unenrollSubject = (class_id) => {
        return $http.post(`${main_uri}/unenroll_subject`, {
            class_id
        });
    }

    this.getCurriculumYearLevels = () => {
        return $http.get(`${main_uri}/get_curriculum_year_levels`).then((res) => {
            return res.data.curriculum_year_levels;
        });
    }

    this.getCourses = () => {
        return $http.get(`${main_uri}/get_courses`);
    }
}]);