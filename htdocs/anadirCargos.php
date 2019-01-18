<?php
include("./inc/inc.Settings.php");
include("./inc/inc.Language.php");
include("./inc/inc.Init.php");
include("./inc/inc.Extension.php");
include("./inc/inc.DBInit.php");
include("./inc/inc.ClassUI.php");
include("./inc/inc.Authentication.php");

if (isset($_GET["cargo"])) 
{
    $cargo=$_GET["cargo"];
    $funciones=$_GET["funciones"];
	$institucion=$_GET["institucion"];
	$anoInicial=$_GET["anoInicio"];
	$anoFinal=$_GET["anoFin"];
	//echo "A punto de anadir cargos;";
     $user->insertarCargo("$cargo","$anoInicial","$anoInicial","$funciones","$institucion");
} //fin de si hay cargos, los meto
?>