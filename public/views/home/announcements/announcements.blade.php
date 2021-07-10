@extends('home-layout')

@section('title')
   Announcements
@endsection

@section('content')

    @include('home.home_navbar')
    
    <script src="/js/services/home/home.announcements.service.js"></script>
    <script src="/js/controllers/home/home.announcements.controller.js"></script>
    <script src="/js/controllers/home/home.side.announcement.controller.js"></script>

    <link rel="stylesheet" type="text/css" href="/css/home/announcements.css" />

    <div class="breadcrumb-section col2">
        <div id="breadcrumb">
            <ul>
            <li class="first">You Are Here</li>
            <li>&#187;</li>
            <li><a>Announcements</a></li>
        </div>
    </div>
    <div class="col3 announcement-list" ng-controller="homeAnnouncementController">
        <div id="container">
            <div id="content">
                <label class="page-title"><i class="fas fa-bullhorn"></i> Announcements</label>
                <div class="homepage">
                    <!-- #start Announcement list -->
                    <table ng-table="tableAnnouncementList" class="announcement-list table">
                        <tr ng-repeat="announcement in $data">
                            <td>
                                <div class="announcement-item ics-box">
                                    <div class="image-section">
                                        <div class="image-container">
                                            <img ng-src="@{{announcement.image_path}}"/>
                                        </div>
                                    </div>
                                    <div class="information-section">
                                        <div class="header-section">
                                            <label class="title">@{{announcement.title}}</label>
                                            <span class="posted-date"><i class="far fa-clock"></i> @{{announcement.posted_date}}</span>
                                        </div>
                                        <div class="content-section">
                                            <div class="description">@{{announcement.description}}</div>
                                        </div>
                                        <div class="read-more-section">
                                            <a href="/announcements/@{{announcement.announcement_id}}">Read more &raquo;</a>   
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <!-- #end -->
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