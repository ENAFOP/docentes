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
$arrayMaterias=array();
if (isset($_POST["materia"])) 
{//inicio de si hay alguna materia meterlas
    $arrayMaterias=$_POST["materia"];
    $arrayInstitucionImpartida=array();
if (isset($_POST["institucionImpartida"])) 
{
    $arrayInstitucionImpartida=$_POST["institucionImpartida"];
}
$arrayPeriodoMateriaInicial=array();
if (isset($_POST["periodoMateriaInicial"])) 
{
    $arrayPeriodoMateriaInicial=$_POST["periodoMateriaInicial"];
}
$arrayPeriodoMateriaFinal=array();
if (isset($_POST["periodoMateriaFinal"])) 
{
    $arrayPeriodoMateriaFinal=$_POST["periodoMateriaFinal"];
}
$arrayModalidad=array();
if (isset($_POST["modalidad"])) 
{
    $arrayModalidad=$_POST["modalidad"];
}


$arrayNombresFichero=array();
$arrayTiposFichero=array();
$arrayUbicacionesFichero=array();
$arrayFileTypes=array();
if (isset($_FILES["atestadoMateria"])) 
{
    //echo "HAY HTTP atestadoMateria";
    //print_r($_FILES);
    $archivo=$_FILES["atestadoMateria"];
    $len = count($_FILES['atestadoMateria']['name']);

    for($i = 0; $i < $len; $i++) 
    {
        $arrayUbicacionesFichero[]=$_FILES['atestadoMateria']['tmp_name'][$i];
        $userfilename = $_FILES["atestadoMateria"]["name"][$i];
       $arrayNombresFichero[] = $userfilename;
       $arrayTiposFichero[]=$_FILES['atestadoMateria']['type'][$i];
       $arrayFileTypes[]=".".pathinfo($userfilename, PATHINFO_EXTENSION);
    }
}
$numaterias=count($arrayMaterias);
//CON ESTAS LINEAS SELECCIONO LA CARPETA CORRECTA DENTRO DEL SISTEMA PARA METER EL ARCHIVO: LA CARPETA
//"ATESTADOS PRACTICA DOCENCIA", "ATESTADOS EXPERIENCA EN FORMACION", "MANEJO DE METODOLOGIAS" O "ADJUNTOS"
//PERO LA PROPIA DEL USUARIO. EN EL CASO DEL PASO 5 EN CONCRETO, LA DEBO METER EN "ATESTADOS PRACTICA DOCENCIA"
for ($i=0;$i<$numaterias;$i++) 
{
    $ubicacionTemporal=$arrayUbicacionesFichero[$i];
    $materia=$arrayMaterias[$i];
    $institucion_impartida=$arrayInstitucionImpartida[$i];
    $yearIni=$arrayPeriodoMateriaInicial[$i];
    $yearFini=$arrayPeriodoMateriaFinal[$i];
    $mod=$arrayModalidad[$i];
    $fileTipo=$arrayFileTypes[$i];
    $userFileTipo=$arrayTiposFichero[$i];
    $userFileNombre=$arrayNombresFichero[$i];
$user->insertarMaterias($idCarpetaDocencia,$ubicacionTemporal,$fileTipo,$userFileTipo,$userFileNombre,"$materia","$institucion_impartida","$yearIni","$yearFini","$mod");
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
    echo "anadirMaterias.php: Error: no se pudo conectar a la BD para modificar a ";
	exit;
  } 
    $historico="INSERT INTO historial VALUES (NULL,$idpostulacion,'$estadopostulacion',NOW(),'Añadido una nueva(s) experiencia(s) en experiencia en impartición de docencia')";
		  //echo "Query historica: ".$historico;
		  $resultado2=$manejador->getResult($historico); 
header('Location: '."/out/out.ModificarPerfil.php");
}
}//fin de si hay alguna materia meterlas
?>