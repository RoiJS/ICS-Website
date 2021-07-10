@extends('account-layout')

@section('title', 'Account')

@section('content')

    @include('teacher.teacher_navbar')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Account
            </h1>
            <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Account</li>
            </ol>
        </section>
    </div>
@endsection
