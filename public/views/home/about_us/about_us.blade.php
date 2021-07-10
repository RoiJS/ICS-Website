@extends('home-layout')

@section('title')
    About Us
@endsection

@section('content')

    @include('home.home_navbar')

    <script src="/js/services/home/home.announcements.service.js"></script>
    <script src="/js/controllers/home/home.about.us.controller.js"></script>
    <script src="/js/controllers/home/home.side.announcement.controller.js"></script>

    <link rel="stylesheet" href="/css/home/about_us.css">
    <link rel="stylesheet" href="/css/home/announcements.css">

    <div class="breadcrumb-section col2">
        <div id="breadcrumb">
            <ul>
            <li class="first">You Are Here</li>
            <li>&#187;</li>
            <li><a>About Us</a></li>
        </div>
    </div>
    <div class="col3" ng-controller="aboutUsController">
        <div id="container">
            <div id="content">
                <label class="page-title"><i class="fas fa-info-circle"></i> About us</label>
                <div class="homepage">
                    <div class="ics-details-section ics-box">
                        <div class="ics-details-header">
                            <label><i class="fas fa-history"></i> History</label>
                        </div>
                        <div class="ics-details-content">
                            <p ng-bind-html="ics_details.history"></p>
                        </div>
                    </div>

                    <div class="ics-details-section ics-box">
                        <div class="ics-details-header">
                            <label><i class="fas fa-list-ul"></i> Mission</label>
                        </div>
                        <div class="ics-details-content">
                            <p ng-bind-html="ics_details.mission"></p>
                        </div>
                    </div>

                    <div class="ics-details-section ics-box">
                        <div class="ics-details-header">
                            <label><i class="far fa-eye"></i> Vision</label>
                        </div>
                        <div class="ics-details-content">
                            <p ng-bind-html="ics_details.vision"></p>
                        </div>
                    </div>
                    
                    <div class="ics-details-section ics-box">
                        <div class="ics-details-header">
                            <label><i class="far fa-check-circle"></i> Objectives</label>
                        </div>
                        <div class="ics-details-content">
                            <p ng-bind-html="ics_details.objectives"></p>
                        </div>
                    </div>
                    
                    <div class="ics-details-section ics-box">
                        <div class="ics-details-header">
                            <label><i class="fas fa-chart-line"></i> Goals</label>
                        </div>
                        <div class="ics-details-content">
                            <p ng-bind-html="ics_details.goals"></p>
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