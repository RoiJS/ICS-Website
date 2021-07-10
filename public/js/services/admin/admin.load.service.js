app.service('adminLoadService', ['$http', function ($http) {
    var main_uri = '/admin/load';

    /**
     * Get list of faculty subjects for the current semester and school year
     * @param {*} faculty_id Id of the selected faculty
     * @param {*} semester_id  Id of the current semester
     * @param {*} school_year_id Id of the current school year
     * @returns {Promise<Array<FacultySubjects>>} List of faculty subjects 
     */
    this.getFacultyLoad = (faculty_id, semester_id, school_year_id) => {
        return $http.post(`${main_uri}/get_faculty_subjects`, {
            faculty_id, semester_id, school_year_id
        }).then((res) => {
            return res.data.faculty_subjects;
        });
    }

    this.saveNewFacultySubject = (load) => {
        return $http.post(`${main_uri}/save_new_faculty_subject`, { load })
            .then((res) => {
                return {
                    status: res.data.status,
                    classId: res.data.class_id
                } ;
            });
    }

    this.saveUpdateFacultySubject = (subject) => {
        return $http.post(`${main_uri}/save_update_faculty_subject`, { subject })
            .then((res) => {
                return res.data.status;
            });
    }

    this.removeFacultySubject = (id) => {
        return $http.delete(`${main_uri}/${id}`);
    }

    this.getSections = () => {
        return $http.get(`${main_uri}/get_sections`);
    }

    /**
     * Verifies if the subject is already been assigned to other faculty
     * @param {*} faculty_id Id of the selected faculty
     * @param {*} subject_id Id of the subject
     * @param {*} section Section name
     * @returns {Promise<Array<ClassLoad>>}
     */
    this.verifyIfSubjectExistFromOtherFaculty = (faculty_id, curriculum_subject_id, section) => {
        return $http.post(`${main_uri}/verify_if_subject_exist_from_other_faculty`, { faculty_id, curriculum_subject_id, section })
            .then((res) => {
                return res.data.class_load;
            });
    }
}]);