@extends('account-layout')

@section('title', 'Edit Faculty')

@section('content')

    @include('admin.admin_navbar')

    <script type="text/javascript" src="/js/services/admin/admin.faculty.service.js"></script>
    <script type="text/javascript" src="/js/controllers/admin/admin.edit.faculty.controller.js"></script>
    
    <link rel="stylesheet" href="/css/admin/faculty.css">

    <script>
        // Set faculty id
        var faculty_id = {!! json_encode($faculty['id']); !!};
    </script>

    <div class="content-wrapper" ng-controller="adminEditFacultyController">
        <section class="content-header">
            <h1> Edit Faculty </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="/admin/faculty">Faculty List</a></li>
                <li class="active">Edit Faculty</li>
                <li class="active">@{{userHelper.getPersonFullname(faculty)}}</li>
            </ol>
        </section>

        <section class="container" ng-controller="adminEditFacultyController">
            <form name="facultyForm" ng-submit="saveUpdateFaculty()" novalidate ng-model-options="{updateOn : 'submit'}">
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
                                            <label for="last_name">Last name:
                                                <span class="control-field-info" ng-show="facultyForm.faculty_last_name.$error.required">(Please enter last name)</span>
                                                <span class="required-field">*</span>
                                            </label>
                                            <input type="text" name="faculty_last_name" ng-model="faculty.last_name" class="form-control" id="last_name" placeholder="Enter last name&hellip;" ng-model-options="{updateOn : '$inherit'}" required>
                                        </div>  
                                        <div class="form-group">
                                            <label for="first_name">First name:
                                                <span class="control-field-info" ng-show="facultyForm.faculty_first_name.$error.required">(Please enter first name)</span>
                                                <span class="required-field">*</span>
                                            </label>
                                            <input type="text" name="faculty_first_name" ng-model="faculty.first_name" class="form-control" id="first_name" placeholder="Enter first name&hellip;" ng-model-options="{updateOn : '$inherit'}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="middle_name">Middle name:
                                                <span class="control-field-info" ng-show="facultyForm.faculty_middle_name.$error.required">(Please enter middle name)</span>
                                                <span class="required-field">*</span>
                                            </label>
                                            <input type="text" name="faculty_middle_name" ng-model="faculty.middle_name" class="form-control" id="middle_name" placeholder="Enter middle name&hellip;" ng-model-options="{updateOn : '$inherit'}" required>
                                        </div>  
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="position">Acadmic Rank:
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
                                                <span class="control-field-info" ng-show="facultyForm.gender.$error.required">(Please enter gender)</span>
                                                <span class="required-field">*</span>
                                            </label><br>
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
                                            <img ng-src=@{{faculty.image_source}} class="img-responsive img-thumbnail preview_image">
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
                                        <input type="email" name="faculty_email_address" class="form-control" id="emailaddress" placeholder="Enter email address&hellip;" ng-model="faculty.email_address" ng-model-options="{updateOn : '$inherit'}">
                                    </div>
                                    <div class="form-group">
                                        <label for="username">Username:</label>
                                        <div ng-show="facultyForm.faculty_username.$dirty && facultyForm.faculty_username.$invalid">
                                            <span class="text-red" ng-show="facultyForm.faculty_username.$error.required">
                                                <i class="fa fa-warning"></i> Please enter faculty username
                                            </span>
                                        </div>
                                        <input type="text" name="faculty_username" class="form-control" id="username" placeholder="Enter username&hellip;" ng-model="faculty.username" ng-model-options="{updateOn : '$inherit'}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Enter new password:</label>
                                        <input type="password" name="faculty_password" class="form-control" id="password" placeholder="Enter password&hellip;" ng-model="new_password" ng-model-options="{updateOn : 'default'}">
                                    </div>
                                    <div class="form-group" ng-show="new_password !== ''">
                                        <label for="password">Confirm Password:</label>
                                        <div ng-show="facultyForm.faculty_confirm_password.$dirty && facultyForm.faculty_confirm_password.$invalid">
                                            <span class="text-red" ng-show="facultyForm.faculty_confirm_password.$error.required">
                                                <i class="fa fa-warning"></i> Please re enter faculty account password
                                            </span>
                                        </div>
                                        <div>
                                            <span class="text-red" ng-show="confirm_new_password !== '' && confirm_new_password !== new_password">
                                                <i class="fa fa-warning"></i> Password does not match
                                            </span>
                                        </div>
                                        <input type="password" name="faculty_confirm_password" class="form-control" id="password" placeholder="Enter password&hellip;" ng-model="confirm_new_password" ng-model-options="{updateOn : '$inherit'}">
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
