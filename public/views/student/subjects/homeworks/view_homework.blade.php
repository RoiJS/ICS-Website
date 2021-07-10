@extends('account-layout')

@section('title')
   {{$subject['description']}} | Homeworks
@endsection

@section('content')

    @include('student.subjects.student_subject_navbar')

    <script src="/js/services/shared/account.homeworks.service.js"></script>
    <script src="/js/controllers/student/student.view.homeworks.controller.js"></script>

    <script>
        // Get current homework id
        var homework_id = {!! json_encode($homework->homework_id); !!};
    </script>

    <link rel="stylesheet" href="/css/shared/homeworks.css">

    <div class="content-wrapper" ng-controller="studentViewHomeworkController">
        <section class="content-header">
            <div class="content-header">
                <ol class="breadcrumb">
                    <li><a href="/student"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="/student/subject/{{$id}}/posts"><i class="fa fa-book"></i> {{$subject['description']}}</a></li>
                    <li><a href="/student/subject/{{$id}}/homeworks">Homeworks</a></li>
                    <li class="active">{{$homework->title}}</li>
                </ol>
                <h1>{{$homework->title}}  <small>Homeworks</small></h1>
            </div>
        </section>

        <section class="content">

            <!-- #start  Approved homework message section-->
            <div class="row" ng-show="homework.approved_status === 1 && file">
                <div class="col-md-12">
                    <div class="alert alert-info alert-dismissible">
                        <h4><i class="icon fa fa-info-circle"></i> Your lastest submittion was already approved by your instructor.</h4>
                    </div>
                </div>
            </div>
            <!-- #end -->

            <!-- #start Due homework message section -->
            <div class="row" ng-show="homework.is_due && !file">
                <div class="col-md-12">
                    <div class="alert alert-danger alert-dismissible">
                        <h4><i class="icon fa fa-warning"></i> Selected homework is already due. You cannot submit any file anymore.</h4>
                    </div>
                </div>
            </div>
            <!-- #end -->


            <div class="row">

                <!-- #start Homework details section  -->
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{$homework->title}}</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="1 col-sm-2 col-md-2 col-lg-2">
                                    <b>Due date:</b>
                                </div>
                                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                    @{{homework.due_date}} 
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="2 col-sm-2 col-md-2 col-lg-2">
                                    <b>Description:</b>
                                </div>
                                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                    <div ng-bind-html="homework.description"></div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer" ng-show="homework.files.length > 0">
                            <div class="row">
                                <div class="col-sm-3 col-md-3 col-lg-3">
                                    <b>Attached files:</b>
                                </div>
                                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                    <u>
                                        <li ng-repeat="file in homework.files"><a ng-href="@{{file.file_path}}">@{{file.original_file_name}}</a></li>
                                    </u>
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>
                <!-- #end -->

                <!-- #start Submit homework file section -->
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="panel box box-success" style="margin-bottom:0px;">
                        <div class="box-header with-border">
                            <h4 class="box-title">Submit file</h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse in">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label ng-show="file === null">Select file:</label>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div ng-show="file !== null" class="info-box file-item-section">
                                                    <span class="info-box-icon bg-green file-item-icon"><i class="fa fa-file"></i></span>
                                                    <div class="info-box-content file-item-content">
                                                        <span class="info-box-text file-item-name" title="@{{file.name}}">@{{file.name}}</span>
                                                        <span class="info-box-number file-item-size">@{{file.fileFormattedSize}} MB</span>
                                                    </div>
                                                </div>

                                                <center ng-show="file === null"><i class="fa fa-file-o fa-5x"></i></center>

                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row" ng-hide="homework.approved_status == 1 || homework.is_due">
                                            <div class="col-md-10">
                                                <input type="file" class="homework_file" onchange="angular.element(this).scope().selectFiles(this)" />
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row" ng-hide="homework.approved_status == 1 || homework.is_due">
                                            <div class="col-md-6">
                                                <button type="button" ng-click="submitFile()" class="btn btn-success btn-block"><i class="fa fa-upload"> </i> Upload</button>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="button" class="btn btn-warning btn-block" ng-click="clearFile()"><i class="fa fa-remove"> </i> Clear</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- #end -->
            </div>
        </section>
    </div>
@endsection
