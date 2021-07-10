app.service('accountChatService', ['$http', function($http){

    var main_uri = "/chat";
    this.getConversation = (class_id) => {
        return $http.post(`${main_uri}/get_conversation`, {class_id});
    }

    this.sendChat = (message, class_id) => {
        return $http.post(`${main_uri}/send_chat`, {message, class_id});
    }

    this.monitorNewMessage = (message_count, class_id) => {
        return $http.post(`${main_uri}/monitor_new_message`,{message_count, class_id});
    }

    this.monitorOtherSubjectNewMessage = (groupchats) => {
        return $http.post(`${main_uri}/monitor_other_subject_new_message`, {groupchats});
    }

    this.getTotalCurrentNumberMessages = () => {
        return $http.get(`${main_uri}/get_total_number_messages`);
    }

    this.clearAllConversations = (class_id) => {
        return $http.delete(`${main_uri}/${class_id}`);
    }
}]);