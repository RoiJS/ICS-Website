app.controller('adminReadMessageController', ['$scope', 'adminMessagesService', function($scope, adminMessagesService){

    $scope.message = {
        details : {},  
        message_id : $('#message_id').val(),
        getCurrentMessage : () => {
            $scope.message.details = adminMessagesService.getCurrentMessage($scope.message.message_id);
        },
        
    }

    message_id = $('#message_id').val();
    $scope.detail = {};

    function getCurrentMessage() {
        return new Promise((resolve) => {
            adminMessagesService.getCurrentMessage(message_id).then((res) => {
                resolve(res.data.current_message);
            });
        });
    }

    $scope.removeCurrentMessage = () => { 
        if(confirm('Are you sure to remove this message?')){
            adminMessagesService.removeMessage(message_id).then((status) => {
                location = '/admin/messages/inbox';
            });
        }
    }

    getCurrentMessage().then((detail) => {
        $scope.detail = detail;
    });
}]);