<script type="text/javascript" src="/js/services/teacher/teacher.chat.service.js"></script>
<script type="text/javascript" src="/js/services/teacher/teacher.navbar.service.js"></script>
<script type="text/javascript" src="/js/controllers/teacher/teacher.navbar.controller.js"></script>

<link rel="stylesheet" href="/css/shared/navbar.css">

<aside class="main-sidebar" >
<!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel" ng-controller="account-details-controller">
            <div class="pull-left user-image-container">
                <img class="profile_pic" />
            </div>
            <div class="pull-left info">
                <p>@{{account_name}} </p>
                <i class="fa fa-circle text-success"></i> <a>@{{account_position}}</a><br>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" ng-controller="teacher-navbar-controller">
            <li class="header">MAIN NAVIGATION</li>
            <li class="@{{systemHelper.activePage(['/teacher/dashboard', '/teacher/', '/teacher']) }} treeview">
                <a href="/teacher/">
                    <i class="fa fa-dashboard"></i>     
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-book"></i> 
                    <span>Subjects</span> 
                    <span class="pull-right-container">
                        <span class="label label-success pull-right">@{{number_of_subjects}}</span>
                    </span>
                </a>
                <ul class="treeview-menu menu-open" style="display:block;">
                    <li ng-repeat="subject in subjects">
                        <a title="@{{subject.subject_description}}" href="/teacher/subject/@{{subject.class_id}}/posts"><i class="fa fa-circle-o"></i> @{{systemHelper.trimString(subject.subject_description, 20)}}</a>
                    </li>
                </ul>
            </li>
            <!-- <li class="@{{helper.activePage(['/teacher/chat', '/teacher/chat/'])}} treeview">
                <a href="/teacher/chat">
                    <i class="fa fa-comments"></i>
                    <span>Chat</span> 
                    <span class="pull-right-container" ng-if="new_messages_count > 0">
                        <span class="label label-success pull-right" >@{{badge_message}}</span>
                    </span>
                </a>
            </li> -->
            <!-- <li class="@{{helper.activePage(['/teacher/messages', '/teacher/messages/'])}} treeview">
                <a href="/teacher/messages/inbox">
                    <i class="fa fa-envelope"></i>
                    <span>Messages</span> 
                </a>
            </li> -->
        </ul>
    </section>
<!-- /.sidebar -->
</aside>
