<?php
header("Content-type:application/json");
include("./inc/inc.Settings.php");
include("./inc/inc.Utils.php");
include("./inc/inc.Init.php");
include("./inc/inc.DBInit.php");
/////////////////////////////////////////////////////////////////////////////////////////////////////////// MAIN ////////////////////////////////////////////////////////////////////////////////////////////////
$arrayMunicipios = array(); //contenedos gene
$departamento = $_GET['departamento'];	
		  
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
    echo "response.php: Error: no se pudo conectar a la BD";
	exit;
  } 
  $obtenerID="SELECT id FROM departamentos WHERE departamento='$departamento'";
  //error_log ("mi query: ".$obtenerID);
  $resultado1=$manejador->getResultArray($obtenerID);
  $idEfectivo=$resultado1[0]['id'];  
   ////
  $obtenerMunicipios="SELECT municipio FROM municipios WHERE idepartamento=$idEfectivo;";
  $resultado2=$manejador->getResultArray($obtenerMunicipios); 
  ////////////////////// EL SELECT
  foreach ($resultado2 as $a) 
  {
    foreach ($a as $valor) 
    {
       $arrayMunicipios[]="<option value=\"".$valor."\">".$valor."</option>";
	   //echo "Municipio: ".$valor;
    }
  }
echo json_encode($arrayMunicipios);
?>