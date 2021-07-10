<!DOCTYPE html>
<html ng-app="wmsu_ics_app">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>WMSU ICS | Login</title>
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

  <!--APP JS-->
  <script type="text/javascript" src="/js/angular.min.js"></script>
  <script type="text/javascript" src="/js/main.app.js"></script>
  <script type="text/javascript" src="/js/services/system/texts.service.js"></script>
  <script type="text/javascript" src="/js/services/system/helper.service.js"></script>
  
  <script type="text/javascript" src="/js/controllers/access/login.controller.js"></script>
  <script type="text/javascript" src="/js/services/access/login.service.js"></script>
  <!--ANGULAR JS-->
    
  <!-- Angular UI calendar -->
	<link rel="stylesheet" href="/assets/shared/ui-calendar/fullcalendar/dist/fullcalendar.css"/>
	<script type="text/javascript" src="/assets/shared/ui-calendar/moment/min/moment.min.js"></script>
	<script type="text/javascript" src="/assets/shared/ui-calendar/angular-ui-calendar/src/calendar.js"></script>
	<script type="text/javascript" src="/assets/shared/ui-calendar/fullcalendar/dist/fullcalendar.min.js"></script>
	<script type="text/javascript" src="/assets/shared/ui-calendar/fullcalendar/dist/gcal.js"></script>

  
  <!-- ng-datatable -->
<script src="/js/directives/ng-table.directive.js"></script>

    <!-- jQuery 2.2.3 -->
    <script src="assets/account/plugins/jQuery/jquery-2.2.3.min.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="assets/account/bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="assets/account/plugins/iCheck/icheck.min.js"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
</head>
<body class="hold-transition login-page" ng-controller="login-controller">
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
  <div class="login-box">
    <div class="login-logo">
      <a href="/">WMSU ICS</a>
    </div>
    <!-- /.login-logo -->
    
    <div class="login-box-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form name="frmLogin" novalidate ng-submit="authenticate()">
        <div class="form-group has-feedback">
          <input type="text" class="form-control" placeholder="Username" name="username" ng-model="login.username" required>
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

          <div ng-show="frmLogin.username.$dirty && frmLogin.username.$invalid">
            <span class="text-red" ng-show="frmLogin.username.$error.required">
              <i class="fa fa-warning "></i> Please enter username
            </span>
          </div>

        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Password" name="password" ng-model="login.password" required>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>

          <div ng-show="frmLogin.password.$dirty && frmLogin.password.$invalid">
            <span class="text-red" ng-show="frmLogin.password.$error.required">
              <i class="fa fa-warning"></i> Please enter password
            </span>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6">
            <!-- <div class="checkbox icheck">
              <label>
                <input type="checkbox"> Remember Me
              </label>
            </div> -->
          </div>
          <!-- /.col -->
          <div class="col-xs-6" ng-show="!login.authenticating">
            <button ng-disabled="(frmLogin.username.$dirty && frmLogin.username.$invalid) || frmLogin.password.$dirty && (frmLogin.password.$invalid)  || (login.username == '' || login.password == '')" type="submit" class="btn btn-success btn-block btn-flat">Sign In</button> 
          </div>
          <div class="col-xs-6" ng-show="login.authenticating">
            <button class="btn btn-success btn-block btn-flat disabled"><i class="fa fa-refresh fa-spin"></i> Authenticating </button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <hr>
      <!-- /.social-auth-links -->
      <div class="row">
          <div class="col-md-6 hidden">
              <center>
                  <a href="#">I forgot my password</a><br>
              </center>  
          </div>
          <div class="col-md-12">
              <center>
                  <a href="/access/register">Register new account</a><br>
              </center>  
          </div>
      </div>
    </div>
    <!-- /.login-box-body -->
  </div>

</body>
</html>
