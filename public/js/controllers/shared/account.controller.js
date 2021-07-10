app.controller('account-details-controller', ['$scope', 'accountDetailsService', ($scope, accountDetailsService) => {
    
    var datetimeHelper = $scope.datetimeHelper;
    var userHelper = $scope.userHelper;
    
    $scope.accountDetails = {
        first_name : '',
        last_name : '',
        middle_name : ''
    };

    function initialize() {
        userHelper.getCurrentAccountProfilePic();
        getDetails();
    }

    function getDetails() {
        accountDetailsService.getAccountDetails().then((res) => {
            $scope.accountDetails = res.data.details;
            $scope.account_name = `${$scope.accountDetails.first_name} ${$scope.accountDetails.last_name[0]}.`;
            $scope.account_position = getPosition();
            $scope.dateMembership = datetimeHelper.parseDate($scope.accountDetails.created_at);
        });
    }

    $scope.fullname = () => {
        var firstname = $scope.accountDetails.first_name.toString().trim(),
            middlename = $scope.accountDetails.middle_name.toString().trim(),
            lastname = $scope.accountDetails.last_name.toString().trim();

        return  `${firstname} ${middlename.substr(0,1).toUpperCase()}. ${lastname}`;  
    }

    $scope.semifullname = function(){
        var firstname = $scope.accountDetails.first_name.toString().trim(),
            lastname = $scope.accountDetails.last_name.toString().trim();

        return `${firstname} ${lastname.substr(0, 1).toUpperCase()}.`;
    }
    
    getPosition = () => {

        var position =  $scope.accountDetails.type;
        var fullnamePosition = '';

        switch (position) {
            case 'admin': 
                fullnamePosition = 'Administrator';
                break;
            case 'student':
                fullnamePosition = 'Student';
                break;
            case 'teacher':
                fullnamePosition = 'Teacher';
                break;
        }

        return fullnamePosition;
    }

    initialize();
}]);