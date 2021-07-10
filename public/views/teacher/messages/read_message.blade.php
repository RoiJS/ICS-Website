@extends('account-layout')

@section('title', 'Read Message')

@section('content')

    @include('teacher.teacher_navbar')

    <div class="content-wrapper">
       <input type="hidden" name="message_id" id="message_id" value="{{$message['id']}}">
        <section class="content-header">
            <h1>Read Message</h1>
            <ol class="breadcrumb">
            <li><a href="/teacher"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/teacher/messages/inbox">Inbox</a></li>
            <li class="active">Read Message</li>
            </ol>
         </section>
        <!-- Main content -->
        <section class="content">
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        <!-- /.box-header -->
                        <div class="box-body no-padding">
                            <div class="mailbox-read-info">
                                <h3>@{{userHelper.getPersonFullname(message.details)}}</h3>
                                <h5>From: @{{message.details.email_address}}
                                <span class="mailbox-read-time pull-right">@{{message.getTimeAgo(message.details) | date : 'MMM d, y'}}</span></h5>
                            </div>
                            <!-- /.mailbox-read-info -->
                            <div class="mailbox-controls with-border text-center">
                                <div class="btn-group">
                                    <a ng-href="/teacher/messages/reply/@{{message.message_id}}" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Reply">
                                        <i class="fa fa-reply"></i></a>
                                    <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Delete">
                                        <i class="fa fa-trash-o"></i></button>
                                </div>
                            </div>
                            <!-- /.mailbox-controls -->
                            <div class="mailbox-read-message">
                                <p>Hello John,</p>

                                <p>Keffiyeh blog actually fashion axe vegan, irony biodiesel. Cold-pressed hoodie chillwave put a bird
                                on it aesthetic, bitters brunch meggings vegan iPhone. Dreamcatcher vegan scenester mlkshk. Ethical
                                master cleanse Bushwick, occupy Thundercats banjo cliche ennui farm-to-table mlkshk fanny pack
                                gluten-free. Marfa butcher vegan quinoa, bicycle rights disrupt tofu scenester chillwave 3 wolf moon
                                asymmetrical taxidermy pour-over. Quinoa tote bag fashion axe, Godard disrupt migas church-key tofu
                                blog locavore. Thundercats cronut polaroid Neutra tousled, meh food truck selfies narwhal American
                                Apparel.</p>

                                <p>Raw denim McSweeney's bicycle rights, iPhone trust fund quinoa Neutra VHS kale chips vegan PBR&amp;B
                                literally Thundercats +1. Forage tilde four dollar toast, banjo health goth paleo butcher. Four dollar
                                toast Brooklyn pour-over American Apparel sustainable, lumbersexual listicle gluten-free health goth
                                umami hoodie. Synth Echo Park bicycle rights DIY farm-to-table, retro kogi sriracha dreamcatcher PBR&amp;B
                                flannel hashtag irony Wes Anderson. Lumbersexual Williamsburg Helvetica next level. Cold-pressed
                                slow-carb pop-up normcore Thundercats Portland, cardigan literally meditation lumbersexual crucifix.
                                Wayfarers raw denim paleo Bushwick, keytar Helvetica scenester keffiyeh 8-bit irony mumblecore
                                whatever viral Truffaut.</p>

                                <p>Post-ironic shabby chic VHS, Marfa keytar flannel lomo try-hard keffiyeh cray. Actually fap fanny
                                pack yr artisan trust fund. High Life dreamcatcher church-key gentrify. Tumblr stumptown four dollar
                                toast vinyl, cold-pressed try-hard blog authentic keffiyeh Helvetica lo-fi tilde Intelligentsia. Lomo
                                locavore salvia bespoke, twee fixie paleo cliche brunch Schlitz blog McSweeney's messenger bag swag
                                slow-carb. Odd Future photo booth pork belly, you probably haven't heard of them actually tofu ennui
                                keffiyeh lo-fi Truffaut health goth. Narwhal sustainable retro disrupt.</p>

                                <p>Skateboard artisan letterpress before they sold out High Life messenger bag. Bitters chambray
                                leggings listicle, drinking vinegar chillwave synth. Fanny pack hoodie American Apparel twee. American
                                Apparel PBR listicle, salvia aesthetic occupy sustainable Neutra kogi. Organic synth Tumblr viral
                                plaid, shabby chic single-origin coffee Etsy 3 wolf moon slow-carb Schlitz roof party tousled squid
                                vinyl. Readymade next level literally trust fund. Distillery master cleanse migas, Vice sriracha
                                flannel chambray chia cronut.</p>

                                <p>Thanks,<br>Jane</p>
                            </div>
                            <!-- /.mailbox-read-message -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <!-- /.content -->
    </div>
@endsection
