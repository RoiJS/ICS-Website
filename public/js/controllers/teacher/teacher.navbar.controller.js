app.controller('teacher-navbar-controller', ['$scope', '$interval' ,'teacherNavbarService', 'teacherChatService', ($scope, $interval, teacherNavbarService, teacherChatService) => {
    
    var userHelper = $scope.userHelper;
    
    $scope.subjects = [];
    $scope.total_number_of_messages = 0;
    $scope.total_number_of_running_messages = 0;
    $scope.new_messages_count = 0;
    $scope.number_of_subjects = 0; 

    function initialize() {
        userHelper.getCurrentAccountProfilePic();
    }

    teacherNavbarService.getFacultySubjects().then((res) => {
        $scope.subjects = res.data.subjects;
    });

    teacherChatService.getTotalCurrentNumberMessages().then((res) => {
        $scope.total_number_of_messages = res.data.total_chat_num;
    });

    // if(window.location.pathname !== "/teacher/chat"){
    //     $interval(() => {
    //         teacherChatService.getTotalCurrentNumberMessages().then((res) => {
    //         $scope.total_number_of_running_messages = res.data.total_chat_num;
    //         $scope.new_messages_count = $scope.total_number_of_running_messages - $scope.total_number_of_messages;
    //         // if($scope.total_number_of_running_messages != $scope.total_number_of_messages){
    //         //     $scope.$scope.total_number_of_messages = $scope.total_number_of_running_messages;
    //         //     $scope.helper.playNewMessageSound();
    //         // }

    //         // TODO: Extract static string
    //         $scope.badge_message = $scope.new_messages_count > 9 ? `9+ New Messages` : `${$scope.new_messages_count} New Messages`;
    //         });
    //     }, 8000);
    // }
    
    teacherNavbarService.getNumberOfSubjects().then((res) => {
       $scope.number_of_subjects = res.data.number_of_subjects; 
    });

    initialize();
}]);

