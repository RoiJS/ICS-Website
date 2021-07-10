@extends('account-layout')

@section('title', 'Dashboard')

@section('content')

    @include('teacher.teacher_navbar')

    <script type="text/javascript" src="/js/services/teacher/teacher.dashboard.service.js"></script>
    <script type="text/javascript" src="/js/controllers/teacher/teacher.dashboard.controller.js"></script>

    <div class="content-wrapper" ng-controller="teacherDashboardController">

        <section class="content-header">
            <h1>Dashboard</h1>
            <ol class="breadcrumb">
            <li><a href="/teacher"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
            </ol>
        </section>

        <section class="content">
        
            <div class="row">
                
                <!-- #start Subject List Section -->
                @include("teacher.dashboard.partials.subject_list_section")
                <!-- #end -->

                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <!-- #start Notification panel section -->
                            @include('partials.notifications.notifications')
                            <!-- #end -->
                        </div>
                    </div>
                    
                    <!-- Main row -->
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <!-- #start Recent activities panel section -->
                            @include('partials.activity_log.activity_log')
                            <!-- #end -->
                        </div>
                    </div>
                    <!-- /.row (main row) -->        
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection
