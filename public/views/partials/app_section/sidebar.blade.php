<aside class="control-sidebar control-sidebar-dark " >
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
    @if(Request::is('*/subject/*'))
        <li @if(Request::is('*/subject/*')) class="active" @endif>
            <a href="#control-sidebar-class-chat" data-toggle="tab"><i class="fa fa-comments"></i></a>
        </li>
    @endif
        <li @if(!Request::is('*/subject/*')) class="active" @endif>
            <a href="#control-sidebar-home-tab" data-toggle="tab">
                <i class="fa fa-list-ul"></i>
            </a>
        </li>
    </ul>
    
    <div class="tab-content" >
    <div class="tab-pane @if(!Request::is('*/subject/*')) active @endif side-bar-options" id="control-sidebar-home-tab" ng-controller="account-details-controller">
        <div class="row bg-green" style="padding:10px;">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12s">
            <center>
                <div class="right-navbar-menu-user-image-container img-circle">
                    <img class="profile_pic" />
                </div>
                <label> @{{fullname()}} </label> <br>
                <small>@{{account_position}}</small> <br>
                <small>Member since <span>@{{dateMembership}}</span></small>
            </center>
        </div>
        </div>
        <ul class="control-sidebar-menu">
        <li>
            <a href="/@if(Request::is('admin*'))admin/profile @elseif(Request::is('student*'))student/profile @elseif(Request::is('teacher*'))teacher/profile @endif">
                <i class="menu-icon fa fa-user bg-green"></i>  
                <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Profile</h4>
                    <p>Manage profile information</p>
                </div>
            </a>
        </li>
        <li>
            <a href="/">
                <i class="menu-icon fa fa-home bg-purple"></i>  
                <div class="menu-info">
                    <h4 class="control-sidebar-subheading">View Home</h4>
                    <p>View home web page</p>
                </div>
            </a>
        </li>
        @if(Request::is('admin*'))
            <!-- <li>
            <a href="/admin/view_as_student">
                <i class="menu-icon fa fa-users bg-yellow"></i>  
                <!-- <div class="menu-info">
                <h4 class="control-sidebar-subheading">View as Student</h4>
                <p>View account as student</p>
                </div> 
            </a>
            </li> 
            <li>
            <a href="/admin/view_as_faculty">
                <i class="menu-icon fa fa-briefcase bg-orange"></i>  
                <!-- <div class="menu-info">
                <h4 class="control-sidebar-subheading">View as Faculty</h4>
                <p>View account as faculty</p>
                </div> 
            </a>
            </li>-->
        <li>
            <a href="/admin/settings">
            <i class="menu-icon fa fa-gear bg-gray"></i>  
            <div class="menu-info">
                <h4 class="control-sidebar-subheading">Settings</h4>
                <p>Manage system settings</p>
            </div>
            </a>
        </li>
        @endif
        <li>
            <a href="/access/sign_out">
            <i class="menu-icon fa fa-sign-out bg-light-blue"></i>
            <div class="menu-info">
                <h4 class="control-sidebar-subheading">Sign out</h4>
                <p>End current session</p>
            </div>
            </a>
        </li>
        </ul>
    </div>
    @if(Request::is('*/subject/*'))
    <div class="tab-pane @if(Request::is('*/subject/*')) active @endif side-bar-options " id="control-sidebar-class-chat" >
        @include('partials.app_section.chat')
    </div>
    @endif 
    </div>
</aside>
<!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>