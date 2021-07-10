app.controller('teacherChatController', ['$scope', '$interval', 'teacherChatService', function ($scope, $interval, teacherChatService) {

    var systemHelper = $scope.systemHelper;
    var dialogHelper = $scope.dialogHelper;

    $scope.subjects = [];
    $scope.current_subject = null;
    $scope.conversations = [];

    $scope.status = {
        subject_loading: false,
        has_subjects: false,

        load_count: 0,
        has_conversations: false,
        conversations_loading: false
    }

    $scope.message = null;

    displayFacultySubjects = () => {
        $scope.status.subject_loading = true;

        /**
         * TODO:
         *  (1) Simplify service promise method return value
         *  (2) Refactor to get the truthy value
         */
        teacherChatService.getFacultySubjects().then((res) => { // (1)
            $scope.status.subject_loading = false;
            $scope.subjects = res.data.subjects;

            $scope.current_subject = $scope.subjects[0];
            $scope.subjects[0].read_status = true;
            $scope.status.has_subjects = $scope.subjects.length > 0 ? true : false; // (2)

            displayConversationPerSubject($scope.current_subject.class_id);
        });
    }

    displayConversationPerSubject = (class_id) => {

        /**
         * TODO:
         *  (1) Simplify service promise method return value
         */

        if ($scope.status.load_count == 0) $scope.status.conversations_loading = true;

        teacherChatService.getConversation(class_id).then((res) => { // (1)

            if (!$scope.status.load_count || $scope.status.load_count === 0) {
                $scope.status.conversations_loading = false;
            }

            $scope.conversations = res.data.conversations;
            $scope.status.has_conversations = Boolean($scope.conversations.length);
            $scope.status.load_count = $scope.status.load_count + 1;
        });
    }

    $scope.sendChat = () => {
        if ($scope.message != null || $scope.message != "") {

            /**
             * TODO:
             *  -> Simplify service promise method return value
             */
            teacherChatService.sendChat($scope.message, $scope.current_subject.class_id).then((res) => { // (1)
                $scope.message = ''
                displayConversationPerSubject($scope.current_subject.class_id);
            });
        }
    }

    $scope.selectSubject = (index) => {
        $scope.current_subject = $scope.subjects[index];
        $scope.status.load_count = 0;
        $scope.current_subject.read_status = true;
        displayConversationPerSubject($scope.current_subject.class_id);
    }

    $scope.clearAllConversations = () => {
        if ($scope.conversations.length > 0) {

            /**
             * TODO: 
             *  (2) Simplify service method return value 
             */

            var title = 'Remove messages';
            var message = 'Removing all messages cannot be undo anymore. Are you really sure to clear all conversation?';
            
            dialogHelper.showRemoveConfirmation(title, message, function (result) {
                if (result) {
                    teacherChatService.clearAllConversations($scope.current_subject.class_id).then((res) => { // (2)
                        if (res.data.status) {
                            displayConversationPerSubject($scope.current_subject.class_id);
                        }
                    });
                }
            });
        }

    }

    displayFacultySubjects();

    $scope.is_first_interval = true;
    $interval(() => {
        /**
         * TODO: 
         *  (1 & 2) Simplify service method return value 
         */
        teacherChatService.monitorNewMessage($scope.conversations.length, $scope.current_subject.class_id).then((res) => { // (1)
            if (res.data.result === true) {
                if (!$scope.is_first_interval) {
                    systemHelper.playNewMessageSound();
                }
                displayConversationPerSubject($scope.current_subject.class_id);
            }
            $scope.is_first_interval = false;
        });


        teacherChatService.monitorOtherSubjectNewMessage($scope.subjects).then((res) => { // (2)
            $scope.subjects = res.data.new_messages;
        });

    }, 5000);
}]);