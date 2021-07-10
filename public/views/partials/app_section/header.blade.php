<header class="main-header" ng-controller="account-details-controller">
    <!-- Logo -->
    <a href="/admin" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">ICS</span>
        <!-- logo for regular state and mobile devices <--></-->
        <span class="logo-lg"><b>WMSU</b> ICS</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less-->
            <!-- Admin account approval menu settings  -->
            @include('partials.navbar.account_approval_menu')
            
            <!-- Messages: style can be found in dropdown.less-->
            <!-- Subject approval menu settings -->
            @include('partials.navbar.subject_approval_menu')
                
            <!-- Messages: style can be found in dropdown.less-->
            <!-- Messages menu notifications -->
            
            <!-- Notifications: style can be found in dropdown.less -->
            <!-- Notifications menu -->
            @include('partials.navbar.notifications_menu')
            
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="control-sidebar">
                <div class="toolbar-header-settings-container">
                    <div class="toolbar-header-user-image-container img-circle">
                        <img class="profile_pic" />
                    </div>
                    
                    <span class="hidden-xs">@{{fullname()}}</span>
                </div>
                </a>
            </li>
            </ul>
        </div>
    </nav>
</header>