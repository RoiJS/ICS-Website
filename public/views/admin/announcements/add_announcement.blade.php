@extends('account-layout')

@section('title', 'New Announcements')

@section('content')

    @include('admin.admin_navbar')
    
    <script type="text/javascript" src="/js/services/admin/admin.announcements.service.js"></script>
    <script type="text/javascript" src="/js/controllers/admin/admin.add.announcements.controller.js"></script>
    
    <link rel="stylesheet" href="/css/admin/announcements.css">

    <div class="content-wrapper" ng-controller="adminAddAnnouncmentsController">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                New Announcement
            </h1>
            <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/admin/announcements">Announcements</a></li>
            <li class="active">New Announcement</li>
            </ol>
        </section>

        <section class="content">  
            <form name="announcementForm" ng-submit="submitNewAnnouncement()" ng-model-options="{updateOn : 'submit'}">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="pull-right">
                            <button type="submit" class="btn btn-success">
                            <i class="fa fa-save" ></i>
                            Submit</button>
                            <a href="/admin/announcements" class="btn btn-danger">
                            <i class="fa fa-ban"></i>
                            Cancel</a>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-xs-4">
                        <div class="box box-success">
                            <div class="box-body with-border">
                                <h3 class="box-title">Image:</h3>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
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
                                        <div class="row">
                                            <div class="col-md-12">
                                                <center>
                                                    <img class="img-responsive img-thumbnail announcement-thumbnail preview_image" />
                                                </center>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <input type="file" class="form-control" file-model="announcement.image" ng-model-options="{updateOn : '$inherit'}" onchange="angular.element(this).scope().imageFileHelper.viewImage(this)" accept="image/*">
                                            </div>
                                            <div class="col-md-4">
                                                <button type="button" class="btn btn-danger btn-block" ng-click="imageFileHelper.resetImage()"><i class="fa fa-eraser"></i> Clear</button>
                                            </div>
                                            <div class="col-md-12">
                                                <br>
                                                <small><b>Notes: </b></small><br>
                                                <small><b>*</b> Only <i>.jpeg, .png, .jpg &amp; .gif are supported.</i></small><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>  
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <h3 class="box-title">Announcement Form</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="title">Title:</label>
                                    <div ng-show="announcementForm.announcement_title.$invalid && announcementForm.announcement_title.$dirty">
                                        <span class="text-red" ng-show="announcementForm.announcement_title.$error.required">
                                            <i class="fa fa-warning"></i> Please enter announcement title.
                                        </span>
                                    </div>
                                    <input type="text" name="announcement_title" class="form-control" id="title" placeholder="Enter title&hellip;" ng-model="announcement.title" ng-model-options="{updateOn : '$inherit'}" required>
                                    
                                </div>
                                <div class="form-group">
                                    <label>Description:</label>
                                    <div ng-show="announcementForm.announcement_description.$invalid && announcementForm.announcement_description.$dirty">
                                        <span class="text-red">
                                            <i class="fa fa-warning"></i> Please enter announcement description.
                                        </span>
                                    </div>
                                    <trix-editor name="announcement_description" angular-trix ng-model="announcement.description" ng-model-options="{updateOn : '$inherit'}" class="text-editor-container" required></trix-editor>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
                      
            </form>
        </section>
    </div>
@endsection
