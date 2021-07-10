@extends('account-layout')

@section('title', 'Settings')

@section('content')

    @include('admin.admin_navbar')

    <div class="content-wrapper">
        <section class="content-header">
            <h1><i class="fa fa-gear"></i> Settings </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Settings</li>
            </ol>
        </section>

        <div class="container">
            <br>
            <br>
            <div class="row">
                <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
                    <ul class="control-sidebar-menu  ">
                        <li style="margin-left:20px;margin-bottom:30px;">
                            <div class="row">
                                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                    <a class="text-black">
                                        <i class="menu-icon fa fa-flag bg-green"></i>  
                                        <div class="menu-info">
                                            <h4 class="control-sidebar-subheading"><b>Semester</b></h4>
                                            <p>Set current semester</p>
                                        </div>
                                    </a>      
                                </div>
                                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                    <a href="/admin/settings/set_semester" class="pull-right"><i class="fa fa-edit"></i> Edit</a>   
                                </div>
                            </div>
                        </li>
                        <hr style="border-top: 2px solid #d5e0d7;">
                        <li style="margin-left:20px;">
                            <div class="row">
                                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                    <a class="text-black">
                                       <i class="menu-icon fa fa-calendar bg-purple"></i>  
                                        <div class="menu-info">
                                            <h4 class="control-sidebar-subheading"><b>School Year</b></h4>
                                            <p>Set current school year</p>
                                        </div>
                                    </a>      
                                </div>
                                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                    <a href="/admin/settings/set_school_year" class="pull-right"><i class="fa fa-edit"></i> Edit</a>   
                                </div>
                            </div>
                        </li>
                        </li>
                        <hr style="border-top: 2px solid #d5e0d7;">
                        <!-- <li style="margin-left:20px;">
                            <div class="row">
                                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                    <a class="text-black">
                                       <i class="menu-icon fa fa-list-ul bg-orange"></i>  
                                        <div class="menu-info">
                                            <h4 class="control-sidebar-subheading"><b>Curriculum</b></h4>
                                            <p>Activate current curriculum</p>
                                        </div>
                                    </a>      
                                </div>
                                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                    <a href="/admin/settings/set_curriculum" class="pull-right"><i class="fa fa-edit"></i> Edit</a>   
                                </div>
                            </div>
                        </li> -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection