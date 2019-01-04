<?php

include("./inc/inc.Settings.php");
include("./inc/inc.Utils.php");
include("./inc/inc.Init.php");
include("./inc/inc.DBInit.php");
$name="";
$pk=""; //me dirá el numero de linea del fichero
$value="";  //nuevo contenido de la línea pk
$estadopostulacion="";
$idpostulacion="";
if(isset($_POST['pk']))
{
  $pk=$_POST['pk'];
}
if(isset($_POST['name']))
{
  $name=$_POST['name'];
}
if(isset($_POST['value']))
{
  $value=$_POST['value'];
  //$value = iconv("UTF-8","windows-1250",$value);
}
if(isset($_POST['value']))
{
  $value=$_POST['value'];
  //$value = iconv("UTF-8","windows-1250",$value);
}
if(isset($_POST['estadopostulacion']))
{
  $estadopostulacion=$_POST['estadopostulacion'];

}
if(isset($_POST['idpostulacion']))
{
  $idpostulacion=$_POST['idpostulacion'];

}
$tmp = explode("_", $name);
$respuesta=false;
//echo "Fichero: ".$nombreFichero;
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
    echo "modificarConocimientos.php: Error: no se pudo conectar a la BD para modificar a ";
	exit;
  } 

      $modificar="UPDATE conocimientos_adicionales  SET $name = '$value' WHERE id=$pk;";

		  $resultado1=$manejador->getResult($modificar);
		  if(!$resultado1)
		  {
			$respuesta=false;
		  }
		  $historico="INSERT INTO historial VALUES (NULL,$idpostulacion,'$estadopostulacion',NOW(),'Modificados  conocimientos complementarios en la sección de temas de la administración pública')";
		  //echo "cargos query historica: ".$historico;
		  $resultado2=$manejador->getResult($historico);
  // echo "Pais, numero, telefono, correo,tipo,nit: ".$paisResidencia.$numeroDocumento.$telefono.$correo.$tipoDocumento.$nit;

?>