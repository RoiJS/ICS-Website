@extends('account-layout')

@section('title', 'Accounts Approval')

@section('content')

    @include('admin.admin_navbar')

    <script type="text/javascript" src="/js/controllers/admin/admin.accounts.approval.controller.js"></script>
    <script type="text/javascript" src="/js/services/admin/admin.accounts.approval.service.js"></script>

    <div class="content-wrapper">

        <section class="content-header">
            <h1>Accounts Approval List</h1>
            <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Accounts Approval</li>
            </ol>
        </section>

        <section class="container" ng-controller="adminAccountsApprovalController">
            <br>
            <div class="row" ng-if="status.data_loading">
                <div class="col-md-12">
                    <i class="fa fa-refresh fa-spin"></i> <span> Loading&hellip; </span>
                </div>
            </div>
            <br>
            <div class="row" ng-if="!status.data_loading && !status.has_data">
                <div class="col-md-12">
                    <div class="callout callout-info">
                        <h4>No accounts waiting for approval.</h4>
                    </div>
                </div>
            </div>
            <div class="row" ng-if="!status.data_loading && status.has_data">
                <div class="col-md-12">
                    <div class="box box-success">
                        <div class="box-body">
                            <table id="table-students" class="table table-bordered table-striped table-hover" >
                                <thead>
                                    <tr>
                                        <th>School ID</th>
                                        <th>Student name</th>
                                        <th>Gender</th>
                                        <th>Birthdate</th>
                                        <th>Email Address</th>
                                        <th>Username</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="student in accounts_approval" >
                                        <td>@{{student.student_id}}</td>
                                        <td>@{{userHelper.getPersonFullname(student)}}</td>
                                        <td>@{{student.gender}}</td>
                                        <td>@{{datetimeHelper.parseDate(student.birthdate)}}</td>
                                        <td>@{{student.email_address}}</td>
                                        <td>@{{student.username}}</td>
                                        <td><button ng-click="approveAccount($index)" class="btn btn-primary"><i class="fa fa-thumbs-o-up"></i> Approve</button></td>
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
