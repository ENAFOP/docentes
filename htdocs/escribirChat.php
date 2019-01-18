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
$mensajito=$_POST["mensajito"];
if(strcmp($mensajito, "")==0)
{
	UI::exitError("Mensaje vacío","el mensaje enviado no puede estar vacío. Por favor, ingrese el texto pertinente");
}
$escritor=$_POST["escritor"];
$chat=$_POST["chat"];
$timestamp=$_POST["timestamp"];
//
$postulado=$_POST["postulado"];
$enviante=$dms->getUser($escritor);
$interesado=$dms->getUser($postulado);
$admini=$dms->getUser(1);

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
		echo "/escribirChat.php[]Error: no se pudo conectar a la BD";
		exit;
	}	
	//query de consulta:
	$insertar="INSERT into chat_log values (NULL,$chat,$escritor,'$mensajito','$timestamp')";
	$manejador->getResult($insertar);
	if(!$notifier)
	{
		echo "/escribirChat.php[]Error: no se pudo tener acceso al notificador";
		exit;
	}
	//se notifica del mensaje tanto a postulante como admin 1
	$nombreInteresado=$interesado->getFullName();
	$nombreEnviante=$enviante->getFullName();
	$rutilla = "http".((isset($_SERVER['HTTPS']) && (strcmp($_SERVER['HTTPS'],'off')!=0)) ? "s" : "")."://".$_SERVER['HTTP_HOST'].$settings->_httpRoot."out/out.VerPostulacion.php?postulante=$postulado";
	$subject = htmlspecialchars("Observación realizada a la postulación de $nombreInteresado");
	$message = htmlspecialchars("\n $nombreEnviante ha realizado la siguiente observación/respuesta a la postulación de  $nombreInteresado: \n $mensajito \n Puede acceder al perfil del postulante desde el siguiente enlace: \n $rutilla \n");
	$params = array();
	$params['sitename'] = $settings->_siteName;
	$params['http_root'] = $settings->_httpRoot;
	
	//dos copias del correo: al admin y al que envía
	if($enviante->isAdmin()) //si quien escribe es el admin, correo dirigido de admin a postulante
	{
	  $notifier->toIndividual($enviante, $interesado, $subject, $message, $params);
	}
	else //si quien escribe es postulante, se manda al admin
	{
	   $notifier->toIndividual($enviante, $admini, $subject, $message, $params);
	}
	
	
	$newURL="/out/out.VerPostulacion.php?postulante=$postulado";
	header('Location: '.$newURL);
?>

