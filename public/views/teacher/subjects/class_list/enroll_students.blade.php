@extends('account-layout')

@section('title')
   {{$subject['description']}} | Class List
@endsection

@section('content')

    @include('teacher.subjects.teacher_subject_navbar')

    <script type="text/javascript" src="/js/services/shared/account.class.list.service.js"></script>
    <script type="text/javascript" src="/js/controllers/teacher/teacher.enroll.students.controller.js"></script>

    <link rel="stylesheet" href="/css/shared/enroll.css">
    
    <div class="content-wrapper">
        <section class="content-header">
            <h1> {{$subject['description']}} <small>({{$subject['code']}})</small></h1>
            <ol class="breadcrumb">
            <li><a href="/teacher"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/teacher/subject/{{$id}}/posts"><i class="fa fa-book"></i> {{$subject['description']}}</a></li>
            <li class="active"><a href="/teacher/subject/{{$id}}/class">Official class List</a></li>
            </ol>
        </section>

        <section class="content" ng-controller="teacherEnrollStudentsController">
        <br>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="row" ng-show="status.students_loading">
                        <div class="col-md-12">
                            <i class="fa fa-refresh fa-spin"></i> Loading Student List. Please wait&hellip;
                        </div>
                    </div>
                    <div class="row" ng-show="!status.students_loading && !status.has_students">
                        <div class="col-md-12">
                            <div class="callout callout-warning">
                                <h4><i class="fa fa-warning"></i> Empty student list.</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row" ng-show="!status.students_loading">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">

                            <table ng-table="tableStudentList" class="table table-bordered table-hover" show-filter="true">
                                <tr ng-repeat="student in $data" ng-init="class_index = $index" class="student-information-panel">
                                    <td title="'Student Information'" filter="{ fullname: 'text' }" sortable="'fullname'">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="student-image-container">
                                                    <img class="student-image" ng-src="@{{student.image_source}}" />
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h3>
                                                            <i class="fa fa-user"></i> @{{student.fullname}}
                                                            <span ng-if="student.is_active === 1" class="badge bg-green">Active</span>
                                                            <span ng-if="student.is_active === 0" class="badge bg-yellow">Inactive</span>
                                                        </h3>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                    <b>Student No:</b> @{{student.student_id}}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                    <b>Email Address:</b> @{{student.email_address}}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                    <b>Birthdate:</b> @{{student.birthdate}}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                    <b>Gender:</b> @{{student.gender}}</b>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                    <button ng-if="student.is_active === 1 && !student.is_enrolled" ng-click="enrollStudent($index)" class="btn btn-success"><i class="fa fa-flag"></i> Enroll</button>
                                                    <button ng-click="unenrollStudent($index)" class="btn btn-warning" ng-if="student.is_enrolled"><i class="fa fa-flag-o"></i> Unenroll</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        
                </div>
            </div>
        </section>
    </div>
@endsection
