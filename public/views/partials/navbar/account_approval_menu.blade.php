@if(Request::is('admin*'))
    <script type="text/javascript" src="/js/services/admin/admin.accounts.approval.service.js"></script>
    <script type="text/javascript" src="/js/controllers/admin/admin.accounts.approval.controller.js"></script>

    <li class="dropdown messages-menu  @if(!Request::is('admin*')) hidden @endif" ng-controller="adminAccountsApprovalController">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-user-plus"></i>
            <span class="label label-danger" ng-show="accounts_approval.length > 0">@{{accounts_approval.length}}</span>
        </a>
        <ul class="dropdown-menu" >
            <li class="header" >You have @{{accounts_approval.length}} account(s) for approval</li>
            <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                    <li ng-repeat="ap in accounts_approval"><!-- start message -->
                    <a style="cursor:pointer;" ng-click="approveAccount($index)">
                        <h4 style="margin-left:0px;">
                        @{{systemHelper.trimString(userHelper.getPersonFullname(ap), 28)}}
                        <small ><i class="fa fa-clock-o"></i> @{{datetimeHelper.parseDate(ap.created_at)}}</small>
                        </h4>
                        <p style="margin-left:0px;">@{{ap.student_id}}</p>
                    </a>
                    </li>
                </ul>
            </li>
            <li class="footer"><a href="/admin/accounts_approval">See All Accounts Approval</a></li>
        </ul>
    </li>
@endif