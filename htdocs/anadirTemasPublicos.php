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
$catego=""; 
$arrayGerencia=array();
if (isset($_POST["temasGerencia"])) 
{
    $catego="Gerencia pública";
    $arrayGerencia=$_POST["temasGerencia"];

    foreach ($arrayGerencia as $key) 
    {
        $user->insertarTema("gerencia",$key,$catego);
    }
}
$arrayPlanificacion=array();
if (isset($_POST["temasPlanificacion"])) 
{
     $catego="Planificación para el desarrollo";
    $arrayPlanificacion=$_POST["temasPlanificacion"];
    foreach ($arrayPlanificacion as $key) 
    {
        $user->insertarTema("planificacion",$key,$catego);
    }
}
$arrayTalento=array();
if (isset($_POST["temasTalento"])) 
{
     $catego="Gestión del talento humano por competencias en el sector público";
    $arrayTalento=$_POST["temasTalento"];
    foreach ($arrayTalento as $key) 
    {
        $user->insertarTema("talento",$key,$catego);
    }
}
$arrayGobierno=array();
if (isset($_POST["temasGobierno"])) 
{
     $catego="Gobierno y territorio";
    $arrayGobierno=$_POST["temasGobierno"];
    foreach ($arrayGobierno as $key) 
    {
        $user->insertarTema("gobierno",$key,$catego);
    }
}
$arrayEtica=array();
if (isset($_POST["temasEtica"])) 
{
    $catego="Ética y transparencia en la gestión pública";
    $arrayEtica=$_POST["temasEtica"];
    foreach ($arrayEtica as $key) 
    {
        $user->insertarTema("etica",$key,$catego);
    }
}
$arrayElectronico=array();
if (isset($_POST["temasElectronico"])) 
{
    $catego="Gobierno electrónico";
    $arrayElectronico=$_POST["temasElectronico"];
    foreach ($arrayElectronico as $key) 
    {
        $user->insertarTema("electronico",$key,$catego);
    }
}
$arrayAbierto=array();
if (isset($_POST["temasAbierto"])) 
{
    $catego="Gobierno abierto y participación ciudadana";
    $arrayAbierto=$_POST["temasAbierto"];
    foreach ($arrayAbierto as $key) 
    {
        $user->insertarTema("abierto",$key,$catego);
    }
}
$arrayCalidad=array();
if (isset($_POST["temasCalidad"])) 
{
     $catego="Gestión de calidad en el sector público";
    $arrayCalidad=$_POST["temasCalidad"];
    foreach ($arrayCalidad as $key) 
    {
        $user->insertarTema("calidad",$key,$catego);
    }
}
$arrayEnfoque=array();
if (isset($_POST["temasEnfoque"])) 
{
    $catego="Enfoque de derechos en la gestión pública";
    $arrayEnfoque=$_POST["temasEnfoque"];
    foreach ($arrayEnfoque as $key) 
    {
        $user->insertarTema("enfoque",$key,$catego);
    }
}
$arrayRelaciones=array();
if (isset($_POST["temasRelaciones"])) 
{
     $catego="Relaciones laborales en el sector público";
    $arrayRelaciones=$_POST["temasRelaciones"];
    foreach ($arrayRelaciones as $key) 
    {
        $user->insertarTema("relaciones",$key,$catego);
    }
}
$arrayCapacitacion=array();
if (isset($_POST["temasCapacitacion"])) 
{
     $catego="Gestión de capacitación en el sector público";
    $arrayCapacitacion=$_POST["temasCapacitacion"];
    foreach ($arrayCapacitacion as $key) 
    {
        $user->insertarTema("capacitacion",$key,$catego);
    }
}
if (isset($_POST["conocimientosAdicionales"])) 
{
    $cono=$_POST["conocimientosAdicionales"];
    $user->insertarConocimentosAdicionales($cono);

}
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
    echo "anadirTemasPublicos.php: Error: no se pudo conectar a la BD para modificar a ";
	exit;
  } 
    $historico="INSERT INTO historial VALUES (NULL,$idpostulacion,'$estadopostulacion',NOW(),'Añadido(s) un nuevo(s) tema(s) de la administración pública que maneja')";
		  //echo "Query historica: ".$historico;
		  $resultado2=$manejador->getResult($historico);
header('Location: '."out/out.ModificarPerfil.php"); 
?>