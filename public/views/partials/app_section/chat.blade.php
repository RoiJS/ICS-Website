<script type="text/javascript" src="/js/services/shared/account.chat.service.js"></script>
<script type="text/javascript" src="/js/controllers/shared/account.chat.controller.js"></script>

<link rel="stylesheet" href="/css/shared/chat.css">

<div class="row" ng-controller="accountChatController">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 chat-container">
        <div class="direct-chat-success">

            <div class="chat-sidebar-container">
                <div class="header"></div>
                <div class="conversation-content">
                    <div ng-if="getConversation" class="chat-loader-section">
                        <div class="chat-loader"></div>
                    </div>
                    <div ng-repeat="conversation in conversations" data-identifier="@{{conversation.chat_id}}">

                        <div ng-if="conversation.chat_id === latest_unread_chat" class="new-messages-text-container">
                            <div class="new-message-text">New Messages</div>    
                        </div>

                        <div class="direct-chat-msg" ng-show="!conversation.is_sender">
                            <div class="direct-chat-info clearfix">
                                <span class="direct-chat-name pull-left">@{{conversation.sender_name}} </span>
                                <span class="direct-chat-timestamp pull-right">@{{conversation.send_at}}</span>
                            </div><!-- /.direct-chat-info -->
                            <div class="user-image-container user-chat-image user-chat-image-receiver">
                                <img class="direct-chat-img" ng-src="@{{conversation.sender_image}}" />
                            </div>
                            <div class="direct-chat-text">
                                @{{conversation.message}}
                            </div><!-- /.direct-chat-text -->
                        </div><!-- /.direct-chat-msg -->

                        <div class="direct-chat-msg right" ng-show="conversation.is_sender">
                            <div class="direct-chat-info clearfix">
                                <span class="direct-chat-name pull-right">@{{conversation.sender_name}} </span>
                                <span class="direct-chat-timestamp pull-left">@{{conversation.send_at}}</span>
                            </div><!-- /.direct-chat-info -->
                            <div class="user-image-container user-chat-image user-chat-image-sender">
                                <img class="direct-chat-img" ng-src="@{{conversation.sender_image}}" />
                            </div>
                            <div class="direct-chat-text">
                                @{{conversation.message}}
                            </div><!-- /.direct-chat-text -->
                        </div><!-- /.direct-chat-msg -->

                    </div>
                </div>
                
            </div>

            <div class="send-chat-section">
                <form novalidate ng-submit="sendChat()">
                    <div class="input-group">
                        <input type="text" ng-model="message" placeholder="Type Message ..." class="form-control">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-success btn-flat">Send</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>