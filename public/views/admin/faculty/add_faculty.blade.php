@extends('account-layout')

@section('title', 'Add Faculty')

@section('content')

    @include('admin.admin_navbar')

    <script type="text/javascript" src="/js/services/admin/admin.faculty.service.js"></script>
    <script type="text/javascript" src="/js/controllers/admin/admin.add.faculty.controller.js"></script>

    <link rel="stylesheet" href="/css/admin/faculty.css">

    <div class="content-wrapper">
        <section class="content-header">
            <h1> Add Faculty </h1>
            <ol class="breadcrumb">
                <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="/admin/faculty">Faculty List</a></li>
                <li class="active">Add Faculty</li>
            </ol>
        </section>

        <section class="container" ng-controller="adminAddFacultyController">
            <form name="facultyForm" ng-submit="saveNewFaculty()" novalidate ng-model-options="{updateOn : 'submit'}">
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
                                            <label>Faculty ID: 
                                                <span class="control-field-info" ng-show="facultyForm.faculty_id.$error.required">(Please enter faculty ID)</span>
                                                <span class="required-field">*</span>
                                            </label>
                                            <input type="text" name="faculty_id" ng-model="faculty.faculty_id" class="form-control" id="studenID" placeholder="Enter faculty ID&hellip;" ng-model-options="{updateOn : '$inherit'}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="lastname">Last name: 
                                                <span class="control-field-info" ng-show="facultyForm.faculty_lastname.$error.required"> (Please enter last name)</span>
                                                <span class="required-field">*</span>
                                            </label>
                                            <input type="text" name="faculty_lastname" ng-model="faculty.lastname" class="form-control" id="lastname" placeholder="Enter last name&hellip;" ng-model-options="{updateOn : '$inherit'}" required>
                                        </div>  
                                        <div class="form-group">
                                            <label for="firstname">First name: 
                                                <span class="control-field-info" ng-show="facultyForm.faculty_firstname.$error.required">(Please enter first name)</span>
                                                <span class="required-field">*</span>
                                            </label>
                                            <input type="text" name="faculty_firstname" ng-model="faculty.firstname" class="form-control" id="firstname" placeholder="Enter first name&hellip;" ng-model-options="{updateOn : '$inherit'}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="middlename">Middle name: 
                                                <span class="control-field-info" ng-show="facultyForm.faculty_middlename.$error.required">(Please enter middle name)</span>
                                                <span class="required-field">*</span>
                                            </label>
                                            <input type="text" name="faculty_middlename" ng-model="faculty.middlename" class="form-control" id="middlename" placeholder="Enter middle name&hellip;" ng-model-options="{updateOn : '$inherit'}" required>
                                        </div>  
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="position">Academic Rank: 
                                                <span class="control-field-info" ng-show="facultyForm.faculty_academic_rank.$error.required">(Please enter academic rank)</span>
                                                <span class="required-field">*</span>
                                            </label>
                                            <input type="text" name="faculty_academic_rank" ng-model="faculty.academic_rank" class="form-control" id="position" placeholder="Enter academic rank&hellip;" ng-model-options="{updateOn : '$inherit'}" required>
                                        </div>    
                                        <div class="form-group">
                                            <label for="designation">Designation: 
                                                <span class="control-field-info" ng-show="facultyForm.faculty_designation.$error.required">(Please enter designation)</span>
                                                <span class="required-field">*</span>
                                            </label>
                                            <input type="text" name="faculty_designation" ng-model="faculty.designation" class="form-control" id="designation" placeholder="Enter designation&hellip;" ng-model-options="{updateOn : '$inherit'}" required>
                                        </div>    
                                        <div class="form-group">
                                            <label>Birthdate: 
                                                <span class="control-field-info" ng-show="facultyForm.faculty_birthdate.$error.required">(Please enter birthdate)</span>
                                                <span class="required-field">*</span>
                                            </label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="date" name="faculty_birthdate" ng-model="faculty.birthdate" class="form-control pull-right"  placeholder="Enter birthdate&hellip;"  ng-model-options="{updateOn : '$inherit'}"  required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Gender: 
                                                <span class="control-field-info" ng-show="facultyForm.gender.$error.required">(Please select gender)</span>
                                                <span class="required-field">*</span>
                                            </label>
                                            <br>
                                            <label>
                                                <input type="radio" name="gender" value="Female" ng-model="faculty.gender" required>
                                                Female
                                            </label>
                                            <label>
                                                <input type="radio" name="gender" value="Male"  ng-model="faculty.gender"  required>
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
                                        <div class="update-profile-teacher-photo">
                                            <img class="img-responsive img-thumbnail preview_image">
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <div class="col-md-12">
                                            <input type="file" class="form-control" file-model="faculty.image" ng-model-options="{updateOn : '$inherit'}" onchange="angular.element(this).scope().imageFileHelper.viewImage(this, true)" accept="image/*">
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
                                        <label for="emailaddress">Email Address:</label>
                                        <div ng-show="facultyForm.faculty_email_address.$dirty && facultyForm.faculty_email_address.$invalid">
                                            <span class="text-red" ng-show="facultyForm.faculty_email_address.$error.email">
                                                <i class="fa fa-warning"></i> Incorrect email address. Please enter a valid and active email address
                                            </span>
                                        </div>
                                        <input type="email" name="faculty_email_address" class="form-control" id="emailaddress" placeholder="Enter email address&hellip;" ng-model="faculty.email_address" ng-model-options="{updateOn : '$inherit'}" >
                                    </div>
                                    <div class="form-group">
                                        <label for="username">Username: 
                                            <span class="control-field-info" ng-show="facultyForm.faculty_username.$error.required"> (Please enter faculty username)</span>
                                            <span class="required-field">*</span>
                                        </label>
                                        <input type="text" name="faculty_username" class="form-control" id="username" placeholder="Enter username&hellip;" ng-model="faculty.username" ng-model-options="{updateOn : '$inherit'}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password: 
                                            <span class="control-field-info" ng-show="facultyForm.faculty_password.$error.required">(Please enter faculty account password)</span>
                                            <span class="required-field">*</span>
                                        </label>
                                        <input type="password" name="faculty_password" class="form-control" id="password" placeholder="Enter password&hellip;" ng-model="faculty.password" ng-model-options="{updateOn : '$inherit'}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Confirm Password: 
                                            <span class="control-field-info" ng-show="facultyForm.faculty_confirm_password.$error.required">(Please re enter faculty account password)</span>
                                            <span class="required-field">*</span>
                                        </label>
                                        <div>
                                            <span class="text-red" ng-show="faculty.confirm_password != faculty.password">
                                                <i class="fa fa-warning"></i> Password does not match
                                            </span>
                                        </div>
                                        <input type="password" name="faculty_confirm_password" class="form-control" id="confirm_password" placeholder="Enter password&hellip;" ng-model="faculty.confirm_password" ng-model-options="{updateOn : '$inherit'}" required>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                                        <a href="/admin/faculty" class="btn btn-danger"><i class="fa fa-ban"></i> Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
            </form>
            
        </section>
    </div>
@endsection
