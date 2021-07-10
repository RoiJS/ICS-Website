app.controller('adminAccountsApprovalController', ['$scope', 'adminAccountsApprovalService', function ($scope, adminAccountsApprovalService) {

    var activityLogHelper = $scope.activityLogHelper;

    $scope.accounts_approval = [];

    $scope.status = {
        data_loading: false,
        has_data: false
    }

    displayAccountsApproval = () => {
        $scope.status.data_loading = true;
        adminAccountsApprovalService.getAccountsApproval().then((res) => {
            $scope.status.data_loading = false;
            $scope.accounts_approval = res.data.accounts_approval;
            $scope.status.has_data = $scope.accounts_approval.length > 0 ? true : false
        });
    }

    displayAccountsApproval();

    $scope.approveAccount = (index) => {
        var account_id = $scope.accounts_approval[index].account_id;

        var title = "Approve request";
        var message = "Are you sure to approve this account?";

        dialogHelper.showConfirmation(title, message, (result) => {
            if (result) {
                adminAccountsApprovalService.approveAccount(account_id).then((res) => {
                    if (res.data.status) {
                        activityLogHelper.registerActivity(`Account Request: Approved new account request.`).then(status => {
                            if (status) {
                                $scope.accounts_approval.splice(index, 1);
                            }
                        });
                    }
                });
            }
        });
    }
}]);