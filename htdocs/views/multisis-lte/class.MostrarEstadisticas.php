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
function contarPostulaciones($tipo,$fechaInicio,$fechaFin) //le puedo pasar "postulado " o "aprobado"
//me da el conteo de cuantos postulados o aprobados hay entre fecha inicio y fecha fin
{
	$contador=0;
	//echo "Función getDefaultUserFolder. Se ha pasado con argumento: ".$id_usuario;
	 $settings = new Settings(); //acceder a parámetros de settings.xml con _antes
  	$driver=$settings->_dbDriver;
    $host=$settings->_dbHostname;
    $user=$settings->_dbUser;
    $pass=$settings->_dbPass;
    $base=$settings->_dbDatabase;
	$manejador=new SeedDMS_Core_DatabaseAccess($driver,$host,$user,$pass,$base);
	$estado=$manejador->connect();
	//echo "Conectado: ".$estado;
	$miQuery="";
	if($estado!=1)
	{
		UI::exitError("Error mostrando estadísticas","mostrarEstadisticas: No se pudo conectar a la BD");
	}	
	//query de consulta:

	$miQuery="SELECT COUNT(*) from postulaciones WHERE fecha between '$fechaInicio' and '$fechaFin'";
	$resultado=$manejador->getResultArray($miQuery);
	$contador=$resultado[0]['COUNT(*)'];
	if(!$resultado)
	{
		UI::exitError("Error mostrando estadísticas","mostrarEstadisticas: No se pudo ejecutar $miQuery");
	}

    return $contador;
} 
function contarAprobados($fechaInicio,$fechaFin) //le puedo pasar "postulado " o "aprobado"
//me da el conteo de cuantos postulados o aprobados hay entre fecha inicio y fecha fin
{
	$contador=0;
	//echo "Función getDefaultUserFolder. Se ha pasado con argumento: ".$id_usuario;
	 $settings = new Settings(); //acceder a parámetros de settings.xml con _antes
  	$driver=$settings->_dbDriver;
    $host=$settings->_dbHostname;
    $user=$settings->_dbUser;
    $pass=$settings->_dbPass;
    $base=$settings->_dbDatabase;
	$manejador=new SeedDMS_Core_DatabaseAccess($driver,$host,$user,$pass,$base);
	$estado=$manejador->connect();
	//echo "Conectado: ".$estado;
	$miQuery="";
	if($estado!=1)
	{
		UI::exitError("Error mostrando estadísticas","mostrarEstadisticas: No se pudo conectar a la BD");
	}	
	//query de consulta:

	$miQuery="SELECT COUNT(*) from historial WHERE comentario='Postulante fue aprobado después de estar en evaluación' and fecha between '$fechaInicio' and '$fechaFin'";
	$resultado=$manejador->getResultArray($miQuery);
	$contador=$resultado[0]['COUNT(*)'];
	if(!$resultado)
	{
		UI::exitError("Error mostrando estadísticas","mostrarEstadisticas: No se pudo ejecutar $miQuery");
	}

    return $contador;
}
function getEdadMedia($status,$fechaInicio,$fechaFin) //le puedo pasar estado "postulado " o "aprobado"
// y me da edad media de postulaciones entre esas dos fechas
{
	//echo "ESTADP: $estado";
	$contador=0;
	//echo "Función getDefaultUserFolder. Se ha pasado con argumento: ".$id_usuario;
	 $settings = new Settings(); //acceder a parámetros de settings.xml con _antes
  	$driver=$settings->_dbDriver;
    $host=$settings->_dbHostname;
    $user=$settings->_dbUser;
    $pass=$settings->_dbPass;
    $base=$settings->_dbDatabase;
	$manejador=new SeedDMS_Core_DatabaseAccess($driver,$host,$user,$pass,$base);
	$estado=$manejador->connect();
	//echo "Conectado: ".$estado;
	$miQuery="";
	if($estado!=1)
	{
		UI::exitError("Error mostrando estadísticas","mostrarEstadisticas: No se pudo conectar a la BD");
	}	
	//query de consulta:

	$miQuery="select AVG(edad) from datosgenerales
INNER JOIN postulaciones ON datosgenerales.idpostulante = postulaciones.idpostulante
WHERE  postulaciones.estado='$status' AND (postulaciones.fecha between '$fechaInicio' and '$fechaFin')";
//echo "query edad: ".$miQuery;
	$resultado=$manejador->getResultArray($miQuery);	
	if($resultado)
	{
		$contador=$resultado[0]['AVG(edad)'];
	}

    return round($contador);
}
function contarDatoGeneral($tipo,$dato,$valorDato,$fechaInicio,$fechaFin) //recibe: tipo (aprobado o postulante)
//dato: dato que necesito: género, edad, etc
//valorDato: valor del dato: Ej. Masculino
//me da el conteo de cuantos postulados o aprobados hay entre fecha inicio y fecha fin
{
	$contador=0;
	//echo "Función getDefaultUserFolder. Se ha pasado con argumento: ".$id_usuario;
	 $settings = new Settings(); //acceder a parámetros de settings.xml con _antes
  	$driver=$settings->_dbDriver;
    $host=$settings->_dbHostname;
    $user=$settings->_dbUser;
    $pass=$settings->_dbPass;
    $base=$settings->_dbDatabase;
	$manejador=new SeedDMS_Core_DatabaseAccess($driver,$host,$user,$pass,$base);
	$estado=$manejador->connect();
	//echo "Conectado: ".$estado;
	$miQuery="";
	if($estado!=1)
	{
		UI::exitError("Error mostrando estadísticas","mostrarEstadisticas: No se pudo conectar a la BD");
	}	
	//query de consulta:

	$miQuery="select COUNT(*) from datosgenerales
INNER JOIN postulaciones ON datosgenerales.idpostulante = postulaciones.idpostulante
WHERE datosgenerales.$dato='$valorDato' AND postulaciones.estado='$tipo' AND (postulaciones.fecha between '$fechaInicio' and '$fechaFin')";
	$resultado=$manejador->getResultArray($miQuery);
	$contador=$resultado[0]['COUNT(*)'];
	if(!$resultado)
	{
		UI::exitError("Error mostrando estadísticas","mostrarEstadisticas: No se pudo ejecutar $miQuery");
	}

    return $contador;
}
function contarProfesion($profesion,$status,$fechaInicio,$fechaFin,$tabla) //recibe: tipo (aprobado o 
{
	$contador=0;
	//echo "Función getDefaultUserFolder. Se ha pasado con argumento: ".$id_usuario;
	 $settings = new Settings(); //acceder a parámetros de settings.xml con _antes
  	$driver=$settings->_dbDriver;
    $host=$settings->_dbHostname;
    $user=$settings->_dbUser;
    $pass=$settings->_dbPass;
    $base=$settings->_dbDatabase;
	$manejador=new SeedDMS_Core_DatabaseAccess($driver,$host,$user,$pass,$base);
	$estado=$manejador->connect();
	//echo "Conectado: ".$estado;
	$miQuery="";
	if($estado!=1)
	{
		UI::exitError("Error mostrando estadísticas","mostrarEstadisticas: No se pudo conectar a la BD");
	}	
	//query de consulta:

	$miQuery="SELECT distinct titulos_$tabla.idpostulante
FROM titulos_$tabla
inner JOIN postulaciones ON titulos_$tabla.idpostulante = postulaciones.idpostulante
WHERE postulaciones.estado='$status' AND titulos_$tabla.titulo='$profesion' AND (postulaciones.fecha between '$fechaInicio' and '$fechaFin')";
//echo "MIQUERY---".$miQuery;
	$resultado=$manejador->getResultArray($miQuery);
	
	foreach ($resultado as $key) 
	{
		$contador++;
	}
	

    return $contador;
}
///////////////////////////////
function contarTemas($tema,$status,$fechaInicio,$fechaFin) //recibe: tipo (aprobado o 
{
	$contador=0;
	//echo "Función getDefaultUserFolder. Se ha pasado con argumento: ".$id_usuario;
	 $settings = new Settings(); //acceder a parámetros de settings.xml con _antes
  	$driver=$settings->_dbDriver;
    $host=$settings->_dbHostname;
    $user=$settings->_dbUser;
    $pass=$settings->_dbPass;
    $base=$settings->_dbDatabase;
	$manejador=new SeedDMS_Core_DatabaseAccess($driver,$host,$user,$pass,$base);
	$estado=$manejador->connect();
	//echo "Conectado: ".$estado;
	$miQuery="";
	if($estado!=1)
	{
		UI::exitError("Error mostrando estadísticas","mostrarEstadisticas: No se pudo conectar a la BD");
	}	
	//query de consulta:

$miQuery="SELECT distinct temas_$tema.idpostulante FROM temas_$tema inner JOIN postulaciones ON temas_$tema.idpostulante = postulaciones.idpostulante WHERE postulaciones.estado='$status' AND (postulaciones.fecha between '$fechaInicio' and '$fechaFin')";
//echo "MIQUERY---".$miQuery;
	$resultado=$manejador->getResultArray($miQuery);	
	foreach ($resultado as $key) 
	{
		$contador++;
	}
	

    return $contador;
}
/////////////////////////////////////
function contarMetodologia($metodologia,$status,$fechaInicio,$fechaFin) //recibe: tipo (aprobado o 
{
	$contador=0;
	//echo "Función getDefaultUserFolder. Se ha pasado con argumento: ".$id_usuario;
	 $settings = new Settings(); //acceder a parámetros de settings.xml con _antes
  	$driver=$settings->_dbDriver;
    $host=$settings->_dbHostname;
    $user=$settings->_dbUser;
    $pass=$settings->_dbPass;
    $base=$settings->_dbDatabase;
	$manejador=new SeedDMS_Core_DatabaseAccess($driver,$host,$user,$pass,$base);
	$estado=$manejador->connect();
	//echo "Conectado: ".$estado;
	$miQuery="";
	if($estado!=1)
	{
		UI::exitError("Error mostrando estadísticas","mostrarEstadisticas: No se pudo conectar a la BD");
	}	
	//query de consulta:

	$miQuery="SELECT distinct metodologias_$metodologia.idpostulante FROM metodologias_$metodologia inner JOIN postulaciones 
	ON metodologias_$metodologia.idpostulante = postulaciones.idpostulante WHERE postulaciones.estado='$status' 
	AND (postulaciones.fecha between '$fechaInicio' and '$fechaFin')";
//echo "MIQUERY---".$miQuery;
	$resultado=$manejador->getResultArray($miQuery);	
	foreach ($resultado as $key) 
	{
		$contador++;
	}
	

    return $contador;
}

