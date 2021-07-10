@extends('account-layout')

@section('title', 'Chat')

@section('content')

    @include('teacher.teacher_navbar')

    <script src="/js/services/teacher/teacher.chat.service.js"></script>
    <script src="/js/controllers/teacher/teacher.chat.controller.js"></script>

    <div class="content-wrapper" ng-controller="teacherChatController">
        <section class="content-header">
            <h1>Chat</h1>
            <ol class="breadcrumb">
            <li><a href="/teacher"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Chat</li>
            </ol>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                      <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-list"></i> Classes</h3>
                        </div>
                        <div class="box-header with-border" ng-show="status.subject_loading">
                            <div class="row">
                                <div class="col-md-12">
                                    <i class="fa fa-refresh fa-spin"></i> Loading subjects&hellip;
                                </div>
                            </div>
                        </div>
                        <div class="box-header with-border" ng-show="!status.subject_loading && !status.has_subjects">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="callout callout-warning">
                                        <p><i class="fa fa-warning"></i> <b>No subject have been loaded for this semester</b></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-body no-padding" ng-show="!status.subject_loading && status.has_subjects">
                            <ul class="nav nav-pills nav-stacked">
                                <li ng-repeat="subject in subjects" >
                                    <a href="#" ng-click="selectSubject($index)">
                                    <i class="fa fa-book"></i> @{{systemHelper.trimString(subject.subject_description, 50)}}
                                    <span class="label label-warning pull-right" ng-if="!subject.read_status && subject.new_chat_num > 0">@{{subject.new_chat_num}}</span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                    <div class="box box-success box-solid direct-chat direct-chat-success">
                        <div class="box-header">
                            <h3 class="box-title">@{{current_subject.subject_description}} (@{{current_subject.subject_code}})</h3>
                            <div class="pull-right" >
                                <a href="#"  class="dropdown-toggle " data-toggle="dropdown"> <i class="fa fa-caret-down"></i></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a style="color:black;cursor:pointer;" ng-click="clearAllConversations()" ><i class="fa fa-trash"></i> Clear Conversation</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="box-header with-border" ng-show="status.conversations_loading">
                            <div class="row">
                                <div class="col-md-12">
                                    <i class="fa fa-refresh fa-spin"></i> Loading conversations&hellip;
                                </div>
                            </div>
                        </div>
                        <div class="box-header with-border" ng-show="!status.conversations_loading && !status.has_conversations">
                            <div class="row">
                                <div class="col-md-12">
                                    Be the first to send message&hellip;
                                </div>
                            </div>
                        </div>
                        <div class="box-body" ng-show="!status.conversations_loading && status.has_conversations">
                            <div class="direct-chat-messages group-chat-container">
                                <div ng-repeat="conversation in conversations">
                                    <div class="direct-chat-msg" ng-show="!conversation.is_sender">
                                        <div class="direct-chat-info clearfix">
                                            <span class="direct-chat-name pull-left">@{{userHelper.getPersonFullname(conversation.sender)}}</span>
                                            <span class="direct-chat-timestamp pull-right">@{{datetimeHelper.parseDate(conversation.send_at, 'medium')}}</span>
                                        </div><!-- /.direct-chat-info -->
                                        <img class="direct-chat-img" ng-src="@{{systemHelper.displayChatImage(conversation.sender.type, conversation.sender.image)}}" alt="@{{userHelper.getPersonFullname(conversation.sender)}}"><!-- /.direct-chat-img -->
                                        <div class="direct-chat-text">
                                            @{{conversation.message}}
                                        </div><!-- /.direct-chat-text -->
                                    </div><!-- /.direct-chat-msg -->

                                    <div class="direct-chat-msg right" ng-show="conversation.is_sender">
                                        <div class="direct-chat-info clearfix">
                                            <span class="direct-chat-name pull-right">@{{userHelper.getPersonFullname(conversation.sender)}}</span>
                                            <span class="direct-chat-timestamp pull-left">@{{datetimeHelper.parseDate(conversation.send_at, 'medium')}}</span>
                                        </div><!-- /.direct-chat-info -->
                                        <img class="direct-chat-img" ng-src="@{{systemHelper.displayChatImage(conversation.sender.type, conversation.sender.image)}}" alt="message user image"><!-- /.direct-chat-img -->
                                        <div class="direct-chat-text">
                                            @{{conversation.message}}
                                        </div><!-- /.direct-chat-text -->
                                    </div><!-- /.direct-chat-msg -->
                                </div>
                            </div><!--/.direct-chat-messages-->
                        </div><!-- /.box-body -->
                        <div class="box-footer">
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
        </section>
    </div>
@endsection
