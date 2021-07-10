@extends('account-layout')

@section('title', 'Sent')

@section('content')

    @include('teacher.teacher_navbar')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Messages</h1>
            <ol class="breadcrumb">
            <li><a href="/teacher"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Sent</li>
            </ol>
         </section>
        <!-- Main content -->
        <section class="content" >
            <br>
            <div class="row">
                <div class="col-md-3">
                    <a href="/teacher/messages/compose" class="btn btn-success btn-block margin-bottom">Compose</a>
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
                                <li class="active"><a href="/teacher/messages/inbox" ><i class="fa fa-inbox"></i> Inbox
                                <span class="label label-success pull-right">12</span></a></li>
                                <li><a href="/teacher/messages/sent"><i class="fa fa-envelope-o"></i> Sent</a></li>
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
                            <div class="box-body">
                                <div class="table-responsive mailbox-messages">
                                    
                                    <table id="table-sent-items" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="sent_item in sent_items.getSentMessagesList()">
                                                <td><a ng-href="/teacher/messages/sent/@{{sent_item.sent_item_id}}">@{{userHelper.getPersonFullname(sent_item)}}</a></td>
                                                <td>@{{systemHelper.trimString(sent_item.message, 50)}}</td>
                                                <td>@{{sent_items.getTimeAgo(sent_item) | date : 'MMM d, y'}}</td>
                                                <td><a ng-href="/teacher/messages/forward/@{{sent_item.sent_item_id}}" data-toggle="tooltip" title="Forward" class="btn btn-default"><i class="fa fa-mail-forward"></i> </a></td>
                                                <td><button data-toggle="tooltip" title="Delete" class="btn btn-danger"><i class="fa fa-trash"></i></button></td>
                                            </tr>
                                        </tbody>
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
