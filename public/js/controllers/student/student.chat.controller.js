app.controller('studentChatController', ['$scope', '$interval','studentChatService', function($scope, $interval , studentChatService){

    var systemHelper = $scope.systemHelper;
    
    $scope.subjects = [];
    $scope.current_subject = null;
    $scope.conversations = [];

    $scope.status = {
        subject_loading : false,
        has_subjects : false,

        load_count : 0,
        has_conversations : false,
        conversations_loading : false
    }

    $scope.message = null;

    displayStudentSubjects = () => {
        $scope.status.subject_loading = true;
        studentChatService.getStudentSubjects().then((res) => {
            $scope.status.subject_loading = false;
            $scope.subjects = res.data.subjects;

            $scope.current_subject = $scope.subjects[0];
            $scope.subjects[0].read_status = true;
            $scope.status.has_subjects = $scope.subjects.length > 0 ? true : false;

            displayConversationPerSubject($scope.current_subject.class_id);
        });
    }

    displayConversationPerSubject = (class_id) => {
    
        if($scope.status.load_count == 0) $scope.status.conversations_loading = true;

        studentChatService.getConversation(class_id).then((res) => {
            
            if($scope.status.load_count == 0) $scope.status.conversations_loading = false;
            $scope.conversations = res.data.conversations;
            $scope.status.has_conversations = $scope.conversations.length > 0 ? true : false;
            $scope.status.load_count = $scope.status.load_count + 1;
        });
    }

    $scope.sendChat = () => {
        if($scope.message != null || $scope.message != ""){
            studentChatService.sendChat($scope.message, $scope.current_subject.class_id).then((res) => {
                $scope.message = ""
                displayConversationPerSubject($scope.current_subject.class_id);
            });
        }
    }

    $scope.selectSubject = (index) => {
        $scope.current_subject = $scope.subjects[index];
        $scope.status.load_count = 0;
        $scope.current_subject.read_status = true;
        displayConversationPerSubject($scope.current_subject.class_id);
    }

    displayStudentSubjects();

    $scope.is_first_interval = true;
    $interval(() => {

        studentChatService.monitorNewMessage($scope.conversations.length, $scope.current_subject.class_id).then((res) => {
            if(res.data.result == true){
                if($scope.is_first_interval != true) {
                    systemHelper.playNewMessageSound();
                }
                displayConversationPerSubject($scope.current_subject.class_id);
            }
            $scope.is_first_interval = false;
        });

        studentChatService.monitorOtherSubjectNewMessage($scope.subjects).then((res) => {
            $scope.subjects = res.data.new_messages;
            $scope.subjects.map((subject) => {
                if(subject.is_chat_num_changed == true){
                    //$scope.helper.playNewMessageSound();
                }
            });
        });
        
    }, 5000);
}]);