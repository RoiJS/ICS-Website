<script type="text/javascript" src="/js/services/student/student.chat.service.js"></script>
<script type="text/javascript" src="/js/services/student/student.navbar.service.js"></script>
<script type="text/javascript" src="/js/controllers/student/student.navbar.controller.js"></script>

<link rel="stylesheet" href="/css/shared/navbar.css">

<aside class="main-sidebar" >
<!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel" ng-controller="account-details-controller" style="height:80px;">
            <div class="pull-left user-image-container">
                <img class="profile_pic" />
            </div>
            <div class="pull-left info">
                <p>@{{account_name}} </p>
                <i class="fa fa-circle text-success"></i> <a>@{{account_position}}</a><br>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" ng-controller="student-navbar-controller">
            <li class="header">MAIN NAVIGATION</li>
            <li class="@{{systemHelper.activePage(['/student/dashboard', '/student/', '/student']) }} treeview">
                <a href="/student/">
                    <i class="fa fa-dashboard"></i>     
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-book"></i> 
                    <span>Subjects</span> 
                    <span class="pull-right-container">
                        <span class="label label-success pull-right" ng-show="number_of_subjects > 0">@{{number_of_subjects}}</span>
                    </span>
                </a>
                <ul class="treeview-menu menu-open" style="display:block;">
                    <li ng-repeat="subject in subjects" ng-show="number_of_subjects > 0">
                        <a title="@{{subject.subject_description}}" href="/student/subject/@{{subject.class_id}}/posts"><i class="fa fa-circle-o"></i> @{{subject.subject_name}}</a>
                    </li>
                    <li>
                        <a href="/student/enroll_subjects"><i class="fa fa-bookmark"></i> Enroll Subjects</a>
                    </li>
                </ul>
            </li>
            <!-- <li class="@{{systemHelper.activePage(['/student/chat', '/student/chat/'])}} treeview">
                <a href="/student/chat">
                    <i class="fa fa-comments"></i>
                    <span>Chat</span> 
                    <span class="pull-right-container" ng-if="new_messages_count > 0">
                        <span class="label label-success pull-right" >@{{badge_message}}</span>
                    </span>
                </a>
            </li> -->
            <!-- <li class="@{{systemHelper.activePage(['/student/messages', '/student/messages/'])}} treeview">
                <a href="/student/messages/inbox">
                    <i class="fa fa-envelope"></i>
                    <span>Messages</span> 
                </a>
            </li> -->
        </ul>
    </section>
<!-- /.sidebar -->
</aside>