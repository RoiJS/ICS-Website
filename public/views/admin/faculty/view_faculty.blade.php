@extends('account-layout')

@section('title', 'View Faculty')

@section('content')

    @include('admin.admin_navbar')
    
    <script type="text/javascript" src="/js/models/Faculty.js"></script>
    <script type="text/javascript" src="/js/services/admin/admin.faculty.service.js"></script>
    <script type="text/javascript" src="/js/controllers/admin/admin.view.faculty.controller.js"></script>
    <link rel="stylesheet" href="/css/admin/faculty.css">   

    <script>
        // Get current faculty id
        var teacher_id = parseInt({!! json_encode($faculty['id']); !!});
    </script>

    <div class="content-wrapper" ng-controller="adminViewFacultyController">
        <input type="hidden" id="faculty_id">
        <section class="content-header">
            <h1> View Faculty </h1>
            <ol class="breadcrumb">
                <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="/admin/faculty">Faculty List</a></li>
                <li class="active">@{{faculty.fullname}}</li>
            </ol>
        </section>

        <section class="container">
            <br>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <a ng-href="/admin/faculty/edit_faculty/@{{faculty.teacher_id}}" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                    <a class="btn btn-warning" ng-show="faculty.is_active === 1" ng-click="deactivateFaculty()"><i class="fa fa-ban"></i> Deactivate</a>
                    <a class="btn btn-success" ng-show="faculty.is_active === 0" ng-click="activateFaculty()"><i class="fa fa-check-circle"></i> Activate</a>
                </div>    
            </div>            
            <br>
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="box box-success">
                        <div class="box-body box-profile">
                            <div class="faculty-image-container img-circle">
                               <img ng-if="faculty.image_source" class="img-responsive" ng-src="@{{faculty.image_source}}">
                            </div>
                            
                            <h3 class="profile-username text-center">@{{faculty.fullname}}</h3>
                            <p class="text-muted text-center">@{{faculty.designation}}</p>

                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <b>Gender:</b> <a class="pull-right">@{{faculty.gender}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Birthdate:</b> <a class="pull-right">@{{faculty.birthdate}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Academic Rank:</b> <a class="pull-right">@{{faculty.academic_rank}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Designation:</b> <a class="pull-right">@{{faculty.designation}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Email Address:</b> <a class="pull-right">@{{faculty.email_address}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Username:</b> <a class="pull-right">@{{faculty.username}}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="box-footer"></div>
                    </div>
                </div>
                <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-success">
                                <div class="box-header">
                                   <div class="box-title">
                                       Subject List
                                   </div>
                                </div>  
                                <div class="box-body">
                                    <div ng-if="!isDetailsLoading && faculty.subjects.length === 0"  class="row">
                                        <div class="col-md-12">
                                            <div class="callout callout-success">
                                                <h4><i class="fa fa-info-circle"></i> Empty subject list</h4>
                                                <p>This faculty has not been assigned with any subjects this semester and school year </p>
                                            </div>        
                                        </div>
                                    </div>
                                    <div ng-if="isDetailsLoading" class="row">
                                        <div class="col-md-12">
                                            <i class="fa fa-refresh fa-spin"></i> <span> Loading&hellip; </span>
                                        </div>
                                    </div>
                                    <div class="row" ng-if="!isDetailsLoading && faculty.subjects.length > 0" >
                                        <div class="col-md-12">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Subject Code</th>
                                                        <th>Subject</th>
                                                        <th>Section</th>
                                                        <th>Year level</th>
                                                        <th>Units</th>
                                                        <th>Schedule</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat="subject in faculty.subjects">
                                                        <td>@{{subject.subject_code}}</td>
                                                        <td>@{{subject.subject_description}}</td>
                                                        <td>@{{subject.section}}</td>
                                                        <td>@{{subject.year_level_name}}</td>
                                                        <td>@{{subject.total_units}}</td>
                                                        <td>@{{subject.schedule}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>    
                                        </div>
                                    </div>    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
