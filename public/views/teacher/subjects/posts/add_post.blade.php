@extends('account-layout')

@section('title')
    {{$subject['description']}}  | Posts
@endsection

@section('content')

    @include('teacher.subjects.teacher_subject_navbar')

    <script type="text/javascript" src="/js/services/shared/account.post.service.js"></script>
    <script type="text/javascript" src="/js/controllers/teacher/teacher.add.post.controller.js"></script>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1><i class="fa fa-book"></i> {{$subject['description']}}  <small>Posts</small></h1>
            <ol class="breadcrumb">
            <li><a href="/teacher"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/teacher/subject/{{$id}}/posts"><i class="fa fa-book"></i> {{$subject['description']}}</a></li>
            <li class="active">Posts</li>
            </ol>
        </section>

        <section class="content" ng-controller="teacherAddPostController">
            <div class="row">
                <form novalidate ng-submit="sendPost()">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="box box-widget">
                            <div class="box-header with-border">

                            </div>
                            <div class="box-body">
                                <trix-editor name="announcement_description" angular-trix ng-model="post_details.description"  class="text-editor-container-post" required></trix-editor>
                            </div>
                            <div class="box-footer">
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-success" ng-disabled="!post_details.description"> <i class="fa fa-save" ></i> Post</button>
                                    <a href="/teacher/subject/{{$id}}/posts" class="btn btn-danger"> <i class="fa fa-ban"></i>Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
