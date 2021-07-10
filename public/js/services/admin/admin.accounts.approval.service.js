app.service('adminAccountsApprovalService',['$http', function($http){

    var main_uri = "/admin/accounts_approval"

    this.getAccountsApproval = () => {
        return $http.post(`${main_uri}/list_of_accounts_approval`);
    }

    this.approveAccount = (account_id) => {
        return $http.put(`${main_uri}/approve_account`, {account_id});
    }
}])