function contarSalvadorenos($status,$fechaInicio,$fechaFin) //recibe: tipo (aprobado o 
{
	$contador=0;
	//echo "Función getDefaultUserFolder. Se ha pasado con argumento: ".$id_usuario;
	 $settings = new Settings(); //acceder a parámetros de settings.xml con _antes
  	$driver=$settings->_dbDriver;
    $host=$settings->_dbHostname;
    $user=$settings->_dbUser;
    $pass=$settings->_dbPass;
    $base=$settings->_dbDatabase;
	$manejador=new SeedDMS_Core_DatabaseAccess($driver,$host,$user,$pass,$base);
	$estado=$manejador->connect();
	//echo "Conectado: ".$estado;
	$miQuery="";
	if($estado!=1)
	{
		UI::exitError("Error mostrando estadísticas","mostrarEstadisticas: No se pudo conectar a la BD");
	}	
	//query de consulta:

	$miQuery="SELECT distinct datosgenerales.idpostulante FROM datosgenerales inner JOIN postulaciones 
	ON datosgenerales.idpostulante = postulaciones.idpostulante WHERE datosgenerales.pais='El Salvador'
	 AND postulaciones.estado='$status' AND (postulaciones.fecha between '$fechaInicio' and '$fechaFin');";
//echo "MIQUERY---".$miQuery;
	$resultado=$manejador->getResultArray($miQuery);	
	foreach ($resultado as $key) 
	{
		$contador++;
	}
	

    return $contador;
}
function contarExtranjeros($status,$fechaInicio,$fechaFin) //recibe: tipo (aprobado o 
{
	$contador=0;
	//echo "Función getDefaultUserFolder. Se ha pasado con argumento: ".$id_usuario;
	 $settings = new Settings(); //acceder a parámetros de settings.xml con _antes
  	$driver=$settings->_dbDriver;
    $host=$settings->_dbHostname;
    $user=$settings->_dbUser;
    $pass=$settings->_dbPass;
    $base=$settings->_dbDatabase;
	$manejador=new SeedDMS_Core_DatabaseAccess($driver,$host,$user,$pass,$base);
	$estado=$manejador->connect();
	//echo "Conectado: ".$estado;
	$miQuery="";
	if($estado!=1)
	{
		UI::exitError("Error mostrando estadísticas","mostrarEstadisticas: No se pudo conectar a la BD");
	}	
	//query de consulta:

	$miQuery="SELECT distinct datosgenerales.idpostulante FROM datosgenerales inner JOIN postulaciones 
	ON datosgenerales.idpostulante = postulaciones.idpostulante WHERE NOT datosgenerales.pais='El Salvador'
	 AND postulaciones.estado='$status' AND (postulaciones.fecha between '$fechaInicio' and '$fechaFin');";
//echo "MIQUERY---".$miQuery;
	$resultado=$manejador->getResultArray($miQuery);	
	foreach ($resultado as $key) 
	{
		$contador++;
	}
	

    return $contador;
}
function contarPracticaDocencia($status,$fechaInicio,$fechaFin) //recibe: tipo (aprobado o 
{
	$contador=0;
	//echo "Función getDefaultUserFolder. Se ha pasado con argumento: ".$id_usuario;
	 $settings = new Settings(); //acceder a parámetros de settings.xml con _antes
  	$driver=$settings->_dbDriver;
    $host=$settings->_dbHostname;
    $user=$settings->_dbUser;
    $pass=$settings->_dbPass;
    $base=$settings->_dbDatabase;
	$manejador=new SeedDMS_Core_DatabaseAccess($driver,$host,$user,$pass,$base);
	$estado=$manejador->connect();
	//echo "Conectado: ".$estado;
	$miQuery="";
	if($estado!=1)
	{
		UI::exitError("Error mostrando estadísticas","mostrarEstadisticas: No se pudo conectar a la BD");
	}	
	//query de consulta:

$miQuery="SELECT distinct materias_docencia.idpostulante FROM materias_docencia
inner join postulaciones on postulaciones.idpostulante=materias_docencia.idpostulante
WHERE postulaciones.estado='$status' AND (postulaciones.fecha between '$fechaInicio' and '$fechaFin');";
//echo "MIQUERY---".$miQuery;
	$resultado=$manejador->getResultArray($miQuery);	
	foreach ($resultado as $key) 
	{
		$contador++;
	}
	

    return $contador;
}



