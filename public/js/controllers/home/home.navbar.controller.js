app.controller('homeNavbarController', ['$scope', function ($scope) {

    var systemHelper = $scope.systemHelper;
    var imageFileHelper = $scope.imageFileHelper;

    $scope.ics_details = {};

    this.load = () => {
        systemHelper.getICSDetails().then((res) => {
            $scope.ics_details = res.data.ics_details;

            // Set ICS official logo
            $scope.ics_details.official_logo = `${imageFileHelper.getFileSrc().ics_logo}${$scope.ics_details.ics_logo}`;
        });
    }

    this.load();
}]);