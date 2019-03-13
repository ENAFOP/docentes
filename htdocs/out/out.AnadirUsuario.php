<?php
//    
//    Copyright (C) José Mario López Leiva. marioleiva2011@gmail.com_addre
//    September 2017. San Salvador (El Salvador)
//
//    This program is free software; you can redistribute it and/or modify
//    it under the terms of the GNU General Public License as published by
//    the Free Software Foundation; either version 2 of the License, or
//    (at your option) any later version.
//
//    This program is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU General Public License for more details.
//
//    You should have received a copy of the GNU General Public License
//    along with this program; if not, write to the Free Software
//    Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.

include("../inc/inc.Settings.php");
include("../inc/inc.Language.php");
include("../inc/inc.Init.php");
include("../inc/inc.Extension.php");
include("../inc/inc.DBInit.php");
include("../inc/inc.ClassUI.php");
//include("../inc/inc.Authentication.php");
function setDefaultUserFolder($id_usuario,$idCarpeta) //dado un id de usuario, me devuelve el id del folder de inicio de ese usuario
{
	//echo "Función getDefaultUserFolder. Se ha pasado con argumento: ".$id_usuario;
	$id_folder=0;
	 $settings = new Settings(); //acceder a parámetros de settings.xml con _antes
  	$driver=$settings->_dbDriver;
    $host=$settings->_dbHostname;
    $user=$settings->_dbUser;
    $pass=$settings->_dbPass;
    $base=$settings->_dbDatabase;
	$manejador=new SeedDMS_Core_DatabaseAccess($driver,$host,$user,$pass,$base);
	$estado=$manejador->connect();
	//echo "Conectado: ".$estado;
	if($estado!=1)
	{
		echo "out.viewFolder.php[getDefaultUserFolder]Error: no se pudo conectar a la BD";
	}	
	//query de consulta:
	$miQuery="UPDATE tblUsers SET homefolder = $idCarpeta WHERE id = $id_usuario";
	//echo "mi query: ".$miQuery;
	$resultado=$manejador->getResult($miQuery);
	return $resultado;
}
//tabla seeddms.tblattributedefinitions;
 //generan
// if ($user->isGuest()) 
// {
// 	UI::exitError(getMLText("my_documents"),getMLText("access_denied"));
// }

// Check to see if the user wants to see only those documents that are still
// in the review / approve stages.
$showInProcess = false;
if (isset($_GET["inProcess"]) && strlen($_GET["inProcess"])>0 && $_GET["inProcess"]!=0) {
	$showInProcess = true;
}

$orderby='n';
if (isset($_GET["orderby"]) && strlen($_GET["orderby"])==1 ) {
	$orderby=$_GET["orderby"];
}

if (isset($_GET["orderby"]) && strlen($_GET["orderby"])==1 ) 
{
	$orderby=$_GET["orderby"];
}

$nombre="";
$correo="";
$pass="";
$nit="";
if (isset($_POST["nombre"])) 
{
	$nombre=$_POST["nombre"];
}
if (isset($_POST["correo"])) 
{
	$correo=$_POST["correo"];
}
if (isset($_POST["nit"])) 
{
	$nit=$_POST["nit"];
}
if (isset($_POST["password"])) 
{
	$pass=$_POST["password"];
}

////// CREO LAS CARPETAS DONDE RESIDIRAN: LA CARPETA DEL USUARIO ESTARÁ EN LA CARPETA RAIZ (1), Y SE LLAMARA COMO SU NOMBRE REAL. dENTRO DE ESA CARPETA IRAN LAS DE ALOJAMIENTO.
$folderRaiz=$dms->getFolder(1);
$admin=$dms->getUser(1); //el dueño será el admin
$folderUsuario=$folderRaiz->addSubFolder($nombre,"Carpeta de $nombre",$admin, 1, NULL);
if(!$folderUsuario)
{
	UI::exitError(getMLText("folder_title", array("foldername" => "Error: no se pudo crear la carpeta raiz/$nombre")),getMLText("error_occured"));
}
$folder1=$folderUsuario->addSubFolder("Atestados práctica docencia","Carpeta de  atestados de $nombre",$admin, 1, NULL);
$folder2=$folderUsuario->addSubFolder("Atestados experiencia en formación","Carpeta de  atestados de formación de $nombre",$admin, 1, NULL);
$folder3=$folderUsuario->addSubFolder("Atestados manejo de metodologías","Carpeta de  atestados de manejos de metodologías de $nombre",$admin, 1, NULL);
$folder4=$folderUsuario->addSubFolder("Documentos adjuntos","Carpeta de  atestados de $nombre",$admin, 1, NULL);

