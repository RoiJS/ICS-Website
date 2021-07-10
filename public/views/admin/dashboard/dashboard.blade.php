@extends('account-layout')

@section('title', 'Dashboard')

@section('content')

    @include('admin.admin_navbar')
    
        
    <script type="text/javascript" src="/js/services/admin/admin.school.year.service.js"></script>
    <script type="text/javascript" src="/js/services/admin/admin.semesters.service.js"></script>

    <script type="text/javascript" src="/js/controllers/admin/admin.dashboard.controller.js"></script>

    <div class="content-wrapper" ng-controller="adminDashboardController">
        <section class="content-header">
            <h1>
            Dashboard
            <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
            </ol>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="box box-success">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <b><i class="fa fa-flag"></i> Current Semester</b> :  @{{current_semester}}
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <b><i class="fa fa-calendar"></i> Current School year</b> : @{{current_school_year}}
                                </div>                  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>@{{status[0]}}</h3>
                            <p>Total Classes</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-folder"></i>
                        </div>
                        <a href="/admin/classes" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>@{{status[1]}}</h3>
                            <p>Total Students</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person"></i>
                        </div>
                        <a href="/admin/students" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>@{{status[2]}}</h3>
                            <p>Total Faculty Members</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-briefcase"></i>
                        </div>
                        <a href="/admin/faculty" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            <!-- ./col -->
            </div>
            <!-- /.row -->

            <!-- Main row -->
            <div class="row">
                <div class="col-md-6">
                    <!-- #Partial view for activitylog -->
                    @include('partials.activity_log.activity_log')
                </div>
            </div>
        </section>
    </div>
@endsection
