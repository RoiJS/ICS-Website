@extends('account-layout')

@section('title', 'Messages')

@section('content')

    @include('admin.admin_navbar')

    
    <script type="text/javascript" src="/js/services/admin/admin.messages.service.js"></script>
    <script type="text/javascript" src="/js/services/admin/admin.sent.messages.service.js"></script>

    <script type="text/javascript" src="/js/controllers/admin/admin.messages.controller.js"></script>
    <script type="text/javascript" src="/js/controllers/admin/admin.sent.messages.controller.js"></script>

    <div class="content-wrapper">
        
        <section class="content-header">
            <h1>Messages</h1>
            <ol class="breadcrumb">
            <li><a href="/student"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Messages</li>
            </ol>
         </section>

        <section class="content" >
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
                                <li class="active"><a href="#inbox" data-toggle="tab"><i class="fa fa-inbox"></i> Inbox
                                <span class="label label-success pull-right">12</span></a></li>
                                <li><a href="#sent-items" data-toggle="tab"><i class="fa fa-envelope-o"></i> Sent</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="inbox" ng-controller="adminMessagesController">
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
                                                    <td><a ng-href="/admin/messages/@{{message.message_id}}">
                                                    @{{userHelper.getPersonFullname(message)}}</a></td>
                                                    <td>@{{systemHelper.trimString(message.message, 50)}}</td>
                                                    <td>@{{messages.getTimeAgo(message) | date : 'MMM d, y'}}</td>
                                                    <td><a data-toggle="tooltip" title="Reply" ng-href="/admin/messages/reply/@{{message.message_id}}" class="btn btn-default"><i class="fa fa-reply"></i></a></td>
                                                    <td><button data-toggle="tooltip" title="Delete" class="btn btn-danger" ng-click="deleteMessage(message)"><i class="fa fa-trash"></i></button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="sent-items" ng-controller="adminSentMessagesController">
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
                                                   <td><a ng-href="/admin/messages/sent/@{{sent_item.sent_item_id}}">@{{userHelper.getPersonFullname(sent_item)}}</a></td>
                                                   <td>@{{systemHelper.trimString(sent_item.message, 50)}}</td>
                                                   <td>@{{sent_items.getTimeAgo(sent_item) | date : 'MMM d, y'}}</td>
                                                   <td><a ng-href="/admin/messages/forward/@{{sent_item.sent_item_id}}" data-toggle="tooltip" title="Forward" class="btn btn-default"><i class="fa fa-mail-forward"></i> </a></td>
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
            </div>
        </section>
    <!-- /.content -->
    </div>
@endsection
