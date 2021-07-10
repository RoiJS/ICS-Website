app.service('adminCoursesService', ['$http', function($http){
    
    var main_uri = "/admin/courses";

    this.getCourses = () => {
        return $http.get(`${main_uri}/get_courses`);
    }
    
    this.saveNewCourse = (course) => {
        return $http.post(`${main_uri}/save_new_course`, {course}).then((res) => {
            return res.data.status;
        });
    }

    this.saveUpdateCourse = (course) => {
        return $http.put(`${main_uri}/save_update_course`, {course}).then((res) => {
            return res.data.status;
        });
    }

    this.deleteCourse = (courseId) => {
        return $http.delete(`${main_uri}/${courseId}`).then((res) => {
            return res.data.status;
        });
    }

    this.verifyDesignatedCourse = (courseId) => {
        return $http.post(`${main_uri}/verify_designated_course`, { courseId } ).then((res) => {
            return res.data.status;
        });
    }
}]);