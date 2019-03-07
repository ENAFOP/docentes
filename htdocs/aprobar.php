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
	$miQuery="UPDATE postulaciones SET estado='aprobado' WHERE idpostulante=$idpostulante;";
	$resultado=$manejador->getResult($miQuery);
	$miQuery2="INSERT into historial values (NULL,$idPostulacion,'aprobado',NOW(),'Postulante fue aprobado después de estar en evaluación')";
	$resultado2=$manejador->getResult($miQuery2);
	/////NOTIFICAR
	if(!$notifier)
	{
		echo "/escribirChat.php[]Error: no se pudo tener acceso al notificador";
		exit;
	}
    $receptor=$dms->getUser($idpostulante);
	$nombreInteresado=$receptor->getFullName();
	//echo "Nombre interesado: ".$nombreInteresado;
    //$idPostulado=$user->getID();
    $rutilla = "http".((isset($_SERVER['HTTPS']) && (strcmp($_SERVER['HTTPS'],'off')!=0)) ? "s" : "")."://".$_SERVER['HTTP_HOST'].$settings->_httpRoot."out/out.VerPostulacion.php?postulante=$idpostulante";
    $subject = htmlspecialchars("Su postulación a docente de la ENAFOP ha sido aprobada");
    $message = htmlspecialchars("\n Estimado(a) $nombreInteresado: \n Su postulación para ser docente de la ENAFOP ha sido aprobada. \n La dirección de la ENAFOP se pondrá en contacto con usted en breve para indicarle los siguientes pasos a seguir. \n Mientras tanto, puede acceder a su perfil desde el siguiente enlace: \n $rutilla \n");
    $params = array();
    $params['sitename'] = $settings->_siteName;
    $params['http_root'] = $settings->_httpRoot;
	$emisor=$dms->getUser(1);
    $notifier->toIndividual($emisor, $receptor, $subject, $message, $params);
	$newURL="out/out.ViewFolder.php?folderid=1";
	header('Location: '.$newURL);
?>

