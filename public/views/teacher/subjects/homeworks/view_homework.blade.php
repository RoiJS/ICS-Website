@extends('account-layout')

@section('title')
   {{$subject['description']}} | Homeworks
@endsection

@section('content')

    @include('teacher.subjects.teacher_subject_navbar')

    <script src="/js/services/shared/account.homeworks.service.js"></script>
    <script src="/js/controllers/teacher/teacher.view.homeworks.controller.js"></script>

    <link rel="stylesheet" href="/css/shared/homeworks.css">

    <script>
        // Get current homework id
        var homework_id = {!! json_encode($homework->homework_id); !!}
    </script>

    <div class="content-wrapper" ng-controller="teacherViewHomeworksController">
        <section class="content-header">
            <h1>{{$subject['description']}}  <small>Homeworks</small></h1>
            <ol class="breadcrumb">
            <li><a href="/teacher"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/teacher/subject/{{$id}}/posts"><i class="fa fa-book"></i> {{$subject['description']}}</a></li>
            <li><a href="/teacher/subject/{{$id}}/homeworks">Homeworks</a></li>
            <li class="active">View Homework</li>
            </ol>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    
                    <div class="row" ng-show="!status.submitted_homeworks_loading && !status.has_submitted_homeworks">
                        <div class="col-md-12">
                            <div class="alert alert-warning alert-dismissible">
                                <h4><i class="icon fa fa-warning"></i> Empty student list.</h4>
                                No students are enrolled to this class.
                            </div>
                        </div>
                    </div>

                    <div class="row" ng-show="status.submitted_homeworks_loading">
                        <div class="col-md-12">
                            <i class="fa fa-refresh fa-spin"></i> Loading submitted homeworks. Please wait&hellip;
                        </div>
                    </div>

                    <div class="row" ng-show="!status.submitted_homeworks_loading && status.has_submitted_homeworks">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="box box-success view-homework-panel">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><b>{{$homework->title}}</b></h3>
                                    <div class="pull-right box-tools">
                                        <!-- button with a dropdown -->
                                        <div class="btn-group">
                                            <a href="#" class="btn-sm dropdown-toggle" data-toggle="dropdown">
                                            <i class="fa fa-caret-down"></i></a>
                                            <ul class="dropdown-menu pull-right submitted_homeworks_menu_options" role="menu">
                                                <li class="option"><a href="#" ng-class="{ 'disable': verifyIfAllApproved() }" ng-click="approveAllHomeworks(true)">Approved all</a></li>
                                                <li class="option"><a href="#" ng-class="{ 'disable': verifyIfAllDisapproved() }" ng-click="approveAllHomeworks(false)">Disapprove all</a></li>
                                                <li class="option"><a href="#" ng-class="{ 'disable': !verifyIfHaveFilesAvailable() }"  ng-click="downloadAllFiles()">Download all files</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <table ng-table="tableSubmittedHomeworks" class="table table-hover table-class-submitted-homeworks" show-filter="true">
                                        <tr ng-repeat="homework in $data">
                                            <td title="'Student name'" filter="{ student_name: 'text' }" sortable="'student_name'">@{{homework.student_name}}</td>
                                            <td title="'File'" filter="{ original_file_name: 'text' }" sortable="'original_file_name'"><a ng-href="@{{homework.file}}">@{{homework.original_file_name}}</a></td>
                                            <td title="'Date submitted'" filter="{ date_submitted: 'text' }" sortable="'date_submitted'">@{{homework.date_submitted}}</td>
                                            <td title="'Submit status'" sortable="'is_submitted'">
                                                <div class="progress progress-xs">
                                                    <div class="submit-status-progress-bar progress-bar @{{homework.is_submitted == 1 ? 'progress-bar-primary' : 'progress-bar-danger'}}" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </td>
                                            <td title="'Approved status'" >
                                                <div class="form-group">
                                                    <label>
                                                        <input type="checkbox" ng-model="homework.approved_status" ng-click="approvedHomework($index)"> 
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
