<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="box box-success">
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            <b><i class="fa fa-flag"></i> Current Semester:</b> @{{current_sem}}
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <b><i class="fa fa-calendar"></i> Current School Year</b> :@{{current_sy}}
                        </div>                  
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" ng-if="!status.subject_loading && !status.has_subjects">
        <div class="col-md-12">
            <div class="callout callout-warning">
                <p><i class="fa fa-warning"></i><b>No subject have been loaded for this semester</b></p>
            </div>
        </div>
    </div>
    <div class="row" ng-if="status.subject_loading">
        <div class="col-md-12">
            <i class="fa fa-refresh fa-spin"></i> Loading subjects&hellip;
        </div>
    </div>
    <div class="row" ng-if="!status.subject_loading  && status.has_subjects">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div ng-repeat="subject in subjects.subjects" class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <!-- Profile Image -->
                    <div class="box box-success">
                        <div class="box-body box-profile">
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3>@{{subject.student_num}}</h3>
                                    <p>Students</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-laptop"></i>
                                </div>
                                <a href="/teacher/subject/@{{subject.class_id}}/posts" class="small-box-footer">@{{subject.subject_description}} <br> (@{{subject.subject_code}}) </i></a>
                            </div>
                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                <b><i class="fa fa-newspaper-o"></i> Posts</b> <a class="pull-right"><span class="badge bg-yellow">@{{subject.posts_num}}</span></a></li>
                                </li>
                                <li class="list-group-item">
                                    <b><i class="fa fa-edit"></i> Homeworks</b> <a class="pull-right"><span class="badge bg-yellow">@{{subject.homeworks_num}}</span></a></li>
                                </li>
                                <li class="list-group-item">
                                    <b><i class="fa fa-comments"></i> New messages</b> <a class="pull-right"><span class="badge bg-yellow">@{{subject.new_messages_count}}</span></a></li>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>        
        </div>
    </div>
</div> 