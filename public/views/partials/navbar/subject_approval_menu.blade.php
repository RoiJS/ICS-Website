@if(Request::is('teacher*'))
    <script type="text/javascript" src="/js/controllers/teacher/teacher.subject.approval.controller.js"></script>
    <script type="text/javascript" src="/js/services/teacher/teacher.subject.approval.service.js"></script>
    <link rel="stylesheet" href="/css/shared/subject_approval.css">

    <li class="dropdown messages-menu  @if(!Request::is('teacher*')) hidden @endif" ng-controller="teacherSubjectApprovalController">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-user-plus"></i>
            <span class="label label-danger" ng-show="subjects_approval.length > 0">@{{sp_count}}</span>
        </a>
        <ul class="dropdown-menu" >
            <li class="header" >You have @{{subjects_approval.length}} class(es) for approval</li>
            <li>
            <!-- inner menu: contains the actual data -->
            <ul class="menu">
                <li ng-repeat="ap in subjects_approval"><!-- start message -->
                <a style="cursor:pointer;" ng-click="approveSubject($index)">
                    <h4 style="margin-left:0px;">
                    @{{ap.requester_name}}
                    <small ><i class="fa fa-clock-o"></i> @{{ap.request_date}}</small>
                    </h4>
                    <p style="margin-left:0px;">@{{ap.student_id}}</p>
                </a>
                </li>
            </ul>
            </li>
            <li class="footer"><a href="/teacher/subjects_approval">See All Class Approval</a></li>
        </ul>
    </li>
@endif