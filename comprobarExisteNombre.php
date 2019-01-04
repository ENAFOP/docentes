<?php
////// SE LLAMA DESDE el JS checkRegistro.js; mediante llamada Ajax. COmprueba si un nombre de usuario existe en la BD, devuelve true si existe o false si no (o sea, el nombre está disponible y se puede tomar)
header("Content-type:application/json");
include("./inc/inc.Settings.php");
include("./inc/inc.Utils.php");
include("./inc/inc.Init.php");
include("./inc/inc.DBInit.php");
/////////////////////////////////////////////////////////////////////////////////////////////////////////// MAIN ////////////////////////////////////////////////////////////////////////////////////////////////
$respuesta=true; //true si existe, false si no
$usuario = $_GET['usuario'];
									
		  
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
    echo "comprobarExisteNombre.php: Error: no se pudo conectar a la BD para modificar a ";
	exit;
  } 
 
    $consultar="SELECT login FROM tblUsers where login='$usuario';";
	//echo "Consultar: ".$consultar;
	 $resultado1=$manejador->getResultArray($consultar);
	 if(!$resultado1)
	 {
		$respuesta=false;
	 }		  
echo json_encode($respuesta);
?>