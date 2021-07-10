@extends('account-layout')

@section('title', 'Events')

@section('content')

    @include('admin.admin_navbar')

    <script type="text/javascript" src="/js/services/admin/admin.events.service.js"></script>
    <script type="text/javascript" src="/js/controllers/admin/admin.events.controller.js"></script>
    
    <div class="content-wrapper" ng-controller="adminEventsController">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Events</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Events</li>
            </ol>
        </section>

        <section class="container">
            <br>
            <div class="row" ng-show="status.data_loading">
                <div class="col-md-12">
                    <i class="fa fa-refresh fa-spin"></i> <span> Loading&hellip; </span>
                </div>
            </div>
            <br>
            <div class="row "ng-show="!status.data_loading" >
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div role="tabpanel" class="nav-tabs-custom tab-success">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="hidden">
                                        <a href="#calendar-view" aria-controls="home" role="tab" data-toggle="tab">Event Calendar</a>
                                    </li>
                                    <li role="presentation" class="active">
                                        <a href="#list-view" aria-controls="tab" role="tab" data-toggle="tab">Event List</a>
                                    </li>
                                </ul>
                            </div>            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane hidden" id="calendar-view">
                                    <div class="box box-success">
                                        <div class="box-body no-padding">
                                            <div id="calendar"></div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane active" id="list-view">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="box box-success">
                                                <div class="box-body">
                                                    <table ng-table="tableEvents" class="table table-bordered table-striped" show-filter="true">
                                                        <tr ng-repeat="event in $data">
                                                            <td title="'Date'" sortable="event_date" filter="{ event_date: 'text' }">@{{event.event_date}}</td>
                                                            <td title="'Description'" sortable="description" filter="{ description: 'text' }">@{{event.description}}</td>
                                                            <td title="''">
                                                                <a ng-href="events/edit_event/@{{event.event_id}}" class="btn btn-success">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                            </td>
                                                            <td title="''"><button type="button" class="btn btn-danger" ng-click="removeEvent($index)">
                                                                <i class="fa fa-trash"></i>
                                                                </button>
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
                </div>
                 <div class="col-md-4">
                    <div class="box box-success">
                         <div class="box-header">
                            <h3 class="box-title">Create Event</h3>
                        </div>
                       <form name="eventForm" novalidate ng-submit="saveNewEvent()" ng-model-options="{updateOn : 'submit'}">
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Event Description:</label>
                                    <div>
                                        <span class="text-red" ng-show="!isValid.description">
                                            <i class="fa fa-warning"></i> Please enter description
                                        </span>
                                    </div>
                                    <input type="text" ng-model="event.description" name="event_description" class="form-control" placeholder="Enter description&hellip;" required>
                                </div>
                                <div class="form-group">
                                    <label>Event Date:</label>
                                    <div>
                                        <span class="text-red" ng-show="!isValid.dates">
                                            <i class="fa fa-warning"></i> Please select dates
                                        </span>
                                    </div>
                                    <div class="input-group" style="width:100%;">
                                        <button type="button" style="width:100%;" class="btn btn-default pull-right" id="daterange-btn">
                                            <span>Date Range Picker</span>
                                            <i class="fa fa-caret-down"></i>
                                        </button>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label>Event Color:</label><br>
                                    <div>
                                        <span class="text-red" ng-show="!isValid.color">
                                            <i class="fa fa-warning"></i> Please select color for the event
                                        </span>
                                    </div>
                                    <label>
                                        <input type="radio" value="red" name="event_color" ng-model="event.color" ng-required="!event.color"> <span class="text-red">Red</span>
                                    </label>
                                    <label>
                                        <input type="radio" value="blue"  name="event_color" ng-model="event.color" ng-required="!event.color"> <span class="text-blue">Blue</span>
                                    </label>
                                    <label>
                                        <input type="radio" value="green" name="event_color" ng-model="event.color" ng-required="!event.color"> <span class="text-green">Green</span>
                                    </label>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
