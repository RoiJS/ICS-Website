app.controller('studentDashboardController', ['$scope', 'studentDashboardService', function($scope, studentDashboardService){

    var systemHelper = $scope.systemHelper;

    $scope.subjects = [];
    $scope.current_sem = 'Loading...'
    $scope.current_sy = 'Loading...'

    $scope.status = {
        subject_loading : false,
        has_subjects : false
    };

    displayStudentSubjects = (callback) => {
        $scope.status.subject_loading = true;
        studentDashboardService.getStudentSubjects().then((res) => {
            $scope.status.subject_loading = false;
            $scope.subjects = res.data;
            $scope.status.has_subjects = ($scope.subjects.subjects.length > 0);

            if (callback) callback();
        });
    }

    displayCurrentSemester = () => {
        systemHelper.getCurrentSemester().then((res) => {
            $scope.current_sem = res.data.current_semester.semester;
        });
    }

    displayCurrentSchoolYear = () => {
        systemHelper.getCurrentSchoolYear().then((res) => {
            $scope.current_sy = `${res.data.current_school_year.sy_from} -  ${res.data.current_school_year.sy_to}`;
        })
    }

    load = () => {
        displayCurrentSemester();
        displayCurrentSchoolYear();
        displayStudentSubjects(() => {
            systemHelper.removePageLoadEffect();
        });
    }

    load();
}]);