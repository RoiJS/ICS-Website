@extends('account-layout')

@section('title', 'Messages')

@section('content')

    @include('admin.admin_navbar')

    <script type="text/javascript" src="/js/services/admin/admin.messages.service.js"></script>
    <script type="text/javascript" src="/js/controllers/admin/admin.messages.controller.js"></script>

    <link rel="stylesheet" href="/css/admin/messages.css">

    <div class="content-wrapper">
        <section class="content-header">
            <h1>Messages</h1>
            <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Inbox</li>
            </ol>
         </section>
         
        <section class="content" ng-controller="adminMessagesController">
            <br>
            <div class="row">
                <div class="col-md-3">
                    <a href="/admin/messages/compose" class="btn btn-success btn-block margin-bottom">Compose</a>
                    <div class="box box-success">
                        <div class="box-header with-border">
                        <h3 class="box-title">Folders</h3>

                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                        </div>
                        <div class="box-body no-padding">
                            <ul class="nav nav-pills nav-stacked">
                                <li class="active"><a href="/admin/messages/inbox" ><i class="fa fa-inbox"></i> Inbox
                                <li><a href="/admin/messages/sent"><i class="fa fa-envelope-o"></i> Sent</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                   <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-inbox"></i> Inbox</h3>
                        </div>
                        <div class="box-header" ng-if="status.messages_loading">
                            <div class="row">
                                <div class="col-md-12">
                                    <i class="fa fa-refresh fa-spin"></i> Loading messages&hellip;
                                </div>
                            </div>
                        </div>
                        <div class="box-header" ng-if="!status.messages_loading && messages.length == 0">
                            <div class="alert alert-info lbl-empty-message-list">
                                <i class="fa fa-info-circle fa-2x"></i>&nbsp;&nbsp;&nbsp; You have no messages.
                            </div>
                        </div>
                        <div class="box-body" ng-if="!status.messages_loading && messages.length > 0">
                            <div class="table-responsive mailbox-messages">
                                <table ng-table="tableMessages" class="table-messages table table-bordered table-striped" show-filter="true">
                                    <tr ng-repeat="message in $data">
                                        <td title="'Sender'" class="col-message-sender" sortable="sender" filter="{ sender: 'text' }">
                                            <a class="txt-message-sender" ng-href="/admin/messages/@{{message.message_id}}">@{{message.sender}}</a>
                                        </td>
                                        <td title="'Content'" class="col-message-content" sortable="message" filter="{ message: 'text'}">
                                            <div class="txt-message-content" ng-bind-html="message.message"></div>
                                        </td>
                                        <td title="'Date sent'" sortable="sent_at">@{{message.sent_at}}</td>
                                        <td class="col-message-options">
                                            <a data-toggle="tooltip" title="Reply" ng-href="/admin/messages/reply/@{{message.message_id}}" class="btn btn-default">
                                                <i class="fa fa-reply"></i>
                                            </a>
                                            <button data-toggle="tooltip" title="Remove" class="btn btn-danger" ng-click="deleteMessage(message.message_id)">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </table>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <!-- /.content -->
    </div>
@endsection
