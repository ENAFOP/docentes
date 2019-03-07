<?php

/**
 * Implementation of MyDocuments view
 *
 * @category   DMS
 * @package    SeedDMS
 * @license    GPL 2
 * @version    @version@
 * @author     Uwe Steinmann <uwe@steinmann.cx> DMS with modifications of José Mario López Leiva
 * @copyright  Copyright (C) 2017 José Mario López Leiva
 *             marioleiva2011@gmail.com    
 				San Salvador, El Salvador, Central America

 *             
 * @version    Release: @package_version@
 */

/**
 * Include parent class
 */
require_once("class.Bootstrap.php");


/**
 * Include class to preview documents
 */
require_once("SeedDMS/Preview.php");



/**
 * Class which outputs the html page for MyDocuments view
 *
 * @category   DMS
 * @package    SeedDMS
 * @author     Markus Westphal, Malcolm Cowe, Uwe Steinmann <uwe@steinmann.cx>
 * @copyright  Copyright (C) 2002-2005 Markus Westphal,
 *             2006-2008 Malcolm Cowe, 2010 Matteo Lucarelli,
 *             2010-2012 Uwe Steinmann
 * @version    Release: @package_version@
 */
 /**
 Función que muestra los documentos próximos a caducar de todos los usuarios
 mostrarTodosDocumentos(lista_usuarios,dias)
 -dias: documentos que van a caducar dentro de cúantos días
 */
 function imprimeAdjuntos($idpostulante,$db)
{ 
    //query de consulta:
   $arrayTablas=array("cartas","referencias_personales");

   $arrayTitulos=array("Carta de motivación","Referencias personales");
   $arrayIdentificadores=array("idcarta","idreferencias");
    for($i=0;$i<count($arrayTablas);$i++)
    {
      $nom=$arrayTablas[$i];
      $ident=$arrayIdentificadores[$i];
      $consultar1="SELECT $ident FROM $nom WHERE idpostulante=$idpostulante;";

      $res1 = $db->getResultArray($consultar1);
      if(count($res1)!=0)//no tiene temas
      {
        $titulo=$arrayTitulos[$i];
        $iddoc=0;
        if(strcmp($nom, "cartas")==0)
        {
          
          $iddoc=$res1[0]['idcarta'];
        }
        if(strcmp($nom, "referencias_personales")==0)
        {
          $iddoc=$res1[0]['idreferencias'];
        }     
             //echo "<small><a href=\"/out/out.ViewDocument.php?documentid=$idcarta\">$titulo</a></small>";
        echo '<div class="row">';
         echo '<div class="col-md-4">';
          echo "<li><a href=\"/out/out.ViewDocument.php?documentid=$iddoc\">$titulo<span class=\"pull-right badge bg-aqua\">ADJUNTO</span></a></li>";
           echo '</div>' ; 

           echo '<div class="col-md-3">';
             echo "<a href=\"/out/out.EliminarAdjunto.php?documentid=$iddoc\">Borrar este documento</a>";

              echo '</div>' ; 
          echo '</div>' ;      

        
      }
    }//fin bucle
    
               
}
function imprimirTemas($nombreFichero) //imprime la lista de temas que se usa en la pestaña 4 temas de la administración publica q ud maneja
{
    $lines = file("../listas_tematicas/$nombreFichero.txt", FILE_IGNORE_NEW_LINES);
  //echo "<option disabled selected value>Seleccione un tema</option>";

    foreach ($lines as $doc) 
    {
      $doc=utf8_encode($doc);
    echo "<option value=\"".$doc."\">".$doc."</option>";
  } //fin del bucle

  //echo "</select>";
}
function imprimeMetodologias($idpostulante,$db)
{ 
    //query de consulta:
   $arrayTablas=array("metodologias_disenocartas","metodologias_elaboracion","metodologias_evaluacion","metodologias_facilitacion","metodologias_linea","metodologias_participativa","metodologias_programas");

   $arrayTitulos=array("Diseño de cartas didácticas (diseños instruccionales)","Elaboración de material de apoyo (manuales, guías, lecturas. Cuáles)","Evaluación de procesos de formación (en cuales procesos, metodología)","Facilitación de talleres o cursos de formación o capacitación (cuáles)","Metodologías en línea (si es diseñador instruccional, contenidista o solo tutor)","Metodologías participativas (cuáles)"," Diseño de programas y/o proyectos de formación y/o capacitación (curricular)");
    for($i=0;$i<count($arrayTablas);$i++)
    {
      $nom=$arrayTablas[$i];
      $consultar1="SELECT experiencia,idatestado,id FROM $nom WHERE idpostulante=$idpostulante;";
      $res1 = $db->getResultArray($consultar1);
      if(count($res1)!=0)//no tiene temas
      {
        $titulo=$arrayTitulos[$i];
        echo "<h3>$titulo</h3>";
        foreach ($res1 as $resultado) 
        {
          $tema=$resultado['experiencia'];
          $idatestado=$resultado['idatestado'];
          $id=$resultado['id'];
             echo "<li><a href=\"/out/out.ViewDocument.php?documentid=$idatestado\">$tema</a></li>";

              $idBorrado="delete-".$nom."-".$id;
                          echo "<button type=\"button\" id=\"$idBorrado\" class=\"btn btn-danger btn-xs\"><i class=\"fa fa-times\"></i></button>";
        }
      }
    }//fin bucle
}
function getDefaultUserFolder($id_usuario) //dado un id de usuario, me devuelve el id del folder de inicio de ese usuario
{
  //echo "Función getDefaultUserFolder. Se ha pasado con argumento: ".$id_usuario;
  $id_folder=0;
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
    echo "out.viewFolder.php[getDefaultUserFolder]Error: no se pudo conectar a la BD";
  } 
  //query de consulta:
  $miQuery="SELECT homefolder FROM tblUsers WHERE id=".$id_usuario;
  //echo "mi query: ".$miQuery;
  $resultado=$manejador->getResultArray($miQuery);
  $id_folder=$resultado[0]['homefolder'];
  //echo "id_folder: ".$id_folder;
  return $id_folder;
}
 function utf8_fopen_read($fileName) { 
    $fc = iconv('windows-1250', 'utf-8', file_get_contents($fileName)); 
    $handle=fopen("php://memory", "rw"); 
    fwrite($handle, $fc); 
    fseek($handle, 0); 
    return $handle; 
} 
function imprimirGeneros($elegido)
{
  $generos=array("Femenino","Masculino","Otro");
  
  echo " <select disabled class=\"form-control chzn-select\" id=\"genero\" name=\"genero\">";
  echo "<option  selected value=\"$elegido\">$elegido</option>";
    foreach ($generos as $doc) 
    {
        if(strcmp($doc, $elegido)!=0)
        {
          echo "<option value=\"".$doc."\">".$doc."</option>";
        }
        
    
    } //fin del bucle

  echo "</select>";
}// fin de imprimir generos
 function imprimirTitulosGrado()
{
  
  $titulos=array("Bachiller","Licenciado","Ingeniero","Doctor");
  //echo " <select class=\"form-control select\"  name=\"titulosObtenidos[]\">";
  echo "<option disabled selected value>Seleccione un título</option>";
    foreach ($titulos as $doc) 
    {
    echo "<option value=\"".$doc."\">".$doc."</option>";
  } //fin del bucle
}
function imprimirTitulosPosGrado()
{
  
  $titulos=array("Máster","Doctorado","Otro");
  //echo " <select class=\"form-control select\"  name=\"titulosObtenidos[]\">";
  echo "<option disabled selected value>Seleccione un título</option>";
    foreach ($titulos as $doc) 
    {
    echo "<option value=\"".$doc."\">".$doc."</option>";
  } //fin del bucle
  //echo "</select>";

}
function imprimirTitulosOtro()
{
  
  $titulos=array("Otro");
  //echo " <select class=\"form-control select\"  name=\"titulosObtenidos[]\">";
  echo "<option disabled selected value>Seleccione un título</option>";
    foreach ($titulos as $doc) 
    {
    echo "<option value=\"".$doc."\">".$doc."</option>";
  } //fin del bucle
  //echo "</select>";

}

 function imprimirModalidades() //se usa en Pestaña 5
{
	
  $titulos=array("Presencial","Semipresencial","En línea");
	//echo " <select class=\"form-control select\"  name=\"titulosObtenidos[]\">";
  echo "<option disabled selected value>Seleccione modalidad</option>";
    foreach ($titulos as $doc) 
    {
		echo "<option value=\"".$doc."\">".$doc."</option>";
	} //fin del bucle

	//echo "</select>";

}
function imprimirTemasManejados($idpostulante,$db)
{ 
    //query de consulta:
   $arrayTablas=array("temas_abierto","temas_calidad","temas_capacitacion","temas_electronico","temas_enfoque","temas_etica","temas_gerencia","temas_gobierno","temas_planificacion","temas_relaciones","temas_talento");

   $arrayTitulos=array("Gobierno abierto y participación ciudadana","Gestión de calidad en el sector público","Gestión de capacitación en el sector público","Gobierno electrónico","Enfoque de derechos en la gestión pública","Ética y transparencia en la gestión pública","Gerencia pública","Gobierno y territorio","Planificación para el desarrollo","Relaciones laborales en el sector público","Gestión del talento humano por competencias en el sector público");
    for($i=0;$i<count($arrayTablas);$i++)
    {
      $nom=$arrayTablas[$i];
      $consultar1="SELECT id, nombretema FROM $nom WHERE idpostulante=$idpostulante;";
      $res1 = $db->getResultArray($consultar1);
      if(count($res1)!=0)//no tiene temas
      {
        $titulo=$arrayTitulos[$i];
        echo "<h3>$titulo</h3>";
        foreach ($res1 as $resultado) 
        {
          $tema=$resultado['nombretema'];
          $id=$resultado['id'];
             echo "<li>$tema</li>";
              $idBorrado="erase-".$nom."-".$id;
                          echo "<button type=\"button\" id=\"$idBorrado\" class=\"btn btn-danger btn-xs\"><i class=\"fa fa-times\"></i></button>";
        }
      }
    }//fin bucle
}

function imprimirYears($primerAno)
{
	
  echo "<option disabled selected value>Elija un año</option>";
   for($i = date('Y') ; $i >=$primerAno ; $i--)
   {
      echo "<option>$i</option>";
   }


}

