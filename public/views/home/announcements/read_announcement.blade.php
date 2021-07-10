@extends('home-layout')

@section('title')
   Read Announcement
@endsection

@section('content')

    @include('home.home_navbar')

    <script src="/js/services/home/home.announcements.service.js"></script>
    <script src="/js/controllers/home/home.read.announcement.controller.js"></script>
    <script src="/js/controllers/home/home.side.announcement.controller.js"></script>

    <link rel="stylesheet" type="text/css" href="/css/home/announcements.css" />

    <script>
        // Get announcement id
        var announcement_id = {!! json_encode($announcement_id) !!}
    </script>

    <div class="breadcrumb-section col2">
        <div id="breadcrumb">
            <ul>
            <li class="first">You Are Here</li>
            <li>&#187;</li>
            <li><a>Announcements</a></li>
            <li>&#187;</li>
            <li><a>Read announcements</a></li>
        </div>
    </div>
    <div class="col3 read-announcement-section" ng-controller="homeReadAnnouncementController">
        <div id="container">
            <div id="content">
                <label class="announcment-title">@{{announcement.title}}</label><b></b>
                <span><i class="far fa-clock"></i> @{{announcement.posted_date}}</span>
                <hr>
                <div ng-bind-html="announcement.description"></div>
            </div>
            <div id="column">

                <!-- #start Side announcement list -->
                @include('home.side_announcement')
                <!-- #end -->
            </div>
            <br class="clear" />
        </div>
    </div>
@endsection