///////////////////////////////
class SeedDMS_View_MostrarEstadisticas extends SeedDMS_Bootstrap_Style 
{
 /**
 Método que muestra los documentos próximos a caducar sólo de 
 **/
	

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
	
		$db = $dms->getDB();
		$previewer = new SeedDMS_Preview_Previewer($cachedir, $previewwidth, $timeout);


		  if($user->isAdmin())
	    {
	      $this->htmlStartPage("Ver estadística", "skin-blue sidebar-mini sidebar-collapse");
	    }
	     $fechaInicial=$_POST["fechaInicio"];
		$fechaFinal=$_POST["fechaFin"];
		$inicialFormato=explode("-", $fechaInicial);
		$diaInicial=$inicialFormato[0];
		$mesInicial=$inicialFormato[1];
		$anoInicial=$inicialFormato[2];
		$fullInicial=$anoInicial."-".$mesInicial."-".$diaInicial;
		$filtro=$_POST["filtro"];
		//echo "full filtro ".$filtro;
		///////////////////////////////
		$finalFormato=explode("-", $fechaFinal);
		$diaFinal=$finalFormato[0];
		$mesFinal=$finalFormato[1];
		$anoFinal=$finalFormato[2];
		$fullFinal=$anoFinal."-".$mesFinal."-".$diaFinal;

		/////hago conteo:
		$numeroAprobados=contarAprobados($fullInicial,$fullFinal);
		$numeroPostulantes=contarPostulaciones("postulado",$fullInicial,$fullFinal);
		$mayor1=max($numeroAprobados,$numeroPostulantes);
		/////////////// SEGUNDA FASE: GENERO: ///////////////////////////////////////////////////
		//contarDatoGeneral($tipo,$dato,$valorDato,$fechaInicio,$fechaFin) 
		$numGeneroMasculinosPostulantes=contarDatoGeneral("postulado","genero","Masculino",$fullInicial,$fullFinal);
		$numGeneroFemeninosPostulantes=contarDatoGeneral("postulado","genero","Femenino",$fullInicial,$fullFinal);
		$numGeneroOtrosPostulantes=contarDatoGeneral("postulado","genero","Otro",$fullInicial,$fullFinal);


		//APROBADOS
		$numGeneroMasculinosAprobados=contarDatoGeneral("aprobado","genero","Masculino",$fullInicial,$fullFinal);
		$numGeneroFemeninosAprobados=contarDatoGeneral("aprobado","genero","Femenino",$fullInicial,$fullFinal);
		$numGeneroOtrosAprobados=contarDatoGeneral("aprobado","genero","Otro",$fullInicial,$fullFinal);
		//TOTAL
		$numGeneroMasculinosTotal=$numGeneroMasculinosPostulantes+$numGeneroMasculinosAprobados;
		$numGeneroFemeninosTotal=$numGeneroFemeninosAprobados+$numGeneroFemeninosPostulantes;
		$numGeneroOtrosTotal=$numGeneroOtrosPostulantes+$numGeneroOtrosAprobados;
			//echo "numGeneroMasculinosAprobados ".$numGeneroMasculinosAprobados;
		//echo "Número de aprobados, postulantes: ".$numeroAprobados.",".$numeroPostulantes;
		///////////// TERCERA FASE: EDAD /////////////////////////////////////////////////////////
		$edadMediaAprobados=getEdadMedia("Aprobado",$fullInicial,$fullFinal);
		$edadMediaPostulados=getEdadMedia("Postulado",$fullInicial,$fullFinal);
		$edadMediaTotal=($edadMediaAprobados+$edadMediaPostulados)/2;




		$this->containerStart();
		$this->mainHeader();
		$this->mainSideBar();
		//$this->contentContainerStart("hoa");
		$this->contentStart();
          
		?>
    <div class="gap-10"></div>
    <div class="row">
    <div class="col-md-12">
      

    <?php
    //en este bloque php va "mi" código
  
 //$this->startBoxPrimary("Estadísticas");
$this->contentContainerStart();
//////INICIO MI CODIGO
?>


<?php  

