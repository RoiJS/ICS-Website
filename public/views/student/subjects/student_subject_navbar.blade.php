<script type="text/javascript" src="/js/services/shared/account.post.service.js"></script>
<script type="text/javascript" src="/js/services/shared/account.class.list.service.js"></script>
<script type="text/javascript" src="/js/services/shared/account.homeworks.service.js"></script>

<script type="text/javascript" src="/js/controllers/student/student.subject.navbar.controller.js"></script>

<link rel="stylesheet" href="/css/shared/navbar.css">

<script>
    // Get current class id
    var ClassGlobalVariable = {
        currentClassId: {!! json_encode($id); !!},
        currentClassDescription: {!! json_encode($subject['description']); !!},
        currentClassCode: {!! json_encode($subject['code']); !!},
        currentClassTeacherId: {!! json_encode($subject['teacher_id']); !!}
    };
</script>

<aside class="main-sidebar" >
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->

        <div class="user-panel" ng-controller="account-details-controller">
            <div class="pull-left image user-image-container">
                <img class="profile_pic" />
            </div>
            <div class="pull-left info">
                <p>@{{account_name}} </p>
                <i class="fa fa-circle text-success"></i> <a>@{{account_position}}</a><br>
            </div>
        </div>
        
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" ng-controller="student-subject-navbar-controller">
            <li class="header"><center>MAIN NAVIGATION</center></li>
            <li class="treeview">
                <a href="/student">
                    <i class="fa fa-arrow-left"></i> 
                    <span>Back Home</span>
                </a>
            </li>
            
             <li class="@{{systemHelper.activePage(['/student/subject/' + param.id + '/posts', '/student/subject/' + param.id, '/student/subject/' + param.id + '/'])}} treeview">
                <a ng-href="/student/subject/{{$id}}/posts">    
                    <i class="fa fa-newspaper-o"></i> 
                    <span>Posts</span> 
                    <span class="pull-right-container">
                        <span class="label label-success pull-right">@{{comment_count}}</span>
                    </span>
                </a>
            </li>
            <li class="@{{systemHelper.activePage(['/student/subject/' + param.id + '/class', '/student/subject/' + param.id + '/'])}} treeview">
                <a ng-href="/student/subject/{{$id}}/class">
                    <i class="fa fa-list"></i>
                    <span>Class List</span> 
                    <span class="pull-right-container">
                        <span class="label label-success pull-right">@{{student_count}}</span>
                    </span>
                </a>
            </li>
            <li class="@{{systemHelper.activePage(['/student/subject/' + param.id + '/homeworks', '/student/subject/' + param.id + '/'])}} treeview">
                <a ng-href="/student/subject/{{$id}}/homeworks">
                    <i class="fa fa-edit"></i>
                    <span>Homeworks </span> 
                    <span class="pull-right-container">
                        <span class="label label-success pull-right">@{{homeworks_count}}</span>
                    </span>
                </a>
            </li>
        </ul>
    </section>
<!-- /.sidebar -->
</aside>