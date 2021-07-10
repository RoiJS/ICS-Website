app.controller('adminMessagesController', ['$scope', 'adminMessagesService', function ($scope, adminMessagesService) {

    var datetimeHelper = $scope.datetimeHelper;
    var dialogHelper = $scope.dialogHelper;
    var dataTableHelper = $scope.dataTableHelper;
    var systemHelper = $scope.systemHelper;

    $scope.tableMessages = null;
    $scope.messages = [];
    $scope.status = {
        messages_loading: false
    }

    displayMessages = () => {
        return new Promise((resolve) => {
            $scope.status.messages_loading = true;
            adminMessagesService.getMessages().then((res) => {
                resolve(res.data.messages);
            });
        });

    }

    $scope.deleteMessage = (id) => {

        var title = 'Remove message';
        var message = 'Are you sure to remove selected message?';

        dialogHelper.showConfirmation(title, message, (result) => {
            if (result) {
                adminMessagesService.removeMessage(id).then((status) => {
                    dialogHelper.showSuccess('Message has been successfully removed.', () => {
                       window.reload(); 
                    });
                }, (err) => {
                    dialogHelper.showError('Error occured', 'Failed to remove selected message. Please try again later.');
                });
            }
        });
    }

    displayMessages().then((messages) => {

        $scope.status.messages_loading = false;
        $scope.messages = messages;
        
        messages.map(m => {
            m.sent_at = datetimeHelper.parseDate(m.sent_at);
            m.message = systemHelper.viewStringAsHtml(m.message);
        });

        $scope.tableMessages = dataTableHelper.initializeDataTable({}, {
            dataset: messages
        });
    });
}]);