@extends('account-layout')

@section('title', 'Sent Message')

@section('content')

    @include('student.student_navbar')

    <script type="text/javascript" src="/js/services/student/student.sent.messages.service.js"></script>
    <script type="text/javascript" src="/js/controllers/student/student.forward.message.controller.js"></script>

    <div class="content-wrapper">
        <input type="hidden" name="sent_item_id" id="sent_item_id" value="{{$sent_item['id']}}">
        <section class="content-header">
            <h1>Sent Message </h1>
            <ol class="breadcrumb">
            <li><a href="/student"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/student/messages/sent">Sent</a></li>
            <li class="active">Sent Message</li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content" ng-controller="studentForwardMessageController">
            
            <br>
            <div class="row">
                <div class="col-md-3">
                    <a href="/student/messages/compose" class="btn btn-success btn-block margin-bottom">Compose</a>
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
                                <li class="active"><a href="/student/messages/inbox" ><i class="fa fa-inbox"></i> Inbox
                                <span class="label label-success pull-right">12</span></a></li>
                                <li><a href="/student/messages/sent"><i class="fa fa-envelope-o"></i> Sent</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                    
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="box box-success">
                                <div class="box-header with-border">
                                    <h3 class="box-title">@{{userHelper.getPersonFullname(sent_item.details)}}</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                    <div class="form-group">
                                        <input class="form-control" placeholder="To:" ng-model="sent_item.details.email_address">
                                    </div>
                                    <div class="form-group">
                                        <textarea id="compose-textarea" class="form-control" style="height: 300px" ng-model="sent_item.details.message"></textarea>
                                    </div>
                                </div>
                            </div>   
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="pull-right">
                                <button type="button" class="btn btn-success"><i class="fa fa-reply"></i> Submit</button>
                                <a href="/student/messages" class="btn btn-danger" ><i class="fa fa-ban"></i> Cancel</a>
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </section>
    <!-- /.content -->
    </div>
@endsection
