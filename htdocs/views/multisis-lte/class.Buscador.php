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
function imprimirAreas()
{
	
  $arrayTitulos=array("Gobierno abierto y participación ciudadana","Gestión de calidad en el sector público","Gestión de capacitación en el sector público","Gobierno electrónico","Enfoque de derechos en la gestión pública","Ética y transparencia en la gestión pública","Gerencia pública","Gobierno y territorio","Planificación para el desarrollo","Relaciones laborales en el sector público","Gestión del talento humano por competencias en el sector público");
echo " <select class=\"form-control select\"  name=\"area\" id=\"area\">";
  echo "<option disabled selected value>Seleccione un valor</option>";
    foreach ($arrayTitulos as $doc) 
    {
		echo "<option value=\"".$doc."\">".$doc."</option>";
	} //fin del bucle
}

 function imprimirTitulos()
{
	
  $titulos=array("Licenciatura","Ingeniería","Maestría","Doctorado");
	echo " <select class=\"form-control select\"  name=\"titulo\" id=\"titulo\">";
  echo "<option disabled selected value>Seleccione un título</option>";
    foreach ($titulos as $doc) 
    {
		echo "<option value=\"".$doc."\">".$doc."</option>";
	} //fin del bucle
}

class SeedDMS_View_Buscador extends SeedDMS_Bootstrap_Style 
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
			//////////// COSAS NECESARIAS QUE NO ME PASAN POR FORMULARIO Y LAS CALCULO

		//echo "categories: ".print_r($categories);
		echo $this->callHook('startPage');
		if($user->isAdmin())
		{
			$this->htmlStartPage("Buscador privado (postulados+aprobados+rechazados) de docentes de la ENAFOP", "skin-blue sidebar-mini sidebar-collapse");
		}
		else
		{
			$this->htmlStartPage("Buscador de docentes aprobados de la ENAFOP", "skin-blue layout-top-nav");
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

   <section class="content-header">
      <h1>
       Buscador de docentes
        <small>de la ENAFOP</small>
      </h1>

    </section>

     <div class="row">
        <div class="col-xs-12">

        </div>
      </div>
   <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-sticky-note"></i> Este es el buscador de docentes de la ENAFOP</h4>
               
			   Para realizar una búsqueda avanzada:
			   </br>
			   (1) Ingrese los términos de interés (palabra o frase) o puede dejar ese espacio en blanco.
			   </br>
              (2) Delimite su búsqueda haciendo click en los espacios sugeridos y rellenando la información requerida (se puede rellenar uno o más campos).
			  </br>
               (3) Presionar el botón Buscar.
            
              </div>

   <!-- INICIO DEL FORMULARIO -->

  <form action="../out/out.Buscar.php" name="busqueda" id="busqueda" method="GET">
     <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Ingrese los términos de interés</h3>

 
             </div>
            <!-- /.box-header -->
            <!-- form start -->
        
              <div class="box-body">
         
                <div class="form-group">
                  
                  <!--  <input type="text" class="form-control" name="terminos" placeholder="Términos de búsqueda"> -->
                      <input type="text" required name="terminos" class="form-control input-lg " placeholder="<?php echo "Ingrese los términos de interés..." ?>">  
                </div>
            
              </div>
              <!-- /.box-body -->
          </div>      

		    <!-- SEGUNDA CAJA: DELIMITACIÓN DE LA BÚSQUEDA -->        			             

         <div class="box box-primary collapsed-box">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo "Delimite su búsqueda"; ?></h3>
		<div class="box-tools pull-right">
    	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
    </div>
  </div>
  <div class="box-body">
				<table class="table">

<!-- ....................................INICIO DE PONER CAJAS DE BUSQUEDA CON ATRIBUTOS ............................................. -->   

 <!-- ENTRADA EN LA TABLA: DE RANGO DE FECHAS -->    	
				<tr>		
							
				<td>
         		  <div class="form-group">
                  <label for="areas">Área de enseñanza:</label>                
		                          <?php             
                          imprimirAreas();
                            ?>         				
                	</div>

				</td>

				<td>
         		  <div class="form-group">
                  <label for="areas">Estudios:</label>                
		                          <?php             
                          imprimirTitulos();
                            ?>         				
                	</div>

				</td>
				<td>
         		  <div class="form-group">
                  <label for="areas">Experiencia laboral (total de años mínimo):</label>                
		               <input type="number" class="form-control" name="experiencia" id="experiencia"  min="0">   				
                	</div>

				</td>

			<div id="errores"></div>
				</tr>
 			<!--******************** FIN DE RANCO DE FECHAS ***************-->  
  

				</table>

    </div>
				<td>
     
               	  <input type="hidden" name="vengoDeBusquedaAvanzada" value="">

			</td>
    		<div class="box-footer">
    			 <div class="form-group">
    			         <label>Máximo de registros que devolverá la búsqueda: (arrastre el botón para modificar el número)</label> 
           <input id="ex6" name="limiteResultados" type="text" data-slider-min="10" data-slider-max="300" data-slider-step="10" data-slider-value="50" data-slider-id='ex1Slider'/>
          <span id="ex6CurrentSliderValLabel">Número máximo de resultados que se mostrarán  para su búsqueda: <span id="ex6SliderVal">50</span>
          </span>

              </div>
                  <div class='text-center'>
	              	<div class="center btn-group">
	              		  <!-- <input type="reset" id="form_reset2" value="Reset Me - Click Only Once" /> -->
	              		
	              		    	<button type="reset" id="form_reset2" class="center-block btn  btn-danger btn-lg"><i class="icon-search"></i> <?php echo "Borrar los campos del formulario de búsqueda"; ?>
			               </button>	
			              			             
		              </div>


		            </div>

              </div>


  </div>
     <!-- Block buttons -->
          <div class="box">
           
            <div class="box-body">
              <button id="submit" type="submit" class="center-block btn  btn-primary btn-lg"><i class="fa fa-search"></i> <?php echo "Buscar"; ?>
			               </button>
            </div>
          </div>
          <!-- /.box -->
   
  </form>
<?php
 //////FIN MI CODIGO                 
//$this->contentContainerEnd();
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
	//echo "<script type='text/javascript' src='/styles/multisis-lte/plugins/resetearChosen.js'></script>";
	  echo "<script type='text/javascript' src='/styles/multisis-lte/plugins/bootstrap-slider/bootstrap-slider.js'></script>";
      echo "<script type='text/javascript' src='/styles/multisis-lte/plugins/bootstrap-slider/hacer.js'></script>"; //dibuja slider
		
		$this->htmlEndPage();
	} /* }}} */
}
?>
