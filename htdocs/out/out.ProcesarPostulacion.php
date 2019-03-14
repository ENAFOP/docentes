<?php
//    
//    Copyright (C) José Mario López Leiva. marioleiva2011@gmail.com_addre
//    September 2017. San Salvador (El Salvador)
//
//    This program is free software; you can redistribute it and/or modify
//    it under the terms of the GNU General Public License as published by
//    the Free Software Foundation; either version 2 of the License, or
//    (at your option) any later version.
//
//    This program is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU General Public License for more details.
//
//    You should have received a copy of the GNU General Public License
//    along with this program; if not, write to the Free Software
//    Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.

include("../inc/inc.Settings.php");
include("../inc/inc.Language.php");
include("../inc/inc.Init.php");
include("../inc/inc.Extension.php");
include("../inc/inc.DBInit.php");
include("../inc/inc.ClassUI.php");
include("../inc/inc.Authentication.php");

//tabla seeddms.tblattributedefinitions;
 //generan
if ($user->isGuest()) 
{

	UI::exitError(getMLText("my_documents"),getMLText("access_denied"));
}

//mande ocultamente el id del folder por el formulario, lo obtenido
if (!isset($_POST["folderid"]) || !is_numeric($_POST["folderid"]) || intval($_POST["folderid"])<1) {
	UI::exitError(getMLText("folder_title", array("foldername" => getMLText("invalid_folder_id"))),getMLText("invalid_folder_id"));
}

$folderid = $_POST["folderid"];



/////////////////////////////////////PARTE DE INSERTAR EN LA BASE DE DATOS LOS DATOS OBTENIDOS EN EL FORMULARIO//////////////////////////////
//---------PREVIO: REGISTRO POSTULACION EN BD
 $estado=$user->getEstadoPostulacion();
 if(strcmp($estado, "")==0)
 {
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
 //echo "Estado de la postulacin: ".$estado;

//---------PESTAÑA 1: DATOS GENERALES:
$nombre="";
$paisResidencia="";
$tipoDocumento="";
$numeroDocumento="";
$telefonoCompleto="";
$correo="";
$nit="";
$departamento="";
$municipio="";
$genero="";
$publico="";
$edad="";
if (isset($_POST["nombre"])) 
{
    $nombre=$_POST["nombre"]; 
}
if (isset($_POST["edad"])) 
{
    $edad=$_POST["edad"]; 
}
if (isset($_POST["paisResidencia"])) 
{
    $paisResidencia=$_POST["paisResidencia"]; 
}
if (isset($_POST["tipoDocumento"])) 
{
    $tipoDocumento=$_POST["tipoDocumento"];
}
if (isset($_POST["numeroDocumento"])) 
{
    $numeroDocumento=$_POST["numeroDocumento"];
}
if (isset($_POST["telefonoCompleto"])) 
{
    $telefonoCompleto=$_POST["telefonoCompleto"];
}
if (isset($_POST["correo"])) 
{
    $correo=$_POST["correo"];
}
// if (isset($_POST["nit"])) 
// {
//     $nit=$_POST["nit"];
// }
if (isset($_POST["departamento"])) 
{
    $departamento=$_POST["departamento"];
}
if (isset($_POST["municipio"])) 
{
    $municipio=$_POST["municipio"];
}
if (isset($_POST["genero"])) 
{
    $genero=$_POST["genero"];
}
$booleano="TRUE";
if (isset($_POST["publico"])) 
{
    $publico=$_POST["publico"];
    if(strcmp($publico, "no")==0)
    {
        $booleano="FALSE";
    }

}
$user->insertarDatos($nombre,$correo,$paisResidencia,$tipoDocumento,$numeroDocumento,$nit,$telefonoCompleto,$departamento,$municipio,$booleano,$genero,$edad);

//echo "Metido en bd datos generales";

//---------PESTAÑA 2: EXPERIENCIA LABORAL (CARGOS)
//ASI INSERTO PARA TAB 2
//$valor=$user->insertarCargo("Supervisor","2010","2015","Supervisar a toditos","vidri");
$arrayCargos=array();
if (isset($_POST["cargo"])) 
{
    //echo "SI hay cargos pestaña 2";
    $arrayCargos=$_POST["cargo"];
    $arrayFunciones=array();
    if (isset($_POST["funciones"])) 
    {
        $arrayFunciones=$_POST["funciones"];
    }
    $arrayInstituciones=array();
    if (isset($_POST["institucion"])) 
    {
        $arrayInstituciones=$_POST["institucion"];
    }
    $arrayPeriodoInicial=array();
    if (isset($_POST["periodoInicial"])) 
    {
        $arrayPeriodoInicial=$_POST["periodoInicial"];
    }
    $arrayPeriodoFinal=array();
    if (isset($_POST["periodoFinal"])) 
    {
        $arrayPeriodoFinal=$_POST["periodoFinal"];
    }
    
    $numeroCargos=count($arrayCargos);
    for ($i=0;$i<$numeroCargos;$i++) 
    {
        $user->insertarCargo("$arrayCargos[$i]","$arrayPeriodoInicial[$i]","$arrayPeriodoFinal[$i]","$arrayFunciones[$i]","$arrayInstituciones[$i]");
    }
} //fin de si hay cargos, los meto



//---------PESTAÑA 3: FORMACION ACADEMICA -------------------------------------------------
//ASI INSERTO PARA TAB 3: 3 bloques de insercio, grados , posgrados y otros
//insertarGrado($titulo,$nombreTitulo,$ano,$institucion) 
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
    //echo "PEST 3 fichero està en ubicacion tmp: ".$ubicacionTemporal;
    $fileTipo=$arrayFileTypes[$i];
    $userFileTipo=$arrayTiposFichero[$i];
    $userFileNombre=$arrayNombresFichero[$i];
    
$user->insertarPestanaGrado("titulos_grado",$idCarpetaAdjuntos,"$arrayTitulosGrados[$i]","$arrayNombreTituloGrado[$i]","$arrayAnoGrado[$i]","$arrayInstitucionGrado[$i]",$ubicacionTemporal,$fileTipo,$userFileTipo,$userFileNombre); 
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
}
}
} // si hay almenos una entrada para otros totulos, meterlso

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
    $conocimentos=$_POST["conocimientosAdicionales"];
    $user->insertarConocimentosAdicionales($conocimentos);
}

//---------PESTAÑA 5: MATERIAS IMPARTIDAS EN LA DOCENCIA -----------------------
//insertarTema($sufijo,$nombreTema) 
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
}
}//fin de si hay alguna materia meterlas

//---------PESTAÑA 6: EXPERIENCIA EN FORMACION Y CAPACITACION
//insertarTema($sufijo,$nombreTema) 
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
}
} //fin de si hay talleres y 

//---------PESTAÑA 7: MANEJO DE METODOLOGIAS
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
 ////////	//pestaña 8 -----------------------------------
$manejoIngles="";
$manejoPrezi="";
$relevante="";
if (isset($_POST["manejoIngles"])) 
{
    $manejoIngles=$_POST["manejoIngles"];
    $arrayIdiomas=array();
    if(strcmp($manejoIngles, "si")==0)
    {
            if (isset($_POST["idiomas"])) 
            {
                $arrayIdiomas=$_POST["idiomas"];
                $arrayHablados=$_POST["hablados"];
                $arrayEscuchados=$_POST["escuchados"];
                $arrayEscritos=$_POST["escritos"];
                 $numIdiomas=count($arrayIdiomas);
                for ($i=0;$i<$numIdiomas;$i++) 
                {
                    $idioma=$arrayIdiomas[$i];
                    $hablado=$arrayHablados[$i];
                    $escuchado=$arrayEscuchados[$i];
                    $escrito=$arrayEscritos[$i];
                    $user->insertarIdiomas($idioma,$hablado,$escuchado,$escrito);
                }
            }   
        }
}
if (isset($_POST["manejoPrezi"])) 
{
    $manejoPrezi=$_POST["manejoPrezi"];
}
if (isset($_POST["informacionRelevante"])) 
{
    $relevante=$_POST["informacionRelevante"];
}

