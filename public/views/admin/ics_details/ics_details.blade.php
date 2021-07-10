@extends('account-layout')

@section('title', 'ICS Details')

@section('content')

    @include('admin.admin_navbar')

    <script src="/js/services/admin/admin.ics.details.service.js"></script>
    <script src="/js/controllers/admin/admin.ics.details.controller.js"></script>

    <link rel="stylesheet" href="/css/admin/ics_details.css">  

    <div class="content-wrapper">
        <section class="content-header">
            <h1>ICS Details</h1>
            <ol class="breadcrumb">
                <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">ICS Details</li>
            </ol>
        </section>

        <section class="content" ng-controller="icsDetailsController">
            
            <div class="row">
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="nav-tabs-custom tab-success">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#mission" data-toggle="tab">Mission</a></li>
                                    <li><a href="#vision" data-toggle="tab">Vision</a></li>
                                    <li><a href="#goals" data-toggle="tab">Goals</a></li>
                                    <li><a href="#objectives" data-toggle="tab">Objectives</a></li>
                                    <li><a href="#history" data-toggle="tab">History</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tab-content">
                                <div class="tab-pane active" id="mission">
                                    <div class="box box-success">
                                        <div class="box-header with-border">
                                            <h3>Mission</h3>
                                        </div>
                                        <div class="box-body">
                                            <form>
                                                <textarea class="textarea mission" placeholder="Place some text here&hellip;">{{$detail->mission}}</textarea>
                                            </form>
                                        </div>
                                        <div class="box-footer">
                                            <button type="button" class="btn btn-success" ng-click="saveNewMission()" >Update</button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="tab-pane" id="vision">
                                    <div class="box box-success">
                                        <div class="box-header with-border">
                                            <h3>Vision</h3>
                                        </div>
                                        <div class="box-body">
                                            <form>
                                                <textarea class="textarea vision" placeholder="Place some text here&hellip;">{{$detail->vision}}</textarea>
                                            </form>
                                        </div>
                                        <div class="box-footer">
                                            <button type="button" class="btn btn-success" ng-click="saveNewVision()">Update</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="goals">
                                    <div class="box box-success">
                                        <div class="box-header with-border">
                                            <h3>Goals</h3>
                                        </div>
                                        <div class="box-body">
                                            <form>
                                                <textarea class="textarea goals" placeholder="Place some text here&hellip;">{{$detail->goals}}</textarea>
                                            </form>
                                        </div>
                                        <div class="box-footer">
                                            <button type="button" class="btn btn-success" ng-click="saveNewGoals()">Update</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="objectives">
                                    <div class="box box-success">
                                        <div class="box-header with-border">
                                            <h3>Objectives</h3>
                                        </div>
                                        <div class="box-body">
                                            <form>
                                                <textarea class="textarea objectives" placeholder="Place some text here&hellip;">{{$detail->objectives}}</textarea>
                                            </form>
                                        </div>
                                        <div class="box-footer">
                                            <button type="button" class="btn btn-success" ng-click="saveNewObjectives()">Update</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="history">
                                    <div class="box box-success">
                                        <div class="box-header with-border">
                                            <h3>History</h3>
                                        </div>
                                        <div class="box-body">
                                            <form>
                                                <textarea class="textarea history" placeholder="Place some text here&hellip;">{{$detail->history}}</textarea>
                                            </form>
                                        </div>
                                        <div class="box-footer">
                                            <button type="button" class="btn btn-success" ng-click="saveNewHistory()">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>        
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="box-group" id="accordion">
                        <div class="panel box box-success panel-contact-information">
                            <div class="box-header with-border">
                                <h4 class="box-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                    Contact Information
                                </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- Organizaition Name Form -->
                                            <form novalidate name="organizationNameForm" ng-submit="saveNewOrganizationName()">
                                                <div class="form-group">
                                                    <label> Organization name:</label>
                                                    <div class="row">
                                                        <div ng-if="!edit.organization_name">
                                                            <div class="col-md-9">
                                                                <h5 ng-bind="details.organization_name"></h3> 
                                                            </div>
                                                            <div class="col-md-3">
                                                                <button type="button" class="btn btn-success btn-block" ng-click="edit.organization_name = true"><i class="fa fa-edit"></i></button>
                                                            </div>
                                                        </div>
                                                        <div ng-if="edit.organization_name">
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                        <div class="input-group">
                                                                            <div class="input-group-addon">
                                                                                <i class="fa fa-location-arrow"></i>
                                                                            </div>
                                                                            <input type="text" name="organization_name" class="form-control col-md-5" placeholder="Enter Organization name&hellip;" ng-model="details.organization_name" ng-model-options="{updateOn : 'submit'}" required>
                                                                        </div>
                                                                        
                                                                        <div ng-show="organizationNameForm.organization_name.$dirty && organizationNameForm.organization_name.$invalid">
                                                                            <span class="text-red" ng-show="organizationNameForm.organization_name.$error.required">
                                                                                <i class="fa fa-warning"></i> Please enter organization name 
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br>
                                                                <div class="row">
                                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                        <div class="pull-right">
                                                                            <button class="btn btn-primary" type="submit" ng-disabled="!details.organization_name"><i class="fa fa-save"></i></button>
                                                                            <button class="btn btn-danger" type="button" ng-click="edit.organization_name = false"><i class="fa fa-ban"></i></button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                            <!-- Address Form -->
                                            <form novalidate name="addressForm" ng-submit="saveNewAddress()">
                                                <div class="form-group">
                                                    <label> Address:</label>
                                                    <div class="row">
                                                        <div ng-if="!edit.address">
                                                            <div class="col-md-9">
                                                                <h5 ng-bind="details.address"></h3> 
                                                            </div>
                                                            <div class="col-md-3">
                                                                <button type="button" class="btn btn-success btn-block" ng-click="edit.address = true"><i class="fa fa-edit"></i></button>
                                                            </div>
                                                        </div>
                                                        <div ng-if="edit.address">
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                        <div class="input-group">
                                                                            <div class="input-group-addon">
                                                                                <i class="fa fa-location-arrow"></i>
                                                                            </div>
                                                                            <input type="text" name="address" class="form-control col-md-5" placeholder="Enter Address&hellip;" ng-model="details.address" ng-model-options="{updateOn : 'submit'}" required>
                                                                        </div>
                                                                        
                                                                        <div ng-show="addressForm.address.$dirty && addressForm.address.$invalid">
                                                                            <span class="text-red" ng-show="addressForm.address.$error.required">
                                                                                <i class="fa fa-warning"></i> Please enter address 
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br>
                                                                <div class="row">
                                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                        <div class="pull-right">
                                                                            <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i></button>
                                                                            <button class="btn btn-danger" type="button" ng-click="edit.address = false"><i class="fa fa-ban"></i></button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            
                                            <!-- Telephone number form -->
                                            <form name="telNumberForm" novalidate ng-submit="saveNewTelNumber()">
                                                <div class="form-group">
                                                    <label>Telephone number:</label>
                                                    <div class="row">
                                                        <div ng-if="!edit.tel_number">
                                                            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                                                <h5 ng-bind="details.tel_number"></h5>
                                                            </div>
                                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                                <button type="button" class="btn btn-success btn-block" ng-click="edit.tel_number = !edit.tel_number"><i class="fa fa-edit"></i></button>
                                                            </div>      
                                                        </div>
                                                        
                                                        <div ng-if="edit.tel_number">
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                        <div class="input-group">
                                                                            <div class="input-group-addon">
                                                                                <i class="fa fa-phone"></i>
                                                                            </div>
                                                                            <input type="text" name="tel_number" class="form-control" placeholder="Enter Telephone number&hellip;" ng-model="details.tel_number" ng-model-options="{updateOn : 'submit'}" required>
                                                                        </div>
                                                                        <div ng-show="telNumberForm.tel_number.$dirty && telNumberForm.tel_number.$invalid">
                                                                            <span class="text-red" ng-show="telNumberForm.tel_number.$error.required">
                                                                                <i class="fa fa-warning"></i> Please enter telephone number 
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br>
                                                                <div class="row">
                                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                        <div class="pull-right">
                                                                            <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i></button>
                                                                            <button class="btn btn-danger" type="button" ng-click="edit.tel_number = !edit.tel_number"><i class="fa fa-ban"></i></button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                            <!-- Email address Form -->
                                            <form novalidate name="emailAddressForm" ng-submit="saveNewEmailAddress()">
                                                <div class="form-group">
                                                    <label>Email Address:</label>

                                                    <div ng-if="!edit.email_address">
                                                        <div class="row">
                                                            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                                                <h5 ng-bind="details.email_address"></h5>
                                                            </div>
                                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                                <button type="button" class="btn btn-success btn-block" ng-click="edit.email_address = !edit.email_address"><i class="fa fa-edit"></i></button>
                                                            </div>   
                                                        </div>
                                                    </div>

                                                    <div ng-if="edit.email_address">
                                                         <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                    <div class="input-group">
                                                                        <div class="input-group-addon">
                                                                            <i class="fa fa-envelope"></i>
                                                                        </div>
                                                                        <input type="email" name="email_address" class="form-control" placeholder="Enter email address&hellip;" ng-model="details.email_address" ng-model-options="{updateOn : 'submit'}" required>
                                                                    </div>
                                                                    <div ng-show="emailAddressForm.email_address.$dirty && emailAddressForm.email_address.$invalid">
                                                                        <span class="text-red" ng-show="emailAddressForm.email_address.$error.required">
                                                                            <i class="fa fa-warning"></i> Please enter email address 
                                                                        </span>
                                                                        <span class="text-red" ng-show="emailAddressForm.email_address.$error.email">
                                                                            <i class="fa fa-warning"></i> Please enter a valid email address
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                    <div class="pull-right">
                                                                        <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i></button>
                                                                        <button class="btn btn-danger" type="button" ng-click="edit.email_address = !edit.email_address"><i class="fa fa-ban"></i></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                </div>
                                            </form>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel box box-success panel-official-logo">
                            <div class="box-header with-border">
                                <h4 class="box-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                    Official Logo
                                </a>
                                </h4>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="exampleInputEmail1">Official Logo:</label>
                                            <hr>
                                            <div class="row">
												<div class="col-lg-12 ">
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
												</div>
                                            </div>
                                            <br>  
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="official-logo-section logo-image-container">
                                                        <img class="img-responsive img-thumbnail preview_image ics-logo" />
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <form ng-submit="saveNewLogo()">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="file" class="form-control" file-model="details.logo" onchange="angular.element(this).scope().imageFileHelper.viewImage(this, true)" accept="image/*" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <button type="submit" class="btn btn-success"><i class="fa fa-upload"> </i> Upload</button>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <br>
                                                        <small><b>Notes: </b></small><br>
                                                        <small><b>*</b> Only <i>.jpeg, .png, .jpg &amp; .gif are supported.</i></small><br>
                                                        <small><b>*</b> Image dimension must be portait oriented. </i></small><br>
                                                        <small><b>*</b> Image width and height must be between 250 and 500 pixels </i></small><br>
                                                    </div>
                                                </div>
                                            </form>
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
