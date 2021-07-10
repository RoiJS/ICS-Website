@extends('account-layout')

@section('title', 'Profile Picture')

@section('content')

    @include('student.student_navbar')

    <script type="text/javascript" src="/js/services/student/student.profile.service.js"></script>
    <script type="text/javascript" src="/js/controllers/student/student.profile.controller.js"></script>

    <link rel="stylesheet" href="/css/shared/profile.css">

    <div class="content-wrapper" ng-controller="studentProfileController">
        <section class="content-header">
            <h1><i class="fa fa-user"></i> Profile Picture</h1>
            <ol class="breadcrumb">
                <li><a href="/student"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="/student/profile">Profile</a></li>
                <li class="active">Profile Picture</li>
            </ol>
        </section>

        <section>
            <br>
            <div class="container"> 
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="panel box box-success" style="margin-bottom:0px;">
                            <div class="box-header with-border">
                                <h4 class="box-title">
                                   Profile Picture
                                </h4>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse in">
                                <div class="box-body">
                                    <div class="alert alert-danger alert-dismissible fade in error-preview hidden" role="alert">
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <center>
                                                    <i class="fa fa-warning fa-2x"></i>
                                                </center>
                                            </div>
                                            <div class="col-lg-10">
                                                <p class="display-error-text"></p>		
                                            </div>
                                        </div>
                                    </div>
                                    <form ng-submit="saveNewProfilePic()">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Select Image:</label>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="user-image-container user-image">
                                                            <img class="profile_pic preview_image" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <input type="file" class="form-control" file-model="profile.image" onchange="angular.element(this).scope().imageFileHelper.viewImage(this, true)" accept="image/*">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <button type="submit" class="btn btn-success"><i class="fa fa-upload"> </i> Change</button>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <br>
                                                        <small><b>Notes: </b></small><br>
                                                        <small><b>*</b> Only <i>.jpeg, .png, .jpg &amp; .gif are supported.</i></small><br>
                                                        <small><b>*</b> Image dimension must be portait oriented. </i></small><br>
                                                        <small><b>*</b> Image width and height must be between 250 and 500 pixels </i></small><br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection