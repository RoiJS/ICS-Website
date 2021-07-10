<script type="text/javascript" src="/js/controllers/shared/account.notifications.panel.controller.js"></script>

<div class="box box-success box-solid notification-box" ng-controller="accountNotificationsPanelController">
    <div class="box-header with-border">
        <h3 class="box-title">Notifications</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive notifications-container">

        <table ng-show="panel_notifications.length > 0" class="notification-list table table-hover">
            <tr ng-show="panel_status.loading">
                <td colspan="2">
                    <div class="notification-loader-section">
                        <div class="notification-loader"></div>
                    </div>  
                </td>
            </tr>
            <tr class="notification-item-section notification-item-container" 
                ng-repeat="notification in panel_notifications" 
                ng-click="panelGoToPath($index)"
                ng-class="{'unread': notification.is_read === 0}">    
                <td class="notification-details">
                    <div class="notification-item">
                        <span class="username">@{{notification.userfullname}}</span>
                        <span class="description">@{{notification.description}}</span> 
                    </div>
                </td>
                <td class="activity-datetime"><i class="fa fa-clock"></i> @{{notification.datetime}}</td>
            </tr>
        </table>

        <div ng-show="panel_notifications.length === 0" class="callout callout-info">
            <p><b>Empty notifications</b> </p>
        </div>
        
    </div>
    <div class="box-footer">
        <a href="#" ng-click="panelMarkAllAsRead()">Mark All As Read</a>
        <a href="#" class="link-see-more" ng-click="panelSeeMoreNotifications()">See More</a>
        <a href="#" ng-click="panelClearAllNotifications()">Clear all notifications</a>
    </div>
    <!-- /.box-body -->
</div>