$user->insertarPrezi("$manejoIngles","$manejoPrezi","$relevante"); 
//pestaña 9 -----------------------------------

if (is_uploaded_file($_FILES['cartaMotivacion']['tmp_name'])) 
{
	$ubicacionTemporal=$_FILES['cartaMotivacion']['tmp_name'];
	$userFileNombre = $_FILES["cartaMotivacion"]["name"];
   $userFileTipo=$_FILES['cartaMotivacion']['type'];
   $fileTipo=".".pathinfo($userFileNombre, PATHINFO_EXTENSION);
   $user->insertarAdjunto("cartas",$idCarpetaAdjuntos,$ubicacionTemporal,$fileTipo,$userFileTipo,$userFileNombre); 
}
if (is_uploaded_file($_FILES['referenciasPersonales']['tmp_name'])) 
{
	$ubicacionTemporal=$_FILES['referenciasPersonales']['tmp_name'];
	$userFileNombre = $_FILES["referenciasPersonales"]["name"];
   $userFileTipo=$_FILES['referenciasPersonales']['type'];
   $fileTipo=".".pathinfo($userFileNombre, PATHINFO_EXTENSION);
   $user->insertarAdjunto("referencias_personales",$idCarpetaAdjuntos,$ubicacionTemporal,$fileTipo,$userFileTipo,$userFileNombre); 
}


///////////////////////////////// ULTIMO PASO Y NO MENOS IMPORTANTE: REGISTRAR LA POSTULACION y notificar
    $postu=$user->crearPostulacion();
    if(!$notifier)
    {
        UI::exitError(getMLText("folder_title", array("foldername" => "No se pudo notificar")),"No se pudo notificar de la postulación al procesarla");
    }
    //se notifica del mensaje tanto a postulante como A TODOS LOS ADMIN
    $nombreInteresado=$user->getFullName();
    $receptor=$dms->getUser(1);
    $idPostulado=$user->getID();
    $rutilla = "http".((isset($_SERVER['HTTPS']) && (strcmp($_SERVER['HTTPS'],'off')!=0)) ? "s" : "")."://".$_SERVER['HTTP_HOST'].$settings->_httpRoot."out/out.VerPostulacion.php?postulante=$idPostulado";
    $subject = htmlspecialchars("Nueva postulación para la base de datos de personas facilitadoras ENAFOP");
    $message = htmlspecialchars("\n $nombreInteresado ha colocado su postulación en el sistema. \n Puede acceder al perfil del postulante desde el siguiente enlace: \n $rutilla \n Posteriormente podrá ingresar con el usuario y contraseña asignadas.");
    $params = array();
    $params['sitename'] = $settings->_siteName;
    $params['http_root'] = $settings->_httpRoot;

    $notifier->toIndividual($user, $receptor, $subject, $message, $params);
 }
 else
 {
 	UI::exitError(getMLText("folder_title", array("foldername" => "Postulación ya realizada")),"Este postulante ya ha realizado la postulación, no puede crear una nueva, solo modificar la existente");
 }


$tmp = explode('.', basename($_SERVER['SCRIPT_FILENAME']));
$view = UI::factory($theme, $tmp[1], array('dms'=>$dms, 'user'=>$user));


if($view)
 {
    $fechaPostulacion=$user->getFechaPostulacion();
    $nombrePostulante=$user->getNombrePostulante();
	$view->setParam('workflowmode', $settings->_workflowMode);
	$view->setParam('cachedir', $settings->_cacheDir);
	$view->setParam('previewWidthList', $settings->_previewWidthList);
	$view->setParam('timeout', $settings->_cmdTimeout);
	$view->setParam('fechaPostulacion', $fechaPostulacion);
	$view->setParam('nombrePostulante', $nombrePostulante);
	$view($_GET);
	exit;
}


?>
