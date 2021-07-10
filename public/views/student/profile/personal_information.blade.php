@extends('account-layout')

@section('title', 'Personal Information')

@section('content')

    @include('student.student_navbar')

    <script type="text/javascript" src="/js/services/student/student.profile.service.js"></script>
    <script type="text/javascript" src="/js/controllers/student/student.profile.controller.js"></script>

    <div class="content-wrapper" ng-controller="studentProfileController">
        <section class="content-header">
            <h1><i class="fa fa-user"></i> Personal Information </h1>
            <ol class="breadcrumb">
                <li><a href="/student"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="/student/profile">Profile</a></li>
                <li class="active">Personal Information</li>
            </ol>
        </section>

        <section class="content">
            <br>
            <form novalidate name="profileForm" ng-submit="saveNewPersonalInformation()" ng-model-options="{updateOn : 'submit'}">
                <div class="container"> 
                    <div class="row">
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Student ID: 
                                    <span class="control-field-info" ng-show="profileForm.student_id.$error.required">(Please enter student id)</span>
                                    <span class="required-field">*</span>
                                </label>
                                <input type="text" name="student_id" ng-model="profile.student_id" class="form-control" id="student_id" placeholder="Enter Student ID&hellip;" ng-model-options="{updateOn : '$inherit'}" required>
                            </div>
                            <div class="form-group">
                                <label>Last name: 
                                    <span class="control-field-info" ng-show="profileForm.lastname.$error.required">(Please enter last name)</span>
                                    <span class="required-field">*</span>
                                </label>
                                <input type="text" name="lastname" ng-model="profile.last_name" class="form-control" id="lastname" placeholder="Enter last name&hellip;" ng-model-options="{updateOn : '$inherit'}" required>
                            </div>
                            <div class="form-group">
                                <label>First name: 
                                    <span class="control-field-info" ng-show="profileForm.firstname.$error.required">(Please enter first name)</span>
                                    <span class="required-field">*</span>
                                </label>
                                <input type="text" name="firstname" ng-model="profile.first_name" class="form-control" id="firstname" placeholder="Enter first name&hellip;" ng-model-options="{updateOn : '$inherit'}" required>
                            </div>
                            <div class="form-group">
                                <label>Middle name: 
                                    <span class="control-field-info" ng-show="profileForm.middlename.$error.required">(Please enter middle name)</span>
                                    <span class="required-field">*</span>
                                </label>
                                <input type="text" name="middlename" ng-model="profile.middle_name" class="form-control" id="middlename" placeholder="Enter middle name&hellip;" ng-model-options="{updateOn : '$inherit'}" required>
                            </div>
                            <div class="form-group">
                                <label>Gender:
                                    <span class="control-field-info" ng-show="profileForm.gender.$error.required">(Please select gender)</span>
                                    <span class="required-field">*</span>
                                </label><br>
                                <label>
                                    <input type="radio" name="gender" name="r1" value="Female" ng-model="profile.gender">
                                    Female
                                </label>
                                <label>
                                    <input type="radio" name="gender" name="r1" value="Male" ng-model="profile.gender">
                                    Male
                                </label>
                            </div>   
                            <div class="form-group">
                                <label>Birthdate:
                                    <span class="control-field-info" ng-show="profileForm.birthdate.$error.required">(Please select birthdate)</span>
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
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection