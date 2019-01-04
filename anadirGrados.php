<?php
include("./inc/inc.Settings.php");
include("./inc/inc.Language.php");
include("./inc/inc.Init.php");
include("./inc/inc.Extension.php");
include("./inc/inc.DBInit.php");
include("./inc/inc.ClassUI.php");
include("./inc/inc.Authentication.php");
$folderid = $_POST["folderid"];
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
 	//echo "AUN NO SE HA HECHO POSTULACION, PROCEDER";
$arrayTitulosGrados=array();
if (isset($_POST["tituloGrado"])) 
{
    //echo "SI hay titulos de grado";
    $arrayTitulosGrados=$_POST["tituloGrado"];
    $arrayNombreTituloGrado=array();
if (isset($_POST["nombreTituloGrado"])) 
{
    $arrayNombreTituloGrado=$_POST["nombreTituloGrado"];
}
$arrayAnoGrado=array();
if (isset($_POST["anoGrado"])) 
{
    $arrayAnoGrado=$_POST["anoGrado"];
}
$arrayInstitucionGrado=array();
if (isset($_POST["institucionGrado"])) 
{
    $arrayInstitucionGrado=$_POST["institucionGrado"];
}
$numgrados=count($arrayTitulosGrados);
if (array_filter($arrayTitulosGrados))//con esto me aseugo que solo meto otros si han metido algo
{//inicio meter grados
$arrayNombresFichero=array();
$arrayTiposFichero=array();
$arrayUbicacionesFichero=array();
$arrayFileTypes=array();
if (isset($_FILES["atestadoGrado"])) 
{
    //echo "HAY HTTP atestadoMateria";
    //print_r($_FILES);
    $archivo=$_FILES["atestadoGrado"];
    $len = count($_FILES['atestadoGrado']['name']);

    for($i = 0; $i < $len; $i++) 
    {
        $arrayUbicacionesFichero[]=$_FILES['atestadoGrado']['tmp_name'][$i];
        $userfilename = $_FILES["atestadoGrado"]["name"][$i];
       $arrayNombresFichero[] = $userfilename;
       $arrayTiposFichero[]=$_FILES['atestadoGrado']['type'][$i];
       $arrayFileTypes[]=".".pathinfo($userfilename, PATHINFO_EXTENSION);
    }
}
//CON ESTAS LINEAS SELECCIONO LA CARPETA CORRECTA DENTRO DEL SISTEMA PARA METER EL ARCHIVO: LA CARPETA
//"ATESTADOS PRACTICA DOCENCIA", "ATESTADOS EXPERIENCA EN FORMACION", "MANEJO DE METODOLOGIAS" O "ADJUNTOS"
//PERO LA PROPIA DEL USUARIO. EN EL CASO DEL PASO 5 EN CONCRETO, LA DEBO METER EN "ATESTADOS PRACTICA DOCENCIA"
for ($i=0;$i<$numgrados;$i++) 
{
    $ubicacionTemporal=$arrayUbicacionesFichero[$i];;
    $fileTipo=$arrayFileTypes[$i];
    $userFileTipo=$arrayTiposFichero[$i];
    $userFileNombre=$arrayNombresFichero[$i];
$user->insertarPestanaGrado("titulos_grado",$idCarpetaAdjuntos,"$arrayTitulosGrados[$i]","$arrayNombreTituloGrado[$i]","$arrayAnoGrado[$i]","$arrayInstitucionGrado[$i]",$ubicacionTemporal,$fileTipo,$userFileTipo,$userFileNombre); 
header('Location: '."/out/out.ModificarPerfil.php");
}

}

} //si hay titulos de grado, meterlos
///////////////POSGRADOS/////////////////////
$arrayTitulosPosGrados=array();
if (isset($_POST["tituloPosgrado"])) 
{
    $arrayTitulosPosGrados=$_POST["tituloPosgrado"];
    $arrayNombreTituloPosGrado=array();
if (isset($_POST["nombreTituloPosGrado"])) 
{
    $arrayNombreTituloPosGrado=$_POST["nombreTituloPosGrado"];
}
$arrayAnoPosGrado=array();
if (isset($_POST["anoPosgrado"])) 
{
    $arrayAnoPosGrado=$_POST["anoPosgrado"];
}
$arrayInstitucionPosGrado=array();
if (isset($_POST["institucionPosgrado"])) 
{
    $arrayInstitucionPosGrado=$_POST["institucionPosgrado"];
}
$numposgrados=count($arrayTitulosPosGrados);
if (array_filter($arrayTitulosPosGrados))//con esto me aseugo que solo meto otros si han metido algo
{
    $arrayNombresFichero=array();
$arrayTiposFichero=array();
$arrayUbicacionesFichero=array();
$arrayFileTypes=array();
if (isset($_FILES["atestadoPosgrado"])) 
{
    //echo "HAY HTTP atestadoMateria";
    //print_r($_FILES);
    $archivo=$_FILES["atestadoPosgrado"];
    $len = count($_FILES['atestadoPosgrado']['name']);

    for($i = 0; $i < $len; $i++) 
    {
        $arrayUbicacionesFichero[]=$_FILES['atestadoPosgrado']['tmp_name'][$i];
        $userfilename = $_FILES["atestadoPosgrado"]["name"][$i];
       $arrayNombresFichero[] = $userfilename;
       $arrayTiposFichero[]=$_FILES['atestadoPosgrado']['type'][$i];
       $arrayFileTypes[]=".".pathinfo($userfilename, PATHINFO_EXTENSION);
    }
}
//CON ESTAS LINEAS SELECCIONO LA CARPETA CORRECTA DENTRO DEL SISTEMA PARA METER EL ARCHIVO: LA CARPETA
//"ATESTADOS PRACTICA DOCENCIA", "ATESTADOS EXPERIENCA EN FORMACION", "MANEJO DE METODOLOGIAS" O "ADJUNTOS"
//PERO LA PROPIA DEL USUARIO. EN EL CASO DEL PASO 5 EN CONCRETO, LA DEBO METER EN "ATESTADOS PRACTICA DOCENCIA"
for ($i=0;$i<$numposgrados;$i++) 
{
    $ubicacionTemporal=$arrayUbicacionesFichero[$i];;
    $fileTipo=$arrayFileTypes[$i];
    $userFileTipo=$arrayTiposFichero[$i];
    $userFileNombre=$arrayNombresFichero[$i];
$user->insertarPestanaGrado("titulos_posgrado",$idCarpetaAdjuntos,"$arrayTitulosPosGrados[$i]","$arrayNombreTituloPosGrado[$i]","$arrayAnoPosGrado[$i]","$arrayInstitucionPosGrado[$i]",$ubicacionTemporal,$fileTipo,$userFileTipo,$userFileNombre); 
header('Location: '."/out/out.ModificarPerfil.php");
}
}
}//si hay al menos una entrada para titulos de posgrado, meterlos

//////////////OTROS////////////////////
$arrayTitulosOtros=array();
if (isset($_POST["tituloOtros"])) 
{
    $arrayTitulosOtros=$_POST["tituloOtros"];
    $ArrayNombreTituloOtros=array();
if (isset($_POST["nombreTituloOtros"])) 
{
    $ArrayNombreTituloOtros=$_POST["nombreTituloOtros"];
}
$arrayAnoOtros=array();
if (isset($_POST["anoOtros"])) 
{
    $arrayAnoOtros=$_POST["anoOtros"];
}
$arrayInstitucionOtros=array();
if (isset($_POST["institucionOtros"])) 
{
    $arrayInstitucionOtros=$_POST["institucionOtros"];
}
$numotros=count($arrayTitulosOtros);
if (array_filter($arrayTitulosOtros))//con esto me aseugo que solo meto otros si han metido algo
{
    $arrayNombresFichero=array();
$arrayTiposFichero=array();
$arrayUbicacionesFichero=array();
$arrayFileTypes=array();
if (isset($_FILES["atestadoOtros"])) 
{
    //echo "HAY HTTP atestadoMateria";
    //print_r($_FILES);
    $archivo=$_FILES["atestadoOtros"];
    $len = count($_FILES['atestadoOtros']['name']);

    for($i = 0; $i < $len; $i++) 
    {
        $arrayUbicacionesFichero[]=$_FILES['atestadoOtros']['tmp_name'][$i];
        $userfilename = $_FILES["atestadoOtros"]["name"][$i];
       $arrayNombresFichero[] = $userfilename;
       $arrayTiposFichero[]=$_FILES['atestadoOtros']['type'][$i];
       $arrayFileTypes[]=".".pathinfo($userfilename, PATHINFO_EXTENSION);
    }
}
//CON ESTAS LINEAS SELECCIONO LA CARPETA CORRECTA DENTRO DEL SISTEMA PARA METER EL ARCHIVO: LA CARPETA
//"ATESTADOS PRACTICA DOCENCIA", "ATESTADOS EXPERIENCA EN FORMACION", "MANEJO DE METODOLOGIAS" O "ADJUNTOS"
//PERO LA PROPIA DEL USUARIO. EN EL CASO DEL PASO 5 EN CONCRETO, LA DEBO METER EN "ATESTADOS PRACTICA DOCENCIA"
for ($i=0;$i<$numotros;$i++) 
{
    $ubicacionTemporal=$arrayUbicacionesFichero[$i];;
    $fileTipo=$arrayFileTypes[$i];
    $userFileTipo=$arrayTiposFichero[$i];
    $userFileNombre=$arrayNombresFichero[$i];
$user->insertarPestanaGrado("titulos_otros",$idCarpetaAdjuntos,"$arrayTitulosOtros[$i]","$ArrayNombreTituloOtros[$i]","$arrayAnoOtros[$i]","$arrayInstitucionOtros[$i]",$ubicacionTemporal,$fileTipo,$userFileTipo,$userFileNombre); 
header('Location: '."/out/out.ModificarPerfil.php");
}
}
} // si hay almenos una entrada para otros totulos, meterlso
?>