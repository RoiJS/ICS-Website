@if(Request::is('teacher*') || Request::is('student*'))
<script type="text/javascript" src="/js/controllers/shared/account.notifications.menu.controller.js"></script>
<link rel="stylesheet" href="/css/shared/notifications.css">

<li class="dropdown notifications-menu" ng-controller="accountNotificationsMenuController">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-bell-o"></i>
        <span class="label label-warning" ng-show="unreadNotificationsCount > 0">@{{unreadNotificationsCount}}</span>
    </a>
    <ul class="dropdown-menu">
        <li class="header">You have @{{unreadNotificationsCount}} notifications</li>
        <li>
        <!-- inner menu: contains the actual data -->
        <ul class="menu">
            <li ng-show="status.loading">
                <div class="notification-loader-section">
                    <div class="notification-loader"></div>
                </div>
            </li>
            <li ng-repeat="notification in notifications" ng-click="goToPath($index)">
                <div class="notification-item-container" ng-class="{'unread': notification.is_read === 0}">
                    <div class="user-image-section">
                        <img src="@{{notification.userimage}}" />
                    </div>
                    <div class="notification-details-section" title="@{{notification.description}}">
                        <span class="userfullname">@{{notification.userfullname}} </span>
                        <span class="notification-description">@{{notification.description}}</span>
                        <span class="notification-datetime"><i class="fa fa-clock"></i> @{{notification.datetime}}</span>
                    </div>
                </div>
            </li>
        </ul>
        </li>
        <li class="footer">
            <a href="#" ng-click="markAllAsRead()">Mark All As Read</a>
            <a href="#" ng-click="seeMoreNotifications()">See More</a>
            <a href="#" ng-click="clearAllNotifications()">Clear All</a>
        </li>
    </ul>
</li>
@endif
