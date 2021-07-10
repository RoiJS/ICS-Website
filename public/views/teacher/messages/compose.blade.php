@extends('account-layout')

@section('title', 'Compose')

@section('content')

    @include('teacher.teacher_navbar')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Compose </h1>
            <ol class="breadcrumb">
            <li><a href="/teacher"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/teacher/messages/inbox">Inbox</a></li>
            <li class="active">Compose</li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <br>
            <div class="row">
                <div class="col-md-3">
                    <a href="/teacher/messages/inbox" class="btn btn-success btn-block margin-bottom">Back to Inbox</a>
                    <div class="box box-success">
                        <div class="box-header with-border">
                        <h3 class="box-title">Folders</h3>

                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                        </div>
                        <div class="box-body no-padding">
                            <ul class="nav nav-pills nav-stacked">
                                <li class="active"><a href="/teacher/messages/inbox" ><i class="fa fa-inbox"></i> Inbox
                                <span class="label label-success pull-right">12</span></a></li>
                                <li><a href="/teacher/messages/sent"><i class="fa fa-envelope-o"></i> Sent</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                    
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="box box-success">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Compose New Message</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                    <div class="form-group">
                                        <input class="form-control" placeholder="To:">
                                    </div>
                                    <div class="form-group">
                                        <textarea id="compose-textarea" class="form-control" style="height: 300px">
                                        <h1><u>Heading Of Message</u></h1>
                                        <h4>Subheading</h4>
                                        <p>But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain
                                            was born and I will give you a complete account of the system, and expound the actual teachings
                                            of the great explorer of the truth, the master-builder of human happiness. No one rejects,
                                            dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know
                                            how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again
                                            is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain,
                                            but because occasionally circumstances occur in which toil and pain can procure him some great
                                            pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise,
                                            except to obtain some advantage from it? But who has any right to find fault with a man who
                                            chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that
                                            produces no resultant pleasure? On the other hand, we denounce with righteous indignation and
                                            dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so
                                            blinded by desire, that they cannot foresee</p>
                                        <ul>
                                            <li>List item one</li>
                                            <li>List item two</li>
                                            <li>List item three</li>
                                            <li>List item four</li>
                                        </ul>
                                        <p>Thank you,</p>
                                        <p>John Doe</p>
                                        </textarea>
                                    </div>
                                </div>
                            </div>  
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="pull-right">
                                 <button type="button" class="btn btn-success"><i class="fa fa-reply"></i> Submit</button>
                                <a href="/teacher/messages" class="btn btn-danger" ><i class="fa fa-ban"></i> Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </section>
    <!-- /.content -->
     </div>
@endsection
