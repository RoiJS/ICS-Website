@extends('account-layout')

@section('title', 'View Student')

@section('content')

    @include('admin.admin_navbar')
    
    <script type="text/javascript" src="/js/models/Student.js"></script>
    <script type="text/javascript" src="/js/services/admin/admin.students.service.js"></script>
    <script type="text/javascript" src="/js/controllers/admin/admin.view.students.controller.js"></script>

    <link rel="stylesheet" href="/css/admin/students.css">   

    <script>
        // Get current student id
        var student_id = {!! json_encode($student_id['id']); !!}
    </script>

    <div class="content-wrapper" ng-controller="adminViewStudentController">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> View Student </h1>
            <ol class="breadcrumb">
                <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="/admin/students">Students List</a></li>
                <li class="active">@{{student.fullname}}</li>
            </ol>
        </section>

        <section class="container">
            <br>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <a ng-href="/admin/students/edit_student/@{{student.stud_id}}" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                    <a class="btn btn-warning" ng-show="student.is_active === 1" ng-click="deactivateStudent()"><i class="fa fa-ban"></i> Deactivate</a>
                    <a class="btn btn-success" ng-show="student.is_active === 0" ng-click="activateStudent()"><i class="fa fa-check-circle"></i> Activate</a>
                </div>    
            </div>            
            <br>
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

                    <!-- #start Student Information Panel Section -->
                     <div class="box box-success">
                        <div class="box-body box-profile">
                            <div class="student-image-container img-circle">
                                <img class="img-responsive" ng-src="@{{student.image_source}}">
                            </div>
                            
                            <h3 class="profile-username text-center">@{{student.fullname}}</h3>

                            <p class="text-muted text-center">@{{student.student_id}}</p>

                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <b>Enrolled Curriculum:</b> 
                                    <a class="pull-right">@{{student.curriculum_year}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Gender:</b> 
                                    <a class="pull-right">@{{student.gender}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Birthdate:</b> 
                                    <a class="pull-right">@{{student.birthdate}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Email Address:</b> 
                                    <a class="pull-right">@{{student.email_address}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Username:</b> 
                                    <a class="pull-right">@{{student.username}}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="box-footer"></div>
                    </div>
                    <!-- #end -->

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
                                    <div ng-if="!isDetailsLoading && student.subjects.length === 0"  class="row">
                                        <div class="col-md-12">
                                            <div class="callout callout-success">
                                                <h4><i class="fa fa-info-circle"></i> Unenrolled student</h4>
                                                <p>This student is not yet enrolled for this current semester and school year.</p>
                                            </div>        
                                        </div>
                                    </div>
                                    <div ng-if="isDetailsLoading" class="row">
                                        <div class="col-md-12">
                                            <i class="fa fa-refresh fa-spin"></i> <span> Loading&hellip; </span>
                                        </div>
                                    </div>
                                    <div class="row" ng-if="!isDetailsLoading && student.subjects.length > 0" >
                                        <div class="col-md-12">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Subject Code</th>
                                                        <th>Subject</th>
                                                        <th>Section</th>
                                                        <th>Year Level</th>
                                                        <th>Units</th>
                                                        <th>Schedule</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat="subject in student.subjects">
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
