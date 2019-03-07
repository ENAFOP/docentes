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
//---------PESTAÑA 4: TEMAS DE LA ADMINISTRACIÓN PÚBLICA -----------------------
//insertarTema($sufijo,$nombreTema) 
$arrayMetodologiaProgramas=array();
$arrayMetodologiaProgramas=$_POST["metodologiaProgramas"];
if (array_filter($arrayMetodologiaProgramas)) 
{
    if (isset($_FILES["metodologiaProgramasAtestado"])) 
	{
		//echo "HAY HTTP metodologiaProgramas";
	    //print_r($_FILES);
	    $archivo=$_FILES["metodologiaProgramasAtestado"];
	    $len = count($_FILES['metodologiaProgramasAtestado']['name']);
	    $arrayUbicacionesFichero=array();
	    $arrayNombresFichero=array();
	    $arrayTiposFichero=array();
	    $arrayFileTypes=array();
	    for($i = 0; $i < $len; $i++) 
	    {
	    	$arrayUbicacionesFichero[]=$_FILES['metodologiaProgramasAtestado']['tmp_name'][$i];
	    	$userfilename = $_FILES["metodologiaProgramasAtestado"]["name"][$i];
	       $arrayNombresFichero[] = $userfilename;
	       $arrayTiposFichero[]=$_FILES['metodologiaProgramasAtestado']['type'][$i];
	       $arrayFileTypes[]=".".pathinfo($userfilename, PATHINFO_EXTENSION);
	    }
	    $num=count($arrayMetodologiaProgramas);
		for ($i=0;$i<$num;$i++) 
		{		
			$experiencia=$arrayMetodologiaProgramas[$i];
			///
			$ubicacionTemporal=$arrayUbicacionesFichero[$i];
			$fileTipo=$arrayFileTypes[$i];
			$userFileTipo=$arrayTiposFichero[$i];
			$userFileNombre=$arrayNombresFichero[$i];
		$user->insertarMetodologia("programas",$idCarpetaMetodologias,$ubicacionTemporal,$fileTipo,$userFileTipo,$userFileNombre,"$experiencia"); 
		}
	}	
}//fin de metodologias programas
$arrayMetodologiaProgramas=array();
$arrayMetodologiaProgramas=$_POST["metodologiaDisenoCartas"];
if (array_filter($arrayMetodologiaProgramas)) 
{
    if (isset($_FILES["metodologiaDisenoCartasAtestado"])) 
	{
		//echo "HAY HTTP metodologiaProgramas";
	    //print_r($_FILES);
	    $archivo=$_FILES["metodologiaDisenoCartasAtestado"];
	    $len = count($_FILES['metodologiaDisenoCartasAtestado']['name']);
	    $arrayUbicacionesFichero=array();
	    $arrayNombresFichero=array();
	    $arrayTiposFichero=array();
	    $arrayFileTypes=array();
	    for($i = 0; $i < $len; $i++) 
	    {
	    	$arrayUbicacionesFichero[]=$_FILES['metodologiaDisenoCartasAtestado']['tmp_name'][$i];
	    	$userfilename = $_FILES["metodologiaDisenoCartasAtestado"]["name"][$i];
	       $arrayNombresFichero[] = $userfilename;
	       $arrayTiposFichero[]=$_FILES['metodologiaDisenoCartasAtestado']['type'][$i];
	       $arrayFileTypes[]=".".pathinfo($userfilename, PATHINFO_EXTENSION);
	    }
	    $num=count($arrayMetodologiaProgramas);
		for ($i=0;$i<$num;$i++) 
		{		
			$experiencia=$arrayMetodologiaProgramas[$i];
			///
			$ubicacionTemporal=$arrayUbicacionesFichero[$i];
			$fileTipo=$arrayFileTypes[$i];
			$userFileTipo=$arrayTiposFichero[$i];
			$userFileNombre=$arrayNombresFichero[$i];
		$user->insertarMetodologia("disenocartas",$idCarpetaMetodologias,$ubicacionTemporal,$fileTipo,$userFileTipo,$userFileNombre,"$experiencia"); 
		}
	}	
}//fin de metodologias disenocartaa

