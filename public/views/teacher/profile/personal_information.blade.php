@extends('account-layout')

@section('title', 'Personal Information')

@section('content')

    @include('teacher.teacher_navbar')

    <script type="text/javascript" src="/js/services/teacher/teacher.profile.service.js"></script>
    <script type="text/javascript" src="/js/controllers/teacher/teacher.profile.controller.js"></script>

    <div class="content-wrapper" ng-controller="teacherProfileController">
        <section class="content-header">
            <h1><i class="fa fa-user"></i> Personal Information </h1>
            <ol class="breadcrumb">
                <li><a href="/teacher"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="/teacher/profile">Profile</a></li>
                <li class="active">Personal Information</li>
            </ol>
        </section>

        <section>
            <br>
            <form novalidate name="facultyForm" ng-submit="saveNewPersonalInformation()" ng-model-options="{updateOn : 'submit'}">
                <div class="container"> 
                    <div class="row">
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Faculty ID: 
                                    <span class="control-field-info" ng-show="facultyForm.faculty_id.$error.required">(Please enter faculty ID)</span>
                                    <span class="required-field">*</span>
                                </label>
                                <input type="text" name="faculty_id" ng-model="profile.faculty_id" class="form-control" id="faculty_id" placeholder="Enter Faculty ID&hellip;" ng-model-options="{updateOn : '$inherit'}" required>
                            </div>
                            <div class="form-group">
                                <label for="lastname">Last name: 
                                    <span class="control-field-info" ng-show="facultyForm.lastname.$error.required"> (Please enter last name)</span>
                                    <span class="required-field">*</span>
                                </label>
                                <input type="text" name="lastname" ng-model="profile.last_name" class="form-control" id="lastname" placeholder="Enter last name&hellip;" ng-model-options="{updateOn : '$inherit'}" required>
                            </div>
                            <div class="form-group">
                                <label for="firstname">First name: 
                                    <span class="control-field-info" ng-show="facultyForm.firstname.$error.required">(Please enter first name)</span>
                                    <span class="required-field">*</span>
                                </label>
                                <input type="text" name="firstname" ng-model="profile.first_name" class="form-control" id="firstname" placeholder="Enter first name&hellip;" ng-model-options="{updateOn : '$inherit'}" required>
                            </div>
                            <div class="form-group">
                                <label for="middlename">Middle name: 
                                    <span class="control-field-info" ng-show="facultyForm.middlename.$error.required">(Please enter middle name)</span>
                                    <span class="required-field">*</span>
                                </label>
                                <input type="text" name="middlename" ng-model="profile.middle_name" class="form-control" id="middlename" placeholder="Enter middle name&hellip;" ng-model-options="{updateOn : '$inherit'}" required>
                            </div>
                            <div class="form-group">
                                <label>Gender: 
                                    <span class="control-field-info" ng-show="facultyForm.gender.$error.required">(Please select gender)</span>
                                    <span class="required-field">*</span>
                                </label>
                                <br>
                                <label>
                                    <input type="radio" name="gender" value="Female" ng-model="profile.gender">
                                    Female
                                </label>
                                <label>
                                    <input type="radio" name="gender" value="Male" ng-model="profile.gender">
                                    Male
                                </label>
                            </div>   
                            <div class="form-group">
                                <label>Birthdate: 
                                    <span class="control-field-info" ng-show="facultyForm.birthdate.$error.required">(Please enter birthdate)</span>
                                    <span class="required-field">*</span>
                                </label>
                                <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="date" name="birthdate" ng-model="profile.birthdate" class="form-control pull-right" placeholder="Enter birthdate&hellip;" ng-model-options="{updateOn : '$inherit'}"  required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="position">Academic Rank: 
                                    <span class="control-field-info" ng-show="facultyForm.academic_rank.$error.required">(Please enter academic rank)</span>
                                    <span class="required-field">*</span>
                                </label>
                                <input type="text" name="academic_rank" ng-model="profile.academic_rank" class="form-control" id="academic_rank" placeholder="Enter academic rank&hellip;" ng-model-options="{updateOn : '$inherit'}"  required>
                            </div>
                            <div class="form-group">
                                <label for="designation">Designation: 
                                    <span class="control-field-info" ng-show="facultyForm.designation.$error.required">(Please enter designation)</span>
                                    <span class="required-field">*</span>
                                </label>
                                <input type="text" name="designation" ng-model="profile.designation" class="form-control" id="designation" placeholder="Enter designation&hellip;" ng-model-options="{updateOn : '$inherit'}"  required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
        
    </div>
@endsection