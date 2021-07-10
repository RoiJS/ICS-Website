@extends('account-layout')

@section('title', 'Reply Message')

@section('content')

    @include('admin.admin_navbar')

    <script type="text/javascript" src="/js/services/admin/admin.messages.service.js"></script>
    <script type="text/javascript" src="/js/controllers/admin/admin.reply.message.controller.js"></script>

    <div class="content-wrapper">
        
        <input type="hidden" name="message_id" id="message_id" value="{{$message['id']}}">
        <section class="content-header">
            <h1>Reply Message </h1>
            <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/admin/messages/inbox">Inbox</a></li>
            <li class="active">Reply Message</li>
            </ol>
        </section>

        <section class="content" ng-controller="adminReplyMessageController">
            <br>
            <form novalidate ng-submit="sendReplyMessage()">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <h3 class="box-title">@{{sender}}</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <textarea id="compose-textarea" class="form-control" style="height: 300px"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="pull-right">
                            <button type="submit" class="btn btn-success"><i class="fa fa-reply"></i> Submit</button>
                            <a href="/admin/messages/inbox" class="btn btn-danger" ><i class="fa fa-ban"></i> Cancel</a>
                        </div>
                    </div>
                </div> 
            </form>  
            <!-- /.row -->
        </section>
    <!-- /.content -->
    </div>
@endsection
