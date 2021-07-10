@extends('home-layout')

@section('title')
   Events
@endsection

@section('content')

    @include('home.home_navbar')
        
    <script src="/js/services/home/home.events.service.js"></script>
    <script src="/js/services/home/home.announcements.service.js"></script>

    <script src="/js/controllers/home/home.events.controller.js"></script>
    <script src="/js/controllers/home/home.side.announcement.controller.js"></script>

    <link rel="stylesheet" href="/css/home/announcements.css">
    <link rel="stylesheet" href="/css/home/events.css">

    <div class="breadcrumb-section col2">
        <div id="breadcrumb">
            <ul>
            <li class="first">You Are Here</li>
            <li>&#187;</li>
            <li><a>Events</a></li>
        </div>
    </div>

    <div class="col3" ng-controller="homeEventController">
        <div id="container">

            <div id="content">
                <label class="page-title"><i class="far fa-calendar-alt"></i> Events</label>
                <div class="homepage">
                    <div class="all-events-section upcoming-events-section">
                        <div class="calendar-section">
                            <div ui-calendar="uiConfig" ng-model="eventSources"></div>
                        </div>
                        <div class="upcoming-event-list">
                            <div ng-repeat="event in events" class="upcoming-event-item">
                                    <div ng-if="event.has_date_from" class="event-date-from-section">
                                        <div class="event-date">
                                            <span class="day">@{{event.date_from_no}}</span>
                                            <span class="month">@{{event.date_from_month_name}}</span>
                                        </div>
                                    </div>
                                    <label  ng-if="event.has_date_to" class="event-to-text">To</label>  
                                    <div  ng-if="event.has_date_to" class="event-date-to-section">
                                        <div class="event-date">
                                            <span class="day">@{{event.date_to_no}}</span>
                                            <span class="month">@{{event.date_to_month_name}}</span>
                                        </div>
                                    </div>
                                    <div class="event-name-section">
                                        <span class="event-name">@{{event.description}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="column">
                    <div class="subnav">
                        <h2>Secondary Navigation</h2>
                        <ul>
                            <li><a href="/">Home</a></li>
                            <li><a href="/about_us">About us</a>
                            <li><a href="/announcements">Announcements</a>
                            <li><a href="/events">Events</a>
                            <li><a href="/access">Sign in</a>
                        </ul>
                    </div>

                    <!-- #start Side announcement list -->
                    @include('home.side_announcement')
                    <!-- #end -->
                </div>

                <br class="clear" />
            </div>
        </div>
    
@endsection