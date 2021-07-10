@extends('account-layout')

@section('title')
   {{$subject['description']}} | Class List
@endsection

@section('content')

    @include('student.subjects.student_subject_navbar')

    <script type="text/javascript" src="/js/services/shared/account.class.list.service.js"></script>
    <script type="text/javascript" src="/js/controllers/student/student.class.list.controller.js"></script>

    <link rel="stylesheet" href="/css/shared/classes.css">

    <div class="content-wrapper">
        
        <section class="content-header">
            <h1>{{$subject['description']}}  <small>Class List</small></h1>
            <ol class="breadcrumb">
            <li><a href="/student"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/student/subject/{{$id}}/posts"><i class="fa fa-book"></i> {{$subject['description']}}</a></li>
            <li class="active">Class List</li>
            </ol>
        </section>

        <section class="content" ng-controller="studentClassListController">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
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
