app.directive('selectModel', ['$parse', function($parse){
    return {
        restrict : 'A',
        template : '<h3>Hello Angular</h3>',
        link : (scope, elements, attrs) => {
            var model = $parse(attrs.selectModel);
            var modelSetter = model.assign;

            elements.bind('change', function(){
                scope.$apply(function(){
                    modelSetter(scope, elements.value);
                });
            });

            elements.bind('click', function(){
               console.log('success');
            });
        }
    }
}]);