   if(strcmp($filtro, "comparativo")==0)
   {
   	echo "Comparativo";
?>
<div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo "Existen $numeroPostulantes postulaciones, y $numeroAprobados postulaciones fueron aprobadas en el periodo comprendido entre $fechaInicial y $fechaFinal"  ?></h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="grafico1" style="height:250px"></canvas>
              </div>
              <p> <b> Ratio postulados/aprobados: <?php 
              $ratio=round($numeroAprobados/$numeroPostulantes,2);
              echo $ratio; ?> </b></p>

             
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.FIN GRAFICOS COMPARATIVO -->
            <?php 
               $accion="/generarExcelAprobados.php?numeroAprobados=$numeroAprobados&numeroPostulantes=$numeroPostulantes&ratio=$ratio&fechaIni=$fullInicial&fechaFin=$fullFinal";
			//echo "<form action=\"".$accion."\" method=\"get\">";
			print "<a href=\"$accion\"><i class=\"fa-file-excel-o\"></i>Descargar la tabla de resultados como Excel</a>";
               ?>
          <input type="hidden" id="numeroAprobados" value="<?php echo $numeroAprobados ?>" />
<input type="hidden" id="numeroPostulantes" value="<?php echo $numeroPostulantes ?>" />
<input type="hidden" id="mayor1" value="<?php echo $mayor1 ?>" />

<?php 
}
?>



<?php 
if(strcmp($filtro, "genero")==0)
{
?>
<!-- /.inicio gráficos de barra GENERO -->

      <div id="js-legend"></div>
      <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Filtro: género</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">

            	<div class="col-md-4">
            		 <label>Postulantes </label>
            		 <canvas id="generoPostulantes" style="height:250px"></canvas>
				</div>

				<div class="col-md-4">
            		 <label>Aprobados </label>
            		 <canvas id="generoAprobados" style="height:250px"></canvas>
				</div>


				<div class="col-md-4">
            		 <label>Total </label>
            		  <canvas id="generoTotal" style="height:250px"></canvas>
				</div>
              
            
               <div class="box-body no-padding">
              <table class="table table-condensed">
                <tr>
                  <th >Estado</th>

                  <th >Masculinos</th>

                  <th>Femeninos</th>

                  <th>Otros</th>
                </tr>
                <tr>
                  <td>Postulantes</td>               
                  <td><span class="badge bg-red"><?php echo $numGeneroMasculinosPostulantes ?></span></td>
                  <td><span class="badge bg-red"><?php echo $numGeneroFemeninosPostulantes ?></span></td>
                  <td><span class="badge bg-red"><?php echo $numGeneroOtrosPostulantes ?></span></td>
                </tr>
                <tr>
                  <td>Aprobados</td>               
                   <td><span class="badge bg-red"><?php echo $numGeneroMasculinosAprobados ?></span></td>
                  <td><span class="badge bg-red"><?php echo $numGeneroFemeninosAprobados ?></span></td>
                  <td><span class="badge bg-red"><?php echo $numGeneroOtrosAprobados ?></span></td>
                </tr>
                <tr>
                  <td>Total</td>                
                   <td><span class="badge bg-red"><?php echo $numGeneroMasculinosTotal ?></span></td>
                  <td><span class="badge bg-red"><?php echo $numGeneroFemeninosTotal ?></span></td>
                  <td><span class="badge bg-red"><?php echo $numGeneroOtrosTotal?></span></td>
                </tr>
              </table>
            </div>
             
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.FIN GRAFICOS DE BARRA: GENERO -->

  			<?php 
               $accion="/generarExcelGenero.php?numGeneroMasculinosPostulantes=$numGeneroMasculinosPostulantes&numGeneroFemeninosPostulantes=$numGeneroFemeninosPostulantes&numGeneroOtrosPostulantes=$numGeneroOtrosPostulantes&numGeneroMasculinosAprobados=$numGeneroMasculinosAprobados&numGeneroFemeninosAprobados=$numGeneroFemeninosAprobados&numGeneroOtrosAprobados=$numGeneroOtrosAprobados&numGeneroMasculinosTotal=$numGeneroMasculinosTotal&numGeneroFemeninosTotal=$numGeneroFemeninosTotal&numGeneroOtrosTotal=$numGeneroOtrosTotal&fechaIni=$fullInicial&fechaFin=$fullFinal";
			//echo "<form action=\"".$accion."\" method=\"get\">";
			print "<a href=\"$accion\"><i class=\"fa-file-excel-o\"></i>Descargar la tabla de resultados como Excel</a>";
               ?>
<input type="hidden" id="numGeneroMasculinosPostulantes" value="<?php echo $numGeneroMasculinosPostulantes ?>" />
<input type="hidden" id="numGeneroFemeninosPostulantes" value="<?php echo $numGeneroFemeninosPostulantes ?>" />
<input type="hidden" id="numGeneroOtrosPostulantes" value="<?php echo $numGeneroOtrosPostulantes ?>" />



<input type="hidden" id="numGeneroMasculinosAprobados" value="<?php echo $numGeneroMasculinosAprobados ?>" />
<input type="hidden" id="numGeneroFemeninosAprobados" value="<?php echo $numGeneroFemeninosAprobados ?>" />
<input type="hidden" id="numGeneroOtrosAprobados" value="<?php echo $numGeneroOtrosAprobados ?>" />



<input type="hidden" id="numGeneroMasculinosTotal" value="<?php echo $numGeneroMasculinosTotal ?>" />
<input type="hidden" id="numGeneroFemeninosTotal" value="<?php echo $numGeneroFemeninosTotal ?>" />
<input type="hidden" id="numGeneroOtrosTotal" value="<?php echo $numGeneroOtrosTotal ?>" />


<?php
}
 ?>

<?php 
if(strcmp($filtro, "edad")==0)
{
?>

<!-- /.INICIO GRAFICOS DE : EDAD -->
             <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Filtro: edad (media)</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">

            	<div class="col-md-3">
				</div>

            	<div class="col-md-6">
            		<canvas id="graficoEdad" style="width:850px"></canvas>
            	</div>
              	
              	<div class="col-md-3">
				</div>

            
               <div class="box-body no-padding">
              <table class="table table-condensed">
                <tr>
                  <th >Estado</th>

                  <th >Edad promedio</th>

                </tr>
                <tr>
                  <td>Postulantes</td>               
                  <td><span class="badge bg-red"><?php echo $edadMediaPostulados ?></span></td>
                


                </tr>
                <tr>
                  <td>Aprobados</td>               
                   <td><span class="badge bg-red"><?php echo $edadMediaAprobados ?></span></td>
                
                </tr>
                <tr>
                  <td>Total</td>                
                   <td><span class="badge bg-red"><?php echo $edadMediaTotal ?></span></td>
               
                </tr>
              </table>
            </div>
             
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.FIN GRAFICOS DE BARRA: edad -->
          	<?php 
               $accion="/generarExcelEdad.php?edadMediaPostulados=$edadMediaPostulados&edadMediaAprobados=$edadMediaAprobados&edadMediaTotal=$edadMediaTotal&fechaIni=$fullInicial&fechaFin=$fullFinal";
			//echo "<form action=\"".$accion."\" method=\"get\">";
			print "<a href=\"$accion\"><i class=\"fa-file-excel-o\"></i>Descargar la tabla de resultados como Excel</a>";
               ?>

<input type="hidden" id="edadMediaAprobados" value="<?php echo $edadMediaAprobados ?>" />
<input type="hidden" id="edadMediaPostulados" value="<?php echo $edadMediaPostulados ?>" />
<input type="hidden" id="edadMediaTotal" value="<?php echo $edadMediaTotal ?>" />
<?php 
}
?>
           

      <?php 

