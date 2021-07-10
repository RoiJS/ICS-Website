@extends('account-layout')

@section('title', 'Sent Messages')

@section('content')

    @include('admin.admin_navbar')
    
    <script type="text/javascript" src="/js/services/admin/admin.faculty.service.js"></script>
    <script type="text/javascript" src="/js/services/admin/admin.students.service.js"></script>
    <script type="text/javascript" src="/js/services/admin/admin.sent.messages.service.js"></script>

    <script type="text/javascript" src="/js/controllers/admin/admin.forward.message.controller.js"></script>

    <div class="content-wrapper">
        <input type="hidden" name="sent_item_id" id="sent_item_id" value="{{$sent_item['id']}}">
        <section class="content-header">
            <h1>Sent Message </h1>
            <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/admin/messages/sent">Sent</a></li>
            <li class="active">Sent Message</li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content" ng-controller="adminForwardMessageController">
            
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
                                <li ><a href="/admin/messages/inbox" ><i class="fa fa-inbox"></i> Inbox
                                <li class="active"><a href="/admin/messages/sent"><i class="fa fa-envelope-o"></i> Sent</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                    
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="box box-success">
                                <div class="box-header with-border">
                                    <div class="form-group">
                                        <label>Contact:</label>
                                        <select id="contact" class="form-control select-model" ng-model="contact" ng-options="userHelper.getAccountID(contact) + ' - ' + userHelper.getPersonFullname(contact) for contact in contacts track by contact.account_id" data-placeholder="Select contact&hellip;" style="width: 100%;">
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <!-- TODO: TO be replaced by trix editor -->
                                        <textarea class="form-control" ng-model="text" style="height: 300px;width:100%;" ng-model="sent_item.details.message"></textarea>
                                    </div>
                                </div>
                            </div>   
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="pull-right">
                                <button type="button" ng-click="sendMessage()" class="btn btn-success"><i class="fa fa-reply"></i> Submit</button>
                                <a href="/admin/messages" class="btn btn-danger" ><i class="fa fa-ban"></i> Cancel</a>
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
