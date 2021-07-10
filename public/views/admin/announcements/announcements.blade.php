@extends('account-layout')

@section('title', 'Announcements')

@section('content')

    @include('admin.admin_navbar')

    <script type="text/javascript" src="/js/services/admin/admin.announcements.service.js"></script>
    <script type="text/javascript" src="/js/controllers/admin/admin.announcements.controller.js"></script>
    
    <link rel="stylesheet" href="/css/admin/announcements.css">

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Announcements</h1>
            <ol class="breadcrumb">
                <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Announcements</li>
            </ol>
        </section>

        <section class="content" ng-controller="adminAnnouncementController">   
            <div class="row">
                <div class="col-md-12">
                    <a class="btn btn-success" href="/admin/announcements/add_announcement">Add Announcement <i class="fa fa-plus"></i></a>
                </div>
            </div>
            <br>
            <div class="row" ng-if="status.data_loading">
                <div class="col-md-12">
                    <i class="fa fa-refresh fa-spin"></i> <span>Loading&hellip;</span>
                </div>
            </div>
            <div class="row" ng-if="!status.data_loading">
                <div class="col-xs-12">
                    <table ng-table="tableParams" class="table-announcements table table-bordered table-striped" show-filter="true">
                        <tr ng-repeat="announcement in $data">
                            <td title="'Announcements'" filter="{ title: 'text'}" sortable="'title'">
                                <div class="row">
                                    <div class="col-md-3">
                                        <center>
                                            <img class="img-responsive img-thumbnail announcement-thumbnail" ng-src="@{{announcement.thumbnail}}">
                                        </center>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="row">
                                        <div class="col-md-10">
                                                <h4>@{{announcement.trimmedTitle}}</h4>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="pull-right">
                                                    <a href="#" class="dropdown-toggle " data-toggle="dropdown"> <i class="fa fa-caret-down"></i></a>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li ng-if="announcement.post_status == 0"><a ng-click="postUnpostAnnouncement($index, 1)"><i class="fa fa-eye"></i> Post</a></li>
                                                        <li ng-if="announcement.post_status == 1"><a ng-click="postUnpostAnnouncement($index, 0)"><i class="fa fa-eye-slash"></i> Unpost</a></li>
                                                        <li><a ng-href="announcements/edit_announcement/@{{announcement.announcement_id}}"><i class="fa fa-edit"></i> Edit</a></li>
                                                        <li><a ng-click="removeAnnouncement($index)"><i class="fa fa-trash"></i> Remove</a></li>
                                                    </ul>
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">@{{announcement.trimmedDescription}}</div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <dl class="dl-horizontal">
                                                    <dt>Date created: </dt>
                                                    <dd>@{{announcement.created_at}}</dd>
                                                    <dt>Date posted: </dt>
                                                    <dd>@{{announcement.post_date}}</dd>
                                                    <dt>Date last updated: </dt>
                                                    <dd>@{{announcement.updated_at}}</dd>
                                                </dl>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>    
                </div>
            </div>
            
        </section>
    </div>
@endsection
