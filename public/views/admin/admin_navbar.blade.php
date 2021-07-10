<script type="text/javascript" src="/js/controllers/admin/admin.navbar.controller.js"></script>

<aside class="main-sidebar" ng-controller="admin-navbar-controller">
<!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel" ng-controller="account-details-controller">
            <div class="pull-left img-circle navbar-menu-user-image-container">
                <img class="profile_pic user-image" />
            </div>
            <div class="pull-left info">
                <p>@{{semifullname()}} </p>
                <i class="fa fa-circle text-success"></i> <a>@{{account_position}}</a><br>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header"><center>MAIN NAVIGATION</center></li>
            <li class="@{{systemHelper.activePage(['/admin/', '/admin'])}} treeview">
                <a href="/admin">
                    <i class="fa fa-dashboard"></i> 
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="@{{systemHelper.activePage(['/admin/ics_details', '/admin/ics_details/'])}} treeview">
                <a href="/admin/ics_details">
                    <i class="fa fa-info-circle"></i> 
                    <span>ICS Details</span>
                </a>
            </li>
            <li class="@{{systemHelper.activePage(['/admin/announcements', '/admin/announcements/'])}} treeview">
                <a href="/admin/announcements">
                    <i class="fa fa-bullhorn"></i> 
                    <span>Announcements</span> 
                    <span class="pull-right-container">
                        <span class="label label-warning pull-right">@{{status[0]}}</span>
                    </span>
                </a>
            </li>
            <li class="@{{systemHelper.activePage(['/admin/events', '/admin/events/'])}} treeview">
                <a href="/admin/events">
                    <i class="fa fa-calendar"></i>
                    <span>Events</span> 
                    <span class="pull-right-container">
                        <span class="label label-warning pull-right">@{{status[1]}}</span>
                    </span>
                </a>
            </li>
            <!-- <li class="@{{systemHelper.activePage(['/admin/inbox','/admin/inbox/', '/admin/sent','/admin/sent/'])}} treeview">
                <a href="/admin/messages/inbox">
                    <i class="fa fa-envelope"></i>
                    <span>Messages</span> 
                    <span class="pull-right-container">
                        <span class="label label-warning pull-right"></span>
                    </span>
                </a>
            </li> -->
            <li class="header">INSTITUTE INFORMATION</li>
            <li class="@{{systemHelper.activePage(['/admin/students', '/admin/students/'])}} treeview">
                <a href="/admin/students">
                    <i class="fa fa-users"></i>
                    <span>Student List</span> 
                    <span class="pull-right-container">
                        <span class="label label-warning pull-right">@{{status[2]}}</span>
                    </span>
                </a>
            </li>
            
            <li class="@{{systemHelper.activePage(['/admin/faculty', '/admin/faculty/'])}} treeview">
                <a href="#">
                    <i class="fa fa-briefcase"></i> 
                    <span>Faculty</span> 
                    <span class="pull-right-container">
                        <span class="label label-warning pull-right">@{{status[3]}}</span>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/admin/faculty"><i class="fa fa-circle-o"></i> List</a></li>
                    <li><a href="/admin/load"><i class="fa fa-circle-o"></i> Load</a></li>
                </ul>
            </li>
            <li class="@{{systemHelper.activePage(['/admin/classes','/admin/classes/'])}} treeview">
                <a href="/admin/classes">
                    <i class="fa fa-folder"></i> 
                    <span>Class List</span>
                    <span class="pull-right-container">
                        <span class="label label-warning pull-right">@{{status[4]}}</span>
                    </span>
                </a>
            </li>
            <li class="@{{systemHelper.activePage(['/admin/subjects','/admin/subjects/'])}} treeview">
                <a href="/admin/subjects">
                    <i class="fa fa-book"></i> 
                    <span>Subject List</span>
                    <span class="pull-right-container">
                        <span class="label label-warning pull-right">@{{status[5]}}</span>
                    </span>
                </a>
            </li>
            <li class="@{{systemHelper.activePage(['/admin/courses','/admin/courses/'])}} treeview">
                <a href="/admin/courses">
                    <i class="fa fa-laptop"></i> 
                    <span>Course List</span>
                    <span class="pull-right-container">
                        <span class="label label-warning pull-right">@{{status[6]}}</span>
                    </span>
                </a>
            </li>
            <li class="@{{systemHelper.activePage(['/admin/curriculum','/admin/curriculum/'])}} treeview">
                <a href="/admin/curriculum">
                    <i class="fa fa-list"></i> 
                    <span>Curriculum</span>
                    <span class="pull-right-container">
                        <span class="label label-warning pull-right">@{{status[7]}}</span>
                    </span>
                </a>
            </li>
        </ul>
    </section>
<!-- /.sidebar -->
</aside>