function imprimirPaises($elegido)
{
	$fichero="../paises.csv";
	$row = 1;
	echo " <select disabled class=\"form-control chzn-select\" id=\"paisResidencia\" name=\"paisResidencia\">";
if (($handle = fopen($fichero, "r")) !== FALSE) 
{
  echo "<option  selected value=\"$elegido\">$elegido</option>";
    while (($data = fgetcsv($handle, 4096, ",")) !== FALSE) 
	{
		//print_r($data);
			if($row!=1)
			{
				$valor=$data[0];
				echo "<option value=\"".$valor."\">".$valor."</option>";
				//print_r($data[0]);
			}


			$row++;
	} //fin del bucle
	}//fin de abrir fichero

	echo "</select>";
}// fin de imprimir países
function imprimirDepartamentos( $departamentoElegido)
{
  //LOS DEPARTAMENTOS LEIDOS DE LA BD
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
    echo "out.viewFolder.php[getDefaultUserFolder]Error: no se pudo conectar a la BD";
  } 
  //query de consulta:
  $miQuery="SELECT departamento FROM departamentos";
  //echo "mi query: ".$miQuery;
  $resultado=$manejador->getResultArray($miQuery);
  $arrayDepartamentos=$resultado[0]['departamento'];
  ////////////////////// EL SELECT
  echo " <select disabled class=\"form-control chzn-select\" id=\"departamento\" name=\"departamento\">";

  echo "<option  selected value=\"$departamentoElegido\">$departamentoElegido</option>";
  foreach ($resultado as $a) 
  {
    foreach ($a as $valor) 
    {
      if(strcmp($valor, $departamentoElegido)!=0)
        {
            echo "<option value=\"".$valor."\">".$valor."</option>";
        }
     
    }
  }

  echo "</select>";
}// fin de imprimir departamentos

function imprimirDocumentos($elegido)
{
	$documentos=array("DUI","Pasaporte","Carné de residencia");
	echo " <select disabled class=\"form-control select\" id=\"tipoDocumento\" name=\"tipoDocumento\">";
  echo "<option  selected value=\"$elegido\">$elegido</option>";
    foreach ($documentos as $doc) 
    {
		echo "<option value=\"".$doc."\">".$doc."</option>";
	 } //fin del bucle

	echo "</select>";
}// fin de imprimir países

class SeedDMS_View_ModificarPerfil extends SeedDMS_Bootstrap_Style 
{



