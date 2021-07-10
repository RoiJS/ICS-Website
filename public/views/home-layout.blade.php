	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<!--
	Template Name: PlusBusiness
	Author: <a href="http://www.os-templates.com/">OS Templates</a>
	Author URI: http://www.os-templates.com/
	Licence: Free to use under our free template licence terms
	Licence URI: http://www.os-templates.com/template-terms
	-->
<html xmlns="http://www.w3.org/1999/xhtml" ng-app="wmsu_ics_app">
	<head>
		<title>@yield('title')</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link rel="stylesheet" href="/assets/home/styles/layout.css" type="text/css" />

		<script type="text/javascript" src="/assets/home/scripts/jquery.min.js"></script>
		<script type="text/javascript" src="/assets/home/scripts/jquery.jcarousel.pack.js"></script>
		<script type="text/javascript" src="/assets/home/scripts/jquery.jcarousel.setup.js"></script>

		<!--ANGULAR JS-->
		<script type="text/javascript" src="/js/angular.min.js"></script>
		<script type="text/javascript" src="/js/main.app.js"></script>

		<!-- Application Service helper -->
		<script type="text/javascript" src="/js/services/system/helper.service.js"></script>
		<script type="text/javascript" src="/js/services/system/texts.service.js"></script>

		<!-- Application custom directives -->
		<script type="text/javascript" src="/js/directives/angularTrix.directive.js"></script>
		<script type="text/javascript" src="/js/directives/fileModel.directive.js"></script>
		<script type="text/javascript" src="/js/directives/selectModel.directive.js"></script>
		<script type="text/javascript" src="/js/directives/ng-table.directive.js"></script>

		<!-- Angular trix text editor -->
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/trix/0.9.2/trix.css">
		<script src="//cdnjs.cloudflare.com/ajax/libs/trix/0.9.2/trix.js"></script>

		<!-- Account Services -->
		<script type="text/javascript" src="/js/services/shared/account.service.js"></script>
		<script type="text/javascript" src="/js/controllers/shared/account.controller.js"></script>

		<!-- Angular UI calendar -->
		<link rel="stylesheet" href="/assets/shared/ui-calendar/fullcalendar/dist/fullcalendar.css"/>
		<link rel="stylesheet" href="/assets/shared/ui-calendar/bootstrap-css/css/bootstrap.css"/>

		<script type="text/javascript" src="/assets/shared/ui-calendar/moment/min/moment.min.js"></script>
		<script type="text/javascript" src="/assets/shared/ui-calendar/angular-ui-calendar/src/calendar.js"></script>
		<script type="text/javascript" src="/assets/shared/ui-calendar/fullcalendar/dist/fullcalendar.min.js"></script>
		<script type="text/javascript" src="/assets/shared/ui-calendar/fullcalendar/dist/gcal.js"></script>

		<!-- Font awesome icon -->
		<link href="/css/font-awesome/css/all.css" rel="stylesheet"> 
		
		<!-- System control sylesheet -->
		<link rel="stylesheet" type="text/css" href="/css/home/home.css" />
		<link rel="stylesheet" type="text/css" href="/css/control.css" />

		<!-- Ng table -->
		<script type="text/javascript" src="/js/directives/ng-table.directive.js"></script>
		<link rel="stylesheet" type="text/css" href="/css/ng-table.css">

	</head>
	<body id="top">

		<!-- System loader section -->
		@include('partials.loader.loader')
		
		@yield('content')

		<div class="col4" ng-controller="homeFooterController">
			<div id="footer" class="footer-ics-information">

				<div class="box1">
					<h2>@{{ics_details.organization_name}}</h2>
					<div class="footer-ics-information-section">
						<div class="ics-logo-section">
							<div class="ics-logo">
								<img class="img" ng-src="@{{ics_details.image_path}}" />
							</div>		
						</div>	
						<p>@{{ics_details.history}}</p>
					</div>
				</div>

				<div class="box contactdetails">
					<h2>Our Contact Details</h2>
					<ul>
					<li><span class="ics-contact-detail">Contact number:</span> @{{ics_details.tel_number}}</li>
					<li><span class="ics-contact-detail">Email address:</span> @{{ics_details.email_address}}</li>
					<li><span class="ics-contact-detail">Address:</span> @{{ics_details.address}}</li>
					</ul>
				</div>
				
				<br class="clear" />
			</div>
		</div>
		<!-- ####################################################################################################### -->
		<div class="col5">
			<div id="copyright">
				<p>Copyright © 2016 - 2017 Western Mindanao State University Institute of Computer Studies. All rights reserved. <a href="#">wmsuics.com</a></p>
			<br class="clear" />
			</div>
		</div>
		<script src="/js/controllers/home/home.footer.controller.js"></script>
	</body>
</html>