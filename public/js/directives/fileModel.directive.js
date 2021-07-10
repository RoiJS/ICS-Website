app.directive('fileModel', ['$parse', function($parse){
    return {
        restrict : 'A',
        link : (scope, elements, attrs) => {
            var model = $parse(attrs.fileModel);
            var modelSetter = model.assign;

            elements.bind('change', function(){
                scope.$apply(function(){
                    modelSetter(scope, elements[0].files[0]);
                });
            });
        }
    }
}]);