<script src="/js/controllers/home/home.navbar.controller.js"></script>
<link rel="stylesheet" type="text/css" href="/css/home/navbar.css" />

<div class="col1" ng-controller="homeNavbarController">
    <!-- #start Header Section -->
  <div id="header">
    <div class="ics-information-header">
        <div class="ics-official-logo-section">
            <img ng-src="@{{ics_details.official_logo}}" />
        </div>
        <div class="ics-official-website-text-section" >
            <div class="text-section">
                <label class="organization-name">@{{ics_details.organization_name}}</label>
                <p>Official Website of @{{ics_details.organization_name}}</p>
            </div>
        </div>
    </div>
    <!-- #end -->

    <!-- #start Navigation Bar Section -->
    <div id="topnav">
        <ul>
            <li @if(Request::is('/')) class="active"  @endif ><a href="/">Home</a></li>
            <li @if(Request::is('about_us')) class="active"  @endif ><a href="/about_us">About Us</a></li>
            <li @if(Request::is('announcements')) class="active"  @endif ><a href="/announcements">Announcements</a></li>
            <li @if(Request::is('events')) class="active"  @endif ><a href="/events">Events</a></li>
        </ul>
        
        <ul class="sign-in-option">
            @if(!Session::has('user'))
                <li class="last"><a href="/access" > Sign in</a></li>
            @else
                <li class="last"><a href="/{{Session::get('user')->type}}" > Back Home</a></li>
            @endif
        </ul>
    </div>
    <!-- #end -->
    <br class="clear" />
  </div>
</div>
