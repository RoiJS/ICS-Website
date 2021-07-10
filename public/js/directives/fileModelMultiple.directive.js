app.directive('fileModelMultiple', ['$parse', function($parse){
    return {
        restrict : 'A',
        link : (scope, elements, attrs) => {
            var model = $parse(attrs.fileModelMultiple);

            elements.bind('change', function(){
                scope.$apply(function(){
                    if (elements[0].files.length > 0) model.assign(scope, elements[0].files);
                });
            });
        }
    }
}]);