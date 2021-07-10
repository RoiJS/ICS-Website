@extends('account-layout')

@section('title', 'Faculty')

@section('content')

    @include('admin.admin_navbar')

    <script type="text/javascript" src="/js/services/admin/admin.faculty.service.js"></script>
    <script type="text/javascript" src="/js/controllers/admin/admin.faculty.controller.js"></script>

    <link rel="stylesheet" href="/css/admin/faculty.css">

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
            Faculty List
            </h1>
            <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Faculty List</li>
            </ol>
        </section>

        <section class="container" ng-controller="adminFacultyController">
            <br>
            <div class="row">
                <div class="col-md-12">
                    <a type="button" class="btn btn-success" href="/admin/faculty/add_faculty">Add Faculty <i class="fa fa-plus"></i></a>
                </div>
            </div>
            <br>
            <div class="row" ng-if="status.data_loading">
                <div class="col-md-12">
                    <i class="fa fa-refresh fa-spin"></i> <span> Loading&hellip; </span>
                </div>
            </div>
            <br>
            <div class="row" ng-if="!status.data_loading">
                <div class="col-md-11">
                    <div class="box box-success">
                        <div class="box-body">
                            <table ng-table="tableParams" class="table table-bordered table-hover table-faculty-list" show-filter="true">
                                <tr ng-repeat="faculty in $data">
                                    <td title="'Image'" >
                                        <div class="list-faculty-photo">
                                            <img ng-src="@{{faculty.image_source}}">
                                        </div>
                                    </td>
                                    <td title="'Faculty Id'" filter="{ faculty_id: 'text'}" sortable="'faculty_id'">
                                        @{{faculty.faculty_id}}
                                    </td>
                                    <td title="'Full name'" filter="{ fullname: 'text'}" sortable="'fullname'">
                                        @{{faculty.fullname}}
                                    </td>
                                    <td title="'Gender'" filter="{ gender: 'text'}" sortable="'gender'">
                                        @{{faculty.gender}}
                                    </td>
                                    <td title="'Academic rank'" filter="{ academic_rank: 'text'}" sortable="'academic_rank'">
                                        @{{faculty.academic_rank}}
                                    </td>
                                    <td title="'Designation'" filter="{ academic_rank: 'text'}" sortable="'academic_rank'">
                                        @{{faculty.designation}}
                                    </td>
                                    <td title="'Status'" class="student-status">
                                        <span ng-if="faculty.is_active === 1" class="label label-success">Active</span>
                                        <span ng-if="faculty.is_active === 0" class="label label-warning">Inactive</span>
                                    </td>
                                    <td title="'Action'"><a class="btn btn-success" ng-href="/admin/faculty/@{{faculty.teacher_id}}"><i class="fa fa-eye"></i> View</a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
