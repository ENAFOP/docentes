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
$arrayTalleres=array();
if (isset($_POST["nombreTaller"])) 
{
    $arrayTalleres=$_POST["nombreTaller"];
    $arrayHoras=array();
if (isset($_POST["totalHoras"])) 
{
    $arrayHoras=$_POST["totalHoras"];
}
$arrayTallerIni=array();
if (isset($_POST["periodoTallerInicial"])) 
{
    $arrayTallerIni=$_POST["periodoTallerInicial"];
}
$arrayTallerFini=array();
if (isset($_POST["periodoTallerFinal"])) 
{
    $arrayTallerFini=$_POST["periodoTallerFinal"];
}
$arrayInstitucionTaller=array();
if (isset($_POST["institucionTaller"])) 
{
    $arrayInstitucionTaller=$_POST["institucionTaller"];
}
$arrayModalidadTaller=array();
if (isset($_POST["modalidadTaller"])) 
{
    $arrayModalidadTaller=$_POST["modalidadTaller"];
}
$arrayNombresFichero=array();
$arrayTiposFichero=array();
$arrayUbicacionesFichero=array();
$arrayFileTypes=array();
if (isset($_FILES["atestadoTaller"])) 
{
    //echo "HAY HTTP atestadatestadoTalleroMateria";
    //print_r($_FILES);
    $archivo=$_FILES["atestadoTaller"];
    $len = count($_FILES['atestadoTaller']['name']);
    for($i = 0; $i < $len; $i++) 
    {
        $arrayUbicacionesFichero[]=$_FILES['atestadoTaller']['tmp_name'][$i];
        $userfilename = $_FILES["atestadoTaller"]["name"][$i];
       $arrayNombresFichero[] = $userfilename;
       $arrayTiposFichero[]=$_FILES['atestadoTaller']['type'][$i];
       $arrayFileTypes[]=".".pathinfo($userfilename, PATHINFO_EXTENSION);
       

    }
}
$numtalleres=count($arrayTalleres);
for ($i=0;$i<$numtalleres;$i++) 
{
    
    $taller=$arrayTalleres[$i];
    $totalhoras=$arrayHoras[$i];
    $yearIni=$arrayTallerIni[$i];
    $yearFini=$arrayTallerFini[$i];
    $institucion=$arrayInstitucionTaller[$i];
    $modalidad=$arrayModalidadTaller[$i];
    ///
    $ubicacionTemporal=$arrayUbicacionesFichero[$i];
    $fileTipo=$arrayFileTypes[$i];
    $userFileTipo=$arrayTiposFichero[$i];
    $userFileNombre=$arrayNombresFichero[$i];
    //echo "A METER TALLERES";
$user->insertarTalleres($idCarpetaTalleres,$ubicacionTemporal,$fileTipo,$userFileTipo,$userFileNombre,"$taller","$totalhoras","$yearIni","$yearFini","$institucion","$modalidad");
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
    echo "anadirTalleres.php: Error: no se pudo conectar a la BD para modificar a ";
	exit;
  } 
    $historico="INSERT INTO historial VALUES (NULL,$idpostulacion,'$estadopostulacion',NOW(),'Añadido una nueva(s) experiencia(s) en formación y capacitación')";
		  //echo "Query historica: ".$historico;
		  $resultado2=$manejador->getResult($historico);
header('Location: '."/out/out.ModificarPerfil.php"); 
}
} //fin de si hay talleres y 
?>