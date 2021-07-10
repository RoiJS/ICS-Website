@extends('account-layout')

@section('title', 'Students')

@section('content')

    @include('admin.admin_navbar')

    <script type="text/javascript" src="/js/services/admin/admin.students.service.js"></script>
    <script type="text/javascript" src="/js/controllers/admin/admin.students.controller.js"></script>

    <link rel="stylesheet" href="/css/admin/students.css"> 

    <div class="content-wrapper">

        <section class="content-header">
            <h1>Students list </h1>
            <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Students List</li>
            </ol>
        </section>

        <section class="container" ng-controller="adminStudentsController">
            <br>
            <div class="row">   
                <div class="col-md-12">
                    <a type="button" class="btn btn-success" href="/admin/students/add_student">Add Student <i class="fa fa-plus"></i></a>
                </div>
            </div>
            <br>
            <div class="row" ng-hide="!status.data_loading">
                <div class="col-md-12">
                    <i class="fa fa-refresh fa-spin"></i> <span> Loading&hellip; </span>
                </div>
            </div>
            <br>
            <div class="row" ng-hide="status.data_loading">
                <div class="col-md-11">
                    <div class="box box-success">
                        <div class="box-body">
                            <table ng-table="tableParams" class="table table-bordered table-hover table-student-list" show-filter="true">
                                <tr ng-repeat="student in $data" ng-class="{'deactivate-status': student.is_active === 0}">
                                    <td title="'Image'" >
                                        <div class="list-student-photo">
                                            <img ng-src="@{{student.image_source}}" ng-title="@{{student.fullname}}">
                                        </div>
                                    </td>
                                    <td title="'Student Id'" filter="{ student_id: 'text'}" sortable="'student_id'">
                                        @{{student.student_id}}
                                    </td>
                                    <td title="'Student Name'" filter="{ fullname: 'text'}" sortable="'fullname'">
                                        @{{student.fullname}}
                                    </td>
                                    <td title="'Gender'" filter="{ gender: 'text'}" sortable="'gender'">
                                        @{{student.gender}}
                                    </td>
                                    <td title="'Email Address'" filter="{ email_address: 'text'}" sortable="'email_address'">
                                        @{{student.email_address}}
                                    </td>
                                    <td title="'Username'" filter="{ username: 'text'}" sortable="'username'">
                                        @{{student.username}}
                                    </td>
                                    <td title="'Status'" class="student-status">
                                        <span ng-if="student.is_active === 1" class="label label-success">Active</span>
                                        <span ng-if="student.is_active === 0" class="label label-warning">Inactive</span>
                                    </td>
                                    <td title="'Action'">
                                        <a href="/admin/students/@{{student.stud_id}}" class="btn btn-success">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
