@extends('account-layout')

@section('title', 'Classes Approval')

@section('content')

    @include('teacher.teacher_navbar')

    <script type="text/javascript" src="/js/services/teacher/teacher.subject.approval.service.js"></script>
    <script type="text/javascript" src="/js/controllers/teacher/teacher.subject.approval.controller.js"></script>

    <div class="content-wrapper" ng-controller="teacherSubjectApprovalController">
        <section class="content-header">
            <h1> Subjects List </h1>
            <ol class="breadcrumb">
                <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Enroll Subjects</li>
            </ol>
        </section>

        <div class="content">
            <br>
            <div class="row" ng-if="status.data_loading">
                <div class="col-md-12">
                    <i class="fa fa-refresh fa-spin"></i> <span> Loading&hellip; </span>
                </div>
            </div>
            <div class="row" ng-if="!status.data_loading">
                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Subject list</h3>
                        </div>
                        <div class="box-body">
                            <table class="table table-hover" ng-show="!status.subject_loading">
                                <thead>
                                    <tr>
                                        <th style="width:15%;">Student name</th>
                                        <th style="width:10%;">Subject</th>
                                        <th style="width:20%;">Date Sent Request</th>
                                        <th style="width:8%;"></th>
                                    </tr>                                
                                </thead>
                                <tbody ng-repeat="subject in subjects_approval">  
                                    <tr>
                                        <td>@{{userHelper.getPersonFullname(subject)}}</td>
                                        <td>@{{subject.subject_description}}</td>
                                        <td>@{{datetimeHelper.parseDate(subject.requested_at)}}</td>
                                        <td><button class="btn btn-success" ng-click="approveSubject($index)" ><i class="fa fa-bookmark-o"></i> Approve</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
@endsection