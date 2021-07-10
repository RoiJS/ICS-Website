app.service('adminMessagesService', ['$http', function($http){
    var main_uri = "/admin/messages";

    this.getMessages = () => {
        return $http.post(`${main_uri}/get_inbox_messages`);
    }

    this.getCurrentMessage = (messageId) => {
        return $http.get(`${main_uri}/get_current_message/${messageId}`);
    }      

    this.sendReplyMessage = (message_details) => {
       return $http.post(`${main_uri}/send_reply_message`, {message_details});
    }

    this.removeMessage = (id) => {
        return $http.delete(`${main_uri}/remove_message/${id}`).then((res) => {
            return res.data.status;
        });
    }
}]);