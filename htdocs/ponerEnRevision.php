<?php
include("./inc/inc.Settings.php");
include("./inc/inc.Utils.php");
include("./inc/inc.Init.php");
include("./inc/inc.Extension.php");
include("./inc/inc.DBInit.php");
include("./inc/inc.ClassUI.php");

$idpostulante=$_POST["idPostulante"];
$idPostulacion=$_POST["idPostulacion"];
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
		echo "/ponerEnRevision.php[]Error: no se pudo conectar a la BD";
	}	
	//query de consulta:
	$miQuery="UPDATE postulaciones SET estado='revisado' WHERE idpostulante=$idpostulante;";
	$resultado=$manejador->getResult($miQuery);
	$miQuery2="INSERT into historial values (NULL,$idPostulacion,'revisado',NOW(),'Postulante solicitó una nueva revisión, habiendo supuestamente corregido las carencias indicadas en su postulación, después de estar en evaluación')";
	$resultado2=$manejador->getResult($miQuery2);
	$newURL="out/out.ViewFolder.php?folderid=1";
	header('Location: '.$newURL);
?>

