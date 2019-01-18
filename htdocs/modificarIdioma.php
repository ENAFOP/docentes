<?php

include("./inc/inc.Settings.php");
include("./inc/inc.Utils.php");
include("./inc/inc.Init.php");
include("./inc/inc.DBInit.php");
$id="";
$categoria=""; //me dirá el numero de linea del fichero
$valor="";  //nuevo contenido de la línea pk
$estadopostulacion="";
$idpostulacion="";
if(isset($_GET['id']))
{
  $id=$_GET['id'];
}
if(isset($_GET['categoria']))
{
  $categoria=$_GET['categoria'];
}
if(isset($_GET['valor']))
{
  $valor=$_GET['valor'];
}
if(isset($_GET['estadopostulacion']))
{
  $estadopostulacion=$_GET['estadopostulacion'];

}
if(isset($_GET['idpostulacion']))
{
  $idpostulacion=$_GET['idpostulacion'];

}
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
    echo "modificarIdioma.php: Error: no se pudo conectar a la BD para modificar a ";
	exit;
  } 

  $modificar="UPDATE idiomas  SET $categoria = '$valor' WHERE id=$id;";
		  //echo "mi query: ".$modificar;
   $resultado1=$manejador->getResult($modificar);
     $historico="INSERT INTO historial VALUES (NULL,$idpostulacion,'$estadopostulacion',NOW(),'Cambió escala del idioma en categoría $categoria a $valor')";
		  //echo "cargos query historica: ".$historico;
		  $resultado2=$manejador->getResult($historico);
?>