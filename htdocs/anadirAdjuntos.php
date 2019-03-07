<?php
include("./inc/inc.Settings.php");
include("./inc/inc.Language.php");
include("./inc/inc.Init.php");
include("./inc/inc.Extension.php");
include("./inc/inc.DBInit.php");
include("./inc/inc.ClassUI.php");
include("./inc/inc.Authentication.php");
$folderid = $_POST["folderid"];
$estadopostulacion = $_POST["estadopostulacion"];
$idpostulacion = $_POST["idpostulacion"];
 $carpetaUsuario=$dms->getFolder($folderid);
$listaCarpetas=$carpetaUsuario->getSubFolders("n");
//////ESTE BUCLE DE RECORRER CARPETAS SOLO LO HAGO ONCE
$idCarpetaDocencia=0;
$idCarpetaTalleres=0;
$idCarpetaMetodologias=0;
$idCarpetaAdjuntos=0;
foreach ($listaCarpetas as $carpeta) 
{
    $nom=$carpeta->getName();
    if(strcmp($nom, "Atestados práctica docencia")==0)
    {
        $idCarpetaDocencia=$carpeta->getID();
    }
    if(strcmp($nom, "Atestados experiencia en formación")==0)
    {
        $idCarpetaTalleres=$carpeta->getID();
    }

    if(strcmp($nom, "Atestados manejo de metodologías")==0)
    {
        $idCarpetaMetodologias=$carpeta->getID();
    }
    if(strcmp($nom, "Documentos adjuntos")==0)
    {
        $idCarpetaAdjuntos=$carpeta->getID();
    }
}//FIN DE RECORRER CARPETAS PARA VER ID DE CARPETA. EXIGE TENERLAS CREADAS DE ANTEMANO
if (is_uploaded_file($_FILES['cartaMotivacion']['tmp_name'])) 
{
	$ubicacionTemporal=$_FILES['cartaMotivacion']['tmp_name'];
	$userFileNombre = $_FILES["cartaMotivacion"]["name"];
   $userFileTipo=$_FILES['cartaMotivacion']['type'];
   $fileTipo=".".pathinfo($userFileNombre, PATHINFO_EXTENSION);
   $user->insertarAdjunto("cartas",$idCarpetaAdjuntos,$ubicacionTemporal,$fileTipo,$userFileTipo,$userFileNombre); 
}
if(is_uploaded_file($_FILES['referenciasPersonales']['tmp_name'])) 
{
	$ubicacionTemporal=$_FILES['referenciasPersonales']['tmp_name'];
	$userFileNombre = $_FILES["referenciasPersonales"]["name"];
   $userFileTipo=$_FILES['referenciasPersonales']['type'];
   $fileTipo=".".pathinfo($userFileNombre, PATHINFO_EXTENSION);
   $user->insertarAdjunto("referencias_personales",$idCarpetaAdjuntos,$ubicacionTemporal,$fileTipo,$userFileTipo,$userFileNombre); 
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
    echo "anadirAdjuntos.php: Error: no se pudo conectar a la BD para modificar a ";
	exit;
  } 
    $historico="INSERT INTO historial VALUES (NULL,$idpostulacion,'$estadopostulacion',NOW(),'Añadido un nuevo documento adjunto (motivaciones o referencias personales)')";
		  //echo "Query historica: ".$historico;
		  $resultado2=$manejador->getResult($historico);
header('Location: '."out/out.ModificarPerfil.php"); 
}
?>