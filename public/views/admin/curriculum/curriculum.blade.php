@extends('account-layout')

@section('title', 'Curriculum')

@section('content')

    @include('admin.admin_navbar')


    <script type="text/javascript" src="/js/services/admin/admin.courses.service.js"></script>
    <script type="text/javascript" src="/js/services/admin/admin.subjects.service.js"></script>
    
    <script type="text/javascript" src="/js/services/admin/admin.curriculum.service.js"></script>
    <script type="text/javascript" src="/js/controllers/admin/admin.curriculum.controller.js"></script>

    <script type="text/javascript" src="/js/services/admin/admin.semesters.service.js"></script>
    <script type="text/javascript" src="/js/services/admin/admin.school.year.service.js"></script>

    <link rel="stylesheet" href="/css/admin/curriculum.css">   

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Curriculum</h1>
            <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Curriculum</li>
            </ol>
        </section>

        <div class="container">
            <br>

            <div class="row">   

                <!-- #start Curriculum Section -->
                <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11" ng-controller="adminCurriculumController">
                    <!-- #start Curriculum settings section -->
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            @include('admin.curriculum.partials.curriculum_settings_panel')
                            <br>
                            @include('admin.curriculum.partials.curriculum_subject_list_panel')
                        </div>
                    </div>
                    <!-- #end -->
                </div>
                <!-- #end -->
            </div>
        </div>
    </div>
@endsection
