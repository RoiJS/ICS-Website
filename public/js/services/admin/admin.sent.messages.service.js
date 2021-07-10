app.service('adminSentMessagesService', ['$http', function($http){

    var main_uri = '/admin/messages';

    this.getSentMessagesList = () => {
        return $http.get(`${main_uri}/get_sent_items`);
    }

    this.getCurrentSentItem = (id) => {
        return $http.get(`${main_uri}/get_current_sent_item/${id}`).then((res) => {
            return res.data.sent_item;
        });
    }

    this.removeSentItem = (id) => {
        return $http.delete(`${main_uri}/remove_sent_item/${id}`);
    }

    this.forwardMessage = (message) => {
        return $http.post(`${main_uri}/forward_message`, {message});
    }
}]);