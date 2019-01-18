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
function getIdPostulacion($idPostulante,$db)
{
	$miQuery="SELECT id FROM postulaciones WHERE idpostulante=$idPostulante;";
	$resultado=$db->getResultArray($miQuery);
	return $resultado[0]['id'];
}
class SeedDMS_View_DecidirPostulante extends SeedDMS_Bootstrap_Style 
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

		$this->htmlStartPage(getMLText("mi_sitio"), "skin-blue sidebar-mini");
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
  
 $this->startBoxPrimary("Aprobar a postulante ");
$this->contentContainerStart();
//////INICIO MI CODIGO
$nombrePostulante=$_POST["nombrePostulante"];
$idPostulante=$_POST["idPostulante"];
$idPostulacion=getIdPostulacion($idPostulante,$db);
if(isset($_POST["botonAprobar"]))
{
	echo '<form name="aprobar" id="aprobar" action="/aprobar.php" method="POST">';
	  echo "<input type=\"hidden\" name=\"idPostulante\" id=\"idPostulante\" value=\"$idPostulante\"></input>";
	 echo "<input type=\"hidden\" name=\"idPostulacion\" id=\"idPostulacion\" value=\"$idPostulacion\"></input>";
	 echo '<div class="callout callout-success">';
           echo '<h4>¿Está seguro?</h4>';
                echo "<p>Está a punto de aprobar al postulante <b>$nombrePostulante</b>. <br>Presione el botón aprobar para realizar el cambio de estado de En evaluación a docente aprobado, o volver a la página anterior.</p>";
              echo '</div>';
              echo '<div class="row">';
              echo '<div class="col-md-6">';
              echo '<button type="button" name="volver" id="volver" class="btn btn-block  btn-lg">Volver</button>';
              echo '</div>';
               echo '<div class="col-md-6">';
              echo '<button type="submit" name="btnAprobar" id="btnAprobar" class="btn btn-block  btn-info btn-lg">Aprobar</button>';
              echo '</div>';
              echo '</div>';
    echo "</form>";
}
if(isset($_POST["botonRechazar"]))
{
	echo '<form name="rechazar" id="rechazar" action="/rechazar.php" method="POST">';
	  echo "<input type=\"hidden\" name=\"idPostulante\" id=\"idPostulante\" value=\"$idPostulante\"></input>";
	 echo "<input type=\"hidden\" name=\"idPostulacion\" id=\"idPostulacion\" value=\"$idPostulacion\"></input>";
	 echo '<div class="callout callout-danger">';
           echo '<h4>¿Está seguro?</h4>';
                echo "<p>Está a punto de rechazar al postulante <b>$nombrePostulante</b>. <br>Presione el botón rechazar para realizar el cambio de estado de En evaluación a docente aprobado (debe indicar la razón del rechazo en el cuadro de texto que se muestra a continuación), o volver a la página anterior. </p>";
              echo '</div>';

              echo "<textarea  required=\"required\" class=\"form-control\" name=\"razon\" id=\"razon\" placeholder=\"Ingrese la razón del rechazo del postulante...\"></textarea>";
              echo "<br>";

              echo '<div class="row">';
              echo '<div class="col-md-6">';
              echo '<button type="button" name="volver" id="volver" class="btn btn-block  btn-lg">Volver</button>';
              echo '</div>';

               echo '<div class="col-md-6">';
              echo '<button type="submit" name="btnRechazar" id="btnRechazar" class="btn btn-block  btn-info btn-lg">Rechazar</button>';
              echo '</div>';
              echo '</div>';


    echo "</form>";
}

 //////FIN MI CODIGO                 
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
		$this->htmlEndPage();
	} /* }}} */
}
?>
