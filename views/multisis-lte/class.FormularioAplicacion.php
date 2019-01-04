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
 function imprimirTitulosGrado()
{
	
  $titulos=array("Licenciatura","Ingeniería","Doctorado");
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


function imprimirYears($primerAno)
{
	
  echo "<option disabled selected value>Elija un año</option>";
   for($i = date('Y') ; $i >=$primerAno ; $i--)
   {
      echo "<option>$i</option>";
   }


}

function imprimirPaises()
{
	$fichero="../paises.csv";
	$row = 1;
	echo " <select class=\"form-control chzn-select\" id=\"paisResidencia\" name=\"paisResidencia\">";
if (($handle = fopen($fichero, "r")) !== FALSE) 
{
  echo "<option disabled selected value>Seleccione un país de la lista</option>";
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
function imprimirDepartamentos()
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
  echo " <select class=\"form-control chzn-select\" id=\"departamento\" name=\"departamento\">";

  echo "<option disabled selected value>Seleccione un departamento de la lista</option>";
  foreach ($resultado as $a) 
  {
    foreach ($a as $valor) 
    {
       echo "<option value=\"".$valor."\">".$valor."</option>";
    }
  }

  echo "</select>";
}// fin de imprimir departamentos

function imprimirDocumentos()
{
	$documentos=array("DUI","Pasaporte","Carné de residencia");

	echo " <select class=\"form-control select\" id=\"tipoDocumento\" name=\"tipoDocumento\">";
  echo "<option disabled selected value>Seleccione un tipo de documento de la lista</option>";
    foreach ($documentos as $doc) 
    {
		echo "<option value=\"".$doc."\">".$doc."</option>";
	} //fin del bucle

	echo "</select>";
}// fin de imprimir países

function imprimirGeneros()
{
  $generos=array("Femenino","Masculino","Otro");

  echo " <select class=\"form-control select\" id=\"genero\" name=\"genero\">";
  echo "<option disabled selected value>Seleccione un género de la lista</option>";
    foreach ($generos as $doc) 
    {
    echo "<option value=\"".$doc."\">".$doc."</option>";
  } //fin del bucle

  echo "</select>";
}// fin de imprimir generos

class SeedDMS_View_FormularioAplicacion extends SeedDMS_Bootstrap_Style 
{
	function show() 
	{ /* {{{ */
		$dms = $this->params['dms'];
		$user = $this->params['user'];
		$orderby = $this->params['orderby'];
		$showInProcess = $this->params['showinprocess'];
		$cachedir = $this->params['cachedir'];
		$workflowmode = $this->params['workflowmode'];
		$previewwidth = $this->params['previewWidthList'];
		$timeout = $this->params['timeout'];	
    $folder = getDefaultUserFolder($user->getID());
		$db = $dms->getDB();
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
  echo '<div class="row text-center">';
    echo '<div class="col-xs-12 col-sm-4">';
    echo '<br>';
     echo "<img src=\"/images/logoesa2.png\" class=\"img-responsive center-block\" alt=\"Logo ESA\" height=\"200\" width=\"200\">";

      echo '</div>'; //cierre col 4
      echo '<div class="col-xs-12 col-sm-4">';
      echo '<br>';
      echo "<img src=\"/images/logoStpp.png\" class=\"center-block\" alt=\"Logo STPP\" height=\"95\" width=\"200\">";
      echo '</div>'; //cierre col 4
       echo '<div class="col-xs-12 col-sm-4">';
       echo '<br>';
    echo "<img src=\"/images/logo_transparente.png\" class=\"img-responsive center-block\" alt=\"Logo ENAFOP\" height=\"200\" width=\"200\">";
    echo '</div>'; //cierre col 4
    echo '</div>'; //cierre de row
		?>
    <h1>
        Formulario de aplicación
      </h1>
      <ol class="breadcrumb">
        <li><a href="/out/out.ViewFolder.php?folderid=1"><i class="fa fa-home"></i>Mi perfil: inicio</a></li>
        <li class="active">Llenar mi formulario</li>
      </ol>
    
    <div class="gap-10"></div>
    <div class="row">
    <div class="col-md-12">
    <?php
    //en este bloque php va "mi" código 
 $this->startBoxPrimary("Por favor, complete el siguiente formulario de aplicación. Si tiene cualquier consulta, diríjase a la dirección <a href=\"mailto:enafop@presidencia.gob.sv?Subject=Consulta%Formulario%Docentes\" target=\"_top\">enafop@presidencia.gob.sv</a>");
$this->contentContainerStart();
//////INICIO MI CODIGO
 
?>
  <style>
        .error {
            color: red;
        }
s
    </style>

 

<form  name="formularioAplicacion" id="formularioAplicacion" action="../out/out.ProcesarPostulacion.php" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="folderid" value="<?php print $folder ?>">
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
                
                   <p style="font-size:18px;">                    
                    <b>Por favor, rellene los siguientes datos personales:</b>
                   </p>
                   <p style="font-size:12px;">                    
                    <b>*Todos los campos son de llenado obligatorio</b>
                   </p>
                   

               <div class="form-group">
                  <label for="nombreCompleto">Nombre completo</label>
                  <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Ingrese aquí su nombre...">
                </div>
                

                <div class="form-group">
                  <label for="pais">Género</label>                
                              <?php             
                          imprimirGeneros();
                            ?>                
                </div>


                <div class="form-group">
                  <label for="edad">Edad</label>
                  <input type="number" class="form-control" name="edad" id="edad" placeholder="Al menos 18 años..." style="width: 23em;" min="18">
                </div>

                <div class="form-group">
                  <label for="pais">País de residencia</label>                
		                          <?php             
                          imprimirPaises();
                            ?>         				
                </div>

                <div class="form-group" style="display: none;" id="divDepartamentos">
                  <label for="departamento">Departamento</label>   
                   <?php             
                          imprimirDepartamentos();
                            ?>                                             
                </div>

                <div class="form-group" style="display: none;" id="divMunicipios">
                  <label for="departamento">Municipio</label> 
                  <select class="form-control chzn-select" id="municipio" name="municipio">
                     <option disabled selected value>Seleccione un municipio de la lista</option>
                  </select>                                            
                </div>

                 <div class="form-group">
                  <label for="tipoDocumento">Tipo de documento</label>                
		                                 
						  <?php 						
						  		imprimirDocumentos();
						  ?>						
                </div>

                 <div class="form-group">
                  <label for="numeroDocumento">Número de documento</label>                		                                 
					<input type="text" class="form-control" name="numeroDocumento" id="numeroDocumento" placeholder="Ingrese aquí su número de documento...">						
                </div>

                <div class="form-group" id="divNit">
                  <label for="nit">NIT (opcional)</label>                                                     
          <input type="text" class="form-control" name="nit" id="nit" placeholder="Ingrese aquí su NIT con guión">           
                </div>

              <div class="form-group">   <!-- *******INICIO TELEFONO****** -->
                  <label for="telefonoCompleto">Teléfono de contacto (si es un teléfono extranjero, incluya código de país)</label>                		                                 			     		        		
		          		<input class="form-control" type="text"  name="telefonoCompleto" id="telefonoCompleto" placeholder="Ingrese aquí su número telefónico...">		     
               </div> <!-- *******FIN TELEFONO****** -->

                 <div class="form-group">
                  <label for="numeroDocumento">Correo electrónico</label>                		                                 
					<input type="email" class="form-control" name="correo" id="correo" placeholder="Ingrese aquí su e-mail...">						
                </div>
                <div class="box-footer">
							<a type="button" href="/out/out.ViewFolder.php?folderid=1&showtree=1"  class="btn btn-default cancel-add-document"><?php echo getMLText("cancel"); ?></a>

              <button  id="form_reset1"  type="button" class="btn btn-default pull-center"><i class="icon-search"></i> <?php echo "Limpiar estos campos del formulario" ?>
              </button> 

							<a id="btn-next-1"  data-toggle="tab" type="button" class="btn btn-default pull-right"><?php echo getMLText("next"); ?> <i class="fa fa-arrow-right"></i></a>
				</div>

              </div>
          
              <!-- ****************************/.PESTAÑA 2 ***************************************************** -->
              <div class="tab-pane" id="tab_2">
                    <p style="font-size:18px;" >                    
                    <b>Ahora, plasme su experiencia laboral en la siguiente tabla:</b>
                   </p>
                   <p style="font-size:12px;" >                    
                    <b>*Si no tiene ninguna experiencia laboral, utilice el botón de Eliminar experiencia para dejar vacía la tabla.</b>
                   </p>
                   <p style="font-size:12px;">                    
                    <b>*Si añade al menos una experiencia laboral, todos los campos serán de rellenado obligatorio.</b>
                   </p>

              	   <p> 
            			  <input type="button" class="btn btn-default btn-sm" id="anadeExperiencia" value="Añadir una nueva experiencia">
            			   <input type="button" class="btn btn-danger btn-sm" id="eliminaExperiencia" value="Eliminar la última experiencia añadida">
            			 
				          </p>


                <table id="tablaExperiencias" class="table table-bordered table-hover">
                <tr>
                  
                  <th>Cargo</th>
                  <th>Funciones</th>
                  <th>Institución</th>

                  <th>Periodo (año-mes-día)</th>

                </tr>
                <tr>
                	
                  <td>
                  	 <input type="text" class="form-control" name="cargo[]" id="cargo1" placeholder="Nombre o descripción breve del cargo">                 	
                  </td>

                  <td>
                  	<input type="text" class="form-control" name="funciones[]" id="funciones1" placeholder="Indique las funciones desempeñadas en ese cargo">
                  </td>

                  <td>
                    <input type="text" class="form-control" name="institucion[]" id="institucion1" placeholder="Nombre de la institución donde desempeñó">
                  </td>

                  <td>

                  	  <div class="col-xs-4"> <!-- *******INICIO PERIODO INICIAL****** -->
                  	    	                   							
						  		          <span class="input-append date datepicker" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd" data-date-language="<?php echo str_replace('_', '-', $this->params['session']->getLanguage()); ?>">
                              <input class="form-control" name="periodoInicial[]" id="periodoInicial1" type="text" value="" required>
                              <span class="add-on"><i class="icon-calendar"></i></span>
                            </span>						              
						             
                     </div> <!-- *******FIN PERIODO INICIAL****** -->
 				  

                     <div class="col-xs-1">
                     	 -                   	
                     </div>
                     
                     	 <div class="col-xs-4"> <!-- *******INICIO PERIODO FINAL****** -->
                     	 	
                  <span class="input-append date datepicker" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd" data-date-language="<?php echo str_replace('_', '-', $this->params['session']->getLanguage()); ?>">
                              <input class="form-control" name="periodoFinal[]" id="periodoFinal1" type="text" value="" required>
                              <span class="add-on"><i class="icon-calendar"></i></span>
                            </span>   
						           
                        </div> <!-- *******FIN PERIODO FINAL****** -->

                    </td>
                </tr>
             
                
              </table>

                 <div class="box-footer">
                 	
                <a id="btn-prev-2" href="#tab_1" data-toggle="tab"  class="btn btn-default pull-left">
                <i class="fa fa-arrow-left"></i>Volver al paso 1: datos generales </a>
				

				<button  type="button" id="form_reset2" class="btn btn-default pull-center"><i class="icon-search"></i> <?php echo "Limpiar estos campos del formulario" ?>
			    </button>	



                
              <a id="btn-next-2"  data-toggle="tab" type="button" class="btn btn-default pull-right"><?php echo getMLText("next"); ?> <i class="fa fa-arrow-right"></i></a>
				

              </div>

              </div>
              <!-- ****************************/.PESTAÑA 3 ***************************************************** -->
              <div class="tab-pane" id="tab_3">

            

                   <p style="font-size:18px;" >                    
                    <b>Plasme su historial académico:</b>
                   </p>
                   <p style="font-size:12px;" >                    
                    <b>*Si no tiene ninguna historial académico en alguna de las categorías (Grado, Posgrado u Otros estudios), utilice el botón de Eliminar  para dejar vacía la tabla correspondiente a esa categoría.</b>
                   </p>
                   <p style="font-size:12px;" >                    
                    <b>*Si añade al menos una experiencia académica, todos los campos serán de rellenado obligatorio para esa tabla determinada.</b>
                   </p>
           
           

					<h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                       Grado universitario
                      </a>
                    </h4>

                 

                    	 <p> 
					  <input type="button" class="btn btn-default btn-sm" id="anadeGrado" value="Añadir un nuevo estudio de grado">
					   <input type="button" class="btn btn-danger btn-sm" id="eliminaGrado" value="Eliminar el último grado añadido">
					
						</p>
                      
                   <table id="tablaGrados" class="table table-bordered table-hover">
	                <tr>
	                  
	                  <th >Titulo obtenido</th>
                    <th >Nombre del título</th>
	                  <th>Año</th>
	                  <th>Institución</th>
                    <th >Atestado</th>

	                </tr>

	                 <tr>

	                 	<td>
                    	<div class="col-xs-8">
                    		
                    		<select class="form-control select"  name="tituloGrado[]" id="tituloGrado1">
                  	        
                               		<?php 						
          						  		imprimirTitulosGrado();						  		
          						   ?>
							     </select>
                     </div>
                 </td>

                 <td>
                  <div class="col-xs-12">
                <input type="text" class="form-control" name="nombreTituloGrado[]" id="nombreTituloGrado1" placeholder="Nombre del título obtenido...">
                </div>
                 </td>

                 <td>
                     <div class="col-xs-8">
                     	
                  	    	<select class="form-control select"  name="anoGrado[]" id="anoGrado1">
                     		<?php 						
						  		imprimirYears(1950);
						   ?>
						</select>
                     </div>
                 </td>
                      

                 <td>
          				 <div class="col-xs-12">
                                  
                              <input type="text" class="form-control" name="institucionGrado[]" id="institucionGrado1" placeholder="Nombre de la institución...">
             				</div>
				        </td>
                <td>

                  <div class="col-xs-12">
                 <input type="file" class="form-control" name="atestadoGrado[]" id="atestadoGrado1">

                  </div>
                </td>

 					</tr>	

 				  </table>

                 	   <!-- FIN DE GRADO UNIVERSITARIO -->
          
                
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                        Post grados
                      </a>
                    </h4>
                  
              
              <p> 
			  <input type="button" class="btn btn-default btn-sm" id="anadePosGrado" value="Añadir un nuevo estudio de posgrado">
			   <input type="button" class="btn btn-danger btn-sm" id="eliminaPosGrado" value="Eliminar el último posgrado añadido">
			
				</p>
                      
                   <table id="tablaPosGrados" class="table table-bordered table-hover">
	                <tr>
	                  
	                  <th>Titulo obtenido</th>
                    <th>Nombre del título</th>
	                  <th>Año</th>
	                  <th>Institución</th>
                    <th>Atestado</th>

	                </tr>

	                 <tr>

	                 	
          

				          </tr>
			</table>
                    
                <!-- FIN DE POSGHRADO -->


                 	    <!-- INICIO DE OTROS -->
              
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                        Otros cursos recibidos
                      </a>
                    </h4>
                
                 
                            	<p> 
			  <input type="button" class="btn btn-default btn-sm" id="anadeOtro" value="Añadir un nuevo estudio">
			   <input type="button" class="btn btn-danger btn-sm" id="eliminaOtro" value="Eliminar el último estudio añadido">
			
				</p>
                      
                   <table id="tablaOtros" class="table table-bordered table-hover">
	                <tr>
	                  
	                  <th>Titulo obtenido</th>
                    <th>Nombre del título</th>
	                  <th>Año</th>
	                  <th>Institución</th>
                    <th>Atestado</th>

	                </tr>

	                 <tr>


			           </tr>
		</table>
				


				   <div class="box-footer">
				  
	                 <a id="btn-prev-3" href="#tab_2" data-toggle="tab" type="button" class="btn btn-default pull-left">
	                <i class="fa fa-arrow-left"></i>Volver al paso 2: experiencia laboral</a>

	                
	              		
	              		    	<button  id="form_reset3" type="button" class="btn btn-default pull-center"><i class="icon-search"></i> <?php echo "Limpiar estos campos del formulario" ?>
			                   </button>	
			              			          	             
											
					  <a id="btn-next-3"  data-toggle="tab" type="button" class="btn btn-default pull-right"><?php echo getMLText("next"); ?> <i class="fa fa-arrow-right"></i></a>
			     	</div>	 <!-- /.FIN DEL BOX FOOTER -->        
 </div> <!-- FIN DE TAB 3 -->

              <!-- ****************************/.PESTAÑA 4 ***************************************************** -->

                <div class="tab-pane" id="tab_4">
                  <p style="font-size:18px;" >                    
                    <b>Indique su manejo en los siguientes temas de la administración pública en los cuales se especializa:</b>
                   </p>

                   <p style="font-size:12px;" >                    
                    <b>*Para aquella categoría que usted marque, deberá elegir obligatoriamente al menos uno de los elementos de la lista correspondiente</b>
                   </p>
                 
                    <div class="row"> <!-- inicio de disposicion row tab 4 -->
                            <div class="col-sm-4" style="background-color: #E8E8E8;">
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
                        <div class="col-sm-4" style="background-color:white;">

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
                        <div class="col-sm-4" style="background-color:  #E8E8E8;">
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

                    <div class="row"> <!-- inicio de disposicion row conocimientos adicionales (feb. 2018) -->
                    <p><b>Si posee conocimientos adicionales a los que seleccionó, escríbalos aquí</b></p>
                        <textarea  class="form-control" name="conocimientosAdicionales" id="conocimientosAdicionales" placeholder="Ingrese sus conocimientos adicionales aquí..."></textarea>

                    </div><!-- fin de disposicion row conocimientos adicionales (feb. 2018) -->

            <div class="box-footer"> <!-- /.INICIO BOX FOOTER -->
                <a id="btn-prev-4" href="#tab_3" data-toggle="tab" type="button" class="btn btn-default pull-left">
                          <i class="fa fa-arrow-left"></i> Volver al paso 3:  formación académica </a>
                  
                    
            <a id="btn-next-4"  data-toggle="tab"  class="btn btn-default pull-right"><?php echo getMLText("next"); ?> <i class="fa fa-arrow-right"></i></a>
                </div>   <!-- /.FIN DEL BOX FOOTER -->

                </div> <!-- /.FIN PESTAÑA 4 -->
              

               <!-- **************************************/.PESTAÑA 5 ***************************************************** -->

                <div class="tab-pane" id="tab_5">
                 <p style="font-size:18px;" >                    
                    <b>Si practica la docencia (al menos los últimos 5 años):</b>
                   </p>
                    <p style="font-size:12px;">                    
                    <b>*Si no tiene ninguna experiencia impartiendo asignaturas, utilice el botón de Eliminar materia para dejar vacía la tabla.</b>
                   </p>
                   <p style="font-size:12px;" >                    
                    <b>*Si añade al menos una materia impartida, todos los campos serán de rellenado obligatorio.</b>
                   </p>
				<p> 
			  <input type="button" class="btn btn-default btn-sm" id="anadeMateria" value="Añadir una nueva materia">
			   <input type="button" class="btn btn-danger btn-sm" id="eliminaMateria" value="Eliminar la última materia añadida">
			   
				</p>


                <table id="tablaMaterias" class="table table-bordered table-hover">
                <tr>
                  
                  <th>Materia</th>
                  <th>Institución</th>
                  <th>Periodo (año-mes-día)</th>

                  <th>Modalidad</th>
                  <th>Atestado* (Debe ser una constancia de la institución respectiva)</th>

                </tr>
                <tr>
                	
                  <td>
                  	 <input type="text" class="form-control" name="materia[]" id="materia1" placeholder="Nombre de la materia impartida">                 	
                  </td>

                  <td>
                  	<input type="text" class="form-control" name="institucionImpartida[]" id="institucionImpartida1" placeholder="Institución donde impartió la materia">
                  </td>


                  <td>

                  	  <div class="col-xs-4">
                  	    	
                     		<span class="input-append date datepicker" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd" data-date-language="<?php echo str_replace('_', '-', $this->params['session']->getLanguage()); ?>">
                              <input class="form-control" name="periodoMateriaInicial[]" id="periodoMateriaInicial1" type="text" value="" required>
                              <span class="add-on"><i class="icon-calendar"></i></span>
                            </span>   
						          
                     </div>
 				  

                     <div class="col-xs-1">
                     	 -                   	
                     </div>
                     
                     	 <div class="col-xs-4">
                     	 
                              <span class="input-append date datepicker" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd" data-date-language="<?php echo str_replace('_', '-', $this->params['session']->getLanguage()); ?>">
                              <input class="form-control" name="periodoMateriaFinal[]" id="periodoMateriaFinal1" type="text" value="" required>
                              <span class="add-on"><i class="icon-calendar"></i></span>
                            </span> 
						        
                        </div>

                    </td>


                     <td>
	                  	 <div class="col-xs-9">
	                    		
	                    		<select class="form-control select"  name="modalidad[]">
	                  	        
	                     		<?php 						
							  		imprimirModalidades();						  		
							   ?>
								</select>
	                     </div>            	
                     </td>

                     <td>
                  	    <input type="file" name="atestadoMateria[]" >
                    </td>


                </tr>
             
                
              </table>



                <div class="box-footer"> <!-- /.INICIO DEL BOX FOOTER 5 -->
	                 <a id="btn-prev-5"  href="#tab_4" data-toggle="tab" type="button" class="btn btn-default pull-left">
	                <i class="fa fa-arrow-left"></i>Volver al paso 4: temáticas de la administración pública</a>
					

						<button  id="form_reset5" type="button" class="btn btn-default pull-center"><i class="icon-search"></i> <?php echo "Limpiar estos campos del formulario" ?>
			            </button>	

					 <a id="btn-next-5"  data-toggle="tab" type="button" class="btn btn-default pull-right"><?php echo getMLText("next"); ?> <i class="fa fa-arrow-right"></i></a>
				    </div>	 <!-- /.FIN DEL BOX FOOTER 5 -->

              </div>  <!-- /.FIN PESTAÑA 5 -->
             

               <!-- ***************************************/.PESTAÑA 6 ***************************************************** -->

                <div class="tab-pane" id="tab_6">  <!-- /.INICIO PESTAÑA 6 -->
                   <p style="font-size:18px;" >                    
                    <b>Experiencia en formación y capacitación (al menos en los últimos 5 años):</b>
                   </p>

                   <p style="font-size:12px;" >                    
                    <b>*Si no tiene ninguna experiencia en formación o capacitación, utilice el botón de Eliminar  para dejar vacía la tabla.</b>
                   </p>
                   <p style="font-size:12px;">                    
                    <b>*Si añade al menos una experiencia, todos los campos serán de rellenado obligatorio.</b>
                   </p>

                    
            </br>
                 <input type="button" class="btn btn-default btn-sm" id="anadeCapacitacion" value="Añadir una nueva experiencia en formación/capacitación">
			   <input type="button" class="btn btn-danger btn-sm" id="eliminaCapacitacion" value="Eliminar la última entrada añadida">
			   
				


                <table id="tablaCapacitaciones" class="table table-bordered table-hover">
                <tr>                 
                  <th>Nombre del programa o curso</th>
                  <th>Total de horas impartidas</th>
                  <th>Periodo (año-mes-día)</th>
                  <th>Institución</th>
                  <th>Modalidad</th>
                  <th>Atestado</th>
                </tr>

                <tr>
                	
                  <td>
                  	 <input type="text" class="form-control" name="nombreTaller[]" id="nombreTaller1" placeholder="Nombre del taller impartido">                 	
                  </td>

                  <td>
                  	<input type="number" class="form-control" name="totalHoras[]" id="totalHoras1"  min="1" placeholder="Número de horas impartidas">
                  </td>


                  <td>

                  	  <div class="col-xs-4">
                  	    	
                            <span class="input-append date datepicker" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd" data-date-language="<?php echo str_replace('_', '-', $this->params['session']->getLanguage()); ?>">
                              <input class="form-control" name="periodoTallerInicial[]" id="periodoTallerInicial1" type="text" value="" required>
                              <span class="add-on"><i class="icon-calendar"></i></span>
                            </span> 
						            
                     </div>
 				  

                     <div class="col-xs-1">
                     	 -                   	
                     </div>
                     
                     	 <div class="col-xs-4">
                     	 	
                             <span class="input-append date datepicker" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd" data-date-language="<?php echo str_replace('_', '-', $this->params['session']->getLanguage()); ?>">
                              <input class="form-control" name="periodoTallerFinal[]" id="periodoTallerFinal1" type="text" value="" required>
                              <span class="add-on"><i class="icon-calendar"></i></span>
                            </span>
						           
                        </div>

                    </td>

                    <td>
                  	 <input type="text" class="form-control" name="institucionTaller[]" id="institucionTaller1" placeholder="Institución donde impartió el taller">                 	
                  </td>


                     <td>
	                  	 <div class="col-xs-9">
	                    		
	                    		<select class="form-control select"  name="modalidadTaller[]">
	                  	        
	                     		<?php 						
							  		imprimirModalidades();						  		
							   ?>
								</select>
	                     </div>            	
                     </td>

                     <td>
                  	    <input type="file" name="atestadoTaller[]" >
                    </td>

                </tr>
                          
              </table>




                <div class="box-footer"> <!-- /.INICIO DEL BOX FOOTER -->
	                 <a id="btn-prev-6"  href="#tab_5" data-toggle="tab" type="button" class="btn btn-default pull-left">
	                <i class="fa fa-arrow-left"></i>Volver al paso 5: práctica de la docencia</a>
					

					<button  id="form_reset6" type="button" class="btn btn-default pull-center"><i class="icon-search"></i> <?php echo "Limpiar estos campos del formulario" ?>
			            </button>	

					 <a id="btn-next-6"  data-toggle="tab" type="button" class="btn btn-default pull-right"><?php echo getMLText("next"); ?> <i class="fa fa-arrow-right"></i></a>
				</div>	 <!-- /.FIN DEL BOX FOOTER -->

              </div>  <!-- /.FIN PESTAÑA 6 -->
             
              <!-- **********************************/.PESTAÑA 7 ***************************************************** -->

                <div class="tab-pane" id="tab_7">
                	 <p style="font-size:18px;" >                   	
                   	Manejo de metodologías (agregar al menos 3 experiencias que demuestren el manejo de metodología que manifiesta)
                   </p>
                   <p style="font-size:12px;" >                    
                    <b>*Para aquellas categorías que usted marque, la información y el atestado son de rellenado obligatorio</b>
                   </p>

                  </br>
              
                 <!-- INICIO DE GRUPO Diseño de programas y/o proyectos de formación y/o capacitación (curricular) -->
                  <div class="form-group">
                  	 <input type="checkbox" id="metodologiaDiseño" > 
                  	 <label class="text-primary">
                         Diseño de programas y/o proyectos de formación y/o capacitación (curricular)
                    </label>              
                  </div>   <!-- fin de form group -->

                <div id="siete1" style="display: none;">
                	<input type="button" class="btn btn-default btn-xs" id="anade71" value="Añadir una nueva experiencia esta metodología">
				    <input type="button" class="btn btn-danger btn-xs" id="elimina71" value="Eliminar la última entrada añadida">
                	<table id="tabla71" class="table table-condensed">
                			 <tr>                 
			                  <th >Describa la experiencia en el manejo de esta metodología</th>
			                  <th> Atestado que demuestre el manejo de esta metodología</th>			                  
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
                	<input type="button" class="btn btn-default btn-xs" id="anade72" value="Añadir una nueva experiencia esta metodología">
				    <input type="button" class="btn btn-danger btn-xs" id="elimina72" value="Eliminar la última entrada añadida">
                	<table id="tabla72" class="table table-condensed">
                			 <tr>                 
			                 <th >Describa la experiencia en el manejo de esta metodología</th>
			                 <th > Atestado que demuestre el manejo de esta metodología</th>			                  
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
                	<input type="button" class="btn btn-default btn-xs" id="anade73" value="Añadir una nueva experiencia esta metodología">
				    <input type="button" class="btn btn-danger btn-xs" id="elimina73" value="Eliminar la última entrada añadida">
                	<table id="tabla73" class="table table-condensed">
                			 <tr>                 
			                  <th >Describa la experiencia en el manejo de esta metodología</th>
			                  <th > Atestado que demuestre el manejo de esta metodología</th>			                  
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
                	<input type="button" class="btn btn-default btn-xs" id="anade74" value="Añadir una nueva experiencia esta metodología">
				    <input type="button" class="btn btn-danger btn-xs" id="elimina74" value="Eliminar la última entrada añadida">
                	<table id="tabla74" class="table table-condensed">
                			 <tr>                 
			                  <th >Describa la experiencia en el manejo de esta metodología</th>
			                  <th > Atestado que demuestre el manejo de esta metodología</th>			                  
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
                	<input type="button" class="btn btn-default btn-xs" id="anade75" value="Añadir una nueva experiencia esta metodología">
				    <input type="button" class="btn btn-danger btn-xs" id="elimina75" value="Eliminar la última entrada añadida">
                	<table id="tabla75" class="table table-condensed">
                			 <tr>                 
			                  <th >Describa la experiencia en el manejo de esta metodología</th>
			                  <th > Atestado que demuestre el manejo de esta metodología</th>			                  
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
                	<input type="button" class="btn btn-default btn-xs" id="anade76" value="Añadir una nueva experiencia esta metodología">
				    <input type="button" class="btn btn-danger btn-xs" id="elimina76" value="Eliminar la última entrada añadida">
                	<table id="tabla76" class="table table-condensed">
                			 <tr>                 
			                  <th >Describa la experiencia en el manejo de esta metodología</th>
			                  <th > Atestado que demuestre el manejo de esta metodología</th>			                  
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
                	<input type="button" class="btn btn-default btn-xs" id="anade77" value="Añadir una nueva experiencia esta metodología">
				    <input type="button" class="btn btn-danger btn-xs" id="elimina77" value="Eliminar la última entrada añadida">
                	<table id="tabla77" class="table table-condensed">
                			 <tr>                 
			                  <th >Describa la experiencia en el manejo de esta metodología</th>
			                  <th > Atestado que demuestre el manejo de esta metodología</th>			                  
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
 				<a id="btn-prev-7"  href="#tab_6" data-toggle="tab" type="button" class="btn btn-default pull-left">
	                <i class="fa fa-arrow-left"></i>Volver al paso 6: talleres y capacitaciones</a>
						

					<button  id="form_reset7" type="button" class="btn btn-default pull-center"><i class="icon-search"></i> <?php echo "Limpiar estos campos del formulario" ?>
			        </button>	

					 <a id="btn-next-7"  data-toggle="tab" type="button" class="btn btn-default pull-right"><?php echo getMLText("next"); ?> <i class="fa fa-arrow-right"></i></a>
				</div>	 <!-- /.FIN DEL BOX FOOTER -->

              </div>
              <!-- /.FIN PESTAÑA 7 -->
              <!-- ***********************************/.PESTAÑA 8 ***************************************************** -->

                <div class="tab-pane" id="tab_8">

                  <p style="font-size:18px;" >                    
                    Por favor, responda a la siguiente información:
                   </p>

                   <p style="font-size:12px;">                    
                    <b>*Los siguientes campos son opcionales</b>
                   </p>

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
                <p>*Tenga en consideración: en cada categoría, 0 es nada, 1 es básico, 3 es intermedio y 5 significa avanzado</p>
                  <input type="button" class="btn btn-default btn-xs" id="anadeIdioma" value="Añadir un nuevo idioma">
            <input type="button" class="btn btn-danger btn-xs" id="eliminaIdioma" value="Eliminar la última entrada añadida">
                  <table id="tablaIdiomas" class="table table-condensed">
                       <tr>                 
                        <th >Nombre del idioma o dialecto</th>
                        <th > Valoración del dominio hablado (número entre 0 y 5)</th>
                         <th > Valoración del dominio escuchado (número entre 0 y 5)</th>  
                          <th > Valoración del dominio escrito (número entre 0 y 5)</th>                         
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

                <div class="form-group">
                     <label>
                    Utilización de programas de presentación (PowerPoint, Prezi, etc.)
                    </label>
                  <div class="radio">
                    <label>
                      <input type="radio" name="manejoPrezi" id="prezi1" value="si">
                     Sí
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="manejoPrezi" id="prezi2" value="no" checked>
                     No
                     </label>
                  </div>
                </div>   <!-- fin de form group -->

  

                <div class="form-group">
                  <label>
                   Alguna información que considere relevante como aclaratoria o complementaria al formulario
                    </label>
                <textarea  class="form-control" name="informacionRelevante" id="informacionRelevante" placeholder="Ingrese su texto aquí..."></textarea>
                </div>   <!-- fin de form group -->



                <div class="box-footer">
				<a id="btn-prev-8"  href="#tab_7" data-toggle="tab" type="button" class="btn btn-default pull-left">
	                <i class="fa fa-arrow-left"></i>Volver al paso 7: manejo de metodologías</a>
					

					<button  id="form_reset8" type="button" class="btn bg-default pull-center"><i class="icon-search"></i> <?php echo "Limpiar estos campos del formulario" ?>
			        </button>	

					 <a id="btn-next-8"  data-toggle="tab" type="button" class="btn btn-default pull-right"><?php echo getMLText("next"); ?> <i class="fa fa-arrow-right"></i></a>
				</div>	 <!-- /.FIN DEL BOX FOOTER -->

              </div>
              <!-- /.FIN PESTAÑA 8 -->
              <!-- ************************************/.PESTAÑA 9 ***************************************************** -->

                <div class="tab-pane" id="tab_9">
                   <p style="font-size:18px;" >                    
                    Por favor, adjunte al formulario la siguiente documentación:
                   </p>
                   <p style="font-size:12px;">                    
                    <b>*Los siguientes documentos son obligatorios</b>
                   </p>
                   

                     <div class="form-group">
                       <label>
                        Razones por las cuales desea ser docente en la ENAFOP (carta)
                       </label>
                       <input type="file" name="cartaMotivacion" id="cartaMotivacion" >
                    </div>   <!-- fin de form group -->

                      <div class="form-group">
                       <label>
                       Referencias personales
                       </label>
                       <input type="file" name="referenciasPersonales" id="referenciasPersonales">
                    </div>   <!-- fin de form group -->


                <div class="form-group">
                     <label>
                   Quiero que mi perfil sea público               
                    </label>
                  <div class="radio">
                    <label>
                      <input type="radio" name="publico" id="publico1" value="si" checked>
                     Sí
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="publico" id="publico2" value="no">
                     No
                     </label>
                  </div>


                  
                    <p>Si usted decide que su perfil NO sea público, este no será visible en las búsquedas que se realicen en el buscador de este sistema; evitando que usuarios externos puedan encontrar su perfil y estando solo disponible para la administración de la ENAFOP. Por el contrario, si activa su perfil como público, éste podrá ser encontrado desde el buscador y usuarios externos podrán acceder a él en caso de que su postulación sea aprobada</p>
                  
                </div>   <!-- fin de form group -->


                   

                <div class="box-footer">
	                 <a id="btn-prev-9"  href="#tab_8" data-toggle="tab" type="button" class="btn btn-default pull-left">
	                <i class="fa fa-arrow-left"></i>Volver al paso 8: experiencia laboral</a>


               <button  id="form_reset9" type="button" class="btn bg-default pull-center"><i class="icon-search"></i> <?php echo "Limpiar estos campos del formulario" ?>
              </button> 
				        						
					       <button type="submit" class="btn bg-maroon btn-lg pull-right"><i class="fa fa-save"></i> <?php echo "Terminar y enviar mi formulario"?></button>
			        	</div>	 <!-- /.FIN DEL BOX FOOTER -->
              </div>
              <!-- /.FIN PESTAÑA 9 -->
            </div>             
            <!-- /.tab-content -->

          </div>
      </form>
 <?php
       //////FIN MI CODIGO      ///////////////////////////////////////////////////////////////////////////////////////    
$this->contentContainerEnd();
$this->endsBoxPrimary();
     ?>
	     </div>
		</div>
		</div>

		<?php	
		$this->contentEnd();
		$this->mainFooter();		
		$this->containerEnd();
		//$this->contentContainerEnd();
		echo "<script type='text/javascript' src='/validar1.js'></script>";
    echo "<script type='text/javascript' src='/styles/multisis-lte/bootstrap-filestyle.js'></script>";
    echo "<script type='text/javascript' src='/styles/multisis-lte/bootstrap-filestyle.min.js'></script>";
      //echo "<script type='text/javascript' src='/styles/multisis-lte/plugins/bootstrap-slider/bootstrap-slider.js'></script>";
     // echo "<script type='text/javascript' src='/styles/multisis-lte/plugins/bootstrap-slider/hacer.js'></script>";
		$this->htmlEndPage();
	} /* }}} */
}
?>