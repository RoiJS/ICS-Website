app.controller('adminStudentsController', ['$scope', 'adminStudentsService', 'NgTableParams', function ($scope, adminStudentsService, NgTableParams) {

    var imageFileHelper = $scope.imageFileHelper;
    var userHelper = $scope.userHelper;

    $scope.tableParams = null;

    $scope.status = {
        data_loading: true
    }

    load = () => {

        adminStudentsService.getStudents().then(students => {
            
            $scope.status.data_loading = false;

            students.map((student) => {
                student.fullname = userHelper.getPersonFullname(student);
                student.image_source = imageFileHelper.setStudentImage(student.image);
            });
            
            $scope.tableParams = new NgTableParams({}, {dataset: students});
        });
    }

    // Initialize list
    load();
}]);