app.controller('accountChatController', ['$scope', '$interval', 'accountChatService', function ($scope, $interval, accountChatService) {

    var systemHelper = $scope.systemHelper;
    var datetimeHelper = $scope.datetimeHelper;
    var userHelper = $scope.userHelper;
    var chatHelper = $scope.chatHelper;

    var class_id = ClassGlobalVariable.currentClassId;
    var currentUser = null;

    $scope.conversations = [];

    $scope.status = {
        subject_loading: false,
        has_subjects: false,

        load_count: 0,
        has_conversations: false,
        conversations_loading: false
    }

    var lazyLoadingSettings = {
        chatFrom: 1,
        chatTo: 10,
        postPerRequests: 10
    };

    $scope.getConversation = false;

    $scope.message = "";
    $scope.absoluteCount = 0;
    $scope.latest_unread_chat = 0;

    this.displayConversationPerSubject = (class_id, callback) => {

        $scope.getConversation = true;
        
        if ($scope.status.load_count == 0) $scope.status.conversations_loading = true;

        accountChatService.getConversation(class_id, lazyLoadingSettings.chatFrom, lazyLoadingSettings.chatTo).then((res) => {
            if ($scope.status.load_count == 0) $scope.status.conversations_loading = false;

            this.addCoversations(res.data.conversations);
            $scope.absoluteCount = res.data.absoluteCount;

            $scope.status.has_conversations = ($scope.conversations.length > 0);
            $scope.status.load_count = $scope.status.load_count + 1;

            $scope.conversations.map(c => {
                c.sender_name = c.sender.first_name[0] + '. ' + c.sender.last_name;
                c.send_at = datetimeHelper.parseDate(c.send_at, 'medium');
                c.sender_image = systemHelper.displayChatImage(c.sender.type, c.sender.image);
                c.sender_image = systemHelper.displayChatImage(c.sender.type, c.sender.image);
            });

            $scope.getConversation = false;

            if (callback) callback();
        });
    }

    this.addCoversations = (conversations) => {
        for (var pos = 0; pos < conversations.length; pos++) {
            $scope.conversations.unshift(conversations[pos]);
        }
    }

    // Get more convesations
    this.initializeScroll = () => {

        var scrollContainer = $('.chat-sidebar-container');

        scrollContainer.slimScroll({
            height: "502px",
            alwaysVisible: true,
            size: '10px',
            color: '#a7a7a7',
            railOpacity: 1,
            start: 'bottom'
        });

        scrollContainer.slimScroll().bind('slimscroll', (e, pos) => {
            if (pos === 'top') {
                if (!this.noMoreConversations()) {

                    lazyLoadingSettings.chatFrom += lazyLoadingSettings.postPerRequests;
                    lazyLoadingSettings.chatTo += lazyLoadingSettings.postPerRequests;

                    this.displayConversationPerSubject(class_id);
                    this.scrollDown();
                }
            }
        });
    }

    this.scrollToBottom = () => {
        var scrollContainer = $('.chat-sidebar-container');
        var scrollTo_int = scrollContainer.prop('scrollHeight') + 'px';

        scrollContainer.slimScroll({
            scrollTo: scrollTo_int
        });
    }

    this.scrollDown = () => {
        var scrollContainer = $('.chat-sidebar-container');

        scrollContainer.slimScroll({
            scrollTo: '100px'
        });
    }

    this.noMoreConversations = () => {
        return $scope.absoluteCount === $scope.conversations.length;
    }

    this.registerLastViewedChat = (class_id) => {
        chatHelper.registerLastViewedChat(class_id).then((res) => {
            // Return number of new messages
            $scope.latest_unread_chat = (res.data[0].last_viewed_chat_id + 1);
        });
    }

    this.getCurrentUser = () => {
        return userHelper.getCurrentAccount();
    }

    this.load = () => {
        // Initialize conversation list
        this.displayConversationPerSubject(class_id, () => {

            this.initializeScroll();

            // Register which conversations last viewed by the current user 
            this.registerLastViewedChat(class_id);

            this.monitorIncomingNewMessages();

            // Remove loader 
            systemHelper.removePageLoadEffect();
        });
    }

    $scope.sendChat = () => {
        if ($scope.message) {
            var message = $scope.message;
            $scope.message = "";
            accountChatService.sendChat(message, class_id).then((res) => {
                // Update last viewed chat
                chatHelper.updateLastViewedChat(class_id).then(res => {
                    $scope.latest_unread_chat = (res.data[0].current_chat_id + 1);
                });
            });
        }
    }

    this.monitorIncomingNewMessages = () => {

        chatHelper.monitorNewMessages($scope.absoluteCount, class_id).then((res) => {

            if (res.data.result === true) {

                var current_latest_id = $scope.conversations.length > 0 ? $scope.conversations[$scope.conversations.length - 1].chat_id : 0;

                chatHelper.getNewMessages(class_id, current_latest_id).then((res) => {

                    var messagesFromCurrentUser = res.data.messagesFromCurrentUser;
                    var newMessages = res.data.newMessages;
                    this.addNewMessages(newMessages);

                    // Determine if new messages came from current user
                    if ($.inArray(true, messagesFromCurrentUser) < 0) {
                        // play sound indicating new message
                        systemHelper.playNewMessageSound();
                    }

                    this.monitorIncomingNewMessages();
                    this.scrollToBottom();
                });
            } else {
                this.monitorIncomingNewMessages();
            }
        });
    }

    this.addNewMessages = (conversations) => {

        conversations.map(c => {
            c.sender_name = c.sender.first_name[0] + '. ' + c.sender.last_name;
            c.send_at = datetimeHelper.parseDate(c.send_at, 'medium');
            c.sender_image = systemHelper.displayChatImage(c.sender.type, c.sender.image);
            c.sender_image = systemHelper.displayChatImage(c.sender.type, c.sender.image);
        });

        for (var pos = 0; pos < conversations.length; pos++) {
            $scope.conversations.push(conversations[pos]);
        }
        $scope.absoluteCount += conversations.length;
    }

    // Initialized content
    this.load();
}]);