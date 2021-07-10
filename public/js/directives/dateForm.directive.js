app.directive('dateFormat', function(){
    return {
        scope : {
            ngModel : '='
        },
        link: function (scope) {
            if (scope.ngModel) {
             scope.ngModel = new Date(scope.ngModel);
          }
        }
    }
});