<?php 


include("../inc/inc.Settings.php");
include("../inc/inc.Language.php");
include("../inc/inc.Init.php");
include("../inc/inc.Extension.php");
include("../inc/inc.DBInit.php");
include("../inc/inc.ClassUI.php");
//include("../inc/inc.Authentication.php");

?>
<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ENAFOP | Página de registro para el sistema de gestión de docentes</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="/styles/multisis-lte/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/styles/multisis-lte/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="/styles/multisis-lte/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/styles/multisis-lte/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="/styles/multisis-lte/plugins/iCheck/square/blue.css">


<script type="text/javascript" src="/styles/multisis-lte/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script type="text/javascript" src="/styles/multisis-lte/plugins/bootbox/bootbox-4.4.0.min.js"></script>
<script type="text/javascript" src="/styles/multisis-lte/passwordstrength/jquery.passwordstrength.js"></script>
<script type="text/javascript" src="/styles/multisis-lte/plugins/noty/jquery.noty.js"></script>
<script type="text/javascript" src="/styles/multisis-lte/plugins/noty/layouts/topRight.js"></script>
<script type="text/javascript" src="/styles/multisis-lte/plugins/noty/layouts/topCenter.js"></script>
<script type="text/javascript" src="/styles/multisis-lte/plugins/noty/themes/default.js"></script>
<script type="text/javascript" src="/styles/multisis-lte/plugins/jqtree/tree.jquery.js"></script>
<script type="text/javascript" src="/styles/multisis-lte/custom/js/validate-logo.js"></script>
<script type="text/javascript" src="/styles/multisis-lte/validation/jquery-validation-1.17.0/dist/jquery.validate.min.js"></script>
<link href="/styles/multisis-lte/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
<script type="text/javascript" src="/styles/multisis-lte/plugins/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/styles/multisis-lte/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="/styles/multisis-lte/validate/jquery.validate.js"></script>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <img src="/images/logo_transparente.png" width="300" height="120" ><a href="../../index2.html"></a></img>
	
  </div>

  <div class="register-box-body">
    <p class="login-box-msg">Registrarse para el sistema de gestión de docentes de la ENAFOP</p>

    <form action="../out/out.AnadirUsuario.php" method="post" name="formRegistro" id="formRegistro">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre completo">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>






      <div class="form-group has-feedback" id="divNomUsuario">
      
        <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Nombre de usuario">
        <span class="glyphicon glyphicon-road form-control-feedback"></span>

         <label id="chequecito" class="control-label" for="inputSuccess" style="display: none;"><i class="fa fa-check"></i> El nombre de usuario no ha sido utilizado
         </label>

         <label id="chequecitoMalo" class="control-label" for="inputError" style="display: none;"><i class="fa fa-times"></i> El nombre de usuario ya ha sido utilizado. Elija otro.
         </label>
      </div>
 



      <div class="form-group has-feedback">
        <input type="email" class="form-control" name="correo" id="correo" placeholder="Correo electrónico">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password2" id="password2" placeholder="Vuelva a digitar password">
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
      </div>
      <div class="row">
     
        <!-- /.col -->
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Darse de alta</button>
        </div>
        <!-- /.col -->
      </div>

       
    </form>


    <a href="/out/out.Login.php" class="text-center">Ya tengo una cuenta</a>
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->

<!-- Bootstrap 3.3.7 -->
<script src="/styles/multisis-lte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="/checkRegistro.js"></script>;
<script src="../styles/multisis-lte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script><script src="../styles/multisis-lte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script><script src="../tablasDinamicas.js"></script><script src="/styles/multisis-lte/dist/js/app.min.js"></script>
<script src="/styles/multisis-lte/plugins/slimScroll/jquery.slimscroll.min.js"></script><script src="/styles/multisis-lte/plugins/fastclick/fastclick.js"></script><script src="/styles/multisis-lte/plugins/pace/pace.min.js"></script><script src="/styles/multisis-lte/datepicker/js/bootstrap-datepicker.js"></script>
<script src="/styles/multisis-lte/chosen/js/chosen.jquery.min.js"></script>
<script src="/styles/multisis-lte/select2/js/select2.min.js"></script>
<script src="/styles/multisis-lte/application.js"></script>
<script src="/styles/multisis-lte/dist/js/demo.js"></script>
<script src="/styles/multisis-lte/bootstrap/js/bootstrap-2.min.js"></script>
</body>
</html>
