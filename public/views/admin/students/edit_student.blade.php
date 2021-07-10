@extends('account-layout')

@section('title', 'Edit Student')

@section('content')

    @include('admin.admin_navbar')

    <script type="text/javascript" src="/js/services/admin/admin.students.service.js"></script>
    <script type="text/javascript" src="/js/services/admin/admin.curriculum.service.js"></script>

    <script type="text/javascript" src="/js/controllers/admin/admin.edit.student.controller.js"></script>

    <link rel="stylesheet" href="/css/admin/students.css"> 

    <script>
        var student_id = {!! json_encode($student_id['id']); !!};
    </script>

    <div class="content-wrapper" ng-controller="adminEditStudentController">
        <section class="content-header">
            <h1>View Student</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="/admin/students">Students List</a></li>
                <li class="active">Edit Student</li>
                <li class="active">@{{userHelper.getPersonFullname(student)}}</li>
            </ol>
        </section>

        <section class="container">
            <br>
            <form novalidate name="studentEditForm" ng-submit="saveUpdateStudent()" ng-model-options="{updateOn : 'submit'}">
                <br>
                <div class="row">
                    <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <h3 class="box-title">Personal Information:</h3>
                            </div>
                            <div class="box-body">
                                <label class="lbl-note-message">@{{sysTxtsHelper.TXT_NOTE}} : (<span class="required-field">*</span>) @{{sysTxtsHelper.TXT_REQUIRED_FIELDS}}</label> <br>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="studenID">Student ID:
                                                <span class="control-field-info" ng-show="studentEditForm.student_id.$error.required">(Please enter student ID)</span>
                                                <span class="required-field">*</span>
                                            </label>
                                            <input type="text" name="student_id" class="form-control" id="studenID" placeholder="Enter student ID&hellip;" ng-model="student.student_id" ng-model-options="{updateOn : '$inherit'}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="lastname">Last name:
                                                <span class="control-field-info" ng-show="studentEditForm.student_lastname.$error.required">(Please enter student last name)</span>
                                                <span class="required-field">*</span>
                                            </label>
                                            <input type="text" name="student_lastname" class="form-control" id="lastname" placeholder="Enter last name&hellip;" ng-model="student.last_name" ng-model-options="{updateOn : '$inherit'}" required>
                                        </div>   
                                        <div class="form-group">
                                            <label for="firstname">First name:
                                                <span class="control-field-info" ng-show="studentEditForm.student_firstname.$error.required">(Please enter student first name)</span>
                                                <span class="required-field">*</span>
                                            </label>
                                            <input type="text" name="student_firstname" class="form-control" id="firstname" placeholder="Enter first name&hellip;" ng-model="student.first_name" ng-model-options="{updateOn : '$inherit'}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="middlename">Middle name:
                                                <span class="control-field-info" ng-show="studentEditForm.student_middlename.$error.required">(Please enter student middle name)</span>
                                                <span class="required-field">*</span>
                                            </label>
                                            <input type="text" name="student_middlename" class="form-control" id="middlename" placeholder="Enter middle name&hellip;" ng-model="student.middle_name" ng-model-options="{updateOn : '$inherit'}" required>
                                        </div> 
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="curriculum_school_year">Enrolled curriculum year:
                                                <span class="control-field-info" ng-show="!student.curriculum_year">(Please enter curriculum year)</span>
                                                <span class="required-field">*</span>
                                            </label>
                                            
                                            <select id="curriculum_school_year" 
                                                    name="curriculum_year"
                                                    class="form-control" 
                                                    ng-model="student.curriculum_year" 
                                                    ng-model-options="{updateOn : '$inherit'}"
                                                    ng-options="cy.curriculum_year for cy in curriculum_years track by cy.curriculum_year"
                                                    required></select>
                                        </div> 
                                        <div class="form-group">
                                            <label>Birthdate:
                                                <span class="control-field-info" ng-show="studentEditForm.student_birthdate.$error.required">(Please select student birthdate)</span>
                                                <span class="required-field">*</span>
                                            </label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="date" name="student_birthdate" class="form-control pull-right"  placeholder="Enter birthdate&hellip;" ng-model="student.birthdate" ng-model-options="{updateOn : '$inherit'}"  required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Gender:
                                                <span class="control-field-info" ng-show="studentEditForm.gender.$error.required">(Please select gender)</span>
                                                <span class="required-field">*</span>
                                            </label><br>
                                            
                                            <label>
                                                <input type="radio" name="gender" value="Female" ng-model="student.gender" required>
                                                Female
                                            </label>
                                            <label>
                                                <input type="radio" name="gender" value="Male"  ng-model="student.gender"  required>
                                                Male
                                            </label>
                                        </div>        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="box box-success">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Photo</h3>
                                    </div>
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
                                        <div class="update-profile-student-photo">
                                            <img ng-src="@{{student.image_source}}" class="img-responsive img-thumbnail preview_image">
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <div class="col-md-12">
                                            <input type="file" class="form-control" file-model="student.image" ng-model-options="{updateOn : '$inherit'}" onchange="angular.element(this).scope().imageFileHelper.viewImage(this, true)" accept="image/*">
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
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                            <div class="box box-success">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Account Information</h3>
                                </div>
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="emailaddress">Email Address:
                                        </label>
                                        <div ng-show="studentEditForm.student_email_address.$dirty && studentEditForm.student_email_address.$invalid">
                                                <span class="text-red" ng-show="studentEditForm.student_email_address.$error.email">
                                                    <i class="fa fa-warning"></i> Incorrect email address. Please enter a valid and active email address
                                                </span>
                                            </div>
                                        <input type="email" name="student_email_address" class="form-control" id="emailaddress" placeholder="Enter email address&hellip;" ng-model="student.email_address" ng-model-options="{updateOn : '$inherit'}" >
                                    </div>
                                    <div class="form-group">
                                        <label for="username">Username:
                                            <span class="control-field-info" ng-show="studentEditForm.student_username.$error.required">(Please enter student username)</span>
                                            <span class="required-field">*</span>
                                        </label>
                                        <input type="text" name="student_username" class="form-control" id="username" placeholder="Enter username&hellip;" ng-model="student.username" ng-model-options="{updateOn : '$inherit'}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Enter new password:</label>
                                        <input type="password" name="student_password" class="form-control" id="password" placeholder="Enter password&hellip;" ng-model="new_password" ng-model-options="{updateOn: 'default'}">
                                    </div>
                                    <div class="form-group" ng-show="new_password !== ''">
                                        <label for="password">Confirm Password:</label>
                                        <div ng-show="studentEditForm.student_password.$dirty && studentEditForm.student_password.$invalid">
                                            <span class="text-red" ng-show="studentEditForm.student_password.$error.required">
                                                <i class="fa fa-warning"></i> Please re enter student account password
                                            </span>
                                        </div>
                                        <input type="password" name="student_confirm_password" class="form-control" id="confirm_password" placeholder="Enter password&hellip;" ng-model-options="{updateOn: '$inherit'}" ng-model="confirm_new_password">
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                                        <a href="/admin/students" class="btn btn-danger"><i class="fa fa-ban"></i> Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection
