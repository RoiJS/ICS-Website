@extends('account-layout')

@section('title', 'School Year')

@section('content')

    @include('admin.admin_navbar')

    <script src="/js/controllers/admin/admin.school.year.controller.js"></script>
    <script src="/js/services/admin/admin.school.year.service.js"></script>
 
    <div class="content-wrapper" >
        <section class="content-header">
            <h1><i class="fa fa-calendar"></i> School Year </h1>
            <ol class="breadcrumb">
                <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="/admin/settings">Settings</a></li>
                <li class="active">School Year</li>
            </ol>
        </section>

        <section>
            <br>
            <div class="container" ng-controller="adminSchoolYearController"> 
                <div class="row">
                    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                        <!-- <div class="form-group">
                            <label for="lastname">Select school year:</label>
                            <select class="form-control" ng-model="current_school_year" ng-options="school_year.from_to for school_year in school_years track by school_year.school_year_id"></select>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-success" ng-click="setCurrentSchoolyear()"><i class="fa fa-check-square-o"></i> Set</button>
                        </div> -->

                        @include('admin.school_years.school_years_panel')
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection