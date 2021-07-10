@extends('account-layout')

@section('title', 'Subjects')

@section('content')

    @include('admin.admin_navbar')

    <script type="text/javascript" src="/js/services/admin/admin.subjects.service.js"></script>
    <script type="text/javascript" src="/js/controllers/admin/admin.subjects.controller.js"></script>

    <link rel="stylesheet" href="/css/admin/subjects.css">

    <div class="content-wrapper" ng-controller="adminSubjectsController">
        <section class="content-header">
            <h1> Subject List </h1>
            <ol class="breadcrumb">
                <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Subjects</li>
            </ol>
        </section>

        <div class="container">
            <br>
            <!-- #start Loading status section -->
            <div class="row" ng-show="status.data_loading">
                <div class="col-md-12">
                    <i class="fa fa-refresh fa-spin"></i> <span>Loading&hellip;</span>
                </div>
            </div>
            <!-- #end -->

            <!-- #start Subject form and list section -->
            <div class="row" ng-show="!status.data_loading">

                <!-- #start Create subject form section -->
                <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
                    @include('admin.subjects.partials.create_subject_form')
                </div>
                <!-- #end -->

                <!-- #start Subject Information List section -->
                <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
                    @include('admin.subjects.partials.subject_list')
                </div>
                <!-- #end -->
                
            </div>
            <!-- #end -->
        </div>
    </div>
@endsection