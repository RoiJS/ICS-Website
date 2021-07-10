@extends('account-layout')

@section('title', 'Semester')

@section('content')

    @include('admin.admin_navbar')

    <script src="/js/services/admin/admin.semesters.service.js"></script>
    <script src="/js/controllers/admin/admin.semesters.controller.js"></script>

    <div class="content-wrapper" ng-controller="adminSemestersController">
        <section class="content-header">
            <h1><i class="fa fa-flag"></i> Semester </h1>
            <ol class="breadcrumb">
                <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="/admin/settings">Settings</a></li>
                <li class="active">Semester</li>
            </ol>
        </section>

        <section>
            <br>
            <div class="container"> 
                <div class="row">
                    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                        <!-- <div class="form-group">
                            <label for="lastname">Select semester:</label>
                            <select class="form-control" ng-options="semester.semester for semester in semesters track by semester.semester_id" ng-model="current_semester"></select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Set</button>
                        </div> -->
                        @include('admin.semesters.semesters_panel')
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection