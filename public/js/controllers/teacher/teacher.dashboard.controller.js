app.controller('teacherDashboardController', ['$scope', 'teacherDashboardService', function($scope, teacherDashboardService){

    var systemHelper = $scope.systemHelper;
    var chatHelper = $scope.chatHelper;

    $scope.subjects = [];
    $scope.current_sem = 'Loading...'
    $scope.current_sy = 'Loading...'

    $scope.status = {
        subject_loading : false,
        has_subjects : false
    };

    displayFacultySubjects = (callback) => {
        $scope.status.subject_loading = true;
        teacherDashboardService.getFacultySubjects().then((res) => {
            $scope.status.subject_loading = false;
            $scope.subjects = res.data;
            $scope.status.has_subjects = ($scope.subjects.subjects.length > 0);

            if (callback) callback($scope.subjects);
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
        displayFacultySubjects((subjects) => {
            systemHelper.removePageLoadEffect();
        });
    }

    load();
}]);