      	if(strcmp($filtro, "profesion")==0)
      	{


      ?>
      		    <!-- /.INICIO GRAFICOS DE : PROFESIÓN -->
             <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Filtro: profesión</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">

            	<div class="col-md-3">
				</div>

				<div class="col-md-6">
						<canvas id="graficoProfesiones" style="width:1050px"></canvas>
				</div>
              


              <div class="col-md-3">
				</div>
            
               <div class="box-body no-padding">

              <table class="table table-condensed">
                <tr>
                  <th>Profesión</th>

                  <th>Aprobados</th>

                  <th>Postulantes</th>


                </tr>
               
                <tr>
                 <td>Licenciatura</td>               
                  <td><span class="badge bg-red"><?php 
                  $LicenciadosAprobados=contarProfesion("Licenciatura","Aprobado",$fullInicial,$fullFinal,"grado"); 
                  echo $LicenciadosAprobados ?></span></td>
                  <td><span class="badge bg-red"><?php 
                 $LicenciadosPostulados=contarProfesion("Licenciatura","Postulado",$fullInicial,$fullFinal,"grado"); 
                  echo $LicenciadosPostulados;
                  ?></span></td>                
                </tr>
                <tr>
                  <td>Ingeniería</td>               
                  <td><span class="badge bg-red"><?php
                 $IngenierosAprobados=contarProfesion("Ingeniería","Aprobado",$fullInicial,$fullFinal,"grado"); 
                  echo $IngenierosAprobados;
                  ?></span></td>
                  <td><span class="badge bg-red"><?php 
               $IngenierosPostulados=contarProfesion("Ingeniería","Postulado",$fullInicial,$fullFinal,"grado"); 
                  echo $IngenierosPostulados; ?></span></td>                
               
                </tr>

                 <tr>
                  <td>Maestría</td>               
                  <td><span class="badge bg-red"><?php
                  $MasteresAprobados=contarProfesion("Maestría","Aprobado",$fullInicial,$fullFinal,"posgrado"); 
                  echo $MasteresAprobados;
                  ?></span></td>
                  <td><span class="badge bg-red"><?php 
                   $MasteresPostulados=contarProfesion("Maestría","Postulado",$fullInicial,$fullFinal,"posgrado"); 
                  echo $MasteresPostulados; ?></span></td>                
               
                </tr>

                 <tr>
                  <td>Doctorado</td>               
                  <td><span class="badge bg-red"><?php 
                   $DoctoresAprobados=contarProfesion("Doctorado","Aprobado",$fullInicial,$fullFinal,"posgrado"); 
                  echo $DoctoresAprobados; ?></span></td>
                  <td><span class="badge bg-red"><?php 
                  $DoctoresPostulados=contarProfesion("Doctorado","Postulado",$fullInicial,$fullFinal,"posgrado"); 
                  echo $DoctoresPostulados; ?></span></td>                
               
                </tr>

                  <tr>
                  <td>Cursos especializados</td>               
                  <td><span class="badge bg-red"><?php 

                  $cursosAprobados=contarProfesion("Curso especializado","Aprobado",$fullInicial,$fullFinal,"otros");
                  echo $cursosAprobados; 


                  ?></span></td>
                  <td><span class="badge bg-red"><?php 
                   $cursosPostulados=contarProfesion("Curso especializado","Postulado",$fullInicial,$fullFinal,"otros");
                  echo $cursosPostulados; 


                  ?></span></td>                
               
                </tr>

                  <tr>
                  <td>Diplomado</td>               
                  <td><span class="badge bg-red"><?php 

                  $diplomadoAprobados=contarProfesion("Diplomado","Aprobado",$fullInicial,$fullFinal,"otros");
                  echo $diplomadoAprobados; 


                  ?></span></td>
                  <td><span class="badge bg-red"><?php 
                   $diplomadoPostulados=contarProfesion("Diplomado","Postulado",$fullInicial,$fullFinal,"otros");
                  echo $diplomadoPostulados; 


                  ?></span></td>                
               
                </tr>

                 <tr>
                  <td>Otro</td>               
                  <td><span class="badge bg-red"><?php 

                  $OtrosAprobados=contarProfesion("Otro","Aprobado",$fullInicial,$fullFinal,"otros");
                  echo $OtrosAprobados; 


                  ?></span></td>
                  <td><span class="badge bg-red"><?php 
                   $OtrosPostulados=contarProfesion("Otro","Postulado",$fullInicial,$fullFinal,"otros");
                  echo $OtrosPostulados; 


                  ?></span></td>                
               
                </tr>
              </table>
            </div>
              <?php 
               $accion="/generarExcelProfesion.php?licAprobados=$LicenciadosAprobados&licPostulados=$LicenciadosPostulados&ingenierosAprobados=$IngenierosAprobados&ingenierosPostulados=$IngenierosPostulados&masteresAprobados=$MasteresAprobados&masteresPostulados=$MasteresPostulados&doctoresAprobados=$DoctoresAprobados&doctoresPostulados=$DoctoresPostulados&otrosAprobados=$OtrosAprobados&otrosPostulados=$OtrosPostulados&fechaIni=$fullInicial&fechaFin=$fullFinal&diplomadoPostulados=$diplomadoPostulados&diplomadoAprobados=$diplomadoAprobados&cursosAprobados=$cursosAprobados&cursosPostulados=$cursosPostulados";
			//echo "<form action=\"".$accion."\" method=\"get\">";
			print "<a href=\"$accion\"><i class=\"fa-file-excel-o\"></i>Descargar la tabla de resultados como Excel</a>";

               ?>
             
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.FIN GRAFICOS DE BARRA: PROFESION -->

<input type="hidden" id="bachilleresAprobados" value="<?php echo $bachilleresAprobados ?>" />
<input type="hidden" id="bachilleresPostulados" value="<?php echo $bachilleresPostulados ?>" />
<input type="hidden" id="LicenciadosAprobados" value="<?php echo $LicenciadosAprobados ?>" />
<input type="hidden" id="LicenciadosPostulados" value="<?php echo $LicenciadosPostulados ?>" />
<input type="hidden" id="IngenierosAprobados" value="<?php echo $IngenierosAprobados ?>" />
<input type="hidden" id="IngenierosPostulados" value="<?php echo $IngenierosPostulados ?>" />
<input type="hidden" id="MasteresAprobados" value="<?php echo $MasteresAprobados ?>" />
<input type="hidden" id="MasteresPostulados" value="<?php echo $MasteresPostulados ?>" />
<input type="hidden" id="DoctoresAprobados" value="<?php echo $DoctoresAprobados ?>" />
<input type="hidden" id="DoctoresPostulados" value="<?php echo $DoctoresPostulados ?>" />
<input type="hidden" id="OtrosAprobados" value="<?php echo $OtrosAprobados ?>" />
<input type="hidden" id="OtrosPostulados" value="<?php echo $OtrosPostulados ?>" />
<input type="hidden" id="diplomadoPostulados" value="<?php echo $diplomadoPostulados ?>" />
<input type="hidden" id="diplomadoAprobados" value="<?php echo $diplomadoAprobados ?>" />
<input type="hidden" id="cursosAprobados" value="<?php echo $cursosAprobados ?>" />
<input type="hidden" id="cursosPostulados" value="<?php echo $cursosPostulados ?>" />

      <?php 
      	}

