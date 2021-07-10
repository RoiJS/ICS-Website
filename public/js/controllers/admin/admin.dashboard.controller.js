app.controller('adminDashboardController', ['$scope', 'adminSchoolYearService', 'adminSemestersService', function($scope, adminSchoolYearService, adminSemestersService){
    
    var systemHelper = $scope.systemHelper;
    var numberHelper = $scope.numberHelper;

    $scope.status = [];

    adminSemestersService.getCurrentSemester().then((res) => {
        $scope.current_semester = res.data.current_semester.semester;
    });

    adminSchoolYearService.getCurrentSchoolYear().then((res) => {
        $scope.current_school_year = `${res.data.current_school_year.sy_from} -  ${res.data.current_school_year.sy_to}`;
    });

    var getStaticStatus = () => {
        return new Promise(resolve => {
            var promises = [];
            ['classes', 'students','teachers'].map((el) => {
                promises.push(systemHelper.staticStatus(el));
            });       
            
            Promise.all(promises).then((res) => {
                resolve(res);
            });
        });
    }
    
    getStaticStatus().then((res) => {
        res.forEach((r) => {
            $scope.status.push(numberHelper.numberFormat(r.data.count, 0, '.', ','));
        });
    });

}]);