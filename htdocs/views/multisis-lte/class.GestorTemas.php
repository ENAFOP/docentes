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
function imprimirTemas($nombreFichero) //imprime la lista de temas que se usa en la pestaña 4 temas de la administración publica q ud maneja
{
  	$lines = file("../listas_tematicas/$nombreFichero.txt", FILE_IGNORE_NEW_LINES);
  //echo "<option disabled selected value>Seleccione un tema</option>";
  	$cont=1;
    foreach ($lines as $doc) 
    {
    	$doc=utf8_encode($doc);
    	$id=$nombreFichero."_".$cont;
    	echo '<div class="row">';
    	echo '<div class="col-md-10">';
		echo "<li>";
	  echo "<a href=\"#\" id=\"$id\" data-type=\"text\" data-pk=\"$cont\" data-url=\"/modificarTema.php\" data-title=\"Enter username\">$doc</a>";
	    echo "</li>";
	    echo '</div>'; //fin primer columna

	    echo '<div class="col-md-1">';
	    $idBorrado="borrar-".$nombreFichero."-".$cont;
	    echo "<button type=\"button\" id=\"$idBorrado\" class=\"btn btn-danger btn-xs\"><i class=\"fa fa-times\"></i></button>";
	    echo '</div>'; //fin segunda columna

	    echo '</div>'; //fin row
		  $cont++;
	} //fin del bucle
}
class SeedDMS_View_GestorTemas extends SeedDMS_Bootstrap_Style 
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

		$this->htmlStartPage("Gestión de lista de temas admin. pública", "skin-blue sidebar-mini sidebar-collapse");
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
  
 $this->startBoxPrimary("Gestor de lista de temas de la administración pública que figuran en el formulario de postulación");
$this->contentContainerStart();
//////INICIO MI CODIGO
?>
<div class="callout callout-success">
                <h4>Bienvenido al gestor de temas de la administación pública</h4>

                <p>Indicaciones:</p>
                 <p><b>Usted puede, para cada categoría de temas, añadir, editar o borrar un tema específico.</b></p>
                 <p>*Para editar: haga click en el nombre de un tema; aparecerá un recuadro donde podrá ingresar el nuevo valor del tema, y debe presionar OK para validar el cambio.</p>
                 <p>*Para eliminar: haga click en el botón rojo que aparece a la par de cada tema; saldrá un mensaje notificando de la acción y la página se recargará</p>
                 <p>*Para añadir: haga click en el botón "Añadir nuevo tema" al pie de cada sección; un mensaje le solicitará el nombre del nuevo tema</p>
              </div>