      ?>


<?php 
if(strcmp($filtro, "temas")==0)
{
?>

                    <!-- /.INICIO GRAFICOS DE : TEMAS -->
             <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Filtro: temas de la administración pública</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">

            	<div class="col-md-12">
            			<canvas id="graficoTemas" style="width:1700px"></canvas>
           		 </div>
              

            
               <div class="box-body no-padding">
              <table class="table table-condensed">
                <tr>
                  <th>Tema de la administración</th>

                  <th>Aprobados</th>

                  <th>Postulantes</th>


                </tr>
                <tr>
                  <td>Gerencia pública</td>               
                  <td><span class="badge bg-red"><?php 
                  //contarTemas($tema,$status,$fechaInicio,$fechaFin)
                  $aprobadosGerencia=contarTemas("gerencia","aprobado",$fullInicial,$fullFinal);
                  echo $aprobadosGerencia;

                  ?></span></td>
                  <td><span class="badge bg-red"><?php
                   $postuladosGerencia=contarTemas("gerencia","postulado",$fullInicial,$fullFinal);
                  echo $postuladosGerencia;
                  ?></span></td> 	

                </tr>
                <tr>
                 <td>Planificación para el desarrollo</td>               
                  <td><span class="badge bg-red"><?php 
                $aprobadosPlanificacion=contarTemas("planificacion","aprobado",$fullInicial,$fullFinal);
                  echo $aprobadosPlanificacion;
                  ?>
                  	
                  </span></td>
                  <td><span class="badge bg-red"><?php 
                 $postuladosPlanificacion=contarTemas("planificacion","postulado",$fullInicial,$fullFinal);
                  echo $postuladosPlanificacion;
                  ?></span></td>                
                </tr>



                <tr>
                  <td>Gestión del talento humano por competencias en el sector público</td>               
                  <td><span class="badge bg-red"><?php
                 $aprobadosTalento=contarTemas("talento","aprobado",$fullInicial,$fullFinal);
                  echo $aprobadosTalento;
                  ?></span></td>
                  <td><span class="badge bg-red"><?php 
               $postuladosTalento=contarTemas("talento","postulado",$fullInicial,$fullFinal);
                  echo $postuladosTalento; ?></span></td>                               
                </tr>



                 <tr>
                  <td>Gobierno y territorio</td>               
                  <td><span class="badge bg-red"><?php
                 $aprobadosGobierno=contarTemas("gobierno","aprobado",$fullInicial,$fullFinal);
                  echo $aprobadosGobierno;
                  ?></span></td>
                  <td><span class="badge bg-red"><?php 
                     $postuladosGobierno=contarTemas("gobierno","postulado",$fullInicial,$fullFinal);
                  echo $postuladosGobierno;
                   ?></span></td>                              
                </tr>



                 <tr>
                  <td>Ética y transparencia en la gestión pública</td>               
                  <td><span class="badge bg-red"><?php 
                    $aprobadosEtica=contarTemas("etica","aprobado",$fullInicial,$fullFinal);
                  echo $aprobadosEtica;
                  ?></span></td>
                  <td><span class="badge bg-red"><?php 
                   $postuladosEtica=contarTemas("etica","postulado",$fullInicial,$fullFinal);
                  echo $postuladosEtica;
                  ?></span></td>                              
                </tr>


                 
                 <tr>
                  <td>Gobierno electrónico</td>               
                  <td><span class="badge bg-red"><?php 
                    $aprobadosElectronico=contarTemas("electronico","aprobado",$fullInicial,$fullFinal);
                  echo $aprobadosElectronico;
                  ?></span></td>
                  <td><span class="badge bg-red"><?php 
                   $postuladosElectronico=contarTemas("electronico","postulado",$fullInicial,$fullFinal);
                  echo $postuladosElectronico;
                  ?></span></td>                              
                </tr>



                 <tr>
                  <td>Gobierno abierto y participación ciudadana</td>               
                  <td><span class="badge bg-red"><?php 
                    $aprobadosAbierto=contarTemas("abierto","aprobado",$fullInicial,$fullFinal);
                  echo $aprobadosAbierto;
                  ?></span></td>
                  <td><span class="badge bg-red"><?php 
                   $postuladosAbierto=contarTemas("abierto","postulado",$fullInicial,$fullFinal);
                  echo $postuladosAbierto;
                  ?></span></td>                              
                </tr>

                  <tr>
                  <td>Gestión de Calidad en el sector público</td>               
                  <td><span class="badge bg-red"><?php 
                    $aprobadosCalidad=contarTemas("calidad","aprobado",$fullInicial,$fullFinal);
                  echo $aprobadosCalidad;
                  ?></span></td>
                  <td><span class="badge bg-red"><?php 
                   $postuladosCalidad=contarTemas("calidad","postulado",$fullInicial,$fullFinal);
                  echo $postuladosCalidad;
                  ?></span></td>                              
                </tr>

                 <tr>
                  <td>Enfoque de derechos en la gestión pública</td>               
                  <td><span class="badge bg-red"><?php 
                    $aprobadosEnfoque=contarTemas("enfoque","aprobado",$fullInicial,$fullFinal);
                  echo $aprobadosEnfoque;
                  ?></span></td>
                  <td><span class="badge bg-red"><?php 
                   $postuladosEnfoque=contarTemas("enfoque","postulado",$fullInicial,$fullFinal);
                  echo $postuladosEnfoque;
                  ?></span></td>                              
                </tr>

                <tr>
                  <td>Relaciones laborales en el sector público</td>               
                  <td><span class="badge bg-red"><?php 
                    $aprobadosRelaciones=contarTemas("relaciones","aprobado",$fullInicial,$fullFinal);
                  echo $aprobadosRelaciones;
                  ?></span></td>
                  <td><span class="badge bg-red"><?php 
                   $postuladosRelaciones=contarTemas("relaciones","postulado",$fullInicial,$fullFinal);
                  echo $postuladosRelaciones;
                  ?></span></td>                              
                </tr>


                 <tr>
                  <td>Gestión de capacitación en el sector público</td>               
                  <td><span class="badge bg-red"><?php 
                    $aprobadosCapacitacion=contarTemas("capacitacion","aprobado",$fullInicial,$fullFinal);
                  echo $aprobadosCapacitacion;
                  ?></span></td>
                  <td><span class="badge bg-red"><?php 
                   $postuladosCapacitacion=contarTemas("capacitacion","postulado",$fullInicial,$fullFinal);
                  echo $postuladosCapacitacion;
                  ?></span></td>                              
                </tr>


              </table>
            </div>
             
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.FIN GRAFICOS DE BARRA: TEMAS -->

 <input type="hidden" id="aprobadosGerencia" value="<?php echo $aprobadosGerencia ?>" />
<input type="hidden" id="postuladosGerencia" value="<?php echo $postuladosGerencia ?>" />
<input type="hidden" id="aprobadosPlanificacion" value="<?php echo $aprobadosPlanificacion ?>" />
<input type="hidden" id="postuladosPlanificacion" value="<?php echo $postuladosPlanificacion ?>" />
<input type="hidden" id="aprobadosTalento" value="<?php echo $aprobadosTalento ?>" />
<input type="hidden" id="postuladosTalento" value="<?php echo $postuladosTalento ?>" />
<input type="hidden" id="aprobadosGobierno" value="<?php echo $aprobadosGobierno ?>" />
<input type="hidden" id="postuladosGobierno" value="<?php echo $postuladosGobierno ?>" />
<input type="hidden" id="aprobadosEtica" value="<?php echo $aprobadosEtica ?>" />
<input type="hidden" id="postuladosEtica" value="<?php echo $postuladosEtica ?>" />
<input type="hidden" id="aprobadosElectronico" value="<?php echo $aprobadosElectronico ?>" />
<input type="hidden" id="postuladosElectronico" value="<?php echo $postuladosElectronico ?>" />
<input type="hidden" id="aprobadosAbierto" value="<?php echo $aprobadosAbierto ?>" />
<input type="hidden" id="postuladosAbierto" value="<?php echo $postuladosAbierto ?>" />
<input type="hidden" id="aprobadosCalidad" value="<?php echo $aprobadosCalidad ?>" />
<input type="hidden" id="postuladosCalidad" value="<?php echo $postuladosCalidad ?>" />
<input type="hidden" id="aprobadosEnfoque" value="<?php echo $aprobadosEnfoque ?>" />
<input type="hidden" id="postuladosEnfoque" value="<?php echo $postuladosEnfoque ?>" />
<input type="hidden" id="aprobadosRelaciones" value="<?php echo $aprobadosRelaciones ?>" />
<input type="hidden" id="postuladosRelaciones" value="<?php echo $postuladosRelaciones ?>" />
<input type="hidden" id="aprobadosCapacitacion" value="<?php echo $aprobadosCapacitacion ?>" />
<input type="hidden" id="postuladosCapacitacion" value="<?php echo $postuladosCapacitacion ?>" />
       <?php 
               $accion="/generarExcelTemas.php?aprobadosGerencia=$aprobadosGerencia
               &postuladosGerencia=$postuladosGerencia

               &aprobadosPlanificacion=$aprobadosPlanificacion
               &postuladosPlanificacion=$postuladosPlanificacion

              
               &aprobadosTalento=$aprobadosTalento
               &postuladosTalento=$postuladosTalento

               &aprobadosGobierno=$aprobadosGobierno
               &postuladosGobierno=$postuladosGobierno

               &aprobadosEtica=$aprobadosEtica
               &postuladosEtica=$postuladosEtica

                 &aprobadosElectronico=$aprobadosElectronico
               &postuladosElectronico=$postuladosElectronico

               &aprobadosAbierto=$aprobadosAbierto
               &postuladosAbierto=$postuladosAbierto

               &aprobadosCalidad=$aprobadosCalidad
               &postuladosCalidad=$postuladosCalidad

               &aprobadosEnfoque=$aprobadosEnfoque
               &postuladosEnfoque=$postuladosEnfoque

               &aprobadosRelaciones=$aprobadosRelaciones
               &postuladosRelaciones=$postuladosRelaciones

               &aprobadosCapacitacion=$aprobadosCapacitacion
               &postuladosCapacitacion=$postuladosCapacitacion

               &fechaIni=$fullInicial&fechaFin=$fullFinal";

			//echo "<form action=\"".$accion."\" method=\"get\">";
			print "<a href=\"$accion\"><i class=\"fa-file-excel-o\"></i>Descargar la tabla de resultados como Excel</a>";
               ?>
<?php 
}
?>


<?php 
if(strcmp($filtro, "docencia")==0)
{

?>
 <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Filtro: Total de postulantes que practican la docencia</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
            	<div class="col-md-4">
           		 </div>

           		 <div class="col-md-4">
           		 		<canvas id="graficaDocencia" style="height:250px"></canvas>
           		 </div>

           		 <div class="col-md-4">
           		 	
           		 </div>
              
         
            
               <div class="box-body no-padding">
              <table class="table table-condensed">
                <tr>
                  <th>Aprobados que practican la docencia</th>

                  <th>Postulados que practican la docencia</th>

                  <th>Total</th>
                </tr>
                <tr>
            
                  <td><span class="badge bg-red"><?php 
                  $numDocenciaAprobados=contarPracticaDocencia("aprobado",$fullInicial,$fullFinal);
                  echo $numDocenciaAprobados; 

                  ?></span></td>
                  <td><span class="badge bg-red"><?php 
                  $numDocenciaPostulados=contarPracticaDocencia("postulado",$fullInicial,$fullFinal);
                  echo $numDocenciaPostulados; 
                  ?></span></td>

                  <td><span class="badge bg-red"><?php
                  $numDocenciaTotal=($numDocenciaAprobados+$numDocenciaPostulados);
                  echo $numDocenciaTotal; 
                  ?></span></td>

                  <input type="hidden" id="numDocenciaAprobados" value="<?php echo $numDocenciaAprobados ?>" />
					<input type="hidden" id="numDocenciaPostulados" value="<?php echo $numDocenciaPostulados ?>" />
					<input type="hidden" id="numDocenciaTotal" value="<?php echo $numDocenciaTotal ?>" />

                </tr>
     
              </table>

               <?php 
               $accion="/generarExcelPractica.php?numDocenciaAprobados=$numDocenciaAprobados&numDocenciaPostulados=$numDocenciaPostulados&numDocenciaTotal=$numDocenciaTotal&fechaIni=$fullInicial&fechaFin=$fullFinal";
			//echo "<form action=\"".$accion."\" method=\"get\">";
			print "<a href=\"$accion\"><i class=\"fa-file-excel-o\"></i>Descargar la tabla de resultados como Excel</a>";

               ?>



            </div>


             
            </div>
            <!-- /.box-body -->
            <?php  
            echo "Número de aprobados en ese periodo: ".$numeroAprobados."<br>";
            $ratio1=$numDocenciaAprobados/$numeroAprobados*100;
            $ratio2=$numDocenciaPostulados/$numeroPostulantes*100;
         echo "<b>Ratio de aprobados / aprobados que practican la docencia en ese periodo: ".$ratio1."%</b><br>";
           echo "Número de postulados en ese periodo: ".$numeroPostulantes."<br>";
            echo "<b>Ratio de postulados / postulados que practican la docencia en ese periodo: ".$ratio2."%</b><br>";
           		 	?>
          </div>
          <!-- /.FIN GRAFICOS DE BARRA: GENERO -->


<?php 
}
?>


<?php 
if(strcmp($filtro, "metodologia")==0)
{
?>
           <!-- /.INICIO GRAFICOS DE : METODOLOGIAS -->
             <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Filtro: metodologías</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">

            	<div class="col-md-12">
            			<canvas id="graficoMetodologias" style="width:1700px"></canvas>
           		 </div>
              

            
               <div class="box-body no-padding">
              <table class="table table-condensed">
                <tr>
                  <th>Metodología</th>

                  <th>Aprobados</th>

                  <th>Postulantes</th>
                </tr>


                <tr>
                  <td>Diseño de programas y/o proyectos de formación y/o capacitación (curricular)</td>               
                  <td><span class="badge bg-red"><?php 
                  //contarMetodologia($metodologia,$status,$fechaInicio,$fechaFin) /
                  $aprobadosProgramas=contarMetodologia("programas","aprobado",$fullInicial,$fullFinal);
                  echo $aprobadosProgramas;

                  ?></span></td>
                  <td><span class="badge bg-red"><?php
                   $postuladosProgramas=contarMetodologia("programas","postulado",$fullInicial,$fullFinal);
                  echo $postuladosProgramas;

                  ?></span></td> 	

                </tr>


                <tr>
                 <td>Diseño de cartas didácticas (diseños instruccionales)o</td>               
                  <td><span class="badge bg-red"><?php 
                 $aprobadosCartas=contarMetodologia("disenocartas","aprobado",$fullInicial,$fullFinal);
                  echo $aprobadosCartas;
                  ?>
                  	
                  </span></td>
                  <td><span class="badge bg-red"><?php 
                  $postuladosCartas=contarMetodologia("disenocartas","postulado",$fullInicial,$fullFinal);
                  echo $postuladosCartas;
                  ?></span></td>                
                </tr>



                <tr>
                  <td>Evaluación de procesos de formación</td>               
                  <td><span class="badge bg-red"><?php
                $aprobadosEvaluacion=contarMetodologia("evaluacion","aprobado",$fullInicial,$fullFinal);
                  echo $aprobadosEvaluacion;
                  ?></span></td>
                  <td><span class="badge bg-red"><?php 
               $postuladosEvaluacion=contarMetodologia("evaluacion","postulado",$fullInicial,$fullFinal);
                  echo $postuladosEvaluacion;
                  ?></span></td>                               
                </tr>

                   <tr>
                  <td>Facilitación de talleres o cursos de formación o capacitación</td>               
                  <td><span class="badge bg-red"><?php
                $aprobadosFacilitacion=contarMetodologia("facilitacion","aprobado",$fullInicial,$fullFinal);
                  echo $aprobadosFacilitacion;
                  ?></span></td>
                  <td><span class="badge bg-red"><?php 
               $postuladosFacilitacion=contarMetodologia("facilitacion","postulado",$fullInicial,$fullFinal);
                  echo $postuladosFacilitacion;
                  ?></span></td>                               
                </tr>

                      <tr>
                  <td>Metodologías participativas</td>               
                  <td><span class="badge bg-red"><?php
                $aprobadosParticipativa=contarMetodologia("participativa","aprobado",$fullInicial,$fullFinal);
                  echo $aprobadosParticipativa;
                  ?></span></td>
                  <td><span class="badge bg-red"><?php 
               $postuladosParticipativa=contarMetodologia("participativa","postulado",$fullInicial,$fullFinal);
                  echo $postuladosParticipativa;
                  ?></span></td>                               
                </tr>

                 <tr>
                  <td>Elaboración de material de apoyo</td>               
                  <td><span class="badge bg-red"><?php
                $aprobadosElaboracion=contarMetodologia("elaboracion","aprobado",$fullInicial,$fullFinal);
                  echo $aprobadosElaboracion;
                  ?></span></td>
                  <td><span class="badge bg-red"><?php 
               $postuladosElaboracion=contarMetodologia("elaboracion","postulado",$fullInicial,$fullFinal);
                  echo $postuladosElaboracion;
                  ?></span></td>                               
                </tr>

                <tr>
                  <td>Metodologías en línea</td>               
                  <td><span class="badge bg-red"><?php
                $aprobadosLinea=contarMetodologia("linea","aprobado",$fullInicial,$fullFinal);
                  echo $aprobadosLinea;
                  ?></span></td>
                  <td><span class="badge bg-red"><?php 
               $postuladosLinea=contarMetodologia("linea","postulado",$fullInicial,$fullFinal);
                  echo $postuladosLinea;
                  ?></span></td>                               
                </tr>       

              </table>
            </div>
             
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.FIN GRAFICOS DE BARRA: METODOLOGIAS -->

 <input type="hidden" id="aprobadosProgramas" value="<?php echo $aprobadosProgramas ?>" />
<input type="hidden" id="postuladosProgramas" value="<?php echo $postuladosProgramas ?>" />
<input type="hidden" id="aprobadosCartas" value="<?php echo $aprobadosCartas ?>" />
<input type="hidden" id="postuladosCartas" value="<?php echo $postuladosCartas ?>" />
<input type="hidden" id="aprobadosEvaluacion" value="<?php echo $aprobadosEvaluacion ?>" />
<input type="hidden" id="postuladosEvaluacion" value="<?php echo $postuladosEvaluacion ?>" />
<input type="hidden" id="aprobadosFacilitacion" value="<?php echo $aprobadosFacilitacion ?>" />
<input type="hidden" id="postuladosFacilitacion" value="<?php echo $postuladosFacilitacion ?>" />
<input type="hidden" id="aprobadosParticipativa" value="<?php echo $aprobadosParticipativa ?>" />
<input type="hidden" id="postuladosParticipativa" value="<?php echo $postuladosParticipativa ?>" />
<input type="hidden" id="aprobadosElaboracion" value="<?php echo $aprobadosElaboracion ?>" />
<input type="hidden" id="postuladosElaboracion" value="<?php echo $postuladosElaboracion ?>" />
<input type="hidden" id="aprobadosLinea" value="<?php echo $aprobadosLinea ?>" />
<input type="hidden" id="postuladosLinea" value="<?php echo $postuladosLinea ?>" />

                 <?php 
               $accion="/generarExcelMetodologias.php?aprobadosProgramas=$aprobadosProgramas
               &postuladosProgramas=$postuladosProgramas
               &aprobadosCartas=$aprobadosCartas
               &postuladosCartas=$postuladosCartas
               &fechaIni=$fullInicial&fechaFin=$fullFinal
               &aprobadosEvaluacion=$aprobadosEvaluacion
               &postuladosEvaluacion=$postuladosEvaluacion
               &aprobadosFacilitacion=$aprobadosFacilitacion
               &postuladosFacilitacion=$postuladosFacilitacion
               &aprobadosParticipativa=$aprobadosParticipativa
               &postuladosParticipativa=$postuladosParticipativa
                 &aprobadosElaboracion=$aprobadosElaboracion
               &postuladosElaboracion=$postuladosElaboracion
               &aprobadosLinea=$aprobadosLinea
               &postuladosLinea=$postuladosLinea";

			//echo "<form action=\"".$accion."\" method=\"get\">";
			print "<a href=\"$accion\"><i class=\"fa-file-excel-o\"></i>Descargar la tabla de resultados como Excel</a>";
               ?>

<?php 
}
?>


<?php 
if(strcmp($filtro, "extranjeros")==0)
{
?>

<!-- DONUT CHART -->
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Nacionales vs extranjeros</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
            	<div class="col-md-6">
            		 <label>Postulantes </label>
            	    <canvas id="PiePostulantes" style="height:20px"></canvas>
            	</div>

            	<div class="col-md-6">
            		 <label>Aprobados </label>
            			<canvas id="PieAprobados" style="height:250px"></canvas>
            	</div>


            	 <table class="table table-condensed">
                <tr>
                	 <th></th>
                  <th>Nacionales</th>

                  <th>Extranjeros</th>

            

                </tr>
                <tr>
            		<th>Postulantes</th>
            		
                  <td><span class="badge bg-blue"><?php 
                  $postulantesNacionales=contarSalvadorenos("postulado",$fullInicial,$fullFinal);
                  echo $postulantesNacionales; 

                  ?></span></td>

                  <td><span class="badge bg-yellow"><?php 
                  $postulantesExtranjeros=contarExtranjeros("postulado",$fullInicial,$fullFinal);
                  echo $postulantesExtranjeros; 
                  ?></span></td>

                  

           
                </tr>
                 <tr>
            		<th>Aprobados</th>
            		
                  <td><span class="badge bg-blue"><?php 
                  $aprobadosNacionales=contarSalvadorenos("aprobado",$fullInicial,$fullFinal);
                  echo $aprobadosNacionales; 

                  ?></span></td>
                  <td><span class="badge bg-yellow"><?php 
                  $aprobadosExtranjeros=contarExtranjeros("aprobado",$fullInicial,$fullFinal);
                  echo $aprobadosExtranjeros; 
                  ?></span></td>

                  

          
                </tr>

                <tr>
            		<th>Total</th>
            		
                 <td><span class="badge bg-green"><?php 
                  $totalNacionales=$postulantesNacionales+$aprobadosNacionales;
                  echo $totalNacionales; 
                  ?></span></td>

                  <td><span class="badge bg-green"><?php 
                  $totalExtranjeros=$postulantesExtranjeros+$aprobadosExtranjeros;
                  echo $totalExtranjeros; 
                  ?></span></td>



           
                </tr>
     	
              </table>




             	  <input type="hidden" id="postulantesNacionales" value="<?php echo $postulantesNacionales ?>" />
					<input type="hidden" id="postulantesExtranjeros" value="<?php echo $postulantesExtranjeros ?>" />
					<input type="hidden" id="aprobadosNacionales" value="<?php echo $aprobadosNacionales ?>" />
					<input type="hidden" id="aprobadosExtranjeros" value="<?php echo $aprobadosExtranjeros ?>" />
              
                 <?php 
               $accion="/generarExcelNacionales.php?postulantesNacionales=$postulantesNacionales&postulantesExtranjeros=$postulantesExtranjeros&aprobadosNacionales=$aprobadosNacionales&aprobadosExtranjeros=$aprobadosExtranjeros&fechaIni=$fullInicial&fechaFin=$fullFinal&totalExtranjeros=$totalExtranjeros&totalNacionales=$totalNacionales";
			//echo "<form action=\"".$accion."\" method=\"get\">";
			print "<a href=\"$accion\"><i class=\"fa-file-excel-o\"></i>Descargar la tabla de resultados como Excel</a>";

               ?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->


<?php 
}
?>











<?php
 //////FIN MI CODIGO                 
$this->contentContainerEnd();
//$this->endsBoxPrimary();
     ?>
	     </div>
		</div>
		</div>





		<?php	
		$this->contentEnd();
		$this->mainFooter();		
		$this->containerEnd();
		//$this->contentContainerEnd();
	  echo '<script type="text/javascript" src="/styles/multisis-lte/bower_components/chart.js/Chart.js"></script>'."\n"; //agregado 
	  echo "<script type='text/javascript'  src='/styles/multisis-lte/bower_components/datosEstadisticas.js'></script>";
		$this->htmlEndPage();
	} /* }}} */
}
?>
