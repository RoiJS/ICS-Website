@extends('account-layout')

@section('title', 'Read Message')

@section('content')

    @include('admin.admin_navbar')

    <script type="text/javascript" src="/js/services/admin/admin.messages.service.js"></script>
    <script type="text/javascript" src="/js/controllers/admin/admin.read.message.controller.js"></script>

    <div class="content-wrapper">
       <input type="hidden" name="message_id" id="message_id" value="{{$message['id']}}">
        <section class="content-header">
            <h1>Read Message</h1>
            <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/admin/messages/inbox">Inbox</a></li>
            <li class="active">Read Message</li>
            </ol>
         </section>
        <!-- Main content -->
        <section class="content" ng-controller="adminReadMessageController">
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        <!-- /.box-header -->
                        <div class="box-body no-padding">
                            <div class="mailbox-read-info">
                                <h3>@{{detail.sender_name}}</h3>
                                <h5>From: @{{detail.email_address}}
                                <span class="mailbox-read-time pull-right">@{{detail.created_at}}</span></h5>
                            </div>
                            <!-- /.mailbox-read-info -->
                            <div class="mailbox-controls with-border text-center">
                                <div class="btn-group">
                                    <a ng-href="/admin/messages/reply/@{{detail.message_id}}" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Reply">
                                        <i class="fa fa-reply"></i>
                                    </a>
                                    <button ng-click="removeCurrentMessage()" type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Delete">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.mailbox-controls -->
                            <div class="mailbox-read-message">
                                @{{systemHelper.viewHTMLAsText(detail.message)}}
                            </div>
                            <!-- /.mailbox-read-message -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <!-- /.content -->
    </div>
@endsection
