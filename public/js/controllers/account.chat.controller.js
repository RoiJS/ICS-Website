app.controller('accountChatController', ['$scope', '$interval', 'accountChatService', function($scope, $interval, accountChatService){

    $scope.conversations = [];

    $scope.status = {
        subject_loading : false,
        has_subjects : false,

        load_count : 0,
        has_conversations : false,
        conversations_loading : false
    }

    $scope.message = null;
    displayConversationPerSubject = (class_id) => {
    
        if($scope.status.load_count == 0) $scope.status.conversations_loading = true;

        accountChatService.getConversation(class_id).then((res) => {
            if($scope.status.load_count == 0) $scope.status.conversations_loading = false;
            $scope.conversations = res.data.conversations;
            $scope.status.has_conversations = $scope.conversations.length > 0 ? true : false;
            $scope.status.load_count = $scope.status.load_count + 1;
        });
    }

    displayConversationPerSubject(class_id);

    $scope.sendChat = () => {
        if($scope.message != null || $scope.message != ""){
            accountChatService.sendChat($scope.message, class_id).then((res) => {
                $scope.message = ""
                displayConversationPerSubject(class_id);
            });
        }
    }

    $scope.is_first_interval = true;
    $interval(() => {
        accountChatService.monitorNewMessage($scope.conversations.length, class_id).then((res) => {
            if(res.data.result == true){
                if($scope.is_first_interval != true) {$scope.helper.playNewMessageSound(); }
                displayConversationPerSubject(class_id);
            }
            $scope.is_first_interval = false;
        });
    }, 5000);
}]);