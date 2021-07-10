<!DOCTYPE html>
<html ng-app="wmsu_ics_app">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>@yield('title')</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.6 -->
	<link rel="stylesheet" href="/assets/account/bootstrap/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="/assets/account/dist/css/AdminLTE.min.css">
	<!-- AdminLTE Skins. Choose a skin from the css/skins
		folder instead of downloading all of them to reduce the load. -->
	<link rel="stylesheet" href="/assets/account/dist/css/skins/_all-skins.min.css">
	<!-- iCheck -->
	<link rel="stylesheet" href="/assets/account/plugins/iCheck/flat/blue.css">
	<!-- Morris chart -->
	<link rel="stylesheet" href="/assets/account/plugins/morris/morris.css">
	<!-- jvectormap -->
	<link rel="stylesheet" href="/assets/account/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
	<!-- Date Picker -->
	<link rel="stylesheet" href="/assets/account/plugins/datepicker/datepicker3.css">
	<!-- Daterange picker -->
	<link rel="stylesheet" href="/assets/account/plugins/daterangepicker/daterangepicker.css">
	<!-- Bootstrap Color Picker -->
	<link rel="stylesheet" href="/assets/account/plugins/colorpicker/bootstrap-colorpicker.min.css"
	<!-- bootstrap wysihtml5 - text editor -->
	<link rel="stylesheet" href="/assets/account/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
	<!-- fullCalendar 2.2.5-->
	<link rel="stylesheet" href="/assets/account/plugins/fullcalendar/fullcalendar.min.css">
	<link rel="stylesheet" href="/assets/account/plugins/fullcalendar/fullcalendar.print.css" media="print">
	<!-- iCheck for checkboxes and radio inputs -->
	<link rel="stylesheet" href="/assets/account/plugins/iCheck/all.css">
	<!-- Select2 -->
	<link rel="stylesheet" href="/assets/account/plugins/select2/select2.min.css">
	<!-- Bootstrap time Picker -->
	<link rel="stylesheet" href="/assets/account/plugins/timepicker/bootstrap-timepicker.min.css">
	<!-- Zebra dialog -->
	<link rel="stylesheet" href="/css/zebra-dialog-master/css/flat/zebra_dialog.min.css">
	<!-- ng data table -->
	<link rel="stylesheet" href="/css/ng-table.css">
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<!-- System control stylesheet -->
	<link rel="stylesheet" href="/css/control.css">

	<!--ANGULAR JS-->
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/rxjs/4.0.6/rx.all.js"></script> -->
	<script type="text/javascript" src="/js/angular.min.js"></script> 

	<script type="text/javascript" src="/js/main.app.js"></script>
	<script type="text/javascript" src="/js/services/system/helper.service.js"></script>
	<script type="text/javascript" src="/js/services/system/texts.service.js"></script>

	<script type="text/javascript" src="/js/directives/angularTrix.directive.js"></script>
	<script type="text/javascript" src="/js/directives/fileModel.directive.js"></script>
	<script type="text/javascript" src="/js/directives/fileModelMultiple.directive.js"></script>
	<script type="text/javascript" src="/js/directives/selectModel.directive.js"></script>
	<script type="text/javascript" src="/js/directives/ng-table.directive.js"></script>

	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/trix/0.9.2/trix.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/trix/0.9.2/trix.js"></script>

	<script type="text/javascript" src="/js/services/shared/account.service.js"></script>
	<script type="text/javascript" src="/js/controllers/shared/account.controller.js"></script>

	<!-- jQuery 2.2.3 -->
	<script src="/assets/account/plugins/jQuery/jquery-2.2.3.min.js"></script>

	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<!-- bootstrap time picker -->
	<script src="/assets/account/plugins/timepicker/bootstrap-timepicker.min.js"></script>

	<!-- Angular UI calendar -->
	<link rel="stylesheet" href="/assets/shared/ui-calendar/fullcalendar/dist/fullcalendar.css"/>
	<script type="text/javascript" src="/assets/shared/ui-calendar/moment/min/moment.min.js"></script>
	<script type="text/javascript" src="/assets/shared/ui-calendar/angular-ui-calendar/src/calendar.js"></script>
	<script type="text/javascript" src="/assets/shared/ui-calendar/fullcalendar/dist/fullcalendar.min.js"></script>
	<script type="text/javascript" src="/assets/shared/ui-calendar/fullcalendar/dist/gcal.js"></script>

</head>

<body class="hold-transition skin-green-light @if(Request::is('*/subject/*')) control-sidebar-open @endif sidebar-mini fixed">

<!-- System header section -->
@include('partials.loader.loader')

	<div class="wrapper">

		<!-- System loader section -->
		@include('partials.app_section.header')
	
		<!-- Left side column. contains the logo and sidebar -->
		<!-- Content Wrapper. Contains page content -->
		@yield('content')
		<!-- /.content-wrapper -->
		
		<!-- System footer section -->
		@include('partials.app_section.footer')
		
		<!-- Control Sidebar -->
		@include('partials.app_section.sidebar')
		
	</div>
	<!-- ./wrapper -->

	@include('partials.resources.plugins');
	</body>
</html>
