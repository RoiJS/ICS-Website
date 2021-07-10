@extends('account-layout')

@section('title')
   {{$subject['id']}} | Announcements
@endsection

@section('content')

    @include('teacher.subjects.teacher_subject_navbar')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>{{$subject['id']}}  <small>Announcements</small></h1>
            <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#"><i class="fa fa-book"></i> {{$subject['id']}}</a></li>
            <li class="active">Announcements</li>
            </ol>
        </section>
    </div>
@endsection
