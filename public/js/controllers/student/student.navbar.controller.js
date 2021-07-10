app.controller('student-navbar-controller', ['$scope', '$interval' ,'studentNavbarService', 'studentChatService', ($scope, $interval, studentNavbarService, studentChatService) => {

    var systemHelper = $scope.systemHelper;
    var userHelper = $scope.userHelper;

    $scope.subjects = [];
    $scope.total_number_of_messages = 0;
    $scope.total_number_of_running_messages = 0;
    $scope.new_messages_count = 0;
    $scope.number_of_subjects = 0; 

    function initialize() {
        userHelper.getCurrentAccountProfilePic();
    }

    studentNavbarService.getStudentSubjects().then((res) => {
        $scope.subjects = res.data.subjects;

        $scope.subjects.map((s) => {
            s.subject_name = systemHelper.trimString(s.subject_description, 20)
        });
    });

    studentChatService.getTotalCurrentNumberMessages().then((res) => {
        $scope.total_number_of_messages = res.data.total_chat_num;
    });

    studentNavbarService.getNumberOfSubjects().then((res) => {
       $scope.number_of_subjects = res.data.number_of_subjects; 
    });

    initialize();
}]);