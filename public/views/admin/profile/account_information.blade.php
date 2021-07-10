@extends('account-layout')

@section('title', 'Account Information')

@section('content')

    @include('admin.admin_navbar')

    <script src="/js/services/admin/admin.profile.service.js"></script>
    <script src="/js/controllers/admin/admin.profile.controller.js"></script>

    <div class="content-wrapper" ng-controller="adminProfileController">
        <section class="content-header" >
            <h1>Account Information </h1>
            <ol class="breadcrumb">
                <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="/admin/profile">Profile</a></li>
                <li class="active">Account Information</li>
            </ol>
        </section>

        <section>
        <br>
        <form novalidate name="accountProfileForm" ng-submit="saveUpdateAccountInformation()" ng-model-options="{updateOn : 'submit'}">
            <div class="container"> 
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label for="emailaddress">Email Address:</label>
                            <div ng-show="accountProfileForm.email_address.$dirty && accountProfileForm.email_address.$invalid">
                                <span class="text-red" ng-show="accountProfileForm.email_address.$error.email">
                                    <i class="fa fa-warning"></i> Incorrect email address. Please enter a valid and active email address
                                </span>
                            </div>
                            <input type="email" name="email_address" ng-model="profile.email_address" class="form-control" id="email_address" placeholder="Enter last valid and active email address&hellip;" ng-model-options="{updateOn : '$inherit'}">
                        </div>
                        <div class="form-group">
                            <label>Username: 
                                <span class="control-field-info" ng-show="accountProfileForm.username.$error.required">(Please enter username)</span>
                                <span class="required-field">*</span>
                            </label>
                            <input type="text" name="username" ng-model="profile.username" class="form-control" id="username" placeholder="Enter username&hellip;" ng-model-options="{updateOn : '$inherit'}" required>
                        </div>
                        <div class="form-group">
                            <label>Password:</label>
                            <input type="password" name="password" ng-model="new_password" class="form-control" id="password" placeholder="Enter password&hellip;" ng-model-options="{updateOn: 'default'}">
                        </div>
                        <div class="form-group" ng-show="new_password !== ''">
                            <label>Confirm Password: 
                                <span class="control-field-info" ng-show="new_password !== '' && confirm_new_password === ''">(Please re enter password)</span>
                                <span class="control-field-info" ng-show="confirm_new_password !== '' && confirm_new_password !== new_password">(Password does not match)</span>
                            </label>
                            <input type="password" name="confirm_password" ng-model="confirm_new_password" class="form-control" placeholder="Enter re enter password&hellip;" ng-model-options="{updateOn: '$inherit'}">
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