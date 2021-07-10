@extends('account-layout')

@section('title', 'Messages')

@section('content')

    @include('admin.admin_navbar')

    <script type="text/javascript" src="/js/services/admin/admin.messages.service.js"></script>
    <script type="text/javascript" src="/js/services/admin/admin.sent.messages.service.js"></script>

    <script type="text/javascript" src="/js/controllers/admin/admin.sent.messages.controller.js"></script>
    <script type="text/javascript" src="/js/controllers/admin/admin.messages.controller.js"></script>

    <link rel="stylesheet" href="/css/admin/sent_items.css">

    <div class="content-wrapper">

        <section class="content-header">
            <h1>Messages</h1>
            <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Sent</li>
            </ol>
         </section>
         
        <section class="content" ng-controller="adminSentMessagesController">
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
                                <li><a href="/admin/messages/inbox" ><i class="fa fa-inbox"></i> Inbox
                                <li class="active"><a href="/admin/messages/sent"><i class="fa fa-envelope-o"></i> Sent</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-envelope"></i> Sent Items</h3>
                            </div>
                            <div class="box-header" ng-if="is_messages_loading">
                                <div class="row">
                                    <div class="col-md-12">
                                        <i class="fa fa-refresh fa-spin"></i> Loading messages&hellip;
                                    </div>
                                </div>
                            </div>
                            <div class="box-header" ng-if="!is_messages_loading && sent_items.length == 0">
                                <div class="alert alert-info lbl-empty-message-list">
                                    <i class="fa fa-info-circle fa-2x"></i>&nbsp;&nbsp;&nbsp; You have no messages.
                                </div>
                            </div>
                            <div class="box-body" ng-if="!is_messages_loading && sent_items.length > 0">
                                <div class="table-responsive mailbox-messages">
                                    <table ng-table="tableSentItems" class="table-sent-items table table-hover" show-filter="true">
                                        <tr ng-repeat="sent_item in $data">
                                            <td title="'Receiver'" class="col-sent-item-receiver" sortable="receiver" filter="{receiver: 'text'}">
                                                <a class="txt-sent-item-receiver" ng-href="/admin/messages/sent/@{{sent_item.message_id}}">@{{sent_item.receiver}}</a>
                                            </td>
                                            <td title="'Content'" class="col-sent-item-content" sortable="message" filter="{ message: 'text' }">
                                                <div class="txt-sent-item-content" ng-bind-html="sent_item.message"></div>
                                            </td>
                                            <td title="'Date sent'" sortable="sent_at" filter="{ sent_at: 'text'}">@{{sent_item.sent_at}}</td>
                                            <td ng-if="false">
                                                <a ng-href="/admin/messages/forward/@{{sent_item.sent_item_id}}" data-toggle="tooltip" title="Forward" class="btn btn-default">
                                                    <i class="fa fa-mail-forward"></i> 
                                                </a>
                                            </td>
                                            <td title="''">
                                                <button ng-click="removeSentItem(sent_item)" data-toggle="tooltip" title="Delete" class="btn btn-danger">
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
            </div>
        </section>
    <!-- /.content -->
    </div>
@endsection
