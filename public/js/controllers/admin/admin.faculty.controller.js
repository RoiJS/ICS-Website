app.controller('adminFacultyController', ['$scope', 'adminFacultyService', 'NgTableParams', function ($scope, adminFacultyService, NgTableParams) {

    var imageFileHelper = $scope.imageFileHelper;
    var userHelper = $scope.userHelper;
    
    var faculties = [];

    $scope.tableParams = null;
    $scope.status = {
        data_loading: true
    }

    load = () => {

        adminFacultyService.getFaculty().then((res) => {
            $scope.status.data_loading = false;
            faculties = res.data.faculties;
            // Set student image source
            faculties.map((faculty) => {
                faculty.image_source = imageFileHelper.setFacultyImage(faculty.image);
                faculty.fullname = userHelper.getPersonFullname(faculty);
            });

            $scope.tableParams = new NgTableParams({}, {dataset: faculties});
        });
    }

    // Initialize list
    load();
}]);