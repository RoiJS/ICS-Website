<script type="text/javascript" src="/js/controllers/shared/account.activity.logs.controller.js"></script>
<link rel="stylesheet" href="/css/shared/activity_logs.css">

<div class="box box-success box-solid" ng-controller="accountActivityLogsController">
    <div class="box-header with-border">
        <h3 class="box-title">Recent Activities</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive activity-logs-container">

        <table ng-show="activities.length > 0" class="activity-logs table table-hover">
            <tr ng-repeat="activity in activities">    
                <td>@{{activity.activity_description}}</td>
                <td class="activity-datetime"><i class="fa fa-clock"></i> @{{activity.datetime}}</td>
            </tr>
        </table>

        <div ng-show="activities.length === 0" class="callout callout-info">
            <p><b>Empty activity logs</b> </p>
        </div>
    </div>
    <div class="box-footer">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a href="#" ng-click="seeMoreActivities()" ng-show="absoluteCount !== activities.length"><i class="fa fa-eye"></i> See more</a>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a href="#" class="pull-right" ng-click="clearActivities()"><i class="fa fa-eraser"></i> Clear all activities</a>
            </div>
        </div>
    </div>
    <!-- /.box-body -->
</div>