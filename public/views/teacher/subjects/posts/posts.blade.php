@extends('account-layout')

@section('title')
    {{$subject['description']}}  | Posts
@endsection

@section('content')

    @include('teacher.subjects.teacher_subject_navbar')
    
    <script type="text/javascript" src="/js/services/shared/account.post.service.js"></script>
    <script type="text/javascript" src="/js/services/shared/account.comments.service.js"></script>

    <script type="text/javascript" src="/js/controllers/teacher/teacher.posts.controller.js"></script>
    <script type="text/javascript" src="/js/controllers/teacher/teacher.comments.controller.js"></script>

    <link rel="stylesheet" href="/css/shared/comments.css">
    <link rel="stylesheet" href="/css/shared/posts.css">

    <div class="content-wrapper" ng-controller="teacherPostsController">
        <section class="content-header">
            <h1><i class="fa fa-book"></i> {{$subject['description']}}  <small>Posts</small></h1>
            <ol class="breadcrumb">
            <li><a href="/teacher"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/teacher/subject/{{$id}}/posts"><i class="fa fa-book"></i> {{$subject['description']}}</a></li>
            <li class="active">Posts</li>
            </ol>
        </section>

        <section class="content">
            
            <div class="row">
                <div class="col-md-12">
                    <a href="/teacher/subject/{{$id}}/posts/add_post" class="btn btn-success"><i class="fa fa-edit"></i> Add Post</a>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">

                    <!-- #start Empty Post list section -->
                    <div class="row" ng-if="!status.post_loading && posts.length === 0">
                        <div class="col-md-12">
                            <div class="callout callout-info">
                                <h4>Empty Post list</h4>
                                <p>Click 'Add post' button above to create post</p>
                            </div>
                        </div>
                    </div>
                    <!-- #end -->

                    <!-- #start Post List section -->
                    <div ng-repeat="post in posts" ng-init="post_index = $index" ng-show="posts.length > 0">
                        <div class="post-list box box-widget">
                            <div class="box-header with-border">
                                <div class="user-block">
                                    <div class="user-image">
                                        <img ng-src="@{{post.user_image}}" />
                                    </div>
                                    <div class="user-information">
                                        <span class="username"><a href="#">@{{post.poster_name}}</a></span>
                                        <span class="description">@{{post.post_date}}</span>
                                    </div>
                                </div>
                                <div class="box-tools" ng-if="post.is_poster">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></a>
                                    <ul class="dropdown-menu-options dropdown-menu" role="menu">
                                        <li><a href="/teacher/subject/{{$id}}/posts/edit_post/@{{post.post_id}}"><i class="fa fa-edit"></i> Edit</a></li>
                                        <li><a href="#" ng-click="removePost($index)"><i class="fa fa-trash"></i> Remove</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="box-body">
                                <p ng-bind-html="post.post_description"></p>
                            </div>
                            <div class="box-body">
                                <small>@{{post.comments.length}} Comments</small>
                            </div>
                            <div ng-controller="teacherCommentsController">
                                <div class="box-footer comment-list-section">
                                    <div class="comment-list box-comment" ng-repeat="comment in post.comments" ng-init="comment_index = $index">
                                        <div class="comment-container">
                                            <div class="comment-user-image">
                                                <img ng-src="@{{comment.user_image}}" />
                                            </div>
                                            <div class="comment-text">
                                                <div class="row">
                                                    <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                                        <b>@{{comment.commenter_name}}</b> -  <span class="comment-date-time">@{{comment.comment_date}}</span>
                                                    </div>
                                                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" >
                                                        <div class="pull-right" ng-show="(post.is_post && comment.is_comment) || !post.is_post && comment.is_comment">
                                                            <a href="#" data-toggle="dropdown"> <i class="fa fa-caret-down"></i></a>
                                                            <ul class="dropdown-menu-options dropdown-menu" role="menu">
                                                                <li ng-click="comment.is_edit = !comment.is_edit"><a><i class="fa fa-edit" ></i> Edit</a></li>
                                                                <li ng-click="removeComment(post_index, comment_index)"><a><i class="fa fa-trash"></i> Remove</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="pull-right" ng-show="(!post.is_post && !comment.is_comment)">
                                                            <a href="#" data-toggle="dropdown"> <i class="fa fa-caret-down"></i></a>
                                                            <ul class="dropdown-menu-options dropdown-menu" role="menu">
                                                                <li ng-click="removeComment(post_index, comment_index)"><a><i class="fa fa-trash"></i> Remove</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" ng-if="!comment.is_edit">
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        @{{comment.comment}}
                                                    </div>
                                                </div>
                                                <div class="row" ng-if="comment.is_edit">
                                                    <form novalidate ng-submit="saveEditComment(post_index, comment_index)" ng-model-options="{updateOn : 'submit'}">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            <div class="form-group">
                                                                <textarea class="form-control" ng-model="comment.comment"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            <div class="pull-right">
                                                                <button type="submit">Save</button>
                                                                <button ng-click="comment.is_edit = !comment.is_edit">Cancel</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <form novalidate ng-submit="sendComment(post_index)">
                                        <div class="new-comment-section">
                                            <div class="user-image-container">
                                                <img class="profile_pic" />
                                            </div>
                                            <div class="comment-control img-push">
                                                <input type="text" class="form-control input-sm" ng-model="comment.comment" placeholder="Press enter to post comment&hellip;">
                                                <button type="submit" class="hidden"></button>
                                            </div>
                                        </div> 
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- #end -->

                    <!-- #start Button see more section -->
                    <div class="row" ng-if="!status.post_loading && posts.length > 0 && absoluteCount > posts.length">
                        <div class="col-md-12">
                            <div class="button-see-more-section">
                                <button class="btn btn-see-more" ng-click="seeMorePosts()">See more</button>
                            </div>
                        </div>
                    </div>
                    <!-- #end -->
                   
                    <!-- #start No more posts section -->
                    <div class="row" ng-if="!status.post_loading && posts.length > 0 && absoluteCount === posts.length">
                        <div class="col-md-12">
                            <div class="no-more-posts-section">
                                Oops. No more posts anymore.  
                            </div>
                        </div>
                    </div>
                    <!-- #end -->
                    
                    <!-- #start posts loader section -->
                    <div class="row">
                        <div class="col-md-12" ng-show="status.post_loading">
                            <div class="post-loader-section">
                               <div class="posts-loader"></div>
                            </div>
                        </div>
                    </div>
                    <!-- #end -->


                </div>
            </div>
            
        </section>
    </div>
@endsection
