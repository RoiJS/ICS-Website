@extends('account-layout')

@section('title', 'Personal Information')

@section('content')

    @include('admin.admin_navbar')

    <script src="/js/services/admin/admin.profile.service.js"></script>
    <script src="/js/controllers/admin/admin.profile.controller.js"></script>

    <div class="content-wrapper" ng-controller="adminProfileController">
        <section class="content-header">
            <h1><i class="fa fa-user"></i> Personal Information </h1>
            <ol class="breadcrumb">
                <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="/admin/profile">Profile</a></li>
                <li class="active">Personal Information</li>
            </ol>
        </section>

        <section>
            <br>
            <form novalidate name="profileForm" ng-submit="saveNewPersonalInformation()" ng-model-options="{updateOn : 'submit'}">
                <div class="container" > 
                    <label class="lbl-note-message">Note: (<span class="required-field">*</span>) Required Fields</label> <br>
                    <div class="row">
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Last name: 
                                    <span class="control-field-info" ng-show="profileForm.last_name.$error.required">(Please enter last name)</span>
                                    <span class="required-field">*</span>
                                </label>
                                <input type="text" name="last_name" ng-model="profile.last_name" class="form-control" id="lastname" placeholder="Enter last name&hellip;" ng-model-options="{updateOn : '$inherit'}" required>
                            </div>
                            <div class="form-group">
                                <label>First name: 
                                    <span class="control-field-info" ng-show="profileForm.first_name.$error.required">(Please enter first name)</span>
                                    <span class="required-field">*</span>
                                </label>
                                <input type="text" name="first_name" ng-model="profile.first_name" class="form-control" id="firstname" placeholder="Enter first name&hellip;" ng-model-options="{updateOn : '$inherit'}" required>
                            </div>
                            <div class="form-group">
                                <label>Middle name: 
                                    <span class="control-field-info" ng-show="profileForm.middle_name.$error.required">(Please enter middle name)</span>
                                    <span class="required-field">*</span>
                                </label>
                                <input type="text" name="middle_name" ng-model="profile.middle_name" class="form-control" id="middlename" placeholder="Enter middle name&hellip;" ng-model-options="{updateOn : '$inherit'}" required>
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