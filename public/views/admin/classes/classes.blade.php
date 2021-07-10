@extends('account-layout')

@section('title', 'Classes')

@section('content')

    @include('admin.admin_navbar')

    <script type="text/javascript" src="/js/services/admin/admin.classes.service.js"></script>
    <script type="text/javascript" src="/js/services/admin/admin.courses.service.js"></script>
    <script type="text/javascript" src="/js/services/admin/admin.curriculum.service.js"></script>
    <script type="text/javascript" src="/js/services/admin/admin.subjects.service.js"></script>
    <script type="text/javascript" src="/js/services/admin/admin.semesters.service.js"></script>
    <script type="text/javascript" src="/js/services/admin/admin.school.year.service.js"></script>
    <script type="text/javascript" src="/js/services/admin/admin.load.service.js"></script>
    <script type="text/javascript" src="/js/services/admin/admin.students.service.js"></script>

    <script type="text/javascript" src="/js/controllers/admin/admin.classes.controller.js"></script>

    <link rel="stylesheet" href="/css/admin/classes.css">   

    <div class="content-wrapper" ng-controller="adminClassesController">
        <section class="content-header">
            <h1> Classes </h1>
            <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Classes</li>
            </ol>
        </section>

        <section class="content">

            <!-- #start Classes Options Panel -->
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    @include('admin.classes.partials.class_filter_panel')
                </div>
            </div>
            <!-- #end -->

            <!-- #start Page Loading Section -->
            <div class="row" ng-if="status.details_loading">
                <div class="col-md-12">
                    <i class="fa fa-refresh fa-spin"></i> <span> Loading subject&hellip; </span>
                </div>
            </div>
            <!-- #end -->

            <!-- #start Initial Message Section -->
            <div class="row" ng-if="!status.details_loading && !status.is_class_detail_set">
                <div class="col-md-12">
                    <div class="callout callout-info">
                        <h4>No class details have been set yet.</h4>
                        <p>Display class details by setting the following fields above.</p>
                    </div>
                </div>
            </div>
            <!-- #end -->

            <!-- #start Empty Class Details Message Section -->
            <div class="row" ng-if="!class_details && !status.details_loading">
                <div class="col-md-12">
                    <div class="callout callout-info">
                        <h4>Subject has not been assigned to any faculty</h4>
                        <p>Go to 'Faculty > Faculty Load' page to assigned this subject to a teacher.</p>
                    </div>
                </div>
            </div>
            <!-- #end -->
            
            <!-- # Class Details Panel -->
            <div id="details-panel" class="row" ng-show="class_details && !status.details_loading"> 
                <div class="col-md-12">

                    <!-- #start Class Faculty Information Panel -->
                    <div class="row" ng-show="!status.details_loading && status.is_class_detail_set">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            @include('admin.classes.partials.faculty_information_panel')
                        </div>
                    </div>
                    <!-- #end -->

                    <!-- #start Student List Information Panel -->
                    <div class="row" ng-show="!status.details_loading && status.is_class_detail_set && class_details.is_active">

                        <!-- #start Overall Student List Information List Section -->
                        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                            @include('admin.classes.partials.overall_student_list')
                        </div>
                        <!-- #end -->

                        <!-- #start Student Class Information List Section-->
                        <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                            @include('admin.classes.partials.official_class_list')
                        </div>
                        <!-- #end -->

                    </div>  
                </div>
            </div>

             <!-- #start Deactivated faculty status section -->
             <div class="row" ng-if="status.is_class_detail_set && !class_details.is_active && !status.details_loading && class_details">
                <div class="col-md-12">
                    <div class="callout callout-warning">
                        <h4>Deactivated faculty</h4>
                        <p>Teacher on this class is currently inactive. Kindly activate its status in order to update its class list. </p>
                    </div>
                </div>
            </div>
            <!-- #end -->
            
        </section>
    </div>
@endsection
