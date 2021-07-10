@extends('account-layout')

@section('title', 'Reply Message')

@section('content')

    @include('teacher.teacher_navbar')

    <script type="text/javascript" src="/js/services/teacher/teacher.messages.service.js"></script>
    <script type="text/javascript" src="/js/controllers/teacher/teacher.reply.message.controller.js"></script>

    <div class="content-wrapper">
        <input type="hidden" name="message_id" id="message_id" value="{{$message['id']}}">
        <section class="content-header">
            <h1>Reply Message </h1>
            <ol class="breadcrumb">
            <li><a href="/teacher"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/teacher/messages/inbox">Inbox</a></li>
            <li class="active">Reply Message</li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content" ng-controller="teacherReplyMessageController">
            <br>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">@{{userHelper.getPersonFullname(message.details)}}</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                            <div class="form-group">
                                <input class="form-control" placeholder="To:" ng-model="message.details.email_address">
                            </div>
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
                        <button type="button" class="btn btn-success"><i class="fa fa-reply"></i> Submit</button>
                        <a href="/teacher/messages" class="btn btn-danger" ><i class="fa fa-ban"></i> Cancel</a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </section>
    <!-- /.content -->
    </div>
@endsection
