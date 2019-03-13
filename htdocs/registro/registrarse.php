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
  <link rel="stylesheet" href="../styles/multisis-lte/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../styles/multisis-lte/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../styles/multisis-lte/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../styles/multisis-lte/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../styles/multisis-lte/plugins/iCheck/square/blue.css">


<script type="text/javascript" src="../styles/multisis-lte/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script type="text/javascript" src="../styles/multisis-lte/plugins/bootbox/bootbox-4.4.0.min.js"></script>
<script type="text/javascript" src="../styles/multisis-lte/passwordstrength/jquery.passwordstrength.js"></script>
<script type="text/javascript" src="../styles/multisis-lte/plugins/noty/jquery.noty.js"></script>
<script type="text/javascript" src="../styles/multisis-lte/plugins/noty/layouts/topRight.js"></script>
<script type="text/javascript" src="../styles/multisis-lte/plugins/noty/layouts/topCenter.js"></script>
<script type="text/javascript" src="../styles/multisis-lte/plugins/noty/themes/default.js"></script>
<script type="text/javascript" src="../styles/multisis-lte/plugins/jqtree/tree.jquery.js"></script>
<script type="text/javascript" src="../styles/multisis-lte/custom/js/validate-logo.js"></script>

<link href="../styles/multisis-lte/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
<script type="text/javascript" src="../styles/multisis-lte/plugins/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../styles/multisis-lte/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="../styles/multisis-lte/validate/jquery.validate.js"></script>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<style type="text/css">
  

  #nit1:valid {
    color: green;
}

#nit1:invalid {
    color: red;
}


  #nit2:valid {
    color: green;
}

#nit2:invalid {
    color: red;
}


  #nit3:valid {
    color: green;
}

#nit3:invalid {
    color: red;
}


  #nit4:valid {
    color: green;
}

#nit4:invalid {
    color: red;
}
</style>
<body class="hold-transition register-page">
  <form action="../out/out.AnadirUsuario.php" method="post" name="formRegistro" id="formRegistro">



<div class="row">


<div class="col-lg-1">
</div>

  <div class="col-lg-8">

      <div class="box box-primary">

        <div class="box-header with-border">
              <h3 class="box-title">Formulario de registro</h3>
              <div class="register-logo">
            <img src="../images/logo_transparente.png" width="300" height="105" ><a href="../../index2.html"></a></img>
          </div>
            </div>


          

  <div class="box-body">
    <p class="login-box-msg">Registrarse para ingresar al banco de datos de facilitadores, docentes y tutores virtuales de la ENAFOP</p>

    


      <label for="nombre">Nombre completo</label>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre completo">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>


      <label for="usuario">NIT</label>
      <p>Ingrese a continuación los dígitos de su NIT, con guiones:</p>
      <div class="form-group has-feedback" id="divNomUsuario">
        

                        <span class="input-group-addon">
                          <input dir="ltr" type="text" title="Ingrese el NIT con guiones"  id="nit" name="nit" placeholder="Ingrese el NIT" required="'required'" class="form-control"  autocomplete="off" />
                        </span>

                                     

                  <!-- /input-group -->
                  <span class="glyphicon glyphicon-road form-control-feedback"></span>

         <label id="chequecito" class="control-label" for="inputSuccess" style="display: none;"><i class="fa fa-check"></i> El NIT no ha sido utilizado y por tanto puede registrarse
         </label>

         <label id="chequecitoMalo" class="control-label" for="inputError" style="display: none;"><i class="fa fa-times"></i> El NIT ya existe. Si ha olvidado su contraseña enviar un correo.
         </label>
        </div>


        

        

 


      <label for="email">Correo electrónico principal</label>
      <div class="form-group has-feedback">
        <input type="email" class="form-control" name="correo" id="correo" placeholder="Correo electrónico">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>

      <label for="password">Asigne una contraseña</label>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password" id="password" placeholder="Incluya números, símbolos y mayúsculas">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>

      <label for="password2">Repita la contraseña</label>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password2" id="password2" placeholder="Vuelva a digitar el mismo password">
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
      </div>
      <div class="row">
     
        <!-- /.col -->
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Darse de alta</button>
        </div>
        <!-- /.col -->
      </div>
   
  </div> <!-- /.box body-box -->
  
</div>
<!-- /.register-box -->
</form>
  </div> <!-- FIN DE COLUMNA PRINCIPAL DE 8 -->

  <div class="col-lg-3">
      <div class="box box-default">
            <div class="box-header with-border">
              <i class="fa fa-warning"></i>

              <h3 class="box-title">Recordatorio</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">


              <div class="callout callout-success">
                <h4>Esta herramienta no permite la aplicación a un empleo</h4>

                <p>A través de la herramienta de base de datos de docentes, facilitadores y personas tutoras virtuales, la ENAFOP busca tener un directorio de personas que podrán ser invitadas en un momento determinado, a participar de los procesos formales de contratación establecidos en la LACAP para procesos formativos que surgan como parte de su oferta académica.

                  <br><br>
                  Usted volcará a través de esta herramienta su hoja de vida para que la ENAFOP, en caso de aprobar la postulación para ingresar en esta base, pueda contactarlo en dado caso se lance un programa formativo que requiera de personas facilitadoras de su área de especialidad.
                </p>
              </div>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <div class="box box-default">
            <div class="box-header with-border">
              <i class="fa fa-info"></i>

              <h3 class="box-title">Haga clic aquí si ya se registró previamente para acceder con su NIT y contraseña</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">


              <a class="btn btn-block btn-social btn-github" href="../out/out.Login.php">
                <i class="fa fa-key"></i> Iniciar sesión
              </a>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
  </div>




  </div> <!-- FIN DE ROW -->

<!-- Bootstrap 3.3.7 -->
<script src="../styles/multisis-lte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="../checkRegistro.js"></script>;
<script src="../styles/multisis-lte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script><script src="../styles/multisis-lte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script><script src="../tablasDinamicas.js"></script><script src="../styles/multisis-lte/dist/js/app.min.js"></script>
<script src="../styles/multisis-lte/plugins/slimScroll/jquery.slimscroll.min.js"></script><script src="../styles/multisis-lte/plugins/fastclick/fastclick.js"></script><script src="../styles/multisis-lte/plugins/pace/pace.min.js"></script><script src="../styles/multisis-lte/datepicker/js/bootstrap-datepicker.js"></script>
<script src="../styles/multisis-lte/chosen/js/chosen.jquery.min.js"></script>
<script src="../styles/multisis-lte/select2/js/select2.min.js"></script>
<script src="../styles/multisis-lte/application.js"></script>
<script src="../styles/multisis-lte/dist/js/demo.js"></script>
<script src="../styles/multisis-lte/bootstrap/js/bootstrap-2.min.js"></script>
</body>
</html>
