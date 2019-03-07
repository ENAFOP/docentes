<?php
include("./inc/inc.Settings.php");
include("./inc/inc.LogInit.php");
include("./inc/inc.Utils.php");
include("./inc/inc.Language.php");
include("./inc/inc.Init.php");
include("./inc/inc.Extension.php");
include("./inc/inc.DBInit.php");
include("./inc/inc.Authentication.php");
include("./inc/inc.ClassUI.php");
$idpostulante=$_POST["idPostulante"];
$idPostulacion=$_POST["idPostulacion"];
$razon=$_POST["razon"];
//echo "idpostulacion: ".$idPostulacion;
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
		echo "/aprobar.php[]Error: no se pudo conectar a la BD";
	}	
	//query de consulta:
	$miQuery="UPDATE postulaciones SET estado='rechazado' WHERE idpostulante=$idpostulante;";
	$resultado=$manejador->getResult($miQuery);
	$miQuery2="INSERT into historial values (NULL,$idPostulacion,'rechazado',NOW(),'$razon')";
	$resultado2=$manejador->getResult($miQuery2);
	/////NOTIFICAR
    $receptor=$dms->getUser($idpostulante);
	$nombreInteresado=$receptor->getFullName();
    //$idPostulado=$user->getID();
    $rutilla = "http".((isset($_SERVER['HTTPS']) && (strcmp($_SERVER['HTTPS'],'off')!=0)) ? "s" : "")."://".$_SERVER['HTTP_HOST'].$settings->_httpRoot."out/out.VerPostulacion.php?postulante=$idpostulante";
    $subject = htmlspecialchars("Su postulación a docente de la ENAFOP no ha sido aprobada");
    $message = htmlspecialchars("\n Estimado(a) $nombreInteresado: \n Se le informa que su postulación para ser docente de la ENAFOP no ha sido aprobada. \n Puede dirigirse a la dirección enafop@presidencia.gob.sv para consultar cuáles son los siguientes pasos a tomar. \n Mientras tanto, puede acceder a su perfil desde el siguiente enlace: \n $rutilla \n");
    $params = array();
    $params['sitename'] = $settings->_siteName;
    $params['http_root'] = $settings->_httpRoot;
	$emisor=$dms->getUser(1);
    $notifier->toIndividual($emisor, $receptor, $subject, $message, $params);
     $baseServer=$settings->_httpRoot;
	$newURL=$baseServer."out/out.ViewFolder.php?folderid=1";
	header('Location: '.$newURL);
?>
