var app = angular.module('wmsu_ics_app', ["ngTable", "ui.calendar"]);

app.run(($rootScope, $timeout, helperService, textsService) => {
    $rootScope.helper = helperService;

    $rootScope.systemHelper = helperService.SYSTEM;
    $rootScope.dialogHelper = helperService.SYSTEM.DIALOGS;
    $rootScope.datetimeHelper = helperService.DATETIME;
    $rootScope.imageFileHelper = helperService.IMAGE_FILE;
    $rootScope.userHelper = helperService.USER;
    $rootScope.numberHelper = helperService.NUMBER;
    $rootScope.dataTableHelper = helperService.DATATABLE;
    $rootScope.chatHelper = helperService.CHAT_HELPER;
    $rootScope.activityLogHelper = helperService.ACTIVITY_LOG_HELPER;
    $rootScope.notificationHelper = helperService.NOTIFICATION_HELPER;

    $rootScope.sysTxtsHelper = textsService.SYSTEM;
    $rootScope.subjTxtsHelper = textsService.SUBJECT;
    $rootScope.courseTxtsHelper = textsService.COURSE;
    $rootScope.syTxtsHelper = textsService.SCHOOL_YEAR;

    $rootScope.timeout = $timeout;

    $rootScope.systemHelper.checkForPendingRequests();
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


