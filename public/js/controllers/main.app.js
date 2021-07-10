var app = angular.module('wmsu_ics_app', []);

app.run(($rootScope, $timeout, helperService) => {
    $rootScope.helper = helperService;
    $rootScope.timeout = $timeout;
});

app.filter('range', function(){
    return function(input, min, max){
        var min = parseInt(min);
        var max = parseInt(max);

        for(i = min; i <= max; i++){    
            input.push(i);
        }
        return input;
    };
    
});

 app.filter('htmlToPlaintext', function() {
    return function(text) {
      return  text ? String(text).replace(/<[^>]+>/gm, '') : '';
    };
});


