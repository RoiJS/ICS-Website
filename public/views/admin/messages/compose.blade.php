@extends('account-layout')

@section('title', 'Compose')

@section('content')

    @include('admin.admin_navbar')

    <script type="text/javascript" src="/js/services/admin/admin.faculty.service.js"></script>
    <script type="text/javascript" src="/js/services/admin/admin.students.service.js"></script>
    <script type="text/javascript" src="/js/services/admin/admin.compose.service.js"></script>
    
    <script type="text/javascript" src="/js/services/admin/admin.compose.controller.js"></script>
    
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Compose </h1>
            <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/admin/messages/inbox">Inbox</a></li>
            <li class="active">Compose</li>
            </ol>
        </section>
        
        <section class="content" ng-controller="adminComposeController">
            <br>
            <div class="row">
                <div class="col-md-3">
                    <a href="/admin/messages/inbox" class="btn btn-success btn-block margin-bottom">Back to Inbox</a>
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
                                <li><a href="/admin/messages/sent"><i class="fa fa-envelope-o"></i> Sent</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                    <form novalidate ng-submit="sendMessage()">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="box box-success">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Compose New Message</h3>
                                    </div>
                                        <!-- /.box-header -->
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label>Contact:</label>
                                            <select id="contact" class="form-control select-model" ng-model="contact" ng-options="userHelper.getAccountID(contact) + ' - ' + userHelper.getPersonFullname(contact) for contact in contacts track by contact.account_id" data-placeholder="Select contact&hellip;" style="width: 100%;">
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <!-- <trix-editor id="message" angular-trix class="text-editor-container" ng-model="message.message">
                                            
                                            </trix-editor> -->
                                            <textarea id="message" cols="100" rows="10" ng-model="text"></textarea>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-reply"></i> Submit</button>
                                    <a href="/admin/messages" class="btn btn-danger" ><i class="fa fa-ban"></i> Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.row -->
        </section>
    <!-- /.content -->
     </div>
@endsection