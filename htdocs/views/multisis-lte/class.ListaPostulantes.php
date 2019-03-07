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

class SeedDMS_View_ListaPostulantes extends SeedDMS_Bootstrap_Style 
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
		$baseServer=$this->params['settings']->_httpRoot;
		$timeout = $this->params['timeout'];	
		$db = $dms->getDB();
		$previewer = new SeedDMS_Preview_Previewer($cachedir, $previewwidth, $timeout);
		$estado=""; //estado de la postulación
		if (isset($_GET["estado"]) && !empty($_GET["estado"]))
		{
			$estado=$_GET["estado"];
		}
		else
		{
			UI::exitError(getMLText("folder_title", array("foldername" => "ID de estado no válido")),"Debe proporcionarse un estado correcto (aprobado,postulado o rechazado) en la solicitud de la página");
		}
		$listaEstados=array("aprobado","rechazado","postulado","revisado");
		if(!in_array($estado, $listaEstados))
		{
			UI::exitError(getMLText("folder_title", array("foldername" => "ID de estado no válido")),"Debe proporcionarse un estado correcto (aprobado,postulado o rechazado o revisado) en la solicitud de la página");
		}
		
		if(!$user->isAdmin())
		{
			if(strcmp($estado, "rechazado")==0)
			{
				UI::exitError(getMLText("folder_title", array("foldername" => "No hay permisos para ver esta lista")),"usted no tiene acceso a la lista de postulantes rechazados");
			}
		}

		echo $this->callHook('startPage');
		if($user->isAdmin())
		{
			$this->htmlStartPage("Lista de postulantes con estado $estado", "skin-blue sidebar-mini sidebar-collapse");
		}
		else
		{
			$this->htmlStartPage("Lista de postulantes con estado  $estado", "skin-blue layout-top-nav");
		}
		$this->containerStart();
		$this->mainHeader();
		if($user->isAdmin())
		{
			$this->mainSideBar();
		}
		//$this->contentContainerStart("hoa");
		$this->contentStart();
          
		?>
    <div class="gap-10"></div>
    <div class="row">
    <div class="col-md-12">
      

    <?php
    //en este bloque php va "mi" código
  
 $this->startBoxPrimary("Lista de postulantes con estado:  $estado");
$this->contentContainerStart();
//////INICIO MI CODIGO
?>
		<div class="box box-success" >
            <div class="box-header">
              <h3 class="box-title">Resultados</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="tablaPostulantes" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Fecha de postulación inicial</th>
                  <th>Acceso al perfil</th>
         
                </tr>
                </thead>
                <tbody>
                <?php
                
					//query de consulta:
					$consultar="SELECT idpostulante,fecha FROM postulaciones WHERE estado=\"$estado\"";
					$res1 = $db->getResultArray($consultar);
					if($res1)
					{
						foreach ($res1 as $key) 
						{
							//print_r("Aubarray: ".$key);
							$idpostulante=$key['idpostulante'];
							$fecha=$key['fecha'];
							$tmp=explode(" ", $fecha);
							$soloDate=$tmp[0];
							$trozos=explode("-", $soloDate);
							$ano=$trozos[0];
							$mes=$trozos[1]; $dia=$trozos[2];
							//Obtenog nombre
							$consultar2="SELECT nombre  FROM datosgenerales WHERE idpostulante=$idpostulante";
							$res2 = $db->getResultArray($consultar2);
							$nombreFull=$res2[0]['nombre'];
							 echo  '<tr>';
			                  echo "<td>$nombreFull</td>";
			                  echo "<td>$dia/$mes/$ano</td>";
			               echo "<td><a href=\"out.VerPostulacion.php?postulante=$idpostulante\">Acceder al perfil </a></td>";
		                    echo '</tr>';
						}
					}		                	
                ?>
                </tbody>
                <tfoot>
              
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
 <?php
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
		echo '<script src="../styles/multisis-lte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>';
        echo '<script src="../styles/multisis-lte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>';
        echo '<script src="../tablasDinamicas.js"></script>';
		$this->htmlEndPage();
	} /* }}} */
}
?>
