@extends('home-layout')

@section('title')
    Home
@endsection

@section('content')

    @include('home.home_navbar')

    <script src="/js/controllers/home/home.controller.js"></script>

    <script src="/js/services/home/home.announcements.service.js"></script>
    <script src="/js/services/home/home.events.service.js"></script>

    <link rel="stylesheet" type="text/css" href="/css/home/announcements.css" />
    <link rel="stylesheet" type="text/css" href="/css/home/events.css" />

    <div class="col2" ng-controller="homeController">
        <div class="scroll-view-announcement-container" id="featured_slide">
            <div id="featured_content">
                <ul>
                    @foreach($announcements as $announcement)
                    <li>
                        <div class="announcement-item-content">
                            <div class="content-info">
                                <div class="title">
                                    <a href="/announcements/{{$announcement->announcement_id}}">{{$announcement->title}}</a>
                                </div>
                                <div class="description">
                                    {!! $announcement->description!!}
                                </div>
                            </div>
                            <div class="content-image">
                                <img src="/files/announcements/{{$announcement->generated_filename}}" />
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            <!-- # Replace this arrow with icons -->
            <a href="javascript:void(0);" id="featured-item-prev"><i class="fas fa-angle-left option-previous-announcement"></i></a> 
            <a href="javascript:void(0);" id="featured-item-next"><i class="fas fa-angle-right option-next-announcement"></i></a> 
        </div>
    </div>

    <!-- #start Latest announcements section -->
    <div class="wrapper col3" ng-controller="homeController">
        <div id="container">
            <div class="homepage">
                <label class="section-title"><i class="fas fa-scroll"></i> Latest Announcements</label> 
                <hr>
                <div class="latest-announcement-list">
                    <div ng-repeat="announcement in announcements" class="latest-announcement-item">
                        <div class="announcement-content">
                            <div class="header-section">
                                <div class="thumbnail">
                                    <img class="latest-announcement-image" ng-src="@{{announcement.image_path}}"/>
                                </div>
                                <div class="announcement-info">
                                    <span class="title">@{{announcement.title}}</span><br><br>
                                    <span class="posted-date"><i class="far fa-clock"></i> @{{announcement.posted_date}}</span>
                                </div>
                            </div>
                            <div class="content-section">
                                <div class="content">
                                    <p ng-bind-html="announcement.description"></p>
                                </div>
                            </div>
                        </div>
                        <div class="footer-section">
                            <p class="readmore"><a href="/announcements/@{{announcement.announcement_id}}">Continue Reading &raquo;</a></p>
                        </div>
                    </div>
                </div>
                <div class="see-more-announcements-section">
                    <a href="/announcements">See more announcements &raquo;</a>   
                </div>
                <br class="clear" />
            </div>
        </div>
    </div>
    <!-- #end -->
    
    <!-- #start Upcoming events section  -->
    <div class="col3" ng-controller="homeController">
        <div id="container">
            <div class="homepage">
                <label class="section-title"><i class="far fa-calendar-alt"></i> Upcoming Events</label> 
                <hr>
                <div class="upcoming-events-section">

                    <div  class="upcoming-event-list">

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

                    <div class="calendar-section">
                        <div ui-calendar="uiConfig" ng-model="eventSources"></div>
                    </div>
                </div>
                <div class="see-more-events-section">
                    <a href="/events">See more events &raquo;</a>   
                </div>

                <br class="clear" />
            </div>
        </div>
    </div>
    <!-- #end -->
@endsection