$arrayMetodologiaProgramas=array();
$arrayMetodologiaProgramas=$_POST["metodologiaEvaluacion"];
if (array_filter($arrayMetodologiaProgramas)) 
{
    if (isset($_FILES["metodologiaEvaluacionAtestado"])) 
	{
		//echo "HAY HTTP metodologiaProgramas";
	    //print_r($_FILES);
	    $archivo=$_FILES["metodologiaEvaluacionAtestado"];
	    $len = count($_FILES['metodologiaEvaluacionAtestado']['name']);
	    $arrayUbicacionesFichero=array();
	    $arrayNombresFichero=array();
	    $arrayTiposFichero=array();
	    $arrayFileTypes=array();
	    for($i = 0; $i < $len; $i++) 
	    {
	    	$arrayUbicacionesFichero[]=$_FILES['metodologiaEvaluacionAtestado']['tmp_name'][$i];
	    	$userfilename = $_FILES["metodologiaEvaluacionAtestado"]["name"][$i];
	       $arrayNombresFichero[] = $userfilename;
	       $arrayTiposFichero[]=$_FILES['metodologiaEvaluacionAtestado']['type'][$i];
	       $arrayFileTypes[]=".".pathinfo($userfilename, PATHINFO_EXTENSION);
	    }
	    $num=count($arrayMetodologiaProgramas);
		for ($i=0;$i<$num;$i++) 
		{		
			$experiencia=$arrayMetodologiaProgramas[$i];
			///
			$ubicacionTemporal=$arrayUbicacionesFichero[$i];
			$fileTipo=$arrayFileTypes[$i];
			$userFileTipo=$arrayTiposFichero[$i];
			$userFileNombre=$arrayNombresFichero[$i];
		$user->insertarMetodologia("evaluacion",$idCarpetaMetodologias,$ubicacionTemporal,$fileTipo,$userFileTipo,$userFileNombre,"$experiencia"); 
		}
	}	
}//fin de metodologias metodologiaEvaluacionAtestado
$arrayMetodologiaProgramas=array();
$arrayMetodologiaProgramas=$_POST["metodologiaFacilitacion"];
if (array_filter($arrayMetodologiaProgramas)) 
{
    if (isset($_FILES["metodologiaFacilitacionAtestado"])) 
	{
		//echo "HAY HTTP metodologiaProgramas";
	    //print_r($_FILES);
	    $archivo=$_FILES["metodologiaFacilitacionAtestado"];
	    $len = count($_FILES['metodologiaFacilitacionAtestado']['name']);
	    $arrayUbicacionesFichero=array();
	    $arrayNombresFichero=array();
	    $arrayTiposFichero=array();
	    $arrayFileTypes=array();
	    for($i = 0; $i < $len; $i++) 
	    {
	    	$arrayUbicacionesFichero[]=$_FILES['metodologiaFacilitacionAtestado']['tmp_name'][$i];
	    	$userfilename = $_FILES["metodologiaFacilitacionAtestado"]["name"][$i];
	       $arrayNombresFichero[] = $userfilename;
	       $arrayTiposFichero[]=$_FILES['metodologiaFacilitacionAtestado']['type'][$i];
	       $arrayFileTypes[]=".".pathinfo($userfilename, PATHINFO_EXTENSION);
	    }
	    $num=count($arrayMetodologiaProgramas);
		for ($i=0;$i<$num;$i++) 
		{		
			$experiencia=$arrayMetodologiaProgramas[$i];
			///
			$ubicacionTemporal=$arrayUbicacionesFichero[$i];
			$fileTipo=$arrayFileTypes[$i];
			$userFileTipo=$arrayTiposFichero[$i];
			$userFileNombre=$arrayNombresFichero[$i];
		$user->insertarMetodologia("facilitacion",$idCarpetaMetodologias,$ubicacionTemporal,$fileTipo,$userFileTipo,$userFileNombre,"$experiencia"); 
		}
	}	
}//fin de metodologias facilitacion
$arrayMetodologiaProgramas=array();
$arrayMetodologiaProgramas=$_POST["metodologiaParticipativa"];
if (array_filter($arrayMetodologiaProgramas)) 
{
    if (isset($_FILES["metodologiaParticipativaAtestado"])) 
	{
		//echo "HAY HTTP metodologiaProgramas";
	    //print_r($_FILES);
	    $archivo=$_FILES["metodologiaParticipativaAtestado"];
	    $len = count($_FILES['metodologiaParticipativaAtestado']['name']);
	    $arrayUbicacionesFichero=array();
	    $arrayNombresFichero=array();
	    $arrayTiposFichero=array();
	    $arrayFileTypes=array();
	    for($i = 0; $i < $len; $i++) 
	    {
	    	$arrayUbicacionesFichero[]=$_FILES['metodologiaParticipativaAtestado']['tmp_name'][$i];
	    	$userfilename = $_FILES["metodologiaParticipativaAtestado"]["name"][$i];
	       $arrayNombresFichero[] = $userfilename;
	       $arrayTiposFichero[]=$_FILES['metodologiaParticipativaAtestado']['type'][$i];
	       $arrayFileTypes[]=".".pathinfo($userfilename, PATHINFO_EXTENSION);
	    }
	    $num=count($arrayMetodologiaProgramas);
		for ($i=0;$i<$num;$i++) 
		{		
			$experiencia=$arrayMetodologiaProgramas[$i];
			///
			$ubicacionTemporal=$arrayUbicacionesFichero[$i];
			$fileTipo=$arrayFileTypes[$i];
			$userFileTipo=$arrayTiposFichero[$i];
			$userFileNombre=$arrayNombresFichero[$i];
		$user->insertarMetodologia("participativa",$idCarpetaMetodologias,$ubicacionTemporal,$fileTipo,$userFileTipo,$userFileNombre,"$experiencia"); 
		}
	}	
}//fin de metodologias participativa
$arrayMetodologiaProgramas=array();
$arrayMetodologiaProgramas=$_POST["metodologiaElaboracion"];
if (array_filter($arrayMetodologiaProgramas)) 
{
    if (isset($_FILES["metodologiaElaboracionAtestado"])) 
	{
		//echo "HAY HTTP metodologiaProgramas";
	    //print_r($_FILES);
	    $archivo=$_FILES["metodologiaElaboracionAtestado"];
	    $len = count($_FILES['metodologiaElaboracionAtestado']['name']);
	    $arrayUbicacionesFichero=array();
	    $arrayNombresFichero=array();
	    $arrayTiposFichero=array();
	    $arrayFileTypes=array();
	    for($i = 0; $i < $len; $i++) 
	    {
	    	$arrayUbicacionesFichero[]=$_FILES['metodologiaElaboracionAtestado']['tmp_name'][$i];
	    	$userfilename = $_FILES["metodologiaElaboracionAtestado"]["name"][$i];
	       $arrayNombresFichero[] = $userfilename;
	       $arrayTiposFichero[]=$_FILES['metodologiaElaboracionAtestado']['type'][$i];
	       $arrayFileTypes[]=".".pathinfo($userfilename, PATHINFO_EXTENSION);
	    }
	    $num=count($arrayMetodologiaProgramas);
		for ($i=0;$i<$num;$i++) 
		{		
			$experiencia=$arrayMetodologiaProgramas[$i];
			///
			$ubicacionTemporal=$arrayUbicacionesFichero[$i];
			$fileTipo=$arrayFileTypes[$i];
			$userFileTipo=$arrayTiposFichero[$i];
			$userFileNombre=$arrayNombresFichero[$i];
		$user->insertarMetodologia("elaboracion",$idCarpetaMetodologias,$ubicacionTemporal,$fileTipo,$userFileTipo,$userFileNombre,"$experiencia"); 
		}
	}	
}//fin de metodologias elaboracion
$arrayMetodologiaProgramas=array();
$arrayMetodologiaProgramas=$_POST["metodologiaLinea"];
if (array_filter($arrayMetodologiaProgramas)) 
{
    if (isset($_FILES["metodologiaLineaAtestado"])) 
	{
		//echo "HAY HTTP metodologiaProgramas";
	    //print_r($_FILES);
	    $archivo=$_FILES["metodologiaLineaAtestado"];
	    $len = count($_FILES['metodologiaLineaAtestado']['name']);
	    $arrayUbicacionesFichero=array();
	    $arrayNombresFichero=array();
	    $arrayTiposFichero=array();
	    $arrayFileTypes=array();
	    for($i = 0; $i < $len; $i++) 
	    {
	    	$arrayUbicacionesFichero[]=$_FILES['metodologiaLineaAtestado']['tmp_name'][$i];
	    	$userfilename = $_FILES["metodologiaLineaAtestado"]["name"][$i];
	       $arrayNombresFichero[] = $userfilename;
	       $arrayTiposFichero[]=$_FILES['metodologiaLineaAtestado']['type'][$i];
	       $arrayFileTypes[]=".".pathinfo($userfilename, PATHINFO_EXTENSION);
	    }
	    $num=count($arrayMetodologiaProgramas);
		for ($i=0;$i<$num;$i++) 
		{		
			$experiencia=$arrayMetodologiaProgramas[$i];
			///
			$ubicacionTemporal=$arrayUbicacionesFichero[$i];
			$fileTipo=$arrayFileTypes[$i];
			$userFileTipo=$arrayTiposFichero[$i];
			$userFileNombre=$arrayNombresFichero[$i];
		$user->insertarMetodologia("linea",$idCarpetaMetodologias,$ubicacionTemporal,$fileTipo,$userFileTipo,$userFileNombre,"$experiencia"); 
		}
	}	
}//fin de metodologias metodologiaLinea
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
    echo "anadirMetodologias.php: Error: no se pudo conectar a la BD para actualizar historial.";
	exit;
  } 
    $historico="INSERT INTO historial VALUES (NULL,$idpostulacion,'$estadopostulacion',NOW(),'Añadida(s) una nuevo(s) metodologías(s) que maneja')";
		  //echo "Query historica: ".$historico;
		  $resultado2=$manejador->getResult($historico);
header('Location: '."out/out.ModificarPerfil.php"); s
?>