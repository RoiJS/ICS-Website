@extends('account-layout')

@section('title')
   {{$subject['description']}} | Homeworks
@endsection

@section('content')

    @include('teacher.subjects.teacher_subject_navbar')

    <script src="/js/services/shared/account.homeworks.service.js"></script>
    <script src="/js/controllers/teacher/teacher.add.homeworks.controller.js"></script>

    <link rel="stylesheet" href="/css/shared/homeworks.css">

    <div class="content-wrapper">
        <section class="content-header">
            <h1>{{$subject['description']}}  <small>Homeworks</small></h1>
            <ol class="breadcrumb">
            <li><a href="/teacher"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/teacher/subject/{{$id}}/posts"><i class="fa fa-book"></i> {{$subject['description']}}</a></li>
            <li><a href="/teacher/subject/{{$id}}/homeworks">Homeworks</a></li>
            <li class="active">Add Homework</li>
            </ol>
        </section>

        <section class="content" ng-controller="teacherAddHomeworksController">

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="row">
                        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                            <!-- #start Homeworks form -->
                            <form novalidate name="newHomeworkForm" ng-submit="saveNewHomework()">
                                <div class="box box-success">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Homework form</h3>
                                    </div>
                                    <div class="box-body">
                                        <label class="lbl-note-message">Note : (<span class="required-field">*</span>) Required Fields</label> <br>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label>Title: 
                                                        <span class="control-field-info" ng-show="newHomeworkForm.homework_title.$error.required">(Please enter Title)</span>
                                                        <span class="required-field">*</span>
                                                    </label>
                                                    <input type="text" name="homework_title" class="form-control" ng-model="homework.title" placeholder="Enter title&hellip;" required>
                                                </div>    
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label>Due date:
                                                        <span class="control-field-info" ng-show="newHomeworkForm.homework_due_date.$error.required">(Please enter due date)</span>
                                                        <span class="required-field">*</span>
                                                    </label>
                                                    <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="date" name="homework_due_date" class="form-control pull-right" ng-model="homework.due_date" placeholder="Enter due date&hellip;" required>
                                                    </div>
                                                </div>    
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <br>
                                                <div class="form-group">
                                                    <label>
                                                        <input type="checkbox" ng-model="homework.is_submit">  Auto submit
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label>Description:</label>
                                                    <trix-editor angular-trix ng-model="homework.description" class="homework-editor-container"></trix-editor>
                                                </div>    
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <div class="row pull-right">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <button ng-if="!status.saving" type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                                                <button ng-if="status.saving" type="submit" class="btn btn-success disabled"><i class="fa fa-refresh fa-spin"></i> Saving. Please wait&hellip;</button>
                                                <a href="/teacher/subject/{{$id}}/homeworks" class="btn btn-danger"><i class="fa fa-ban"></i> Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- #end -->
                        </div>

                        <!--List of files to be uploaded-->
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            <!-- #start File list panel section -->
                            <div class="box box-success">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Upload files</h3>
                                </div>
                                <div class="box-body">
                                    <div class="row" ng-show="!status.files_loading && homework.files.length === 0">
                                        <div class="col-md-12">
                                            <i class="fa fa-copy"></i> <b>Select files to upload&hellip;</b>
                                        </div>
                                    </div>
                                    <div class="row" ng-show="status.files_loading">
                                        <div class="col-md-12">
                                            <i class="fa fa-refresh fa-spin"></i> Loading Files. Please wait&hellip;
                                        </div>
                                    </div>
                                </div>
                                <div class="box-body homeworks-file-upload-container" ng-show="!status.files_loading && homework.files.length > 0">
                                    <div class="row">
                                        <div ng-repeat="file in homework.files"  class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="info-box file-item-section">
                                                <span class="info-box-icon bg-green file-item-icon"><i class="fa fa-file"></i></span>
                                                <div class="info-box-content file-item-content">
                                                    <span class="info-box-text file-item-name" title="@{{file.name}}">@{{file.name}}</span>
                                                    <span class="info-box-number file-item-size">@{{file.fileFormattedSize}} MB</span>
                                                    <a class="pull-right file-item-remove-icon" ng-click="removeFile($index)"><i class="fa fa-trash"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <input type="file" onchange="angular.element(this).scope().selectFiles(this)" multiple class="form-control" accept="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <button type="button" class="btn btn-warning btn-block" ng-click="clearFiles()"><i class="fa fa-eraser"></i> Clear All</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- #end -->
                        </div>
                        
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
