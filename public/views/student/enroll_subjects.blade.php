@extends('account-layout')

@section('title', 'Enroll Subjects')

@section('content')

    @include('student.student_navbar')

    <script type="text/javascript" src="/js/services/student/student.enroll.subjects.service.js"></script>
    <script type="text/javascript" src="/js/services/admin/admin.curriculum.service.js"></script>
    <script type="text/javascript" src="/js/services/admin/admin.courses.service.js"></script>

    <script type="text/javascript" src="/js/controllers/student/student.enroll.subjects.controller.js"></script>

    <link rel="stylesheet" href="/css/shared/enroll.css">

    <div class="content-wrapper" ng-controller="studentEnrollSubjectsController">
        <section class="content-header">
            <h1> Subjects List </h1>
            <ol class="breadcrumb">
                <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Enroll Subjects</li>
            </ol>
        </section>

        <div class="content">
            <br>
            <div class="row" ng-if="status.data_loading">
                <div class="col-md-12">
                    <i class="fa fa-refresh fa-spin"></i> <span> Loading&hellip; </span>
                </div>
            </div>
            <div class="row" ng-if="!status.data_loading">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Subject list</h3>
                        </div>
                        <div class="box-body">
                            <div class="enroll-subjects-section">
                                <div class="subject-filetr">
                                    <div class="filter-field course-field">
                                        <div class="form-group">
                                            <label>Course:</label>
                                            <select id="selected_course"
                                                    class="form-control" 
                                                    ng-model="selectedCourse" 
                                                    ng-options="course.description for course in courses track by course.course_id"></select>
                                        </div>
                                    </div>
                                    <div class="filter-field year-level-field">
                                        <div class="form-group">
                                            <label>Year Level:</label>
                                            <select id="selected_year_level"
                                                    class="form-control" 
                                                    ng-model="selectedYearLevel" 
                                                    ng-options="yl.year_level_name for yl in year_levels track by yl.year_level"></select>
                                        </div>
                                    </div>
                                    <div class="filter-button-section">
                                        <label for="studenID">&nbsp;</label>
                                        <div class="form-group">
                                            <button class="btn btn-success" ng-click="filterSubjects()">Filter</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="subject-list">
                                    <table ng-table="tblClassList" class="table table-hover table-class-subjects" ng-show="!status.subject_loading" show-filter="true">
                                        <tr ng-repeat="subject in $data">
                                            <td style="width:15%;" title="'Instructor'" filter="{ teacher_name: 'text'}" sortable="'teacher_name'">@{{subject.teacher_name}}</td>
                                            <td style="width:10%;" title="'Subject code'" filter="{ subject_code: 'text'}" sortable="'subject_code'">@{{subject.subject_code}}</td>
                                            <td style="width:20%;" title="'Subject'" filter="{ subject_name: 'text'}" sortable="'subject_name'">@{{subject.subject_name}}</td>
                                            <td title="'Year Level'" filter="{ year_level_name: 'text'}" sortable="'year_level_name'">@{{subject.year_level_name}}</td>
                                            <td style="width:8%;" title="'Section'" filter="{ section: 'text'}" sortable="'section'">@{{subject.section}}</td>
                                            <td title="'Days'" filter="{ subject_schedlule: 'text'}" sortable="'subject_schedlule'">@{{subject.subject_schedlule}}</td>
                                            <td title="'Start Time'" filter="{ start_time: 'text'}" sortable="'start_time'">@{{subject.start_time}}</td>
                                            <td title="'End Time'" filter="{ end_time: 'text'}" sortable="'end_time'">@{{subject.end_time}}</td>
                                            <td style="width:10%;" title="'Room'" filter="{ room: 'text'}" sortable="'room'">@{{subject.room}}</td>
                                            <td style="width:5%;">
                                                <button class="btn btn-success col-option" ng-click="enrollSubject($index)" ng-show="subject.is_enrolled === -1"><i class="fa fa-bookmark-o"></i> Enroll</button>
                                                <button class="btn btn-warning col-option" ng-click="unenrollSubject($index)" ng-show="subject.is_enrolled === 1"><i class="fa fa-bookmark"></i> Unenroll</button>
                                                <span class="badge bg-yellow col-option" ng-show="subject.is_enrolled === 0">Pending</span>
                                            </td>
                                        </tr>
                                    </table>    
                                </div>
                            </div>
                            
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
@endsection