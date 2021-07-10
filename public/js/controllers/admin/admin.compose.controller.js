app.controller('adminComposeController', ['$scope', 'adminComposeService', 'adminFacultyService', 'adminStudentsService', function ($scope, adminComposeService, adminFacultyService, adminStudentsService) {

    $scope.contacts = [];

    getContacts = () => {
        return new Promise((resolve) => {
            adminFacultyService.getFaculty().then((res) => {
                res.data.faculties.forEach((faculty) => {
                    $scope.contacts.push(faculty);
                });

                adminStudentsService.getStudents().then((res) => {
                    res.forEach((student) => {
                        $scope.contacts.push(student);
                    });
                    resolve($scope.contacts);
                });
            });
        });
    }

    $scope.sendMessage = () => {

        var contact = $("#contact").val();
        var message = $("#message").val();

        if (confirm('Are you sure to send message?')) {
            adminComposeService.sendMessage({ contact, message }).then((res) => {
                if (res.data.status === true) {
                    alert('Message has been successfully sent.');
                    window.location = '/admin/messages/inbox';
                }
            });
        }
    }

    getContacts().then((res) => { });
}]);