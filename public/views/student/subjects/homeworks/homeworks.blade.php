@extends('account-layout')

@section('title')
   {{$subject['description']}} | Homeworks
@endsection

@section('content')

    @include('student.subjects.student_subject_navbar')

    <script src="/js/services/shared/account.homeworks.service.js"></script>
    <script src="/js/controllers/student/student.homeworks.controller.js"></script>

    <div class="content-wrapper" ng-controller="studentHomeworksController">

        <section class="content-header">
            <h1>{{$subject['description']}}  <small>Homeworks</small></h1>
            <ol class="breadcrumb">
            <li><a href="/student"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/student/subject/{{$subject['description']}}/posts"><i class="fa fa-book"></i> {{$subject['description']}}</a></li>
            <li class="active">Homeworks</li>
            </ol>
        </section>

        <section class="content">
            <div class="row" ng-show="!status.homeworks_loading && !status.has_homeworks">
                <div class="col-md-12">
                    <div class="alert alert-warning alert-dismissible">
                        <h4><i class="icon fa fa-warning"></i> Empty homeworks list.</h4>
                    </div>
                </div>
            </div>
            <div class="row" ng-show="status.homeworks_loading">
                <div class="col-md-12">
                    <i class="fa fa-refresh fa-spin"></i> Loading homeworks. Please wait&hellip;
                </div>
            </div>
            <div class="row" ng-show="!status.homeworks_loading && status.has_homeworks">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Homeworks list</h3>
                        </div>
                        <div class="box-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Due date</th>
                                        <th>Submit status</th>
                                        <th>Date submitted</th>
                                        <th>Approved status</th>
                                        <th>Date approved</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="hw in homeworks">
                                        <td><b><a href="homeworks/@{{hw.homework_id}}">@{{systemHelper.trimString(hw.title, 25)}}</a></b></td>
                                        <td>@{{datetimeHelper.parseDate(hw.due_at)}}</td>
                                        <td>
                                            <div class="progress progress-xs ">
                                                <div class="progress-bar @{{hw.is_submitted == 1 ? 'progress-bar-primary' : 'progress-bar-danger'}}" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                                </div>
                                            </div>
                                        </td>
                                        <td>@{{datetimeHelper.parseDate(hw.date_submitted)}}</td>
                                        <td>
                                            <div class="progress progress-xs">
                                                <div class="progress-bar @{{hw.approved_status == 1 ? 'progress-bar-primary' : 'progress-bar-danger'}}" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                                </div>
                                            </div>
                                        </td>
                                        <td>@{{datetimeHelper.parseDate(hw.date_approved)}}</td>
                                    </tr>
                                </tbody>
                            </table>        
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
