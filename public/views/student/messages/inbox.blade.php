@extends('account-layout')

@section('title', 'Messages')

@section('content')

    @include('student.student_navbar')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Messages</h1>
            <ol class="breadcrumb">
                <li><a href="/student"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Inbox</li>
            </ol>
         </section>
        <!-- Main content -->
        <section class="content">
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
                <div class="col-md-9">
                   <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-inbox"></i> Inbox</h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive mailbox-messages">
                                <table id="table-inbox" class="table table-bordered table-striped">
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
                                        <tr ng-repeat="message in messages.getMessagesList()">
                                            <td><a ng-href="/student/messages/@{{message.message_id}}">
                                            @{{userHelper.getPersonFullname(message)}}</a></td>
                                            <td>@{{systemHelper.trimString(message.message, 50)}}</td>
                                            <td>@{{messages.getTimeAgo(message) | date : 'MMM d, y'}}</td>
                                            <td><a data-toggle="tooltip" title="Reply" ng-href="/student/messages/reply/@{{message.message_id}}" class="btn btn-default"><i class="fa fa-reply"></i></a></td>
                                            <td><button data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-trash"></i></button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
