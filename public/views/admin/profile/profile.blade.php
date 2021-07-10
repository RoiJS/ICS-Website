@extends('account-layout')

@section('title', 'Profile')

@section('content')

    @include('admin.admin_navbar')

    <div class="content-wrapper">
        <section class="content-header">
            <h1><i class="fa fa-user"></i> Profile </h1>
            <ol class="breadcrumb">
                <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Profile</li>
            </ol>
        </section>

        <div class="container" >
            <br>
            <div class="row">
                <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
                    <ul class="control-sidebar-menu  ">
                        <li style="margin-left:20px;margin-bottom:30px;">
                            <div class="row">
                                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                    <a class="text-black">
                                        <i class="menu-icon fa fa-camera bg-blue"></i>  
                                        <div class="menu-info">
                                            <h4 class="control-sidebar-subheading"><b>Profile Picture</b></h4>
                                            <p>Udpate account profile picture</p>
                                        </div>
                                    </a>      
                                </div>
                                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                    <a href="/admin/profile/profile_picture" class="pull-right"><i class="fa fa-edit"></i> Edit</a>   
                                </div>
                            </div>
                        </li>
                        <hr style="border-top: 2px solid #d5e0d7;">
                        <li style="margin-left:20px;margin-bottom:30px;">
                            <div class="row">
                                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                    <a class="text-black">
                                        <i class="menu-icon fa fa-user bg-green"></i>  
                                        <div class="menu-info">
                                            <h4 class="control-sidebar-subheading"><b>Personal Information</b></h4>
                                            <p>Udpate user personal information</p>
                                        </div>
                                    </a>      
                                </div>
                                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                    <a href="/admin/profile/personal_information" class="pull-right"><i class="fa fa-edit"></i> Edit</a>   
                                </div>
                            </div>
                        </li>
                        <hr style="border-top: 2px solid #d5e0d7;">
                        <li style="margin-left:20px;">
                            <div class="row">
                                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                    <a class="text-black">
                                       <i class="menu-icon fa fa-key bg-purple"></i>  
                                        <div class="menu-info">
                                            <h4 class="control-sidebar-subheading"><b>Account information</b></h4>
                                            <p>Update user account information</p>
                                        </div>
                                    </a>      
                                </div>
                                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                    <a href="/admin/profile/account_information" class="pull-right"><i class="fa fa-edit"></i> Edit</a>   
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
@endsection