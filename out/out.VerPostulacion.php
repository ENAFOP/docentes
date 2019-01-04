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



// Check to see if the user wants to see only those documents that are still
// in the review / approve stages.
$showInProcess = false;
if (isset($_GET["inProcess"]) && strlen($_GET["inProcess"])>0 && $_GET["inProcess"]!=0) {
	$showInProcess = true;
}

$orderby='n';
if (isset($_GET["orderby"]) && strlen($_GET["orderby"])==1 ) {
	$orderby=$_GET["orderby"];
}
$idpostulante=0;
if (isset($_GET["postulante"]) && !empty($_GET["postulante"]) )
{
	$idpostulante=$_GET["postulante"];
}
else
{
	UI::exitError(getMLText("folder_title", array("foldername" => "ID de postulante no válido")),"Debe proporcionarse el ID de un postulante en la solicitud de la página");
}
//CASOS PARA PODER VER LA POSTULACION:
//1 que lo vea un admin: el siempre podrá
//2 que la postulación sea aprobado Y publica: todo mundo podrá verlo
//3 si la postulación no está aprobada: podrá verlo un admin; o el mismo postulante
$sePuedeVer=false;
$estadoPostulacion=$user->getEstadoPostulacionByUser($idpostulante);
$postulantePublico=$user->getPostulantePublico($idpostulante); //true si es publico, false si es privado
//echo "get es publico: ".$postulantePublico;



if($postulantePublico==true && (strcmp($estadoPostulacion, "aprobado")==0)) // caso 2
{
	//echo "caso 2";
	$sePuedeVer=true;
}
if((strcmp($estadoPostulacion, "aprobado")!=0)) //caso 3: si no esta aprobado, solo lo puede ver el dueño y admin
{
	//echo "caso 3";
	if($user->getID()==$idpostulante)
	{
		$sePuedeVer=true;
	}

}
else //si SI esta aprobado lo ve cualqueira
{
$sePuedeVer=true;
}

if($user->isAdmin()) //caso 1: admin siempre puede ver
{
	$sePuedeVer=true;
}

///////////// si no se puede ver, tiramos el error //////////////////
if ($sePuedeVer==false)
{
	//echo "caso fatal";
	UI::exitError("Ver perfil del postulante","USTED NO TIENE LOS PRIVILEGIOS para ver el perfil del postulante, bien porque el postulante está en proceso de evaluación o EL PERFIL DEL MISMO ES PRIVADO (o ambos)");
}
//echo "Id del postulante url: ".$idpostulante;
$nombre=$user->getDatoGeneralPostulante($idpostulante,"nombre");
$pais=$user->getDatoGeneralPostulante($idpostulante,"pais");
$tipodocumento=$user->getDatoGeneralPostulante($idpostulante,"tipodocumento");
$numerodocumento=$user->getDatoGeneralPostulante($idpostulante,"numerodocumento");
$nit=$user->getDatoGeneralPostulante($idpostulante,"nit");
$telefono=$user->getDatoGeneralPostulante($idpostulante,"telefono");
$correo=$user->getDatoGeneralPostulante($idpostulante,"correo");
$departamento=$user->getDatoGeneralPostulante($idpostulante,"departamento");
$municipio=$user->getDatoGeneralPostulante($idpostulante,"municipio");

$anosLaborales=$user->getAnosLaboresODocencia($idpostulante,"cargos");
$anosDocencia=$user->getAnosLaboresODocencia($idpostulante,"materias_docencia");
$anosCapacitacion=$user->getAnosCapacitacion($idpostulante);
$genero=$user->getDatoGeneralPostulante($idpostulante,"genero");
$edad=$user->getDatoGeneralPostulante($idpostulante,"edad");
$nombreUsuario=$user->getUsuarioPostulante($idpostulante);
$tmp = explode('.', basename($_SERVER['SCRIPT_FILENAME']));
$view = UI::factory($theme, $tmp[1], array('dms'=>$dms, 'user'=>$user));

if($view) 
{
	$view->setParam('orderby', $orderby);
	$view->setParam('showinprocess', $showInProcess);
	$view->setParam('workflowmode', $settings->_workflowMode);
	$view->setParam('cachedir', $settings->_cacheDir);
	$view->setParam('previewWidthList', $settings->_previewWidthList);
	$view->setParam('timeout', $settings->_cmdTimeout);
	$view->setParam('idpostulante', $idpostulante);
	$view->setParam('nombre', $nombre);
	$view->setParam('pais', $pais);
	$view->setParam('tipodocumento', $tipodocumento);
	$view->setParam('numerodocumento', $numerodocumento);
	$view->setParam('nit', $nit);
	$view->setParam('telefono', $telefono);
	$view->setParam('correo', $correo);
	$view->setParam('departamento', $departamento);
	$view->setParam('municipio', $municipio);
	$view->setParam('estadoPostulacion', $estadoPostulacion);
	$view->setParam('anosLaborales', $anosLaborales);
	$view->setParam('anosDocencia', $anosDocencia);
	$view->setParam('anosCapacitacion', $anosCapacitacion);
	$view->setParam('genero', $genero);
	$view->setParam('edad', $edad);
	$view->setParam('nombreUsuario', $nombreUsuario);
	$view->setParam('postulantePublico', $postulantePublico);

	$view($_GET);
	exit;
}


?>
