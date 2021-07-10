app.controller('adminReplyMessageController', ['$scope', 'adminMessagesService', function($scope, adminMessagesService){

    var userHelper = $scope.userHelper;
    
    $scope.sender = "";
    sender_info = {};

    var message_id = $('#message_id').val();

    getCurrentMessage = (messageId) => {
        return new Promise((resolve) => {
            adminMessagesService.getCurrentMessage(messageId).then((res) => {
                resolve(res);
            });
        });
    }

    $scope.sendReplyMessage = () => {
        var text = $('#compose-textarea').val();

        if(text.trim().length > 0){
            if(confirm('Are you sure to send this message?')){
                adminMessagesService.sendReplyMessage({send_to_id : sender_info.account_id, text}).then((res) => {
                    window.location = '/admin/messages/inbox';
                });
            }
        }else{
            alert('Please enter message. Message input area must not be empty.');
        }
    }

    getCurrentMessage(message_id).then((res) => {
        sender_info = res.data.sender;
        $scope.sender = userHelper.getPersonFullname(sender_info);
    });
}]);