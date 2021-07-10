@extends('account-layout')

@section('title', 'Courses')

@section('content')

    @include('admin.admin_navbar')
    
    <script type="text/javascript" src="/js/services/admin/admin.courses.service.js"></script>
    <script type="text/javascript" src="/js/controllers/admin/admin.courses.controller.js"></script>
    <link rel="stylesheet" href="/css/admin/course.css">
    
    <div class="content-wrapper" ng-controller="adminCoursesController">
        <section class="content-header">
            <h1>Courses</h1>
            <ol class="breadcrumb">
                <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Courses</li>
            </ol>
        </section>
        <div class="container">
            <br>
            <!-- #starts Loading status section -->
            <div class="row" ng-show="status.data_loading">
                <div class="col-md-12">
                    <i class="fa fa-refresh fa-spin"></i> <span> Loading&hellip; </span>
                </div>
            </div>
            <!-- #end -->

            <!-- #start Course Details Section  -->
            <div class="row" ng-show="!status.data_loading">

                <!-- #start Create new course form  -->
                <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
                    @include('admin.courses.partials.create_course_form')
                </div>
                <!-- #end -->

                <!-- #start Course list information section -->
                <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
                    @include('admin.courses.partials.course_list')                    
                </div>
                <!-- #end -->
            </div>
            <!-- #end -->
        </div>
    </div>
@endsection
