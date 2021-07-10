app.controller('adminSentMessagesController', ['$scope', 'adminSentMessagesService', function ($scope, adminSentMessagesService) {

    var dataTableHelper = $scope.dataTableHelper;
    var datetimeHelper = $scope.datetimeHelper;
    var dialogHelper = $scope.dialogHelper;
    var systemHelper = $scope.systemHelper;

    $scope.tableSentItems = null;
    $scope.sent_items = [];
    $scope.is_messages_loading = false;

    function getSentMessagesList() {
        return new Promise((resolve) => {
            $scope.is_messages_loading = true;
            adminSentMessagesService.getSentMessagesList().then(res => {
                resolve(res.data.sent_items);
            });
        });
    }

    $scope.removeSentItem = (sent_item) => {

        var title = 'Remove message';
        var message = 'Are you sure to remove selected message';

        dialogHelper.showConfirmation(title, message, (result) => {
            if (result) {
                adminSentMessagesService.removeSentItem(sent_item.message_id).then((res) => {
                    dialogHelper.showSuccess('Selected message has been successfully removed', () => {
                        document.reload();
                    });
                }, (err) => {
                    dialogHelper.showError('Error occured', 'Failed to remove selected message. Please try again later.');
                });
            }
        });
    }

    getSentMessagesList().then((sent_items) => {
        $scope.is_messages_loading = false;
        $scope.sent_items = sent_items;
        sent_items.map(s => {
            s.sent_at = datetimeHelper.parseDate(s.sent_at);
            s.message = systemHelper.viewStringAsHtml(s.message);
        });

        $scope.tableSentItems = dataTableHelper.initializeDataTable({}, {
            dataset: sent_items
        });
    });

}]);