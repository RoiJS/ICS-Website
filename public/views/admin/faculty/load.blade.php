@extends('account-layout')

@section('title', 'Faculty Load')

@section('content')

    @include('admin.admin_navbar')

    <script type="text/javascript" src="/js/services/admin/admin.load.service.js"></script>
    <script type="text/javascript" src="/js/services/admin/admin.faculty.service.js"></script>
    <script type="text/javascript" src="/js/services/admin/admin.courses.service.js"></script>
    <script type="text/javascript" src="/js/services/admin/admin.subjects.service.js"></script>
    <script type="text/javascript" src="/js/services/admin/admin.curriculum.service.js"></script>
    <script type="text/javascript" src="/js/services/admin/admin.semesters.service.js"></script>
    <script type="text/javascript" src="/js/services/admin/admin.school.year.service.js"></script>

    <script type="text/javascript" src="/js/controllers/admin/admin.load.controller.js"></script>
    
    <link rel="stylesheet" href="/css/admin/load.css">  

    <div class="content-wrapper" ng-controller="adminLoadController">

        <section class="content-header">
            <h1> Faculty Load</h1>
            <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Faculty Load</li>
            </ol>
        </section>

        <section class="content">

            <!-- #start Faculty Information Panel -->
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Faculty Load</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="faculty-load-settings-section">
                                        <div class="load-dropdown">
                                            <div class="form-group">
                                                <label>Faculty:</label><br>
                                                <select id="faculty" class="form-control select-model" 
                                                        ng-model="faculty_id" 
                                                        ng-options="faculty.faculty_id + ' - ' + userHelper.getPersonFullname(faculty) for faculty in faculties track by faculty.teacher_id"></select>
                                            </div>
                                        </div>
                                        <div class="load-semester">
                                            <label>Semester:</label><br>
                                            <h4 id="semester">@{{c_sem}}</h4>
                                        </div>
                                        <div class="load-school-year">
                                            <label>School Year:</label><br>
                                            <h4 id="school_year">@{{c_sy}}</h4>
                                        </div>
                                        <div class="load-options">
                                            <div class="load-set">
                                                <div class="form-group">
                                                    <button class="btn btn-success" ng-click="setFacultyLoad()"><i class="fa fa-check-square-o"></i> Set</button>  
                                                </div>
                                            </div>
                                            <div class="load-reset">
                                                <div class="form-group">
                                                    <button class="btn btn-warning" ng-click="resetFacultySubjects()"><i class="fa fa-refresh"></i> Reset</button>  
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #end -->

            <!-- #start Subject List Panel -->
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div id="box-subject-list" class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Subject List</h3>
                        </div>

                        <!-- #start Subject Filter settings section -->
                        <div class="box-header with-border">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="subject-filter-settings">
                                        <div class="course-control">
                                            <div class="form-group">
                                                <label>Course:</label><br>
                                                <select id="course" 
                                                        class="form-control select-model" 
                                                        onchange="angular.element(this).scope().sortSubject()" 
                                                        ng-model="load.selected_course" ng-options="course.description for course in courses track by course.course_id"></select>
                                            </div>
                                        </div>
                                        <div class="curriculum-school-year-contol">
                                            <div class="form-group">
                                                <label for="school_year_curriculum">Curriculum Year:</label><br>

                                                <select id="curriculum_school_year" 
                                                    onchange="angular.element(this).scope().sortSubject()" 
                                                    class="form-control select-model" 
                                                    ng-model="class.curriculum_school_year" 
                                                    ng-options="cy.curriculum_year for cy in curriculum_years track by cy.curriculum_year"></select>
                                            </div>
                                        </div>
                                        <div class="subject-name-control">
                                            <div class="form-group" ng-show="!status.is_subject_sort">
                                                <label for="subjects">Subjects:</label><br>
                                                <select id="subjects" class="form-control select-model col-xs-3 col-sm-3 col-md-3 col-lg-3" ng-model="load.selected_subject" ng-options="subject.subject_details for subject in curriculum_subjects track by subject.subject_details_id"></select>
                                            </div>
                                            <div class="form-group" ng-show="status.is_subject_sort">
                                                <label for="subjects">Subjects:</label><br>
                                                <i class="fa fa-refresh fa-spin"></i> Loading subjects
                                            </div>
                                        </div>
                                        <div class="subject-filter-button-options">
                                            <div class="form-group">
                                                <button class="btn btn-success btn-block btn-add-selected-subject" 
                                                        ng-click="saveNewFacultySubject()">Add subject <i class="fa fa-arrow-down"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- #end -->


                        <div class="box-body loan-subjects-container">

                            <!-- #start Initial view  -->
                            <div class="row" ng-show="!status.subject_loading && !status.is_subject_set">
                                <div class="col-md-12">
                                    <div class="callout callout-info">
                                        <h4>No teacher has been set yet.</h4>
                                        <p>Display list of subjects per teacher by setting the following fields above.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- #end -->
                            
                            <!-- #start Loading view when initializing list of faculty subjects is still on the process -->
                            <div class="row" ng-if="status.subject_loading">
                                <div class="col-md-12">
                                    <i class="fa fa-refresh fa-spin"></i> <span> Loading subject&hellip; </span>
                                </div>
                            </div>
                            <!-- #end -->

                            <!-- #start Table view for the list of faculty subjects -->
                            <table class="table table-hover" ng-show="!status.subject_loading && status.is_subject_set">
                                <thead>
                                    <tr>
                                        <th style="width:10%;">Code</th>
                                        <th  style="width:20%;">Description</th>
                                        <th style="width:2%;">Section</th>
                                        <th style="width:9%;">Year Level</th>
                                        <th>Days</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th style="width:10%;">Room</th>
                                        <th style="width:5%;"></th>
                                        <th style="width:5%;"></th>
                                    </tr>                                
                                </thead>
                                <tbody ng-if="!status.has_curriculum_subjects">
                                    <tr>
                                        <td colspan="9" class="text-red">
                                            <div class="callout callout-warning">
                                                <p><i class="fa fa-warning"></i> <b>Empty subject list.</b> Add new subject for this faculty by selecting subject from the list above.</p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody ng-if="status.has_curriculum_subjects" ng-repeat="subject in faculty_subjects">  

                                    <!-- #start List View -->
                                    <!-- Displayed if subject edit property is false -->
                                    <tr id="subject-@{{$index}}" ng-if="!subject.edit" >
                                        <td class="subject-code">@{{subject.subject_code}}</td>
                                        <td class="subject-name">@{{subject.subject_description}}</td>
                                        <td>@{{subject.section}}</td>
                                        <td>@{{subject.year_level_name}}</td>
                                        <td>@{{subject.day_schedule}}</td>
                                        <td>@{{subject.subject_start_time}}</td>
                                        <td>@{{subject.subject_end_time}}</td>
                                        <td>@{{subject.room}}</td>
                                        <td><button class="btn btn-warning" ng-click="subject.edit = !subject.edit"><i class="fa fa-edit"></i></button></td>
                                        <td><button class="btn btn-danger" ng-click="removeFacultySubject($index)"><i class="fa fa-trash"></i></button></td>
                                    </tr>
                                    <!-- #end -->

                                    <!-- #start Subject Editor -->
                                    <!-- Displayed if subject edit property is true -->
                                    <tr ng-if="subject.edit">
                                        <td colspan="10">
                                            <form ng-submit="saveUpdateFacultySubject($index)" ng-model-options="{updateOn : 'submit'}">
                                                <table  class="table">
                                                    <tr id="subject-@{{$index}}">
                                                        <td class="subject-code" style="width:10%;">@{{subject.subject_code}}</td>
                                                        <td class="subject-name" style="width:20%;">@{{subject.subject_description}}</td>
                                                        <td style="width:8%;">
                                                            <input type="text" ng-model="subject.section" list="sections" style="width:80%;">
                                                            <datalist id="sections">
                                                                <option ng-repeat="section in sections" value="@{{section.section}}"></option>
                                                            </datalist>
                                                        </td>
                                                        <td style="width:8%;">@{{subject.year_level_name}}</td>
                                                        <td>
                                                            <div class="form-group">
                                                                <label>
                                                                    <input type="checkbox" ng-checked="subject.monday == 1" ng-model="subject.monday"> Mon
                                                                </label>
                                                                <label>
                                                                    <input type="checkbox" ng-checked="subject.tuesday == 1" ng-model="subject.tuesday"> Tue
                                                                </label>
                                                                <label>
                                                                    <input type="checkbox" ng-checked="subject.wednesday == 1" ng-model="subject.wednesday"> Wed
                                                                </label>
                                                                <label>
                                                                    <input type="checkbox" ng-checked="subject.thursday == 1" ng-model="subject.thursday"> Thu
                                                                </label>
                                                                <label>
                                                                    <input type="checkbox" ng-checked="subject.friday == 1" ng-model="subject.friday"> Fri
                                                                </label>
                                                                <label>
                                                                    <input type="checkbox" ng-checked="subject.saturday == 1" ng-model="subject.saturday"> Sat
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="bootstrap-timepicker">
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <input type="time" class="form-control" ng-model="subject.start_time">
                                                                    </div>  
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="bootstrap-timepicker">
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <input type="time" class="form-control" ng-model="subject.end_time">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td style="width:10%;">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" ng-model="subject.room">
                                                            </div>
                                                        </td>   
                                                        <td style="width:5%;"> <button type="submit" class="btn btn-info"><i class="fa fa-save"></i></button></td>
                                                        <td style="width:5%;"><button class="btn btn-danger" ng-click="subject.edit = !subject.edit"><i class="fa fa-ban"></i></button></td>       
                                                    </tr>
                                                </table>
                                            </form>
                                        </td>
                                    </tr>
                                    <!-- #end -->
                                    
                                </tbody>
                            </table>
                            <!-- #end -->

                        </div>
                        <div class="box-footer"></div>
                    </div>
                </div>
            </div>
            <!-- #end -->

        </section>
    </div>
@endsection
