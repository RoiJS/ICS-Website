app.controller('account-details-controller', ['$scope', 'accountDetailsService', ($scope, accountDetailsService) => {
    
    $scope.accountDetails = {};
    $scope.helper.getCurrentAccountProfilePic();

    getDetails();
    
    function getDetails() {
        accountDetailsService.getAccountDetails().then((res) => {
            $scope.accountDetails = res.data.details;
        });
    }

    $scope.fullname = () => {
        var firstname = new String($scope.accountDetails.first_name),
            middlename = new String($scope.accountDetails.middle_name),
            lastname = new String($scope.accountDetails.last_name);
        return  firstname + ' ' + middlename.substr(0,1).toUpperCase() + '. ' + lastname;  
    }

    $scope.semifullname = function(){
        var firstname = new String($scope.accountDetails.first_name),
            lastname = new String($scope.accountDetails.last_name);

        return firstname + ' ' + lastname.substr(0,1).toUpperCase() + '.'
    }
    
    $scope.position = () => {
        var position =  $scope.accountDetails.type;
        if(position == 'admin'){
            return 'Administrator';
        }else if(position == 'student'){
            return 'Student';
        }else if(position == 'teacher'){
            return 'Teacher';
        }
    }

    $scope.dateMembership = (date) => {
        return $scope.helper.parseDate($scope.accountDetails.created_at);
    }

    
}]);