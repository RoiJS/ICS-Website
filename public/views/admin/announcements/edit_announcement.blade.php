@extends('account-layout')

@section('title', 'Edit Announcement')

@section('content')

    @include('admin.admin_navbar')
    
    <script type="text/javascript" src="/js/services/admin/admin.announcements.service.js"></script>
    <script type="text/javascript" src="/js/controllers/admin/admin.edit.announcements.controller.js"></script>
    
    <link rel="stylesheet" href="/css/admin/announcements.css">

    <script>
        // Get current announcement id
        var announcement_id = {!! json_encode($announcement['id']); !!};
    </script>

    <div class="content-wrapper" ng-controller="adminEditAnnouncementsController">

        <section class="content-header">
            <h1>Edit Announcement</h1>
            <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/admin/announcements">Announcements</a></li>
            <li>Edit Announcement</li>
            <li class="active">@{{systemHelper.trimString(announcement.title, 20)}}</li>
            </ol>
        </section>

        <section class="content">  
            <form name="announcementEditForm"  ng-submit="saveUpdateAnnouncement()" ng-model-options="{updateOn : 'submit'}">
                
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                        <div class="pull-right">
                            <button type="submit" class="btn btn-success">
                            <i class="fa fa-save"></i>
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
                                                    <img ng-src="@{{announcement.file}}" class="img-responsive img-thumbnail announcement-thumbnail preview_image" />
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
                                    <div ng-show="announcementEditForm.announcement_title.$invalid &&announcementEditForm.announcement_title.$dirty">
                                        <span class="text-red" ng-show="announcementEditForm.announcement_title.$error.required">
                                            <i class="fa fa-warning"></i> Please enter announcement title.
                                        </span>
                                    </div>
                                    <input type="text" name="announcement_title" class="form-control" id="title" placeholder="Enter title&hellip;" ng-model="announcement.title" ng-model-options="{updateOn : '$inherit'}" required>
                                </div>
                                <div class="form-group">
                                    <label>Description:</label>
                                    <div ng-show="announcementEditForm.announcement_description.$invalid && announcementEditForm.announcement_description.$dirty">
                                            <span class="text-red" ng-show="announcementEditForm.announcement_description.$error.required">
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
