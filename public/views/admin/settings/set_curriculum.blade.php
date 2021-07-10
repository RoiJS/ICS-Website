@extends('account-layout')

@section('title', 'Curriculum')

@section('content')

    @include('admin.admin_navbar')

    <div class="content-wrapper" >
        <section class="content-header">
            <h1><i class="fa fa-list-ul"></i> Curriculum </h1>
            <ol class="breadcrumb">
                <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="/admin/settings">Settings</a></li>
                <li class="active">Curriculum</li>
            </ol>
        </section>

        <section>
            <br>
            <div class="container"> 
                <div class="row">
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label for="lastname">Select curriculum:</label>
                            <select class="form-control"></select>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-success"><i class="fa fa-check-square-o"></i> Set</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
    </div>
@endsection