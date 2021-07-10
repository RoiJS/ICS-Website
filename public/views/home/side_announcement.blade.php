<div ng-controller="homeSideAnnouncementController">
    <div class="holder side-announcement" ng-repeat="announcement in announcements">
        <h2 class="title">
            <img ng-src="@{{announcement.image_path}}"/> @{{announcement.title}}
        </h2>
        <p>@{{announcement.description}}</p>
        <p class="readmore"><a href="/announcements/@{{announcement.announcement_id}}">Continue Reading &raquo;</a></p>
    </div>
</div>
