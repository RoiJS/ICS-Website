@extends('account-layout')

@section('title', 'Edit Subject')

@section('content')

    @include('admin.admin_navbar')

    <script type="text/javascript" src="/js/services/admin/admin.subjects.service.js"></script>
    <script type="text/javascript" src="/js/controllers/admin/admin.edit.subject.controller.js"></script>

    <script>
        // Get current subject id
        var subject_id = {!! json_encode($subject['id']) !!}
    </script>

    <div class="content-wrapper" ng-controller="adminEditSubjectController">
        <section class="content-header">
            <h1>
            Subjects <List></List>
            </h1>
            <ol class="breadcrumb">
                <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="/admin/subjects"> Subjects</a></li>
                <li class="active">Edit Subject</li>
                <li class="active">@{{subject.subject_description}}</li>
            </ol>
        </section>

        <div class="container">
            <br>
            <form novalidate ng-submit="saveUpdateSubject()" ng-model-options="{updateOn : 'submit'}">
                <div class="row">
                    <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
                        <div class="box box-success">
                            <div class="box-header">
                                <h3 class="box-title">Edit Subject Form</h3>
                            </div>
                        
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <label for="subject_code">Code:</label>
                                            <input type="text" class="form-control" id="subject-code" placeholder="Enter subject code&hellip;" ng-model="subject.subject_code">
                                        </div>       
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-5">
                                        <div class="form-group">
                                            <label for="description">Description:</label>
                                            <input type="text" class="form-control" id="description" placeholder="Enter subject desciption&hellip;" ng-model="subject.subject_description">
                                        </div>        
                                    </div>
                                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                        <div class="form-group">
                                            <label for="lec_unit">Lec unit:</label>
                                            <input type="number" value="0" step="0.1" class="form-control" id="lec-unit" ng-model="subject.lec_units">
                                        </div>          
                                    </div>
                                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                        <div class="form-group">
                                            <label for="lab_unit">Lab unit:</label>
                                            <input type="number" value="0" step="0.1" class="form-control" id="lab-unit" ng-model="subject.lab_units">
                                        </div>    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
                        <div class="pull-right">
                            <button type="submit" class="btn btn-success">
                            <i class="fa fa-save"></i>
                            Save</button>
                            <a href="/admin/subjects" class="btn btn-danger">
                            <i class="fa fa-ban"></i>
                            Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
            
        </div>
    </div>
@endsection
