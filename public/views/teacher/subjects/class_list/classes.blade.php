@extends('account-layout')

@section('title')
   {{$subject['description']}} | Class List
@endsection

@section('content')

    @include('teacher.subjects.teacher_subject_navbar')

    <script type="text/javascript" src="/js/services/shared/account.class.list.service.js"></script>
    <script type="text/javascript" src="/js/controllers/teacher/teacher.class.list.controller.js"></script>

    <link rel="stylesheet" href="/css/shared/classes.css">

    <div class="content-wrapper">
        <section class="content-header">
            <h1>{{$subject['description']}}  <small>Official class List</small></h1>
            <ol class="breadcrumb">
            <li><a href="/teacher"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/teacher/subject/{{$id}}/posts"><i class="fa fa-book"></i> {{$subject['description']}}</a></li>
            <li class="active">Official class List</li>
            </ol>
        </section>

        <section class="content" ng-controller="teacherClassListController">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="/teacher/subject/{{$id}}/class/enroll_students" class="btn btn-success"> Enroll students <i class="fa fa-user-plus"></i></a>
                        </div>
                    </div>
                    <br>
                    <div class="row" ng-show="status.class_list_loading">
                        <div class="col-md-12">
                            <i class="fa fa-refresh fa-spin"></i> Loading Class List. Please wait&hellip;
                        </div>
                    </div>
                    <div class="row" ng-show="!status.class_list_loading && !status.has_class_lists">
                        <div class="col-md-12">
                            <div class="callout callout-warning">
                                <h4><i class="fa fa-warning"></i> No students have been enrolled to this class.</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row" ng-show="!status.class_list_loading">
                        <div ng-repeat="class in class_lists" ng-init="class_index = $index" class="col-xs-4 col-sm-4 col-md-4 col-lg-4" >
                            <div class="box box-widget widget-user-2" >
                                <div class="widget-user-header" ng-class="{'bg-green': class.is_active === 1, 'bg-yellow': class.is_active === 0 }">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="pull-right" >
                                                <a href="#" class="icon-caret-down dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-caret-down"></i></a>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li ng-click="removeStudent(class_index)"><a class="delete-student-icon" href="#"><i class="fa fa-trash"></i>Unenroll student </a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="student-information-panel">
                                        <div class="student-image-container widget-user-image">
                                            <img class="student-image" ng-src="@{{class.image_source}}" title="@{{class.fullname}}" />
                                        </div>
                                        <div>
                                            <h4 title="@{{class.fullname}}">@{{class.trimname}}</h4>
                                            <h5>@{{class.student_id}}</h5>   
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer no-padding">
                                    <ul class="nav nav-stacked">
                                        <li ng-if="class.is_active === 1"><a href="#">Status: <span class="pull-right badge bg-green">Active</span></a></li>
                                        <li ng-if="class.is_active === 0"><a href="#">Status: <span class="pull-right badge bg-yellow">Inactive</span></a></li>
                                        <li ng-if="!class.email_address"><a href="#">Email address: <span class="pull-right badge ">No Email</span></a></li>
                                        <li ng-if="class.email_address"><a href="#">Email address: <span class="pull-right badge ">@{{class.email_address}}</span></a></li>
                                        <li><a href="#">Birthdate: <span class="pull-right badge ">@{{class.birthdate}}</span></a></li>
                                        <li><a href="#">Gender: <span class="pull-right badge ">@{{class.gender}}</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
