app.controller('student-subject-navbar-controller', ['$scope', 'accountPostService', 'accountClassListService', 'accountHomeworksService',($scope, accountPostService, accountClassListService, accountHomeworksService) => {
 
    var systemHelper = $scope.systemHelper;
    
    var class_id = ClassGlobalVariable.currentClassId;
    
    $scope.comment_count = 0
    $scope.student_count = 0;
    $scope.homeworks_count = 0;

    accountPostService.getPosts(class_id, 0, 0).then((res) => {
        $scope.comment_count = res.data.posts.length;
    });

    accountClassListService.getClassList(class_id).then((res) => {
        $scope.student_count = res.data.classes.length;
    });

    accountHomeworksService.getHomeworks(class_id).then((res) => {
        $scope.homeworks_count = res.data.homeworks.length;
    });
}]);