	function show() 
	{ /* {{{ */
		$dms = $this->params['dms'];
		$user = $this->params['user'];
		$orderby = $this->params['orderby'];
		$showInProcess = $this->params['showinprocess'];
		$cachedir = $this->params['cachedir'];
    $baseServer=$this->params['settings']->_httpRoot;
		$workflowmode = $this->params['workflowmode'];
		$previewwidth = $this->params['previewWidthList'];
		$timeout = $this->params['timeout'];	
    $folder = getDefaultUserFolder($user->getID());
		$db = $dms->getDB();
    $idpostulante=$user->getID();
    $idpostulacion=$user->getIDPostulacion();
    $estadopostulacion=$user->getEstadoPostulacion();
		$this->htmlAddHeader('<link href="../styles/'.$this->theme.'/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">'."\n", 'css');
		$this->htmlAddHeader('<script type="text/javascript" src="../styles/'.$this->theme.'/plugins/datatables/jquery.dataTables.min.js"></script>'."\n", 'js');
		$this->htmlAddHeader('<script type="text/javascript" src="../styles/'.$this->theme.'/plugins/datatables/dataTables.bootstrap.min.js"></script>'."\n", 'js');
		$this->htmlAddHeader('<script type="text/javascript" src="../styles/'.$this->theme.'/validate/jquery.validate.js"></script>'."\n", 'js');
		
		echo $this->callHook('startPage');
		$previewer = new SeedDMS_Preview_Previewer($cachedir, $previewwidth, $timeout);
		$this->htmlStartPage("Formulario de aplicación para docente de la ENAFOP", "skin-blue layout-top-nav");
		$this->containerStart();
		//$this->mainHeader();
		//$this->mainSideBar();
		//$this->contentContainerStart("hoa");
		echo $this->callHook('preContent');
		$this->contentStart(); 
       /// INICIO DE IMPRIMIR LOGOS
    echo '<div class="row text-center">';
    echo '<div class="col-xs-12 col-sm-6">';
    echo '<br>';
     echo "<img src=\"".$baseServer."images/escudoarmas.png\" class=\"img-responsive center-block\" alt=\"Escudo de Armas\" height=\"100\" width=\"100\">";
      echo '</div>'; //cierre col 6

       echo '<div class="col-xs-12 col-sm-6">';
       echo '<br>';
    echo "<img src=\"".$baseServer."images/logo_transparente.png\" class=\"img-responsive center-block\" alt=\"Logo ENAFOP transformando\" height=\"200\" width=\"200\">";
    echo '</div>'; //cierre col 4
    echo '</div>'; //cierre de row
  ////////////////FIN DE IMPRIMIR LOGOS       
		?>
        
      <h1>
        Formulario de modificación de perfil
      </h1>
      <ol class="breadcrumb">
        <?php echo "<li><a href=\"".$baseServer."out/out.ViewFolder.php?folderid=1\">"; ?>
          <i class="fa fa-home">
          
        </i>Mi perfil: inicio</a></li>
        <li class="active">modificar mi perfil</li>
      </ol>
    
    <div class="gap-10"></div>
    <div class="row">
    <div class="col-md-12">
    <?php
    //en este bloque php va "mi" código 
 $this->startBoxPrimary("Modifique cada sección del formulario, según la llenó en el formulario de aplicación, haciendo click en el título de cada pestaña. Si tiene cualquier consulta, diríjase a la dirección <a href=\"mailto:enafop@presidencia.gob.sv?Subject=Consulta%Formulario%Docentes\" target=\"_top\">enafop@presidencia.gob.sv</a>");
$this->contentContainerStart();
//////INICIO MI CODIGO
 
?>
  <style>
        .error {
            color: red;
        }
    </style>
 
<form  name="formularioModificacion" id="formularioModificacion" action="" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="folderid" value="<?php print $folder ?>">
  <input type="hidden" name="idpostulante" id="idpostulante" value="<?php print $user->getID(); ?>">
  <input type="hidden" name="estadopostulacion" id="estadopostulacion" value="<?php echo $estadopostulacion ?>">

  <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
            	<!-- *******************Aqui modificar cabeceras de tab********************************** -->

          <li class="active" id="nav-tab-1"><a href="#tab_1" data-toggle="tab" aria-expanded="true">1 -Datos generales</a></li>
          <li class="" id="nav-tab-2"><a href="#tab_2" data-toggle="tab" aria-expanded="false">2 - Experiencia laboral</a></li>
          <li class="" id="nav-tab-3"><a href="#tab_3" data-toggle="tab" aria-expanded="false">3 - Formación académica</a></li>
          <li class="" id="nav-tab-4"><a href="#tab_4" data-toggle="tab" aria-expanded="false">4 - Temas de la administración pública</a></li>
          <li class="" id="nav-tab-5"><a href="#tab_5" data-toggle="tab" aria-expanded="false">5 - Experiencia en docencia</a></li>
          <li class="" id="nav-tab-6"><a href="#tab_6" data-toggle="tab" aria-expanded="false">6 - Experiencia en formación y capacitación</a></li>
           <li class="" id="nav-tab-7"><a href="#tab_7" data-toggle="tab" aria-expanded="false">7 - Manejo de metodologías</a></li>
           <li class="" id="nav-tab-8"><a href="#tab_8" data-toggle="tab" aria-expanded="false">8 - Otros</a></li>
            <li class="" id="nav-tab-9"><a href="#tab_9" data-toggle="tab" aria-expanded="false">9 - Documentos a adjuntar</a></li>
              <!-- *********************fin de modificar cabeceras************************ -->
            </ul>
            <div class="tab-content">
      
            	<!-- ****************************/.PESTAÑA 1 ***************************************************** -->
            	
              <div class="tab-pane active" id="tab_1">
                
                 
                   

               <div class="form-group">
                <?php
                 $nombre=$user->getNombrePostulante();
                 ?>
                  
                      <label for="nombreCompleto">Nombre completo</label>
          <input type="text" class="form-control" name="nombre" id="nombre" readonly value="<?php echo $nombre;?>">
                              
              </div>

              <div class="form-group">
                  <label for="pais">Género</label>                
                              <?php 
                      $generoElegido=$user->getDatoGeneral("genero");                  
                          imprimirGeneros($generoElegido);
                            ?>                
                </div>


                <div class="form-group">
                  <?php
                 $edadActual=$user->getDatoGeneral("edad");
                 ?>
                  <label for="edad">Edad</label>
          <input type="number" min="18" style="width: 23em;" class="form-control" name="edad" id="edad" disabled value="<?php echo $edadActual;?>">
                </div>



                <div id="errorNombre"></div>

                <div class="form-group">
                  <label for="pais">País de residencia</label>                
		                          <?php 
                              $elpais=$user->getDatoGeneral("pais");                
                          imprimirPaises($elpais);
                          $departamentoElegido=$user->getDatoGeneral("departamento");
                          //echo "DEPARTAMENTO ELEGIDO: ".$departamentoElegido;
                          $municipioElegido=$user->getDatoGeneral("municipio");
                          $municipioElegido=str_replace('"', '', $municipioElegido);    
                            ?> 
        				
                </div>


        <div class="form-group"   <?php  if(strcmp($departamentoElegido, "")==0) echo 'style="display: none;"';?>                id="divDepartamentos">
                  <label for="departamento">Departamento</label>   
                   <?php             
                          imprimirDepartamentos($departamentoElegido);
                    ?>                                             
        </div>



                <div class="form-group"  <?php  if(strcmp($municipioElegido, "")==0) echo 'style="display: none;"';?>    id="divMunicipios">

                <label for="departamento">Municipio</label> 
      <input type="text"  class="form-control" name="municipio" id="municipio" disabled value="<?php echo $municipioElegido;?>">
                </div>


                 <div class="form-group"><!-- INICIO TIPO DE DOCUMENTO -->
                  <label for="tipoDocumento">Tipo de documento</label>                
		                                 
        						  <?php 
                        $eltipo=$user->getDatoGeneral("tipodocumento");						
        						  		imprimirDocumentos($eltipo);
        						  ?>

                      				
                </div><!-- FIN TIPO DE DOCUMENTO -->

                 <div class="form-group"> <!-- INICIO NUMERO DE DOCUMENTO -->
                  <label for="numeroDocumento">Número de documento</label>                		   
                  <?php 
                        $elNUmero=$user->getDatoGeneral("numerodocumento");                                   
                      ?>                                
					<input type="text" class="form-control" name="numeroDocumento" id="numeroDocumento" disabled value="<?php echo $elNUmero;?>">


                </div> <!-- FIN NUMERO DE DOCUMENTO -->

                <div class="form-group" id="divNit">
                    <?php 
                        $elNit=$user->getDatoGeneral("nit");                                   
                      ?> 
                  <label for="nit">NIT</label>                                                     
          <input type="text" class="form-control" name="nit" id="nit" disabled value="<?php echo $elNit;?>">
           
                </div>

                 <div class="form-group"><!-- INICIO TELEFONO -->
                  <label for="numeroDocumento">Teléfono de contacto</label>                		     
                  <?php 
                        $elTelefono=$user->getDatoGeneral("telefono");                                   
                      ?>                              
			   
		        		
	             <input class="form-control" type="text"  name="telefono" id="telefono" disabled value="<?php echo $elTelefono;?>">
		        	
                </div> <!-- FIN TELEFONO -->

                 <div class="form-group"> <!-- inicio CORREO -->
                  <label for="numeroDocumento">Correo electrónico</label>  
                   <?php 
                        $elCorreo=$user->getDatoGeneral("correo");                                   
                      ?>              		                                 
					<input type="email" class="form-control" name="correo" id="correo" disabled value="<?php echo $elCorreo;?>">					
                </div> <!-- FIN CORREO -->


                <div class="box-footer">
							<a type="button" href="/out/out.ViewFolder.php?folderid=1&showtree=1"  class="btn btn-default cancel-add-document"><?php echo getMLText("cancel"); ?></a>

                    
              <button type="button" id="editarPestana1"class="btn btn-warning btn-flat"> Editar esta sección  <i class="fa fa-pencil"></i></button> 

               <button type="button" id="aplicarPestana1" class="btn btn-success btn-flat" data-toggle="modal" data-target="#modal-success"> Aplicar los cambios <i class="fa fa-save"></i></button> 
                    
							
				       </div> <!-- FIN Box footer pestaña 1 -->

              </div> <!-- FIN  pestaña 1 -->
          
              <!-- ****************************/.PESTAÑA 2 ***************************************************** -->
              <div class="tab-pane" id="tab_2">
                    <p style="font-family:verdana;font-size:18px;" class="text-success">                    
                    <b>En esta pestaña puede modificar su experiencia laboral</b>
                   </p>
                   <p style="font-family:verdana;font-size:12px;" class="text-warning">                    
                    <b>Para editar una entrada existente, haga click en el elemento que desea editar y aplique los cambios necesarios.</b>
                   </p>
                   <p style="font-family:verdana;font-size:12px;" class="text-info">                    
                    <b>Para añadir un nuevo cargo, utilice el botón de Añadir una nueva experiencia.</b>
                   </p>

              	   <p> 
            			  <input type="button" class="btn btn-primary btn-sm" id="anadeExperiencia" value="Añadir una nueva experiencia">
            			
				          </p>


                <table id="tablaExperiencias" class="table table-bordered table-hover">
                <tr>
                  
                  <th>Cargo</th>
                  <th>Funciones</th>
                  <th>Institución</th>
                  <th>Periodo (año-mes-día)</th>


                </tr>
                

                  <?php 
                    $consultar="SELECT * FROM cargos WHERE idpostulante=$idpostulante";
                    $cargosDB = $db->getResultArray($consultar);
                    if($cargosDB)
                    {
                      foreach ($cargosDB as $key) 
                      {
                        //print_r("Aubarray: ".$key);
                        $id=$key['id'];
                        $cargo=$key['cargo'];
                        $funciones=$key['funciones'];
                        $institucion=$key['institucion'];
                        $anoinicio=$key['anoinicio'];
                        $anofin=$key['anofin'];
                         echo "<tr>";

                        $idCargo="cargo";
                        $idFunciones="funciones";
                        $idInstitucion="institucion";
                        $idAnoInicio="anoinicio";
                        $idAnoFin="anofin";



                      echo "<td><a href=\"#\" id=\"$idCargo\" data-type=\"text\" data-pk=\"$id\" data-url=\"".$baseServer."modificarCargos.php\" data-title=\"Nombre del cargo\">$cargo</a></td>";


                                  
                      echo "<td><a href=\"#\" id=\"$idFunciones\" data-type=\"text\" data-pk=\"$id\" data-url=\"".$baseServer."modificarCargos.php\" data-title=\"Funciones ejercidas\">$funciones</a></td>";


                                              
                      echo "<td><a href=\"#\" id=\"$idInstitucion\" data-type=\"text\" data-pk=\"$id\" data-url=\"".$baseServer."modificarCargos.php\" data-title=\"Nombre de la institución\">$institucion</a></td>";

                                  //

                              echo "<td>";
                                    echo '<div class="col-xs-4">';
                                      echo "<a href=\"#\" id=\"$idAnoInicio\" data-type=\"combodate\" data-pk=\"$id\" data-url=\"".$baseServer."modificarCargos.php\" data-title=\"Fecha inicial\">$anoinicio</a>";
                                      echo '</div>';

                                     echo '<div class="col-xs-1">-</div>';


                                    echo '<div class="col-xs-4">';
                                         echo "<a href=\"#\" id=\"$idAnoFin\" data-type=\"combodate\" data-pk=\"$id\" data-url=\"".$baseServer."modificarCargos.php\" data-title=\"Fecha inicial\">$anofin</a>";
                                      echo '</div>';

                                       echo '<div class="col-md-1">';
                          $idBorrado="eliminar-cargo-".$id;
                          echo "<button type=\"button\" id=\"$idBorrado\" class=\"btn btn-danger btn-xs\"><i class=\"fa fa-times\"></i></button>";
                          echo '</div>' ;   
                                      echo "</td>";


                                        
       
                                
                                echo "</tr>";
                              


                      }
                    }
                    else
                    {
                      echo "No hay ninguna experiencia laboral. Añada una con el botón superior.";
                    }
                  ?>
                
                
             
                
              </table>

                 <div class="box-footer">
                 	
              

               <button type="button" id="aplicarPestana2" class="btn btn-success btn-flat"> Guardar las nuevas entradas al registro <i class="fa fa-save"></i></button> 
				

              </div>

              </div>
        </form>
              <!-- ****************************/.PESTAÑA 3 ***************************************************** -->
     

              <div class="tab-pane" id="tab_3">
  <form  name="formPestana3" id="formPestana3" <?php echo "action=\"".$baseServer."anadirGrados.php\""; ?>method="POST" enctype="multipart/form-data">
            
  <input type="hidden" name="folderid" value="<?php print $folder ?>">
                   <p style="font-family:verdana;font-size:18px;" class="text-success">                    
                    <b>Edite su historial académico:</b>
                   </p>
                   <p style="font-family:verdana;font-size:12px;" class="text-warning">                    
                    <b>Puede añadir nueva formación y editar los datos de las que ingresó en el formulario de aplicación</b>
                   </p>
                   <p style="font-family:verdana;font-size:12px;" class="text-info">                    
                    <b>Si desea modificar el archivo de un atestado, ingrese al vínculo "Ver atestado" y en la página que se abrirá, debe buscar la acción "actualizar documento"</b>
                   </p>
           
           

					<h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                       Grado universitario
                      </a>
                    </h4>

                 

                    	 <p> 
					  <input type="button" class="btn btn-primary btn-sm" id="anadeGrado" value="Añadir un nuevo estudio de grado">
					 <button type="submit" id="aplicarPestana31" class="btn btn-success btn-flat"> Guardar las nuevas entradas al registro de estudios de grado<i class="fa fa-save"></i></button>

					  <p>(Se eliminará la última experiencia de la tabla)</p>
						</p>
                      
                   <table id="tablaGrados" class="table table-bordered table-hover">
	                <tr>
	                  
	                  <th >Titulo obtenido</th>
                    <th >Nombre del título</th>
	                  <th>Año</th>
	                  <th>Institución</th>
                    <th >Atestado (acceder al gestor de archivos)</th>

	                </tr>

	                

                  <?php 
                    $consultar="SELECT * FROM titulos_grado  WHERE idpostulante=$idpostulante";
                    $cargosDB = $db->getResultArray($consultar);
                    if($cargosDB)
                    {
                      foreach ($cargosDB as $key) 
                      {
                        //print_r("Aubarray: ".$key);
                        $id=$key['id'];
                        $titulo=$key['titulo'];
                        $nombretitulo=$key['nombretitulo'];
                        $ano=$key['ano'];
                        $institucion=$key['institucion'];
                        $idatestado=$key['idatestado'];
                        $sufijo="grado";
                         echo "<tr>";
                         //echo "Estado postulación: ".$estadopostulacion;


  echo "<td><a href=\"#\" id=\"titulo\" data-type=\"select\" data-pk=\"$id\" data-url=\"".$baseServer."modificarGrado.php\" data-source=\"{'Bachiller': 'Bachiller', 'Licenciado': 'Licenciado', 'Ingeniero': 'Ingeniero', 'Doctor': 'Doctor', 'Otro': 'Otro'}\" data-title=\"Nombre del título\">$titulo</a></td>";


         echo "<td><a href=\"#\" id=\"nombretitulo\" data-type=\"text\" data-pk=\"$id\" data-url=\"".$baseServer."modificarGrado.php\" data-title=\"F\">$nombretitulo</a></td>";


                                              
            echo "<td><a href=\"#\" id=\"ano\" data-type=\"number\" data-pk=\"$id\" data-url=\"".$baseServer."modificarGrado.php\" data-title=\"Año\">$ano</a></td>";

                                  //

                      echo "<td>";
                              echo "<a href=\"#\" id=\"institucion\" data-type=\"text\" data-pk=\"$id\" data-url=\"".$baseServer."modificarGrado.php\" data-title=\"institucion\">$institucion</a>";
                       echo "</td>";


                      echo "<td>";
                       echo '<div class="col-md-3">';
                        echo "<a href=\"".$baseServer."out/out.ViewDocument.php?documentid=$idatestado\">Ver atestado</a>"; 
                        echo '</div>';
                    
                          echo '<div class="col-md-1">';
                          $idBorrado="borrar-grado-".$id;
                          echo "<button type=\"button\" id=\"$idBorrado\" class=\"btn btn-danger btn-xs\"><i class=\"fa fa-times\"></i></button>";
                          echo '</div>' ;   
                      echo "</td>";      
                                    
                                echo "</tr>";                           
                      }
                    }
                    else
                    {
                      echo "No hay ninguna experiencia laboral. Añada una con el botón superior.";
                    }
                  ?>

 				  </table>

                 	   <!-- FIN DE GRADO UNIVERSITARIO -->
          
                
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                        Post grados
                      </a>
                    </h4>
                  
              
              <p> 
			  <input type="button" class="btn btn-primary btn-sm" id="anadePosGrado" value="Añadir un nuevo estudio de posgrado">
        <button type="submit" id="aplicarPestana32" class="btn btn-success btn-flat"> Guardar las nuevas entradas al registro de estudios de posgrado<i class="fa fa-save"></i></button>
			  
				</p>
                      
                   <table id="tablaPosGrados" class="table table-bordered table-hover">
	                <tr>
	                  
	                  <th>Titulo obtenido</th>
                    <th>Nombre del título</th>
	                  <th>Año</th>
	                  <th>Institución</th>
                    <th>Atestado</th>

	                </tr>

	                 <?php 
                    $consultar="SELECT * FROM titulos_posgrado  WHERE idpostulante=$idpostulante";
                    $cargosDB = $db->getResultArray($consultar);
                    if($cargosDB)
                    {
                      foreach ($cargosDB as $key) 
                      {
                        //print_r("Aubarray: ".$key);
                        $id=$key['id'];
                        $titulo=$key['titulo'];
                        $nombretitulo=$key['nombretitulo'];
                        $ano=$key['ano'];
                        $institucion=$key['institucion'];
                        $idatestado=$key['idatestado'];
                         echo "<tr>";



                      echo "<td><a href=\"#\" id=\"titulo\" data-type=\"select\" data-pk=\"$id\" data-url=\"".$baseServer."modificarPosGrado.php\" data-source=\"{'Máster': 'Máster', 'Doctorado': 'Doctorado','Otro': 'Otro'}\" data-title=\"Nombre del título\" >$titulo</a></td>";


                                  
                      echo "<td><a href=\"#\" id=\"nombretitulo\" data-type=\"text\" data-pk=\"$id\" data-url=\"".$baseServer."modificarPosGrado.php\" data-title=\"Funciones ejercidas\">$nombretitulo</a></td>";


                                              
                      echo "<td><a href=\"#\" id=\"ano\" data-type=\"number\" data-pk=\"$id\" data-url=\"".$baseServer."modificarPosGrado.php\" data-title=\"Año\">$ano</a></td>";

                                  //

                      echo "<td>";
                    echo "<a href=\"#\" id=\"institucion\" data-type=\"text\" data-pk=\"$id\" data-url=\"".$baseServer."modificarPosGrado.php\" data-title=\"institucion\">$institucion</a>";
                       echo "</td>";


                      echo "<td>";
                       echo '<div class="col-md-3">';
                        echo "<a href=\"".$baseServer."out/out.ViewDocument.php?documentid=$idatestado\">Ver atestado</a>"; 
                        echo '</div>';
                    
                          echo '<div class="col-md-1">';
                          $idBorrado="borrar-posgrado-".$id;
                          echo "<button type=\"button\" id=\"$idBorrado\" class=\"btn btn-danger btn-xs\"><i class=\"fa fa-times\"></i></button>";
                          echo '</div>' ;   
                      echo "</td>";     
                                    
                                echo "</tr>";                           
                      }
                    }
                    else
                    {
                      echo "No hay ninguna formación en posgrado. Añada una con el botón superior.";
                    }
                  ?>

			</table>
                    
                <!-- FIN DE POSGHRADO -->


                 	    <!-- INICIO DE OTROS -->
              
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                        Otros cursos recibidos
                      </a>
                    </h4>
                
                 
                            	<p> 
			  <input type="button" class="btn btn-primary btn-sm" id="anadeOtro" value="Añadir un nuevo estudio">
        <button type="submit" id="aplicarPestana33" class="btn btn-success btn-flat"> Guardar las nuevas entradas al registro de otros estudios<i class="fa fa-save"></i></button>
		
				</p>
                      
                   <table id="tablaOtros" class="table table-bordered table-hover">
	                <tr>
	                  
	                  <th>Titulo obtenido</th>
                    <th>Nombre del título</th>
	                  <th>Año</th>
	                  <th>Institución</th>
                    <th>Atestado</th>

	                </tr>
                   <?php 
                    $consultar="SELECT * FROM titulos_otros WHERE idpostulante=$idpostulante";
                    $cargosDB = $db->getResultArray($consultar);
                    if($cargosDB)
                    {
                      foreach ($cargosDB as $key) 
                      {
                        //print_r("Aubarray: ".$key);
                        $id=$key['id'];
                        $titulo=$key['titulo'];
                        $nombretitulo=$key['nombretitulo'];
                        $ano=$key['ano'];
                        $institucion=$key['institucion'];
                        $idatestado=$key['idatestado'];
                         echo "<tr>";



                      echo "<td><a href=\"#\" id=\"titulo\" data-type=\"text\" data-pk=\"$id\" data-url=\"".$baseServer."modificarOtroGrado.php\" data-title=\"Nombre del título\">$titulo</a></td>";


                                  
                      echo "<td><a href=\"#\" id=\"nombretitulo\" data-type=\"text\" data-pk=\"$id\" data-url=\"".$baseServer."modificarOtroGrado.php\" data-title=\"Funciones ejercidas\">$nombretitulo</a></td>";


                                              
                      echo "<td>";
                      echo "<a href=\"#\" id=\"ano\" data-type=\"number\" data-pk=\"$id\" data-url=\"".$baseServer."modificarOtroGrado.php\" data-title=\"Año\">$ano</a>";   
                          echo "</td>";


                     echo "<td>";
                              echo "<a href=\"#\" id=\"institucion\" data-type=\"text\" data-pk=\"$id\" data-url=\"".$baseServer."modificarOtroGrado.php\" data-title=\"institucion\">$institucion</a>";
                       echo "</td>";
                        


                     echo "<td>";
                       echo '<div class="col-md-3">';
                        echo "<a href=\"".$baseServer."out/out.ViewDocument.php?documentid=$idatestado\">Ver atestado</a>"; 
                        echo '</div>';
                    
                          echo '<div class="col-md-1">';
                          $idBorrado="borrar-otro-".$id;
                          echo "<button type=\"button\" id=\"$idBorrado\" class=\"btn btn-danger btn-xs\"><i class=\"fa fa-times\"></i></button>";
                          echo '</div>' ;   
                      echo "</td>";




                                echo "</tr>";                           
                      }
                    }
                    else
                    {
                      echo "No hay ninguna formación en otros estudios. Añada una con el botón superior.";
                    }
                  ?>

	                 
		              </table>
				

				   <div class="box-footer">
				  
	                 <a id="btn-prev-3" href="#tab_2" data-toggle="tab" type="button" class="btn btn-warning pull-left">
	                <i class="fa fa-arrow-left"></i>Volver al paso 2: experiencia laboral</a>

	                
	              		
	              		    		
			              			          	             
											
					 
			     	</div>	 <!-- /.FIN DEL BOX FOOTER -->        
 </div> <!-- FIN DE TAB 3 -->
</form>
              <!-- ****************************/.PESTAÑA 4 ***************************************************** -->

                <div class="tab-pane" id="tab_4">
                    <form  name="formPestana4" id="formPestana4" <?php echo "action=\"".$baseServer."anadirTemasPublicos.php"; ?>method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="folderid" value="<?php print $folder ?>">
                     <input type="hidden" name="estadopostulacion" value="<?php print $estadopostulacion ?>">
                    <input type="hidden" name="idpostulacion" value="<?php print $idpostulacion ?>">
                  <p style="font-family:verdana;font-size:18px;" class="text-success">                    
                    <b>En esta sección, puede quitar o añadir temas de la administración pública en la que se especializa.</b>
                   </p>

                   <p style="font-family:verdana;font-size:12px;" class="text-warning">                    
                    <b>Si desea eliminar un tema de los mostrados, haga click en el botón rojo abajo del mismo.
                    </b><br>
                    Para añadir, seleccione de la lista los temas correspondientes, tal como lo hizo en el formulario de aplicación. Verá un mensaje y la página se refrescará cuando añada un nuevo tema.
                   </p>

                      <div class="box box-solid">
            <div class="box-header with-border">
              <i class="fa fa-text-width"></i>

              <h3 class="box-title">Temas de la administración pública en los que se especializa</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <ul>

                <?php 
                  imprimirTemasManejados($idpostulante,$db);
                ?>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

                             <div class="row"> <!-- inicio de disposicion row tab 4 -->
                            <div class="col-sm-4" style="background-color:lavender;">
                                                    <!-- INICIO DE GRUPO GERENCIA PÚBLICA -->
                                        <div class="form-group">
                                           <label>
                                          Gerencia pública
                                          </label>
                                        <div class="radio">
                                          <label>
                                            <input type="radio" name="gerenciaPublica" id="optionsRadios1" value="si">
                                           Sí
                                          </label>
                                        </div>
                                        <div class="radio">
                                          <label>
                                            <input type="radio" name="gerenciaPublica" id="optionsRadios2" value="no" checked>
                                           No
                                         </label>
                                        </div>
                                      </div>   <!-- fin de form group -->
                                      <div id="mostrarGerencia" style="display: none;">
                                ¿En qué temas específicamente?
                                <select class="form-control chzn-select"  name="temasGerencia[]"  id="temasGerencia" multiple="multiple" data-placeholder="Seleccione uno o varios temas de la lista..."  >
                                <?php             
                                        imprimirTemas("gerencia");
                                     ?>
                                </select>
                              </div>
                      <!-- FIN DE GRUPO GERENCIA PÚBLICA -->


                      <!-- INICIO DE PLANIFICACION PARA EL DESARROLLO -->
                                        <div class="form-group">
                                           <label>
                                          Planificación para el desarrollo
                                          </label>
                                        <div class="radio">
                                          <label>
                                            <input type="radio" name="planificacionDesarrollo" id="optionsRadios1" value="si">
                                           Sí
                                          </label>
                                        </div>
                                        <div class="radio">
                                          <label>
                                            <input type="radio" name="planificacionDesarrollo" id="optionsRadios2" value="no" checked>
                                           No
                                         </label>
                                        </div>
                                      </div>   <!-- fin de form group -->
                                      <div id="mostrarPlanificacion" style="display: none;">
                                ¿En qué temas específicamente?
                                <select class="form-control chzn-select"  name="temasPlanificacion[]"  multiple="multiple" data-placeholder="Seleccione uno o varios temas de la lista...">
                                <?php             
                                        imprimirTemas("planificacion");
                                     ?>
                                    </select>
                              </div>
                      <!-- FIN DE PLANIFICACION PARA EL DESARROLLO-->

                       <!-- INICIO DE GRUPO c.  Gestión del talento humano por competencias en el sector público -->
                                        <div class="form-group">
                                           <label>
                                         Gestión del talento humano por competencias en el sector público
                                          </label>
                                        <div class="radio">
                                          <label>
                                            <input type="radio" name="gestionTalento" id="optionsRadios1" value="si">
                                           Sí
                                          </label>
                                        </div>
                                        <div class="radio">
                                          <label>
                                            <input type="radio" name="gestionTalento" id="optionsRadios2" value="no" checked>
                                           No
                                         </label>
                                        </div>
                                      </div>   <!-- fin de form group -->
                                      <div id="mostrarTalento" style="display: none;">
                                ¿En qué temas específicamente?
                                <select class="form-control chzn-select"  name="temasTalento[]"  multiple="multiple" data-placeholder="Seleccione uno o varios temas de la lista...">
                                <?php             
                                        imprimirTemas("talento");
                                     ?>
                                    </select>
                              </div>
                      <!-- FIN DE GRUPO c.  Gestión del talento humano por competencias en el sector público -->


                       <!-- INICIO DE GRUPO d.  Gobierno y territorio -->
                                        <div class="form-group">
                                           <label>
                                         Gobierno y territorio
                                          </label>
                                        <div class="radio">
                                          <label>
                                            <input type="radio" name="gobiernoTerritorio" id="optionsRadios1" value="si">
                                           Sí
                                          </label>
                                        </div>
                                        <div class="radio">
                                          <label>
                                            <input type="radio" name="gobiernoTerritorio" id="optionsRadios2" value="no" checked>
                                           No
                                         </label>
                                        </div>
                                      </div>   <!-- fin de form group -->
                                      <div id="mostrarGobierno" style="display: none;">
                                ¿En qué temas específicamente?
                                <select class="form-control chzn-select"  name="temasGobierno[]"  multiple="multiple" data-placeholder="Seleccione uno o varios temas de la lista...">
                                <?php             
                                        imprimirTemas("gobierno");
                                     ?>
                                    </select>
                                 </div>
                
                      <!-- FIN DE GRUPO d.  Gobierno y territorio -->              
                        </div> <!-- fin de primer row tab4 : primeras 4 opciones-->
                        <div class="col-sm-4" style="background-color:lavenderblush;">

                                <!-- INICIO DE GRUPO e. Ética y transparencia en la gestión pública -->
                  <div class="form-group">
                     <label>
                   Ética y transparencia en la gestión pública
                    </label>
                  <div class="radio">
                    <label>
                      <input type="radio" name="etica" id="optionsRadios1" value="si">
                     Sí
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="etica" id="optionsRadios2" value="no" checked>
                     No
                   </label>
                  </div>
                </div>   <!-- fin de form group -->
                <div id="mostrarEtica" style="display: none;">
          ¿En qué temas específicamente?
          <select class="form-control chzn-select"  name="temasEtica[]"  multiple="multiple" data-placeholder="Seleccione uno o varios temas de la lista...">
          <?php             
                  imprimirTemas("etica");
               ?>
              </select>
        </div>
<!-- FIN DE GRUPO e.  Ética y transparencia en la gestión pública -->

 <!-- INICIO DE GRUPO f.  Gobierno electrónico -->
                  <div class="form-group">
                     <label>
                   Gobierno electrónico
                    </label>
                  <div class="radio">
                    <label>
                      <input type="radio" name="gobiernoElectronico" id="optionsRadios1" value="si">
                     Sí
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="gobiernoElectronico" id="optionsRadios2" value="no" checked>
                     No
                   </label>
                  </div>
                </div>   <!-- fin de form group -->
                <div id="mostrarElectronico" style="display: none;">
          ¿En qué temas específicamente?
          <select class="form-control chzn-select"  name="temasElectronico[]"  multiple="multiple" data-placeholder="Seleccione uno o varios temas de la lista...">
          <?php             
                  imprimirTemas("electronico");
               ?>
              </select>
        </div>
<!-- FIN DE GRUPO f.  Gobierno electrónico -->

 <!-- INICIO DE GRUPO g.  Gobierno abierto y participación ciudadana -->
                  <div class="form-group">
                     <label>
                   Gobierno abierto y participación ciudadana
                    </label>
                  <div class="radio">
                    <label>
                      <input type="radio" name="gobiernoAbierto" id="optionsRadios1" value="si">
                     Sí
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="gobiernoAbierto" id="optionsRadios2" value="no" checked>
                     No
                   </label>
                  </div>
                </div>   <!-- fin de form group -->
                <div id="mostrarAbierto" style="display: none;">
          ¿En qué temas específicamente?
          <select class="form-control chzn-select"  name="temasAbierto[]"  multiple="multiple" data-placeholder="Seleccione uno o varios temas de la lista...">
          <?php             
                  imprimirTemas("abierto");
               ?>
              </select>
        </div>
<!-- FIN DE GRUPO g.  Gobierno abierto y participación ciudadana -->

 <!-- INICIO DE GRUPO h.  Gestión de Calidad en el sector público -->
                  <div class="form-group">
                     <label>
                   Gestión de Calidad en el sector público
                    </label>
                  <div class="radio">
                    <label>
                      <input type="radio" name="gestionCalidad" id="optionsRadios1" value="si">
                     Sí
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="gestionCalidad" id="optionsRadios2" value="no" checked>
                     No
                   </label>
                  </div>
                </div>   <!-- fin de form group -->
                <div id="mostrarCalidad" style="display: none;">
            ¿En qué temas específicamente?
            <select class="form-control chzn-select"  name="temasCalidad[]"  multiple="multiple" data-placeholder="Seleccione uno o varios temas de la lista...">
            <?php             
                imprimirTemas("calidad");
               ?>
              </select>
            </div>
<!-- FIN DE GRUPO h.  Gestión de Calidad en el sector público -->
             
                        </div> <!-- fin de segundo row tab4  segundas 4 opciones-->
                        <div class="col-sm-4" style="background-color:lavender;">
                              <!-- INICIO DE GRUPO i. Enfoque de derechos en la gestión pública -->
                  <div class="form-group">
                     <label>
                   Enfoque de derechos en la gestión pública
                    </label>
                  <div class="radio">
                    <label>
                      <input type="radio" name="enfoque" id="optionsRadios1" value="si">
                     Sí
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="enfoque" id="optionsRadios2" value="no" checked>
                     No
                   </label>
                  </div>
                </div>   <!-- fin de form group -->
                <div id="mostrarEnfoque" style="display: none;">
          ¿En qué temas específicamente?
          <select class="form-control chzn-select"  name="temasEnfoque[]"  multiple="multiple" data-placeholder="Seleccione uno o varios temas de la lista...">
          <?php             
                  imprimirTemas("enfoque");
               ?>
              </select>
        </div>
<!-- FIN DE GRUPO i.  Enfoque de derechos en la gestión pública -->

<!-- INICIO DE GRUPO j. Relaciones laborales en el sector público -->
                  <div class="form-group">
                     <label>
                   Relaciones laborales en el sector público
                    </label>
                  <div class="radio">
                    <label>
                      <input type="radio" name="relaciones" id="optionsRadios1" value="si">
                     Sí
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="relaciones" id="optionsRadios2" value="no" checked>
                     No
                   </label>
                  </div>
                </div>   <!-- fin de form group -->
                <div id="mostrarRelaciones" style="display: none;">
          ¿En qué temas específicamente?
          <select class="form-control chzn-select"  name="temasRelaciones[]"  multiple="multiple" data-placeholder="Seleccione uno o varios temas de la lista...">
          <?php             
                  imprimirTemas("relaciones");
               ?>
              </select>
        </div>
<!-- FIN DE GRUPO j.  Relaciones laborales en el sector público -->

<!-- INICIO DE GRUPO k. Gestión de capacitación en el sector público -->
                  <div class="form-group">
                     <label>
                   Gestión de capacitación en el sector público
                    </label>
                  <div class="radio">
                    <label>
                      <input type="radio" name="capacitacion" id="optionsRadios1" value="si">
                     Sí
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="capacitacion" id="optionsRadios2" value="no" checked>
                     No
                   </label>
                  </div>
                </div>   <!-- fin de form group -->
                <div id="mostrarCapacitacion" style="display: none;">
          ¿En qué temas específicamente?
          <select class="form-control chzn-select"  name="temasCapacitacion[]"  multiple="multiple" data-placeholder="Seleccione uno o varios temas de la lista...">
          <?php             
                  imprimirTemas("capacitacion");
               ?>
              </select>
        </div>
<!-- FIN DE GRUPO k.  Gestión de capacitación en el sector público -->
                  
                        </div> <!-- fin de tercer row tab4 -->
                    </div> <!-- fin de disposicion row tab 4 -->

      <?php 
        $hayConocimientos=$user->hayConocimientosAdicionales($idpostulante);
        if(!$hayConocimientos)
        {
          echo'<div class="row"> <!-- inicio de disposicion row conocimientos adicionales (feb. 2018) -->';
        echo '<p><b>Si posee conocimientos adicionales a los que seleccionó, escríbalos aquí</b></p>';
        echo '<textarea  class="form-control" name="conocimientosAdicionales" id="conocimientosAdicionales" placeholder="Ingrese sus conocimientos adicionales aquí..."></textarea>';

        echo '</div><!-- fin de disposicion row conocimientos adicionales (feb. 2018) -->';
        }

        else
        {
          echo '<h3>Conocimientos adicionales a estos temas</h3>';
            //$conocimientos=$user->getConocimientosAdicionales($idpostulante);
          $getNumChats="SELECT conocimientos,id FROM conocimientos_adicionales WHERE idpostulante=$idpostulante";
          //echo "query: ".$getNumChats;
          $tat = $db->getResultArray($getNumChats);
          $conocimientos=$tat[0]['conocimientos'];
           $id=$tat[0]['id'];
            echo "<a href=\"#\" id=\"conocimientos\" data-type=\"text\" data-pk=\"$id\" data-url=\"".$baseServer."modificarConocimientos.php\" data-title=\"Nombre conocimientos\">$conocimientos</a>";

        }
      

      ?>
              

            <div class="box-footer"> <!-- /.INICIO BOX FOOTER -->
                <button type="submit" id="aplicarPestana4" class="btn btn-success btn-flat"> Guardar las nuevas entradas al registro <i class="fa fa-save"></i></button> 
              </div>   <!-- /.FIN DEL BOX FOOTER -->
              </form> <!-- /.FIN FORMULARIO  4 -->
                </div> <!-- /.FIN PESTAÑA 4 -->
              

               <!-- **************************************/.PESTAÑA 5 ***************************************************** -->

                <div class="tab-pane" id="tab_5">
                <form  name="formPestana5" id="formPestana5" <?php echo "action=\"".$baseServer."anadirMaterias.php"; ?>method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="folderid" value="<?php print $folder ?>">
                     <input type="hidden" name="estadopostulacion" value="<?php print $estadopostulacion ?>">
                    <input type="hidden" name="idpostulacion" value="<?php print $idpostulacion ?>">
                 <p style="font-family:verdana;font-size:18px;" class="text-success">                    
                    <b>Si practica la docencia (al menos los últimos 5 años):</b>
                   </p>
                    <p style="font-family:verdana;font-size:12px;" class="text-warning">                    
                    <b>Puede editar cada elemento de esta sección haciendo click en él</b>
                   </p>
                   <p style="font-family:verdana;font-size:12px;" class="text-info">                    
                    <b>Si desea modificar el atestado, ingrese al enlace "Ver atestado" y en la página que se abrirá busque la acción "Actualizar documento"</b>
                   </p>
				<p> 
			  <input type="button" class="btn btn-primary btn-sm" id="anadeMateria" value="Añadir una nueva materia">

				</p>


                <table id="tablaMaterias" class="table table-bordered table-hover">
                <tr>
                  
                  <th>Materia</th>
                  <th>Institución</th>
                  <th>Periodo</th>

                  <th>Modalidad</th>
                  <th>Atestado*</th>

                </tr>
               <?php 
                    $consultar="SELECT * FROM materias_docencia WHERE idpostulante=$idpostulante";
                    $cargosDB = $db->getResultArray($consultar);
                    if($cargosDB)
                    {
                      foreach ($cargosDB as $key) 
                      {
                        //print_r("Aubarray: ".$key);
                        $id=$key['id'];
                        $materia=$key['materia'];
                        $modalidad=$key['modalidad'];
                        $institucion=$key['institucion'];
                        $anoinicio=$key['anoinicio'];
                        $anofin=$key['anofin'];
                         $idatestado=$key['idatestado'];
                         echo "<tr>";



                      echo "<td><a href=\"#\" id=\"materia\" data-type=\"text\" data-pk=\"$id\" data-url=\"".$baseServer."modificarMaterias.php\" data-title=\"Nombre materia\">$materia</a></td>";


                                  
                      echo "<td><a href=\"#\" id=\"institucion\" data-type=\"text\" data-pk=\"$id\" data-url=\"".$baseServer."modificarMaterias.php\" data-title=\"Institucion\">$institucion</a></td>";


                    


                              echo "<td>";
                                    echo '<div class="col-xs-4">';
                          echo "<a href=\"#\" id=\"anoinicio\" data-type=\"combodate\" data-pk=\"$id\" data-url=\"".$baseServer."modificarMaterias.php\" data-title=\"Fecha inicial\">$anoinicio</a>";
                                      echo '</div>';

                                     echo '<div class="col-xs-1">-</div>';

                                    echo '<div class="col-xs-4">';
                              echo "<a href=\"#\" id=\"anofin\" data-type=\"combodate\" data-pk=\"$id\" data-url=\"".$baseServer."modificarMaterias.php\" data-title=\"Fecha inicial\">$anofin</a>";
                                      echo '</div>';                                      
                                      echo "</td>"; 

                    echo "<td><a href=\"#\" id=\"modalidad\" data-type=\"select\" data-pk=\"$id\" data-url=\"".$baseServer."modificarMaterias.php\" data-source=\"{'Presencial': 'Presencial', 'Semipresencial': 'Semipresencial', 'En línea': 'En línea'}\" >$modalidad</a></td>";


                                    echo "<td>";
                       echo '<div class="col-md-3">';
                        echo "<a href=\"".$baseServer."out/out.ViewDocument.php?documentid=$idatestado\">Ver atestado</a>"; 
                        echo '</div>';
                    
                          echo '<div class="col-md-1">';
                          $idBorrado="eliminar-materia-".$id;
                          echo "<button type=\"button\" id=\"$idBorrado\" class=\"btn btn-danger btn-xs\"><i class=\"fa fa-times\"></i></button>";
                          echo '</div>' ;   
                      echo "</td>";



                                echo "</tr>";                             
                      }
                    }
                    else
                    {
                      echo "No hay ninguna experiencia en impartición de docencia. Añada una con el botón superior.";
                    }
                  ?>
                
              </table>



                <div class="box-footer"> <!-- /.INICIO DEL BOX FOOTER 5 -->
	         <button type="button" id="aplicarPestana5" class="btn btn-success btn-flat"> Guardar las nuevas entradas al registro <i class="fa fa-save"></i></button> 
        
				    </div>	 <!-- /.FIN DEL BOX FOOTER 5 -->
 </form>
              </div>  <!-- /.FIN PESTAÑA 5 -->
           

               <!-- ***************************************/.PESTAÑA 6 ***************************************************** -->

                <div class="tab-pane" id="tab_6">  <!-- /.INICIO PESTAÑA 6 -->
                   <form  name="formPestana6" id="formPestana6" <?php echo "action=\"".$baseServer."anadirTalleres.php" ?> method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="folderid" value="<?php print $folder ?>">
                    <input type="hidden" name="estadopostulacion" value="<?php print $estadopostulacion ?>">
                    <input type="hidden" name="idpostulacion" value="<?php print $idpostulacion ?>">
                   <p style="font-family:verdana;font-size:18px;" class="text-success">                    
                    <b>Experiencia en formación y capacitación (al menos en los últimos 5 años):</b>
                   </p>

                   <p style="font-family:verdana;font-size:12px;" class="text-warning">                    
                    <b>Si no tiene ninguna experiencia en formación o capacitación, utilice el botón de Eliminar  para dejar vacía la tabla.</b>
                   </p>
                   <p style="font-family:verdana;font-size:12px;" class="text-info">                    
                    <b>Si añade al menos una experiencia, todos los campos serán de rellenado obligatorio.</b>
                   </p>

                    
            </br>
                 <input type="button" class="btn btn-primary btn-sm" id="anadeCapacitacion" value="Añadir una nueva experiencia en formación/capacitación">


                <table id="tablaCapacitaciones" class="table table-bordered table-hover">
                <tr>                 
                  <th>Nombre del programa o taller</th>
                  <th>Total de horas impartidas</th>
                  <th>Periodo</th>
                  <th>Institución</th>
                  <th>Modalidad</th>
                  <th>Atestado</th>
                </tr>

                <?php 
                    $consultar="SELECT * FROM experiencia_formacion WHERE idpostulante=$idpostulante";
                    $cargosDB = $db->getResultArray($consultar);
                    if($cargosDB)
                    {
                      foreach ($cargosDB as $key) 
                      {
                        //print_r("Aubarray: ".$key);
                        $id=$key['id'];
                        $taller=$key['taller'];
                        $totalhoras=$key['totalhoras'];
                        $fechainicio=$key['fechainicio'];
                        $fechafin=$key['fechafin'];
                        $modalidad=$key['modalidad'];
                        $institucion=$key['institucion'];
                         $idatestado=$key['idatestado'];
                         echo "<tr>";

                      echo "<td><a href=\"#\" id=\"taller\" data-type=\"text\" data-pk=\"$id\" data-url=\"".$baseServer."modificarTaller.php\" data-title=\"Nombre taller\">$taller</a></td>";


                                  
                      echo "<td><a href=\"#\" id=\"totalhoras\" data-type=\"number\" data-pk=\"$id\" data-url=\"".$baseServer."modificarTaller.php\" data-title=\"total de horas\">$totalhoras</a></td>";


                              echo "<td>";
                                    echo '<div class="col-xs-4">';
                          echo "<a href=\"#\" id=\"fechainicio\" data-type=\"combodate\" data-pk=\"$id\" data-url=\"".$baseServer."modificarTaller.php\" data-title=\"Fecha inicial\">$fechainicio</a>";
                                      echo '</div>';

                                     echo '<div class="col-xs-1">-</div>';

                                    echo '<div class="col-xs-4">';
                              echo "<a href=\"#\" id=\"fechafin\" data-type=\"combodate\" data-pk=\"$id\" data-url=\"".$baseServer."modificarTaller.php\" data-title=\"Fecha final\">$fechafin</a>";
                                      echo '</div>';                                      
                                      echo "</td>"; 

                    echo "<td><a href=\"#\" id=\"institucion\" data-type=\"text\" data-pk=\"$id\" data-url=\"".$baseServer."modificarTaller.php\">$institucion</a></td>";

                     echo "<td><a href=\"#\" id=\"modalidad\" data-type=\"select\" data-pk=\"$id\" data-url=\"".$baseServer."modificarTaller.php\" data-source=\"{'Presencial': 'Presencial', 'Semipresencial': 'Semipresencial', 'En línea': 'En línea'}\" >$modalidad</a></td>";


                                    echo "<td>";
                       echo '<div class="col-md-3">';
                        echo "<a href=\"".$baseServer."out/out.ViewDocument.php?documentid=$idatestado\">Ver atestado</a>"; 
                        echo '</div>';
                    
                          echo '<div class="col-md-1">';
                          $idBorrado="eliminar-taller-".$id;
                          echo "<button type=\"button\" id=\"$idBorrado\" class=\"btn btn-danger btn-xs\"><i class=\"fa fa-times\"></i></button>";
                          echo '</div>' ;   
                      echo "</td>";



                                echo "</tr>";                             
                      }
                    }
                    else
                    {
                      echo "No hay ninguna experiencia en impartición de docencia. Añada una con el botón superior.";
                    }
                  ?>
              </table>




                <div class="box-footer"> <!-- /.INICIO DEL BOX FOOTER -->
	                  <button type="button" id="aplicarPestana6" class="btn btn-success btn-flat"> Guardar las nuevas entradas al registro <i class="fa fa-save"></i></button> 
				</div>	 <!-- /.FIN DEL BOX FOOTER -->
        </form> <!-- /.FIN DE FORM PESTAÑA 6 -->
              </div>  <!-- /.FIN PESTAÑA 6 -->
             
              <!-- **********************************/.PESTAÑA 7 ***************************************************** -->

                <div class="tab-pane" id="tab_7">
                  <form  name="formPestana7" id="formPestana7" <?php echo "action=\"".$baseServer."anadirMetodologias.php" ?> method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="folderid" value="<?php print $folder ?>">
                     <input type="hidden" name="estadopostulacion" value="<?php print $estadopostulacion ?>">
                    <input type="hidden" name="idpostulacion" value="<?php print $idpostulacion ?>">
                	 <p style="font-family:verdana;font-size:18px;" class="text-success">


                   	Manejo de metodologías (agregar al menos 3 experiencias que demuestren el manejo de metodología que manifiesta)
                   </p>
                   <p style="font-family:verdana;font-size:12px;" class="text-warning">                    
                    <b>Para aquellas categorías que usted marque, la información y el atestado son de rellenado obligatorio</b>
                   </p>

                  </br>

          <div class="box box-solid">
            <div class="box-header with-border">
              <i class="fa fa-text-width"></i>

              <h3 class="box-title">Descripción de las metodologías que maneja. Haga click en una descripción para ver el atestado</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <ul>

                <?php 
                  imprimeMetodologias($idpostulante,$db);
                ?>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>  

              
                 <!-- INICIO DE GRUPO Diseño de programas y/o proyectos de formación y/o capacitación (curricular) -->
                  <div class="form-group">
                  	 <input type="checkbox" id="metodologiaDiseño" > 
                  	 <label class="text-primary">
                         Diseño de programas y/o proyectos de formación y/o capacitación (curricular)
                    </label>              
                  </div>   <!-- fin de form group -->

                <div id="siete1" style="display: none;">
                	<input type="button" class="btn btn-primary btn-xs" id="anade71" value="Añadir una nueva experiencia esta metodología">
				    <input type="button" class="btn btn-danger btn-xs" id="elimina71" value="Eliminar la última entrada añadida">
                	<table id="tabla71" class="table table-condensed">
                			 <tr>                 
			                  <th style="color:blue;font-family:courier;">Describa la experiencia en el manejo de esta metodología</th>
			                  <th style="color:blue; font-family:courier;"> Atestado que demuestre el manejo de esta metodología</th>			                  
			                </tr>

			                <tr> 
			                	<td>
                  	  			  <textarea  class="form-control" name="metodologiaProgramas[]" id="metodologiaProgramas1" placeholder="Ingrese su texto aquí..."></textarea>
                    			</td>

						         <td>
			                  	   <input type="file" name="metodologiaProgramasAtestado[]" id="metodologiaProgramasAtestado1" >
			                     </td>
			                </tr>


                	</table>				      					
				</div>
				<!-- FIN DE GRUPO Diseño de programas y/o proyectos de formación y/o capacitación (curricular) -->

				 <!-- INICIO DE GRUPO Diseño de cartas didácticas (diseños instruccionales) -->

                  <div class="form-group">
                  	 <input type="checkbox" id="disenoCartas" > 
                  	 <label class="text-primary">
                        Diseño de cartas didácticas (diseños instruccionales)
                    </label>              
                  </div>   <!-- fin de form group -->

                <div id="siete2" style="display: none;">
                	<input type="button" class="btn btn-primary btn-xs" id="anade72" value="Añadir una nueva experiencia esta metodología">
				    <input type="button" class="btn btn-danger btn-xs" id="elimina72" value="Eliminar la última entrada añadida">
                	<table id="tabla72" class="table table-condensed">
                			 <tr>                 
			                  <th style="color:blue;font-family:courier;">Describa la experiencia en el manejo de esta metodología</th>
			                  <th style="color:blue; font-family:courier;"> Atestado que demuestre el manejo de esta metodología</th>			                  
			                </tr>

			                <tr> 
			                	<td>
                  	  			  <textarea  class="form-control" name="metodologiaDisenoCartas[]" id="metodologiaDisenoCartas1" placeholder="Ingrese su texto aquí..."></textarea>
                    			</td>

						         <td>
			                  	   <input type="file" name="metodologiaDisenoCartasAtestado[]" id="metodologiaDisenoCartasAtestado1" >
			                     </td>
			                </tr>


                	</table>				      					
				</div>
				<!-- FIN DE GRUPO Diseño de cartas didácticas (diseños instruccionales) -->

				<!-- INICIO DE GRUPO Evaluación de procesos de formación (en cuales procesos, metodología) -->

                  <div class="form-group">
                  	 <input type="checkbox" id="evaluacionProcesos" > 
                  	 <label class="text-primary">
                        Evaluación de procesos de formación (en cuales procesos, metodología)
                    </label>              
                  </div>   <!-- fin de form group -->

                <div id="siete3" style="display: none;">
                	<input type="button" class="btn btn-primary btn-xs" id="anade73" value="Añadir una nueva experiencia esta metodología">
				    <input type="button" class="btn btn-danger btn-xs" id="elimina73" value="Eliminar la última entrada añadida">
                	<table id="tabla73" class="table table-condensed">
                			 <tr>                 
			                  <th style="color:blue;font-family:courier;">Describa la experiencia en el manejo de esta metodología</th>
			                  <th style="color:blue; font-family:courier;"> Atestado que demuestre el manejo de esta metodología</th>			                  
			                </tr>

			                <tr> 
			                	<td>
                  	  			  <textarea  class="form-control" name="metodologiaEvaluacion[]" id="metodologiaEvaluacion1" placeholder="Ingrese su texto aquí..."></textarea>
                    			</td>

						         <td>
			                  	   <input type="file" name="metodologiaEvaluacionAtestado[]" id="metodologiaEvaluacionAtestado1" >
			                     </td>
			                </tr>


                	</table>				      					
				</div>
				<!-- FIN DE GRUPO Evaluación de procesos de formación (en cuales procesos, metodología) -->


					<!-- INICIO DE GRUPO Facilitación de talleres o cursos de formación o capacitación (cuáles) -->

                  <div class="form-group">
                  	 <input type="checkbox" id="facilitacionTalleres" > 
                  	 <label class="text-primary">
                       Facilitación de talleres o cursos de formación o capacitación (cuáles)
                    </label>              
                  </div>   <!-- fin de form group -->

                <div id="siete4" style="display: none;">
                	<input type="button" class="btn btn-primary btn-xs" id="anade74" value="Añadir una nueva experiencia esta metodología">
				    <input type="button" class="btn btn-danger btn-xs" id="elimina74" value="Eliminar la última entrada añadida">
                	<table id="tabla74" class="table table-condensed">
                			 <tr>                 
			                  <th style="color:blue;font-family:courier;">Describa la experiencia en el manejo de esta metodología</th>
			                  <th style="color:blue; font-family:courier;"> Atestado que demuestre el manejo de esta metodología</th>			                  
			                </tr>

			                <tr> 
			                	<td>
                  	  			  <textarea  class="form-control" name="metodologiaFacilitacion[]" id="metodologiaFacilitacion1" placeholder="Ingrese su texto aquí..."></textarea>
                    			</td>

						         <td>
			                  	   <input type="file" name="metodologiaFacilitacionAtestado[]" id="metodologiaFacilitacionAtestado1" >
			                     </td>
			                </tr>


                	</table>				      					
				</div>
				<!-- FIN DE GRUPO Facilitación de talleres o cursos de formación o capacitación (cuáles) -->

					<!-- INICIO DE GRUPO Metodologías participativas (cuáles) -->

                  <div class="form-group">
                  	 <input type="checkbox" id="metodologiasParticipativas" > 
                  	 <label class="text-primary">
                       Metodologías participativas (cuáles)
                    </label>              
                  </div>   <!-- fin de form group -->

                <div id="siete5" style="display: none;">
                	<input type="button" class="btn btn-primary btn-xs" id="anade75" value="Añadir una nueva experiencia esta metodología">
				    <input type="button" class="btn btn-danger btn-xs" id="elimina75" value="Eliminar la última entrada añadida">
                	<table id="tabla75" class="table table-condensed">
                			 <tr>                 
			                  <th style="color:blue;font-family:courier;">Describa la experiencia en el manejo de esta metodología</th>
			                  <th style="color:blue; font-family:courier;"> Atestado que demuestre el manejo de esta metodología</th>			                  
			                </tr>

			                <tr> 
			                	<td>
                  	  			  <textarea  class="form-control" name="metodologiaParticipativa[]" id="metodologiaParticipativa1" placeholder="Ingrese su texto aquí..."></textarea>
                    			</td>

						         <td>
			                  	   <input type="file" name="metodologiaParticipativaAtestado[]" id="metodologiaParticipativaAtestado1" >
			                     </td>
			                </tr>


                	</table>				      					
				</div>
				<!-- FIN DE GRUPO Metodologías participativas (cuáles) -->

				<!-- INICIO DE GRUPO Elaboración de material de apoyo (manuales, guías, lecturas. Cuáles) -->

                  <div class="form-group">
                  	 <input type="checkbox" id="elaboracionMaterial" > 
                  	 <label class="text-primary">
                       Elaboración de material de apoyo (manuales, guías, lecturas. Cuáles)
                    </label>              
                  </div>   <!-- fin de form group -->

                <div id="siete6" style="display: none;">
                	<input type="button" class="btn btn-primary btn-xs" id="anade76" value="Añadir una nueva experiencia esta metodología">
				    <input type="button" class="btn btn-danger btn-xs" id="elimina76" value="Eliminar la última entrada añadida">
                	<table id="tabla76" class="table table-condensed">
                			 <tr>                 
			                  <th style="color:blue;font-family:courier;">Describa la experiencia en el manejo de esta metodología</th>
			                  <th style="color:blue; font-family:courier;"> Atestado que demuestre el manejo de esta metodología</th>			                  
			                </tr>

			                <tr> 
			                	<td>
                  	  			  <textarea  class="form-control" name="metodologiaElaboracion[]" id="metodologiaElaboracion1" placeholder="Ingrese su texto aquí..."></textarea>
                    			</td>

						         <td>
			                  	   <input type="file" name="metodologiaElaboracionAtestado[]" id="metodologiaElaboracionAtestado1" >
			                     </td>
			                </tr>


                	</table>				      					
				</div>
				<!-- FIN DE GRUPO Elaboración de material de apoyo (manuales, guías, lecturas. Cuáles) -->

				<!-- INICIO DE GRUPO Metodologías en línea (si es diseñador instruccional, contenidista o solo tutor) -->

                  <div class="form-group">
                  	 <input type="checkbox" id="disenador" > 
                  	 <label class="text-primary">
                       Metodologías en línea (si es diseñador instruccional, contenidista o solo tutor)
                    </label>              
                  </div>   <!-- fin de form group -->

                <div id="siete7" style="display: none;">
                	<input type="button" class="btn btn-primary btn-xs" id="anade77" value="Añadir una nueva experiencia esta metodología">
				    <input type="button" class="btn btn-danger btn-xs" id="elimina77" value="Eliminar la última entrada añadida">
                	<table id="tabla77" class="table table-condensed">
                			 <tr>                 
			                  <th style="color:blue;font-family:courier;">Describa la experiencia en el manejo de esta metodología</th>
			                  <th style="color:blue; font-family:courier;"> Atestado que demuestre el manejo de esta metodología</th>			                  
			                </tr>

			                <tr> 
			                	<td>
                  	  			  <textarea  class="form-control" name="metodologiaLinea[]" id="metodologiaLinea1" placeholder="Ingrese su texto aquí..."></textarea>
                    			</td>

						         <td>
			                  	   <input type="file" name="metodologiaLineaAtestado[]" id="metodologiaLineaAtestado1" >
			                     </td>
			                </tr>


                	</table>				      					
				</div>
				<!-- FIN DE GRUPO Metodologías en línea (si es diseñador instruccional, contenidista o solo tutor) -->


                <div class="box-footer"> <!-- /.INICIO DEL BOX FOOTER TAB 7-->
 				 <button type="button" id="aplicarPestana7" class="btn btn-success btn-flat"> Guardar las nuevas entradas al registro <i class="fa fa-save"></i></button> 
				</div>	 <!-- /.FIN DEL BOX FOOTER -->
      </form>
              </div>
              <!-- /.FIN PESTAÑA 7 -->
              <!-- ***********************************/.PESTAÑA 8 ***************************************************** -->
  <div class="tab-pane" id="tab_8">
       <form  name="formPestana8" id="formPestana8" <?php echo "action=\"/anadirIdiomas.php"; ?>method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="folderid" value="<?php print $folder ?>">
                    <input type="hidden" name="estadopostulacion" value="<?php print $estadopostulacion ?>">
                    <input type="hidden" name="idpostulacion" value="<?php print $idpostulacion ?>">
                  <p style="font-family:verdana;font-size:18px;" class="text-success">                    
                    En esta sección, puede modificar la información relativa a los idiomas dominados que indicó en el formulario de aplicación. Concretamente, puede modificar la escala entre 0 y 5 de cada idioma indicado, y añadir nuevos idiomas.
                   </p>

                   <p style="font-family:verdana;font-size:12px;" class="text-info">                    
                    <b>También puede modificar la información aclaratoria de la postulación y su manejo de programas de presentación, haciendo click en el propio texto.</b>
                   </p>

                   <?php 
                      
                      $consultar="SELECT id,relevante FROM otros WHERE idpostulante=$idpostulante;";
                $res = $db->getResultArray($consultar);
                if(strcmp($res[0]['relevante'], "")!=0)
                {
                  echo '<div class="info-box">';
                      echo '<span class="info-box-icon bg-green"><i class="fa fa-address-card-o "></i></span>';

                      echo '<div class="info-box-content">';
                      $crudo=$res[0]['relevante'];
                      $id=$res[0]['id'];
                      $textoRelevante="<a href=\"#\" id=\"relevante\" data-type=\"text\" data-pk=\"$id\" data-url=\"".$baseServer."modificarOtros.php\" data-title=\"Info relevante\">$crudo</a>";

                  echo '<span class="info-box-number">Información que usted indicó como aclaratoria:</span>';
                  echo "<span class=\"info-box-text\">".$textoRelevante."</span>";
                         
                      echo '</div> </div>';          
                }

                echo '<div class="info-box">';
                      echo '<span class="info-box-icon bg-green"><i class="fa fa-file-powerpoint-o"></i></span>';

                      echo '<div class="info-box-content">';
                     $consultar2="SELECT prezi FROM otros WHERE idpostulante=$idpostulante;";
        $res2 = $db->getResultArray($consultar2);
        $valorPrezi=$res2[0]['prezi'];
         $manejoPrezi="<a href=\"#\" id=\"prezi\" data-type=\"select\" data-pk=\"$id\" data-source=\"{'si': 'Sí', 'no': 'No'}\"  data-url=\"".$baseServer."modificarOtros.php\" data-title=\"Info relevante\">$valorPrezi</a>";
                         echo '<span class="info-box-number">Utilización de programas de presentación (PowerPoint, Prezi, etc.):</span>';
                  echo "<span class=\"info-box-text\">".$manejoPrezi."</span>";
                         
                      echo '</div> </div>';       

                ?>
                   <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-info"></i> Atención!</h4>
                Para modificar los valores de las categorías escritas, habladas y escuchadas de un idioma, puede:
                <ul>
                    <li> Utilizar su ratón o dedo dentro del círculo para modificar el valor numérico (como si fuese un marcador)</li>
                    <li> Posicionarse dentro del círculo y modificar con su teclado el valor numérico.</li>

                </ul>
              </div>
        <?php 
        //en un bucle imprimo todos los idiomas que habla
        //query de consulta:
          $consultar="SELECT id,idioma,hablado,escuchado,escrito FROM idiomas WHERE idpostulante=$idpostulante;";
          $res1 = $db->getResultArray($consultar);
          if($res1)
          {
            foreach ($res1 as $key) 
            {
              //print_r("Aubarray: ".$key);
              $id=$key['id'];
              $idioma=$key['idioma'];
              $hablado=$key['hablado']; $hablado=intval($hablado);
              $escuchado=$key['escuchado']; $escuchado=intval($escuchado);
              $escrito=$key['escrito']; $escrito=intval($escrito);

                 echo  '<div class="box-body">';
              echo  '<div class="row">';
                echo  '<div class="col-md-3 text-center">';
                   echo  '<div class="info-box">';
                echo  '<span class="info-box-icon bg-green"><i class="fa fa-flag-o"></i></span>';

                echo  '<div class="info-box-content">';
                  
                  echo "<span class=\"info-box-number\">Idioma $idioma</span>";
                echo  '</div>';
               
                echo  '</div>';

                echo  '</div>';

                echo  '<div class="col-md-3 text-center">';
                  echo "<input type=\"text\" categoria=\"hablado\" id=$id class=\"knob\" value=\"$hablado\" data-skin=\"tron\" data-thickness=\"0.2\" data-width=\"120\" data-height=\"120\" data-step=\"1.0\" data-min=\"0\" data-max=\"5\" data-fgColor=\"#0033cc\">";

                  echo '<div class="knob-label">Hablado</div>';
                echo '</div>';
               
                echo '<div class="col-md-3 text-center">';
                  echo "<input type=\"text\" categoria=\"escuchado\" id=$id class=\"knob\" value=\"$escuchado\" data-skin=\"tron\" data-thickness=\"0.2\" data-width=\"120\" data-height=\"120\" data-step=\"1\" data-min=\"0\" data-max=\"5\" data-fgColor=\"#f56954\">";

                  echo "<div class=\"knob-label\">Escuchado</div>";
                echo '</div>';
               echo '<div class="col-md-3 text-center">';
                  echo "<input type=\"text\" id=$id categoria=\"escrito\" class=\"knob\" value=\"$escrito\" data-skin=\"tron\" data-thickness=\"0.2\" data-width=\"120\" data-height=\"120\" data-step=\"1\" data-min=\"0\" data-max=\"5\" data-fgColor=\"#33cc33\">";

                  echo "<div class=\"knob-label\">Escrito</div>";
                 echo '</div>';
              
               echo '</div>';
             echo '</div>';
              
              
            }//fin bucle
          } //fin si hay resultado consulta
           

        ?>
  

                  <div class="form-group">
                     <label>
                    Dominio de otras lenguas
                    </label>
                  <div class="radio">
                    <label>
                      <input type="radio" name="manejoIngles" id="ingles1" value="si">
                     Sí
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="manejoIngles" id="ingles2" value="no" checked>
                     No
                   </label>
                  </div>
                </div>   <!-- fin de form group -->


                <div id="divOtrasLenguas" style="display: none;">
                  <input type="button" class="btn btn-primary btn-xs" id="anadeIdioma" value="Añadir un nuevo idioma">
            <input type="button" class="btn btn-danger btn-xs" id="eliminaIdioma" value="Eliminar la última entrada añadida">
                  <table id="tablaIdiomas" class="table table-condensed">
                       <tr>                 
                        <th style="color:blue;font-family:courier;">Nombre del idioma o dialecto</th>
                        <th style="color:blue; font-family:courier;"> Valoración del dominio hablado (número entre 0 y 5)</th>
                         <th style="color:blue; font-family:courier;"> Valoración del dominio escuchado (número entre 0 y 5)</th>  
                          <th style="color:blue; font-family:courier;"> Valoración del dominio escrito (número entre 0 y 5)</th>                         
                      </tr>

                      <tr> 
                          <td>
                              <input type="text"  class="form-control" name="idiomas[]" id="idiomas1" placeholder="Nombre del idioma o dialecto...">

                          </td>

                          <td>
                            <input id="hablados1" class="form-control" name="hablados[]" type="number" min="0" max="5" step="1" value="0">                                                      
                           </td>

                             <td>
                    <input id="escuchados1" class="form-control" name="escuchados[]" type="number" min="0" max="5" step="1" value="0">
                              
                           </td>


                             <td>
                      <input id="escritos1" class="form-control" name="escritos[]" type="number" min="0" max="5" step="1" value="0">
                              
                           </td>


                      </tr>


                  </table>                        
                 </div>

      

                <div class="box-footer">
        <button type="button" id="aplicarPestana8" class="btn btn-success btn-flat"> Guardar las nuevas entradas al registro <i class="fa fa-save"></i></button> 
        </div>   <!-- /.FIN DEL BOX FOOTER -->
          </form>
              </div>
              <!-- /.FIN PESTAÑA 8 -->
              <!-- /.FIN PESTAÑA 8 -->
              <!-- ************************************/.PESTAÑA 9 ***************************************************** -->

                <div class="tab-pane" id="tab_9">
                  <form  name="formPestana9" id="formPestana9" <?php echo "action=\"/anadirAdjuntos.php" ?> method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="folderid" value="<?php print $folder ?>">
                    <input type="hidden" name="estadopostulacion" value="<?php print $estadopostulacion ?>">
                    <input type="hidden" name="idpostulacion" value="<?php print $idpostulacion ?>">
                   <p style="font-family:verdana;font-size:18px;" class="text-success">                    
                    Estos son los documentos anexos a su postulación: carta de referencia personales y/o carta de motivación para postulación.
                   </p>
                   <p style="font-family:verdana;font-size:12px;" class="text-warning">                    
                    <b>Si desea actualizar cualquier de estos archivos, ingrese al correspondiente archivo, que lo llevará al gestor de ficheros. En esa sección, identifique la opción "Actualizar documento" y cambie el archivo a su conveniencia.</b>
                   </p>

                   <p style="font-family:verdana;font-size:12px;" class="text-info">                    
                    <b>Si desea adjuntar un archivo, utilice el botón correspondiente y presione el botón "Subir adjuntos"</b>
                   </p>
                   <?php 
                      $hayCarta=$user->hayCarta($idpostulante);

                       if($hayCarta==false)
                       {
                           echo '<div class="form-group">';
                           echo '<label>';
                           echo ' Razones por las cuales desea ser docente en la ENAFOP (carta)';
                           echo '</label>';
                           echo '<input type="file" name="cartaMotivacion" id="cartaMotivacion" >';
                        echo '</div>';
                       }
                        $hayReferencias=$user->hayReferencias($idpostulante);
                        if($hayReferencias==false)
                         {
                             echo '<div class="form-group">';
                             echo '<label>';
                             echo ' Referencias personales';
                             echo '</label>';
                             echo '<input type="file" name="referenciasPersonales" id="referenciasPersonales">';
                          echo '</div>';
                         }

                     ?>

                    <div class="box-footer no-padding">
                       
                          <?php
                            imprimeAdjuntos($idpostulante,$db);
                          ?>                
                     
                   </div>
                   

                <div class="box-footer">
	                <button type="submit" id="aplicarPestana9" class="btn btn-success btn-flat"> Guardar los nuevos adjuntos<i class="fa fa-save"></i></button> 


			        	</div>	 <!-- /.FIN DEL BOX FOOTER -->
              </form>
              </div>
              <!-- /.FIN PESTAÑA 9 -->
            </div>             
            <!-- /.tab-content -->

          </div>


        <div class="modal modal-success fade" id="modal-success">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Cambios guardados</h4>
              </div>
              <div class="modal-body">
                <p>Cambios aplicados correctamente&hellip;</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">OK</button>

              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
 <?php
       //////FIN MI CODIGO      ///////////////////////////////////////////////////////////////////////////////////////    
$this->contentContainerEnd();
$this->endsBoxPrimary();
     ?>
	     </div>
		</div>
		</div>
  <input type="hidden" name="idpostulacion" id="idpostulacion" value="<?php echo $idpostulacion ?>">
  <input type="hidden" name="estadopostulacion" id="estadopostulacion" value="<?php echo $estadopostulacion ?>">
  <input type="hidden" name="baseServer" id="baseServer" value="<?php echo $baseServer ?>">
		<?php	
		$this->contentEnd();
		$this->mainFooter();		
		$this->containerEnd();
		//$this->contentContainerEnd();
		echo "<script type='text/javascript' src='".$baseServer."modificarPefil.js'></script>";
    echo "<script type='text/javascript' src='".$baseServer."styles/multisis-lte/bootstrap-filestyle.js'></script>";
    echo "<script type='text/javascript' src='".$baseServer."/styles/multisis-lte/bootstrap-filestyle.min.js'></script>";
      echo "<script type=\"text/javascript\" src=\"".$baseServer."/styles/".$this->theme.'/jquery-editable/js/jquery-editable-poshytip.min.js"></script>'."\n";
    echo "<script type=\"text/javascript\" src=\"".$baseServer."/styles/".$this->theme.'/poshytip-1.2/src/jquery.poshytip.min.js"></script>'."\n";

    echo '<script src="../styles/multisis-lte/bower_components/jquery-knob/js/jquery.knob.js"></script>';
    echo '<script src="../graficasEnModificar.js"></script>';
		$this->htmlEndPage();
	} /* }}} */
}
?>