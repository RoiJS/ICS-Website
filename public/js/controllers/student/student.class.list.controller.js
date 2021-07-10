app.controller('studentClassListController', ['$scope', 'accountClassListService', function($scope, accountClassListService){

    var userHelper = $scope.userHelper;
    var imageFileHelper = $scope.imageFileHelper;
    var datetimeHelper = $scope.datetimeHelper;
    var systemHelper = $scope.systemHelper;

    var class_id = ClassGlobalVariable.currentClassId;
    
    $scope.class_lists = [];

    $scope.status = {
        has_class_lists : false,
        class_list_loading : false
    }

    displayClassList = (callback) => {
        $scope.status.class_list_loading = true;
        accountClassListService.getClassList(class_id).then((res) => {
            $scope.status.class_list_loading = false;
            $scope.class_lists = res.data.classes;
            $scope.status.has_class_lists = ($scope.class_lists.length > 0);

            $scope.class_lists.map((c) => {
                c.trimname = systemHelper.trimString(userHelper.getPersonFullname(c), 15);
                c.fullname = userHelper.getPersonFullname(c);
                c.image_source = imageFileHelper.setStudentImage(c.image);
                c.birthdate = datetimeHelper.parseDate(c.birthdate);
            });

            if (callback) callback();
        });
    }
    
    displayClassList(() => {
        systemHelper.removePageLoadEffect();
    });
}]);