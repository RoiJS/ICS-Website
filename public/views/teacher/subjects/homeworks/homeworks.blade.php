@extends('account-layout')

@section('title')
   {{$subject['description']}} | Homeworks
@endsection

@section('content')

    @include('teacher.subjects.teacher_subject_navbar')
    
    <script src="/js/services/shared/account.homeworks.service.js"></script>
    <script src="/js/controllers/teacher/teacher.homeworks.controller.js"></script>

    <link rel="stylesheet" href="/css/shared/homeworks.css">

    <div class="content-wrapper" ng-controller="teacherHomeworksController">
        <section class="content-header">
            <div class="content-header">
                <ol class="breadcrumb">
                    <li><a href="/teacher"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="/teacher/subject/{{$id}}/posts"><i class="fa fa-book"></i> {{$subject['description']}} </a></li>
                    <li class="active">Homeworks</li>
                </ol>
                <h1>{{$subject['description']}}   <small>Homeworks</small></h1>
            </div>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <a href="homeworks/add_homework" class="btn btn-success">Add Homeworks <i class="fa fa-plus"></i></a>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    
                    <div class="row" ng-show="!status.homeworks_loading && !status.has_homeworks">
                        <div class="col-md-12">
                            <div class="alert alert-warning alert-dismissible">
                                <h4><i class="icon fa fa-warning"></i> Empty homeworks list.</h4>
                                Create homeworks by clicking "Add Homework" button above.
                            </div>
                        </div>
                    </div>
                    <div class="row" ng-show="status.homeworks_loading">
                        <div class="col-md-12">
                            <i class="fa fa-refresh fa-spin"></i> Loading Homeworks. Please wait&hellip;
                        </div>
                    </div>
                    <div class="row" ng-show="!status.homeworks_loading && status.has_homeworks">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">Homeworks list</h3>
                                </div>
                                <div class="box-body">
                                    <table ng-table="tableHomeworksList" show-filter="true" class="table table-hover table-homework-list">
                                        <tr ng-repeat="homework in $data" class="homework-id-@{{homework.homework_id}}">
                                            <td class="homework-title" data-homework-title="@{{homework.title}}" title="'Title'" filter="{ title: 'text' }" sortable="'title'">
                                                <a href="homeworks/@{{homework.homework_id}}">@{{homework.show_title}}</a>
                                            </td>
                                            <td title="'Due date'" filter="{ show_due_at: 'text' }" sortable="'show_due_at'">@{{homework.show_due_at}}</td>
                                            <td title="'Send status'" sortable="'send_status'">
                                                <div class="progress progress-xs">
                                                    <div class="send-status-progress-bar progress-bar @{{homework.send_status == 1 ? 'progress-bar-primary' : 'progress-bar-danger'}}" role="progressbar" aria-valuenow="100" aria-valuemin="100" aria-valuemax="100"></div>
                                                </div>
                                            </td>
                                            <td title="'Date sent'" filter="{ show_send_at: 'text' }" sortable="'show_send_at'">@{{homework.show_send_at}}</td>
                                            <td class="student-submitted-column" title="'Student submitted'" sortable="'no_of_students_submitted'"><center>@{{homework.no_of_students_submitted}}</center></td>
                                            <td class="submittion-percentage-column" title="'Submittion Percentage'" sortable="'no_of_students_submitted_percentage'">
                                                <center><span class="badge bg-green">@{{homework.no_of_students_submitted_percentage}}</span></center>
                                            </td>
                                            <td class="homework-options">
                                                <button title="Unsend homework" type="button" class="btn btn-default" ng-show="homework.send_status == 1" ng-click="unsendHomework(homework.homework_id)"><i class="fa fa-reply"></i></button>
                                                <button title="Send homework" type="button" class="btn btn-primary" ng-show="homework.send_status == 0" ng-click="sendHomework(homework.homework_id)"><i class="fa fa-mail-forward"></i></button>
                                                <a title="Edit homework" href="/teacher/subject/{{$id}}/homeworks/edit_homework/@{{homework.homework_id}}" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                                <button title="Remove homework" type="button" class="btn btn-danger" ng-click="removeHomework(homework.homework_id)"><i class="fa fa-trash"></i></button>
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