$folder1->setDefaultAccess(3); //a los folders creados les doy permiso de lecto escritura 3
$folder2->setDefaultAccess(3);
$folder3->setDefaultAccess(3);
$folder4->setDefaultAccess(3);

$folder1->setInheritAccess(0); //linea añadida 28 sept 2017 
$folder2->setInheritAccess(0); //linea añadida 28 sept 2017 
$folder3->setInheritAccess(0); //linea añadida 28 sept 2017 
$folder4->setInheritAccess(0); //linea añadida 28 sept 2017 


$idFolderUsuario=$folderUsuario->getID();

////////////////////// CREO EL USUARIO ///////////////////
// addUser(string $login, string $pwd,  $fullName, string $email, string $language,  $theme, string $comment, integer $role, integer $isHidden, integer $isDisabled,  $pwdexpiration) : object
$comment="Usuario para poder hacer uso del sistema de gestión de docentes de la ENAFOP como postulante";
$role=0; //usuario normal
//echo "a crear usuario con NIT".$nit;
//echo "a crear usuario con pass".$pass;
//echo "a crear usuario con nombre".$nit;
$creacion=$dms->addUser($nit,md5($pass),$nombre,$correo,$settings->_language, $settings->_theme,$comment,$role,0,0,'',0,1);
if(!$creacion)
{
	UI::exitError(getMLText("folder_title", array("foldername" => "Error: no se pudo crear el usuario $nombre")),"Error: no se pudo crear el usuario $nombre");
}
//////////// seteo default folder
$idNuevoUsuario=$creacion->getID();
//seteo el folder de usuario como default
$setear=setDefaultUserFolder($idNuevoUsuario,$idFolderUsuario);
if($setear==false)
{
 UI::exitError(getMLText("folder_title", array("foldername" => "Error: no se pudo setear carpeta con id $idFolderUsuario como la default del usuario $nombre")),getMLText("error_occured"));
}

$mensajito="";
if($creacion) //si usuario se crea correctamente
{
	$mensajito="Usuario $usuario creado correctamente. Ahora puede acceder al sistema y crear su postulación";
}
else
{	
	$mensajito="Usuario $usuario No pudo ser creado. Revise los datos e intente nuevamente";
}


$tmp = explode('.', basename($_SERVER['SCRIPT_FILENAME']));
//$view = UI::factory($theme, $tmp[1], array('dms'=>$dms, 'user'=>$user));
// if($view) 
// {
// 	$view->setParam('orderby', $orderby);
// 	$view->setParam('showinprocess', $showInProcess);
// 	$view->setParam('workflowmode', $settings->_workflowMode);
// 	$view->setParam('cachedir', $settings->_cacheDir);
// 	$view->setParam('previewWidthList', $settings->_previewWidthList);
// 	$view->setParam('timeout', $settings->_cmdTimeout);
// 	$view->setParam('mensajito', $mensajito);

// 	$view($_GET);
// 	exit;
// }
?>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Usuario creado correctamente | ENAFOP</title>
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
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../styles/multisis-lte/dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

  <header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a href="out.Login.php" class="navbar-brand"><b>ENAFOP</b>  Banco de datos de personas facilitadoras ENAFOP</a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          <ul class="nav navbar-nav">
           
            <li><a href="http://www.enafop.gob.sv">Sitio web de la ENAFOP</a></li>
          </ul>
        </div>
        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less-->

            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!-- The user image in the navbar-->
                <img src="../images/usuario.png" class="user-image" alt="User Image">
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <span class="hidden-xs"><?php echo $nombre; ?></span>
              </a>
            </li>
          </ul>
        </div>
        <!-- /.navbar-custom-menu -->
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>
  <!-- Full Width Column -->
  <div class="content-wrapper">
    <div class="container">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Usuario
          <small>creado correctamente en el sistema</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-wpforms"></i> Registro</a></li>
          <li><a href="#">registro exitoso</a></li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="callout callout-info">
          <h4>¡Enhorabuena!</h4>
            <h4>  <?php  echo $mensajito; ?></h4>
            <h4><a href="out.Login.php">Ir a la página de inicio de sesión</a></h4>
              
        </div>
        <!-- /.box -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="container">
      <div class="pull-right hidden-xs">
        <b>Versión</b> 1.0.0
      </div>
      <strong>Copyright &copy; 2018 <a href="http://www.enafop.gob.sv">ENAFOP</a>.</strong>
    </div>
    <!-- /.container -->
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="../styles/multisis-lte/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../styles/multisis-lte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="../styles/multisis-lte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../styles/multisis-lte/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../styles/multisis-lte/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../styles/multisis-lte/dist/js/demo.js"></script>
</body>
</html>









