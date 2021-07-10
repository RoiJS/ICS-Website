app.controller('adminForwardMessageController', [
    '$scope', 
    'adminSentMessagesService', 
    'adminFacultyService', 
    'adminStudentsService',
    function($scope, adminSentMessagesService, adminFacultyService, adminStudentsService){

    $scope.sent_item = {};
    sent_item_id = $('#sent_item_id').val();
    $scope.contacts = [];
    $scope.contact;
    $scope.text = '';

    function getCurrentSentItem() {
        return new Promise((resolve) => {
            adminSentMessagesService.getCurrentSentItem(sent_item_id).then(sent_item => {
                resolve(sent_item);
            });
        });
    }

    function getContacts() {
        return new Promise((resolve) => {
            adminFacultyService.getFaculty().then((res) => {
                res.data.faculties.forEach((faculty) => {
                    $scope.contacts.push(faculty);
                });

                adminStudentsService.getStudents().then((res) => {
                    res.forEach((student) => {
                        $scope.contacts.push(student);
                    });
                    resolve();
                });
            });
        });
    }
    
    $scope.sendMessage = () => {
        if(confirm('Are you sure to send this message?')){
            var contact = $('#contact').val();

            var message = {
                contact,
                text : $scope.text
            }
            adminSentMessagesService.forwardMessage(message).then((status) => {
                location = '/admin/messages/sent';
            });            
        }
    }

    getContacts().then((contacts) => { });

    getCurrentSentItem().then((sent_item) => {
        $scope.text = sent_item.message;
    });
}]);