<div class="row">
        <div class="col-md-3">
   			      <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Gerencia pública</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
               <ul>
                <?php 
                	imprimirTemas("gerencia");
                ?>
              </ul>
            </div>
            <!-- /.box-body -->
            <div class="box-footer"> <!-- /.INICIO BOX FOOTER -->
                <a id="btn-add-gerencia" type="submit" class="btn btn-warning pull-left">
                <i class="fa fa-plus"></i>Añadir nuevo tema</a>
               
                </div>   <!-- /.FIN DEL BOX FOOTER -->
          </div>
        </div>
        <!-- /.col -->
        <div class="col-md-3">
                <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Planificación para el desarrollo</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
               <ul>
                <?php 
                	imprimirTemas("planificacion");
                ?>
              </ul>
            </div>
            <!-- /.box-body -->
            <div class="box-footer"> <!-- /.INICIO BOX FOOTER -->
                <a id="btn-add-planificacion" type="submit" class="btn btn-warning pull-left">
                <i class="fa fa-plus"></i>Añadir nuevo tema</a>
               
                </div>   <!-- /.FIN DEL BOX FOOTER -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Gobierno abierto y participación ciudadana</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
               <ul>
                <?php 
                	imprimirTemas("abierto");
                ?>
              </ul>
            </div>
            <!-- /.box-body -->
            <div class="box-footer"> <!-- /.INICIO BOX FOOTER -->
                <a id="btn-add-abierto" type="submit" class="btn btn-warning pull-left">
                <i class="fa fa-plus"></i>Añadir nuevo tema</a>
               
                </div>   <!-- /.FIN DEL BOX FOOTER -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3">
            <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Gestión del talento humano por competencias en el sector público </h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
               <ul>
                <?php 
                	imprimirTemas("talento");
                ?>
              </ul>
            </div>
            <!-- /.box-body -->
            <div class="box-footer"> <!-- /.INICIO BOX FOOTER -->
                <a id="btn-add-talento" type="submit" class="btn btn-warning pull-left">
                <i class="fa fa-plus"></i>Añadir nuevo tema</a>
               
                </div>   <!-- /.FIN DEL BOX FOOTER -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div> <!-- /.fin primera fila -->
      <!-- /.row -->


      <div class="row"> <!-- /.inicio segunda fila -->
      		     <div class="col-md-3">
            <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Gobierno y territorio</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
               <ul>
                <?php 
                	imprimirTemas("gobierno");
                ?>
              </ul>
            </div>
            <!-- /.box-body -->
            <div class="box-footer"> <!-- /.INICIO BOX FOOTER -->
                <a id="btn-add-gobierno" type="submit" class="btn btn-warning pull-left">
                <i class="fa fa-plus"></i>Añadir nuevo tema</a>
               
                </div>   <!-- /.FIN DEL BOX FOOTER -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

        	     <div class="col-md-3">
            <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Ética y transparencia en la gestión pública</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
               <ul>
                <?php 
                	imprimirTemas("etica");
                ?>
              </ul>
            </div>
            <!-- /.box-body -->
            <div class="box-footer"> <!-- /.INICIO BOX FOOTER -->
                <a id="btn-add-etica" type="submit" class="btn btn-warning pull-left">
                <i class="fa fa-plus"></i>Añadir nuevo tema</a>
               
                </div>   <!-- /.FIN DEL BOX FOOTER -->
          </div>
          <!-- /.box -->
        </div>


        	     <div class="col-md-3">
            <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Gobierno electrónico</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
               <ul>
                <?php 
                	imprimirTemas("electronico");
                ?>
              </ul>
            </div>
            <!-- /.box-body -->
            <div class="box-footer"> <!-- /.INICIO BOX FOOTER -->
                <a id="btn-add-electronico" type="submit" class="btn btn-warning pull-left">
                <i class="fa fa-plus"></i>Añadir nuevo tema</a>
               
                </div>   <!-- /.FIN DEL BOX FOOTER -->
          </div>
          <!-- /.box -->
        </div>

           <div class="col-md-3">
            <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Gestión de Calidad en el sector público</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
               <ul>
                <?php 
                	imprimirTemas("calidad");
                ?>
              </ul>
            </div>
            <!-- /.box-body -->
            <div class="box-footer"> <!-- /.INICIO BOX FOOTER -->
                <a id="btn-add-calidad" type="submit" class="btn btn-warning pull-left">
                <i class="fa fa-plus"></i>Añadir nuevo tema</a>
               
                </div>   <!-- /.FIN DEL BOX FOOTER -->
          </div>
          <!-- /.box -->
        </div>

      </div> <!-- /.fin segunda fila -->

      <div class="row"> <!-- /.inicio tercera fila -->

      	 <div class="col-md-3">
            <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Enfoque de derechos en la gestión pública</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
               <ul>
                <?php 
                	imprimirTemas("enfoque");
                ?>
              </ul>
            </div>
            <!-- /.box-body -->
            <div class="box-footer"> <!-- /.INICIO BOX FOOTER -->
                <a id="btn-add-enfoque" type="submit" class="btn btn-warning pull-left">
                <i class="fa fa-plus"></i>Añadir nuevo tema</a>
               
                </div>   <!-- /.FIN DEL BOX FOOTER -->
          </div>
          <!-- /.box -->
        </div>

         	 <div class="col-md-3">
            <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Relaciones laborales en el sector público</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
               <ul>
                <?php 
                	imprimirTemas("relaciones");
                ?>
              </ul>
            </div>
            <!-- /.box-body -->
            <div class="box-footer"> <!-- /.INICIO BOX FOOTER -->
                <a id="btn-add-relaciones" type="submit" class="btn btn-warning pull-left">
                <i class="fa fa-plus"></i>Añadir nuevo tema</a>
               
                </div>   <!-- /.FIN DEL BOX FOOTER -->
          </div>
          <!-- /.box -->
        </div>

        <div class="col-md-3">
            <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Gestión de capacitación en el sector público</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
               <ul>
                <?php 
                	imprimirTemas("capacitacion");
                ?>
              </ul>
            </div>
            <!-- /.box-body -->
            <div class="box-footer"> <!-- /.INICIO BOX FOOTER -->
                <a id="btn-add-capacitacion" type="submit" class="btn btn-warning pull-left">
                <i class="fa fa-plus"></i>Añadir nuevo tema</a>
               
                </div>   <!-- /.FIN DEL BOX FOOTER -->
          </div>
          <!-- /.box -->
        </div>


      </div> <!-- /.fin tercer fila -->
 

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
		//$this->contentContainerEnd();
		echo '<script type="text/javascript" src="/styles/'.$this->theme.'/jquery-editable/js/jquery-editable-poshytip.min.js"></script>'."\n";
		echo '<script type="text/javascript" src="/styles/'.$this->theme.'/poshytip-1.2/src/jquery.poshytip.min.js"></script>'."\n";
		echo "<script type='text/javascript' src='/anadirTemas.js'></script>";
		$this->htmlEndPage();
	} /* }}} */
}
?>
