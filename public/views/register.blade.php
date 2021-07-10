<!DOCTYPE html>
<html ng-app="wmsu_ics_app">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>WMSU ICS | Register</title>
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
		<!-- iCheck -->
		<link rel="stylesheet" href="/assets/account/plugins/iCheck/square/blue.css">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

		<!--ANGULAR JS-->
		<script type="text/javascript" src="/js/angular.min.js"></script>
		<script type="text/javascript" src="/js/main.app.js"></script>
		<script type="text/javascript" src="/js/services/system/helper.service.js"></script>
		<script type="text/javascript" src="/js/services/system/texts.service.js"></script>

		<script type="text/javascript" src="/js/directives/ng-table.directive.js"></script>
		<!--ANGULAR JS-->
			
		<!-- jQuery 2.2.3 -->
		<script src="/assets/account/plugins/jQuery/jquery-2.2.3.min.js"></script>
		<!-- Bootstrap 3.3.6 -->
		<script src="/assets/account/bootstrap/js/bootstrap.min.js"></script>
		<!-- iCheck -->
		<script src="/assets/account/plugins/iCheck/icheck.min.js"></script>
		<!-- Zebra dialog -->
		<script src="/css/zebra-dialog-master/zebra_dialog.min.js"></script>
		<link rel="stylesheet" href="/css/zebra-dialog-master/css/flat/zebra_dialog.min.css">

		<link rel="stylesheet" href="/css/signup/register.css">
		<link rel="stylesheet" href="/css/control.css">

		<script type="text/javascript" src="/js/services/access/register.service.js"></script>
		<script type="text/javascript" src="/js/controllers/access/register.controller.js"></script>

		<!-- Angular UI calendar -->
		<link rel="stylesheet" href="/assets/shared/ui-calendar/fullcalendar/dist/fullcalendar.css"/>
		<script type="text/javascript" src="/assets/shared/ui-calendar/moment/min/moment.min.js"></script>
		<script type="text/javascript" src="/assets/shared/ui-calendar/angular-ui-calendar/src/calendar.js"></script>
		<script type="text/javascript" src="/assets/shared/ui-calendar/fullcalendar/dist/fullcalendar.min.js"></script>
		<script type="text/javascript" src="/assets/shared/ui-calendar/fullcalendar/dist/gcal.js"></script>
	</head>
	<body class="hold-transition login-page" ng-controller="registerAccountController">
		<div class="row">
			<div class="col-md-12">
			<center>
				<div class="callout callout-danger" ng-show="login.error">
				<h4><i class="fa fa-warning"></i> Sign In Error:</h4>
				<p>@{{login.errorMessage}}</p>
			</div>
			</center>
			</div>
		</div>
		<div class="registration-form-panel login-box">
			<div class="login-logo">
				<a href="/">WMSU ICS</a>
			</div>
			<div class="register-box-body">
				<div class="registration-header-panel">
					<p class="login-box-msg">Student Registration Form</p>
				</div>
				<br>
				<form novalidate name="registerForm"  ng-submit="saveNewAccount()" ng-model-options="{updateOn : 'submit'}">
					<label class="lbl-note-message">Note: (<span class="required-field">*</span>) Required Fields </label> <br>

					<div class="form-group has-feedback">
						<label>Student ID: 
							<span class="control-field-info" ng-show="registerForm.student_id.$error.required">(Please enter student ID)</span>
							<span class="required-field">*</span>
						</label>
						<input type="text" name="student_id" class="form-control" placeholder="Enter student ID&hellip;" ng-model="account.student_id" ng-model-options="{updateOn : '$inherit'}" required> 
						<span class="glyphicon glyphicon-user form-control-feedback"></span>
						<!--Find a pattern for the studentId-->
					</div>
					<div class="form-group has-feedback">
						<label>Last name: 
							<span class="control-field-info" ng-show="registerForm.lastname.$error.required">(Please enter lastname)</span>
							<span class="required-field">*</span>
						</label>
						<input type="text" name="lastname" class="form-control" placeholder="Enter last name&hellip;" ng-model="account.lastname" ng-model-options="{updateOn : '$inherit'}" required pattern="^[a-zA-Z\s]*$"> 
						<span class="glyphicon glyphicon-user form-control-feedback"></span>
					</div>
					<div class="form-group has-feedback">
						<label>First name: 
							<span class="control-field-info" ng-show="registerForm.firstname.$error.required">(Please enter first name)</span>
							<span class="required-field">*</span>
						</label>
						<input type="text" name="firstname" class="form-control" placeholder="Enter first name&hellip;" ng-model="account.firstname" ng-model-options="{updateOn : '$inherit'}" required pattern="^[a-zA-Z\s]*$">
						<span class="glyphicon glyphicon-user form-control-feedback"></span>
					</div>
					<div class="form-group has-feedback">
						<label>Middle name: 
							<span class="control-field-info" ng-show="registerForm.middlename.$error.required">(Please enter middle name)</span>
							<span class="required-field">*</span>
						</label>
						<input type="text" name="middlename" class="form-control" placeholder="Enter middle name&hellip;" ng-model="account.middlename" ng-model-options="{updateOn : '$inherit'}" required pattern="^[a-zA-Z\s]*$">
						<span class="glyphicon glyphicon-user form-control-feedback"></span>
					</div>
					<div class="form-group">
						<label>Gender: 
							<span class="control-field-info" ng-show="registerForm.gender.$error.required">(Please select gender)</span>
							<span class="required-field">*</span>
						</label><br>
						<label>
							<input type="radio" name="gender" value="Female" ng-model="account.gender" required>
							Female
						</label>
						<label>
							<input type="radio" name="gender" value="Male"  ng-model="account.gender"  required>
							Male
						</label>
					</div> 
					<div class="form-group has-feedback">
						<label>Birthdate: 
							<span class="control-field-info" ng-show="registerForm.birthdate.$error.required">(Please enter birthdate)</span>
							<span class="required-field">*</span>
						</label>
						<input type="date" name="birthdate" class="form-control" placeholder="Birthdate" ng-model="account.birthdate" ng-model-options="{updateOn : '$inherit'}" required>
						<span class="glyphicon glyphicon-calendar form-control-feedback"></span>
					</div>
					<div class="form-group has-feedback">
						<label for="emailaddress">Email Address:
							<span class="control-field-info" ng-show="registerForm.email_address.$error.required">(Please enter email address)</span>
							<span class="required-field">*</span>
						</label>
						<div ng-show="registerForm.email_address.$dirty && registerForm.email_address.$invalid">
							<span class="text-red" ng-show="registerForm.email_address.$error.email">
								<i class="fa fa-warning"></i> Incorrect email address. Please enter a valid and active email address
							</span>
						</div>
						<input type="email" name="email_address" class="form-control" placeholder="Enter middle valid and active email address&hellip;" ng-model="account.emailaddress" ng-model-options="{updateOn : '$inherit'}" required>
						<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
					</div>
					<div class="form-group has-feedback">
						<label for="emailaddress">Username:
							<span class="control-field-info" ng-show="registerForm.username.$error.required">(Please enter username)</span>
							<span class="required-field">*</span>
						</label>
						<input type="text" name="username" class="form-control" placeholder="Enter username&hellip;" ng-model="account.username" ng-model-options="{updateOn : '$inherit'}" required>
						<span class="glyphicon glyphicon-lock form-control-feedback"></span>
					</div>
					<div class="form-group has-feedback">
						<label for="emailaddress">Password:
							<span class="control-field-info" ng-show="registerForm.password.$error.required">(Please enter username)</span>
							<span class="required-field">*</span>
						</label>
						<input type="password" name="password" class="form-control" placeholder="Enter password&hellip;" ng-model="account.password" ng-model-options="{updateOn : '$inherit'}" required>
						<span class="glyphicon glyphicon-lock form-control-feedback"></span>
					</div>
					<div class="form-group has-feedback">
						<label for="password">Confirm Password:
							<span class="control-field-info" ng-show="registerForm.confirm_password.$error.required">(Please re enter password)</span>
							<span class="required-field">*</span>
						</label>
						<div>
							<span class="text-red" ng-show="account.confirm_password != account.password">
								<i class="fa fa-warning"></i> Password does not match
							</span>
						</div>
						<input type="password" name="confirm_password" class="form-control" id="cofirm_password" placeholder="Re enter password&hellip;" ng-model="account.confirm_password" ng-model-options="{updateOn : '$inherit'}" required>
						<span class="glyphicon glyphicon-lock form-control-feedback"></span>
					</div>
					
					<div class="row">
						<div class="col-xs-4 btn-submit-section">
							<button type="submit" class="btn btn-primary btn-block btn-flat">Submit</button>
						</div>
					</div>
				</form>
			</div>
	</body>
</html>