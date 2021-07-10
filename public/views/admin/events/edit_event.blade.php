@extends('account-layout')

@section('title', 'Edit Event')

@section('content')

    @include('admin.admin_navbar')

    <script type="text/javascript" src="/js/services/admin/admin.events.service.js"></script>
    <script type="text/javascript" src="/js/controllers/admin/admin.edit.events.controller.js"></script>
    
    <script>
        var event_id = {!! json_encode($event['id']) !!};
    </script>
    
    <div class="content-wrapper" ng-controller="adminEditEventsController">
        <section class="content-header">
            <h1>Events</h1>
            <ol class="breadcrumb">
                <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="/admin/events">Events</a></li>
                <li>Edit Event</li>
                <li class="active">@{{systemHelper.trimString(event.description, 20)}}</li>
            </ol>
        </section>

        <section class="container">
            <br>
            <form name="editEventForm" novalidate ng-submit="saveUpdateEvent()" ng-model-options="{updateOn : 'submit'}">
                <div class="row">
                    <div class="col-md-11">
                        <div class="box box-success">
                            <div class="box-header">
                                <h3 class="box-title">Event Form</h3>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Event Description:</label>
                                            <div>
                                                <span class="text-red" ng-show="!isValid.description">
                                                    <i class="fa fa-warning"></i> Please enter description
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="Enter description&hellip;" ng-model="event.description">
                                        </div>       
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <label>Event Date:</label>
                                            <div>
                                                <span class="text-red" ng-show="!isValid.dates">
                                                    <i class="fa fa-warning"></i> Please select dates
                                                </span>
                                            </div>
                                            <div class="input-group" style="width:100%;">
                                                <button type="button" style="width:100%;" class="btn btn-default pull-right" id="daterange-btn">
                                                    <span>
                                                        @{{datetimeHelper.parseDate(event.date_from)}} - @{{datetimeHelper.parseDate(event.date_to)}}
                                                    </span>
                                                    <i class="fa fa-caret-down"></i>
                                                </button>
                                            </div>
                                        </div>        
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <label>Event Color:</label><br>
                                            <div>
                                                <span class="text-red" ng-show="!isValid.color">
                                                    <i class="fa fa-warning"></i> Please select color for the event
                                                </span>
                                            </div>
                                            <label>
                                                <input type="radio" value="red" name="color" ng-model="event.color"> <span class="text-red">Red</span>
                                            </label>
                                            <label>
                                                <input type="radio" value="blue"  name="color" ng-model="event.color"> <span class="text-blue">Blue</span>
                                            </label>
                                            <label>
                                                <input type="radio" value="green" name="color" ng-model="event.color"> <span class="text-green">Green</span>
                                            </label>
                                        </div>      
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
                        <div class="pull-right">
                            <button type="submit" class="btn btn-success">
                            <i class="fa fa-save"></i> Save
                            </button>
                            <a href="/admin/events" class="btn btn-danger">
                            <i class="fa fa-ban"></i> Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </form>
            
        </section>
    </div>
@endsection
