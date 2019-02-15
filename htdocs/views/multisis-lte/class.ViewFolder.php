<?php
/**
 * Implementation of ViewFolder view
 *
 * @category   DMS
 * @package    SeedDMS
 * @license    GPL 2
 * @version    @version@
 * @author     Uwe Steinmann <uwe@steinmann.cx>
 * @copyright  Copyright (C) 2002-2005 Markus Westphal,
 *             2006-2008 Malcolm Cowe, 2010 Matteo Lucarelli,
 *             2010-2012 Uwe Steinmann
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
 * Class which outputs the html page for ViewFolder view
 *
 * @category   DMS
 * @package    SeedDMS
 * @author     Markus Westphal, Malcolm Cowe, Uwe Steinmann <uwe@steinmann.cx>
 * @copyright  Copyright (C) 2002-2005 Markus Westphal,
 *             2006-2008 Malcolm Cowe, 2010 Matteo Lucarelli,
 *             2010-2012 Uwe Steinmann
 * @version    Release: @package_version@
 */
class SeedDMS_View_ViewFolder extends SeedDMS_Bootstrap_Style {
	function getAccessModeText($defMode) { /* {{{ */
		switch($defMode) {
			case M_NONE:
				return getMLText("access_mode_none");
				break;
			case M_READ:
				return getMLText("access_mode_read");
				break;
			case M_READWRITE:
				return getMLText("access_mode_readwrite");
				break;
			case M_ALL:
				return getMLText("access_mode_all");
				break;
		}
	} /* }}} */
	
	function js() { /* {{{ */
		$user = $this->params['user'];
		$folder = $this->params['folder'];
		$orderby = $this->params['orderby'];
		$expandFolderTree = $this->params['expandFolderTree'];
		$enableDropUpload = $this->params['enableDropUpload'];
		header('Content-Type: application/javascript; charset=UTF-8');
		parent::jsTranslations(array('cancel', 'splash_move_document', 'confirm_move_document', 'move_document', 'splash_move_folder', 'confirm_move_folder', 'move_folder'));
		
?>

function folderSelected(id, name) {
	window.location = '../out/out.ViewFolder.php?folderid=' + id;
}





$(document).ajaxStart(function() { Pace.restart(); });
//  $('.ajax').click(function(){
//    $.ajax({url: '#', success: function(result){
//    $('.ajax-content').html('<hr>Ajax Request Completed !');
//  }});
//});

$(document).ready(function(){
	
	$('body').on('submit', '#form1', function(ev){
		if(!checkForm()) {
			ev.preventDefault();
		} else {
			$("#box-form1").append("<div class=\"overlay\"><i class=\"fa fa-refresh fa-spin\"></i></div>");
		}
	});

	$('body').on('submit', '#form2', function(ev){
		if(!checkForm2()){
			ev.preventDefault();
		} else {
			$("#box-form2").append("<div class=\"overlay\"><i class=\"fa fa-refresh fa-spin\"></i></div>");
		}
	});

	$("#form1").validate({
		invalidHandler: function(e, validator) {
			noty({
				text:  (validator.numberOfInvalids() == 1) ? "<?php printMLText("js_form_error");?>".replace('#', validator.numberOfInvalids()) : "<?php printMLText("js_form_errors");?>".replace('#', validator.numberOfInvalids()),
				type: 'error',
				dismissQueue: true,
				layout: 'topRight',
				theme: 'defaultTheme',
				timeout: 1500,
			});
		},
		messages: {
			name: "<?php printMLText("js_no_name");?>",
			comment: "<?php printMLText("js_no_comment");?>"
		},
	});

	$("#form2").validate({
		invalidHandler: function(e, validator) {
			noty({
				text:  (validator.numberOfInvalids() == 1) ? "<?php printMLText("js_form_error");?>".replace('#', validator.numberOfInvalids()) : "<?php printMLText("js_form_errors");?>".replace('#', validator.numberOfInvalids()),
				type: 'error',
				dismissQueue: true,
				layout: 'topRight',
				theme: 'defaultTheme',
				timeout: 1500,
			});
		},
		messages: {
			name: "<?php printMLText("js_no_name");?>",
			comment: "<?php printMLText("js_no_comment");?>",
			/*expdate: "<?php printMLText("js_no_expdate");?>",*/
			theuserfile: "<?php printMLText("js_no_file");?>",
		},
	});

	$("#add-folder").on("click", function(){
 		  $("#div-add-folder").show('slow');
  });

  $("#cancel-add-folder").on("click", function(){
 		  $("#div-add-folder").hide('slow');
  });

  $("#add-document").on("click", function(){
 		  $("#div-add-document").show('slow');
  });

  $(".cancel-add-document").on("click", function(){
 		  $("#div-add-document").hide('slow');
  });

  $(".move-doc-btn").on("click", function(ev){
  	id = $(ev.currentTarget).attr('rel');
 		$("#table-move-document-"+id).show('slow');
  });

  $(".cancel-doc-mv").on("click", function(ev){
  	id = $(ev.currentTarget).attr('rel');
 		$("#table-move-document-"+id).hide('slow');
  });

  $(".move-folder-btn").on("click", function(ev){
  	id = $(ev.currentTarget).attr('rel');
 		$("#table-move-folder-"+id).show('slow');
  });

  $(".cancel-folder-mv").on("click", function(ev){
  	id = $(ev.currentTarget).attr('rel');
 		$("#table-move-folder-"+id).hide('slow');
  });

  $("#btn-next-1").on("click", function()
  {
  	
  	$("#nav-tab-1").removeClass("active");
  	$("#nav-tab-2").addClass("active");
  	$('html, body').animate({scrollTop: 0}, 800);
  });

  $("#btn-next-2").on("click", function(){
  	$("#nav-tab-2").removeClass("active");
  	$("#nav-tab-3").addClass("active");
  	$('html, body').animate({scrollTop: 0}, 800);
  });

  /* ---- For document previews ---- */

  $(".preview-doc-btn").on("click", function(){
  	$("#div-add-folder").hide();
		$("#div-add-document").hide();
  	$("#folder-content").hide();

  	var docID = $(this).attr("id");
  	var version = $(this).attr("rel");
  	$("#doc-title").text($(this).attr("title"));
  	$("#document-previewer").show('slow');
  	$("#iframe-charger").attr("src","../pdfviewer/web/viewer.html?file=..%2F..%2Fop%2Fop.Download.php%3Fdocumentid%3D"+docID+"%26version%3D"+version);
  });

  $(".close-doc-preview").on("click", function(){
  	$("#document-previewer").hide();
  	$("#iframe-charger").attr("src","");
  	$("#folder-content").show('slow');
  });
  
  /* ---- For datatables ---- */
	$(function () {
    $('#viewfolder-table').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": true,
      "ordering": false,
      "info": false,
      "autoWidth": true
    });
  });

});
<?php
		if ($enableDropUpload && $folder->getAccessMode($user) >= M_READWRITE) {
			echo "SeedDMSUpload.setUrl('../op/op.Ajax.php');";
			echo "SeedDMSUpload.setAbortBtnLabel('".getMLText("cancel")."');";
			echo "SeedDMSUpload.setEditBtnLabel('".getMLText("edit_document_props")."');";
			echo "SeedDMSUpload.setMaxFileSize(".SeedDMS_Core_File::parse_filesize(ini_get("upload_max_filesize")).");";
			echo "SeedDMSUpload.setMaxFileSizeMsg('".getMLText("uploading_maxsize")."');";
		}
		$this->printDeleteFolderButtonJs();
		$this->printDeleteDocumentButtonJs();
		$this->printKeywordChooserJs("form2");
		$this->printFolderChooserJs("form3");
		$this->printFolderChooserJs("form4");
	} /* }}} */

	function show() { /* {{{ */
		$dms = $this->params['dms'];
		$user = $this->params['user'];
		$folder = $this->params['folder'];
		$orderby = $this->params['orderby'];
    $baseServer=$this->params['settings']->_httpRoot;
		$enableFolderTree = $this->params['enableFolderTree'];
		$enableClipboard = $this->params['enableclipboard'];
		$enableDropUpload = $this->params['enableDropUpload'];
		$expandFolderTree = $this->params['expandFolderTree'];
		$showtree = $this->params['showtree'];
		$cachedir = $this->params['cachedir'];
		$workflowmode = $this->params['workflowmode'];
		$enableRecursiveCount = $this->params['enableRecursiveCount'];
		$maxRecursiveCount = $this->params['maxRecursiveCount'];
		$previewwidth = $this->params['previewWidthList'];
		$timeout = $this->params['timeout'];
     $rutaModificar=$baseServer."out/out.ModificarPerfil.php";
		$folderid = $folder->getId();
		$db = $dms->getDB();
		$limite=8; //limite de los que se muestran en la tanblita últimos n postulantes
		$this->htmlAddHeader('<link href="../styles/'.$this->theme.'/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">'."\n", 'css');
		$this->htmlAddHeader('<script type="text/javascript" src="../styles/'.$this->theme.'/plugins/datatables/jquery.dataTables.min.js"></script>'."\n", 'js');
		$this->htmlAddHeader('<script type="text/javascript" src="../styles/'.$this->theme.'/plugins/datatables/dataTables.bootstrap.min.js"></script>'."\n", 'js');
		$this->htmlAddHeader('<script type="text/javascript" src="../styles/'.$this->theme.'/validate/jquery.validate.js"></script>'."\n", 'js');
		
		echo $this->callHook('startPage');
		if($user->isAdmin())
		{
			$this->htmlStartPage("Página de inicio de ".htmlspecialchars($folder->getName()), "skin-blue sidebar-mini sidebar-collapse");
		}
		else
		{
			$this->htmlStartPage("Página de inicio de ".htmlspecialchars($folder->getName()), "skin-blue layout-top-nav");
		}
		
		$this->containerStart();
		$this->mainHeader();
		if($user->isAdmin())
		{
			$this->mainSideBar($folder->getID(),0,0);
		}
		
		$previewer = new SeedDMS_Preview_Previewer($cachedir, $previewwidth, $timeout);
		echo $this->callHook('preContent');
		$this->contentStart();
    echo '<div class="row text-center">';
    echo '<div class="col-xs-12 col-sm-6">';
    echo '<br>';
     echo "<img src=\"".$baseServer."images/escudoarmas.png\" class=\"img-responsive center-block\" alt=\"Logo ESA\" height=\"100\" width=\"100\">";

      echo '</div>'; //cierre col 4


      // echo '<div class="col-xs-12 col-sm-4">';
      // echo '<br>';
      // echo "<img src=\"".$baseServer."images/logoStpp.png\" class=\"center-block\" alt=\"Logo STPP\" height=\"95\" width=\"200\">";
      // echo '</div>'; //cierre col 4


       echo '<div class="col-xs-12 col-sm-6">';
       echo '<br>';
    echo "<img src=\"".$baseServer."images/logo_transparente.png\" class=\"img-responsive center-block\" alt=\"Logo ENAFOP\" height=\"200\" width=\"200\">";
    echo '</div>'; //cierre col 4
    echo '</div>'; //cierre de row


		?>
    <div class="gap-10"></div>
    <div class="row">
    <div class="col-md-12">
    <?php	
     //echo $this->getFolderPathHTML($folder);
     if($user->isAdmin())
     {
     	$this->startBoxPrimary("Panel de control gestión de postulaciones");
     	
     			
     }
     else
     {
     	$this->startBoxPrimary("Gestión de docentes de la ENAFOP: Inicio");
     }

     $this->contentContainerStart();
     //////INICIO MI CODIGO 2 GRANDES SECCIONES: POSTULANTES Y ADMINISTRADORES
     if($user->isAdmin())
     {
     	$numeroPostulaciones=$user->cuentaPostulaciones();
     	$numeroPostulados=$user->getPostulacionesEstado("postulado");
     	$numeroAprobados=$user->getPostulacionesEstado("aprobado");
     	$numeroRechazados=$user->getPostulacionesEstado("rechazado");
      $numeroRevisados=$user->getPostulacionesEstado("revisado");
     	//echo "Numero de postulaciones: ".$numeroPostulaciones;

     	?>
     		<section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
       <div class="col-lg-1 col-xs-6"> <!-- inicio col vacio para que lsita de revisados quede enmedio-->
         </div>
        <div class="col-lg-2 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3>
              	<?php 
              echo $numeroPostulaciones;  
              ?> 
             </h3>

              <p><?php 
              echo getMLText("totales");  
              ?></p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-bookmarks-outline"></i>
            </div>
            <a href="#" class="small-box-footer">De usuarios registrados en el mismo</a>
          </div>
        </div>
         <!-- ./col -->
        <div class="col-lg-2 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3>
                <?php 
              echo $numeroPostulados;  
              ?> 
              </h3>

              <p> <?php 
              echo getMLText("en_evaluacion");  
              ?> </p>
            </div>
            <div class="icon">
              <i class="ion ion-person"></i>
            </div>
            <a <?php echo "href=\"".$baseServer."out/out.ListaPostulantes.php?estado=postulado\""?> class="small-box-footer">Ver lista de postulantes en evaluación<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <!-- ./col -->
        <div class="col-lg-2 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>
              	<?php 
              echo $numeroAprobados;  
              ?> 
              	<sup style="font-size: 20px"></sup></h3>

              <p><?php 
              echo getMLText("aprobados");  
              ?></p>
            </div>
            <div class="icon">
              <i class="ion ion-checkmark-circled"></i>
            </div>
            <a <?php echo "href=\"".$baseServer."out/out.ListaPostulantes.php?estado=aprobado\""?> 
         class="small-box-footer">Ver la lista de aprobados<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-2 col-xs-6">  <!-- inicio lista de revisados-->
         
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>
                <?php 
              echo $numeroRevisados;  
              ?> 
             </h3>

              <p><?php 
              echo getMLText("revisados");  
              ?></p>
            </div>
            <div class="icon">
              <i class="ion ion-information-circled"></i>
            </div>

            <a <?php echo "href=\"".$baseServer."out/out.ListaPostulantes.php?estado=revisado\""?>  class="small-box-footer">Ver lista de solicitudes en revisión<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
       
        <div class="col-lg-2 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php 
              echo $numeroRechazados;  
              ?> </h3>

              <p><?php 
              echo getMLText("no_aprobadas");  
              ?></p>
            </div>
            <div class="icon">
              <i class="ion ion-close-circled"></i>
            </div>

            <a <?php echo "href=\"".$baseServer."out/out.ListaPostulantes.php?estado=rechazado\""?> class="small-box-footer">Ver lista de solicitudes no aprobadas<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        

        
      </div>
      <!-- /.row -->
            <!-- /COMIENZA: 3 COL CON UNA LLENA EN MEDIO -->
      <div class="row">
      <div class="col-md-4">

      </div>

      <div class="col-md-4">
       
      </div>

      <div class="col-md-4">
         <div class="info-box bg-gray">
            <span class="info-box-icon"><i class="fa fa-search"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">ENAFOP</span>

               <span class="info-box-number">
               <a <?php echo "href=\"".$baseServer."out/out.Buscador.php\""?>>Acceder al buscador de docentes</a>
               </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->

      </div>
        </div>
      <!-- /TERMINA: 3 COL CON UNA LLENA EN MEDIO -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
                 <div class="box box-default">
                <div class="box-header with-border">
                  <h3 class="box-title">Últimos postulantes</h3>

                  <div class="box-tools pull-right">
                    <span class="label label-primary">8 últimos postulantes</span>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <ul class="users-list clearfix">
                    <?php
                     $consultar="SELECT idpostulante,fecha FROM postulaciones WHERE estado=\"postulado\"  ORDER BY fecha DESC";
                     //echo "Consultar: ".$consultar;
          $res1 = $db->getResultArray($consultar);
          $contador=0;
          if($res1)
          {
            foreach ($res1 as $key) 
            {
              if($contador==$limite)
              {
                break;
              }
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
                
                     echo '<li>';
                   
                      $fotoUsuario=$user->getFotoPostulante($idpostulante,$baseServer); 
              if($fotoUsuario==false)
              {
                 echo '<img class="img-circle" src="'.$baseServer.'styles/multisis-lte/dist/img/persona.png" width="50" height="50" alt="avatar postulante">';
              }
              else
              {
                echo "<img class=\"img-circle\" src=$fotoUsuario width=\"50\" height=\"50\" alt=\"avatar postulante\">";
              }


                      echo "<a class=\"users-list-name\"href=\"".$baseServer."out/out.VerPostulacion.php?postulante=$idpostulante\">$nombreFull</a>";
                      echo "<span class=\"users-list-date\">$dia/$mes/$ano</span>";
                    echo '</li>';
                    
                      $contador++;
                        } //fin bucle imprimir ultimos 8
                    }
                    ?>
                  </ul>
                  <!-- /.users-list -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">
                  <p>Ordenados desde el más nuevo</p>
                </div>
                <!-- /.box-footer -->
              </div>
     

        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable">

          <!-- Map box -->
      <!-- MAP & BOX PANE -->
        <div class="box box-default">
                <div class="box-header with-border">
                  <h3 class="box-title">Últimas modificaciones a perfiles</h3>

                  <div class="box-tools pull-right">
                    <span class="label label-primary">8 últimos cambios</span>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <ul class="users-list clearfix">
                  	<?php
                    //Obtenog cambios
             $consultarCambios="SELECT idpostulacion FROM historial  WHERE comentario LIKE 'Cambios%' OR  comentario LIKE 'Añadido%' OR  comentario LIKE 'Cambió%' OR  comentario LIKE'Se eliminó%'  ORDER by FECHA DESC";
              $idpostu=array();
              $resnov = $db->getResultArray($consultarCambios);
              foreach ($resnov as $cambio) 
              {
                $idpostu[]=$cambio['idpostulacion'];
              }
              $idpostu=array_unique($idpostu);
              $arrayIDPostulantes=array();
              foreach ($idpostu as $ids) 
              {
              $damePerson="SELECT idpostulante FROM postulaciones  WHERE id = $ids";
                $resnov2 = $db->getResultArray($damePerson);
              $quiero=$resnov2[0]['idpostulante'];
              $arrayIDPostulantes[]=$quiero;
              }


					$contador=0;
	         //$arrayIDPostulantes=array_reverse($arrayIDPostulantes);// le doy vuelta al array para que me den los últimos cambios
						foreach ($arrayIDPostulantes as $key) 
						{

							if($contador==$limite)
							{
								break;
							}
              $consultarOtraVez="SELECT idpostulante,fecha FROM postulaciones WHERE idpostulante=$key";
              $resnov3 = $db->getResultArray($consultarOtraVez);

							$idpostulante=$resnov3[0]['idpostulante'];
							$fecha=$resnov3[0]['fecha'];
							$tmp=explode(" ", $fecha);
							$soloDate=$tmp[0];
							$trozos=explode("-", $soloDate);
							$ano=$trozos[0];
							$mes=$trozos[1]; $dia=$trozos[2];

							$consultar2="SELECT nombre  FROM datosgenerales WHERE idpostulante=$idpostulante";
							$res2 = $db->getResultArray($consultar2);
							$nombreFull=$res2[0]['nombre'];
                // if($contador==0 || $contador==3)
                //      {
                //         echo '<div class="row">';
                //      }
                     echo '<li>';
                              $fotoUsuario=$user->getFotoPostulante($idpostulante,$baseServer); 
                              //echo "foto usuariuo: ".$fotoUsuario;
              if($fotoUsuario==false)
              {
                 echo '<img class="img-circle" src="'.$baseServer.'styles/multisis-lte/dist/img/persona.png" width="50" height="50" alt="avatar postulante">';
              }

                      echo "<a class=\"users-list-name\"href=\"".$baseServer."out/out.VerPostulacion.php?postulante=$idpostulante\">$nombreFull</a>";
                      echo "<span class=\"users-list-date\">$dia/$mes/$ano</span>";
                    echo '</li>';
                   
                    	$contador++;
              } //fin bucle imprimir ultimos 8 cmabiadors
                  	?>
                  </ul>
                  <!-- /.users-list -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">
                  <p>Ordenados desde el cambio más reciente</p>
                </div>
                <!-- /.box-footer -->
              </div>
              <!--/.box -->
          <!-- /.box -->


        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->


    </section>

     	<?php
     }//FIN SECCION ADMIN
     //////////////////////////////////////////////////////////////////////////
     if(!$user->isAdmin() && !$user->isGuest()) //postulantes
     {
     	?>

      <div class="row"> <!-- /INICIA WIDGET RESUMEN PERFIL -->
        <!-- /INICIA col de 4 vacio para hacer esqueleto -->
        <div class="col-md-4">
        </div>
<!-- /INICIA col de 4 donde van datos -->
      <div class="col-md-4">

          <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-navy"  center center;">
              <h3 class="widget-user-username"><?php echo $user->getFullName(); ?></h3>
              <h5 class="widget-user-desc"> <?php echo $user->getEmail();?> </h5>
            </div>
            <div class="widget-user-image">
              <img class="img-circle" <?php echo "src=\"".$baseServer."images/usuario.png" ?>  alt="User Avatar">
            </div>
            <div class="box-footer">
              <div class="row">


                <!-- /.col -->

                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
<!-- /INICIA col de 4 vacio para hacer esqueleto -->
        <div class="col-md-4">
        </div>

      </div> <!-- /TERMINA: ROW DE WIDGET RESUMEN PERFIL -->




     		<div class="row"> <!-- /INICIA ROW QUE LLEVA CARROUSEL Y ESTADO -->



          <div class="col-md-6">
              <div class="box box-solid">
            
            <!-- /.box-header -->
            <div class="box-body">
              <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                  <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                  <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
                  <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
                </ol>
                <div class="carousel-inner">
                  <div class="item active">
                    <img <?php echo "src=\"".$baseServer."images/slide/Diapositiva1.JPG" ?>"  width="1400" height="200" alt="First slide">

                    <div class="carousel-caption">
                      Primera lámina
                    </div>
                  </div>
                  <div class="item">
                    <img <?php echo "src=\"".$baseServer."images/slide/Diapositiva2.JPG" ?>" width="1400" height="200" alt="Second slide">

                    <div class="carousel-caption">
                      Segunda lámina
                    </div>
                  </div>
                  <div class="item">
                    <img <?php echo "src=\"".$baseServer."images/slide/Diapositiva3.JPG" ?>" width="1400" height="200" alt="Third slide">

                    <div class="carousel-caption">
                      Tercera lámina
                    </div>
                  </div>
                   <div class="item">
                    <img <?php echo "src=\"".$baseServer."images/slide/Diapositiva4.JPG" ?>" width="1400" height="200" alt="Third slide">

                    <div class="carousel-caption">
                      Cuarta lámina
                    </div>
                  </div>
                   <div class="item">
                    <img <?php echo "src=\"".$baseServer."images/slide/Diapositiva5.JPG" ?>" width="1400" height="200" alt="Third slide">

                    <div class="carousel-caption">
                      Quinta lámina
                    </div>
                  </div>
                   <div class="item">
                    <img <?php echo "src=\"".$baseServer."images/slide/Diapositiva6.JPG" ?>" width="1400" height="200" alt="Third slide">

                    <div class="carousel-caption">
                      Sexta lámina
                    </div>
                  </div>
                  <div class="item">
                    <img <?php echo "src=\"".$baseServer."images/slide/Diapositiva7.JPG" ?>" width="1400" height="200" alt="Third slide">

                    <div class="carousel-caption">
                      Séptima y última lámina
                    </div>
                  </div>
                </div>
                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                  <span class="fa fa-angle-left"></span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                  <span class="fa fa-angle-right"></span>
                </a>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          </div>






          <div class="col-md-6">
                    <?php
      $estado=$user->getEstadoPostulacion();

      
     if(strcmp($estado, "")==0)
     {
      echo '<div class="callout callout-warning">';
                echo '<h4>Estado de mi postulación: aplicación no realizada</h4>';

                //echo '<p>Rellene el formulario y envíe su postulación con el enlace siguiente:</p>';
          echo '</div>';
      $rutaFormulario=$baseServer."out/out.FormularioAplicacion.php";
 

        echo '<div class="small-box bg-primary">';
             echo '<div class="inner">';
               echo '<h3>Llene su formulario</h3>';

              echo '<p>Por favor, prepare todos los atestados digitales para los documentos que acrediten su formación académica, experiencia laboral y formativa, etc; para su inclusión en el formulario</p>';
             echo '</div>';
             echo '<div class="icon">';
               echo '<i class="fa fa-pencil-square-o "></i>';
             echo '</div>';
            echo "<a href=\" $rutaFormulario\" class=\"small-box-footer\">";
              echo 'Acceder a llenar el formulario <i class="fa fa-arrow-circle-right"></i>';
             echo '</a>';
           echo '</div>';
     }
     else
      if(strcmp($estado, "postulado")==0)
      {
        echo '<div class="callout callout-info">';
                echo '<h4>Estado de mi postulación: en evaluación</h4>';

                //echo '<p>Si desea modificar su postulación y los datos adjuntos a la misma, haga click en el enlace siguiente:</p>';
          echo '</div>';
      $rutaFormulario=$baseServer."/out/out.FormularioAplicacion.php";
      echo '<div class="small-box bg-primary">';
             echo '<div class="inner">';
               echo '<h3>Modificar mi perfil</h3>';
              //echo '<p>Su postulación aún se encuentra en evaluación, pero puede modificar su perfil si lo requiere</p>';
             echo '</div>';
             echo '<div class="icon">';
               echo '<i class="fa fa-pencil-square-o "></i>';
             echo '</div>';
            echo "<a href=\" $rutaModificar\" class=\"small-box-footer\">";
              echo 'Acceder a modificar mi perfil <i class="fa fa-arrow-circle-right"></i>';
             echo '</a>';
           echo '</div>';

                 echo '<div class="small-box bg-gray">';
             echo '<div class="inner">';
               echo '<h3>Ver mi perfil</h3>';
               $id=$user->getID();
               $rutaPerfil=$baseServer."/out/out.VerPostulacion.php?postulante=".$id;
              echo '<p>En el siguiente enlace puede ver un consolidado de su perfil</p>';
             echo '</div>';
             echo '<div class="icon">';
               echo '<i class="fa fa-address-book-o "></i>';
             echo '</div>';
            echo "<a href=\" $rutaPerfil\" class=\"small-box-footer\">";
              echo 'Acceder a  ver mi perfil<i class="fa fa-arrow-circle-right"></i>';
             echo '</a>';
           echo '</div>';
      }
      if(strcmp($estado, "aprobado")==0)
      {
        echo '<div class="callout callout-success">';
                echo '<h4>Estado de mi postulación: aprobado</h4>';

                //echo '<p>Si desea modificar su perfil y los datos adjuntos a la misma, haga click en el enlace siguiente:</p>';
          echo '</div>';
     
      echo '<div class="small-box bg-primary">';
             echo '<div class="inner">';
               echo '<h3>Modificar mi perfil</h3>';

              //echo '<p>Usted es un docente aprobado, pero puede modificar su perfil.</p>';
             echo '</div>';
             echo '<div class="icon">';
               echo '<i class="fa fa-pencil-square-o "></i>';
             echo '</div>';
            echo "<a href=\" $rutaModificar\" class=\"small-box-footer\">";
              echo 'Acceder a modificar mi perfil<i class="fa fa-arrow-circle-right"></i>';
             echo '</a>';
           echo '</div>';

            echo '<div class="small-box bg-gray">';
             echo '<div class="inner">';
               echo '<h3>Ver mi perfil</h3>';
               $id=$user->getID();
               $rutaPerfil=$baseServer."/out/out.VerPostulacion.php?postulante=".$id;
              echo '<p>En el siguiente enlace puede ver un consolidado de su perfil</p>';
             echo '</div>';
             echo '<div class="icon">';
               echo '<i class="fa fa-address-book-o "></i>';
             echo '</div>';
            echo "<a href=\" $rutaPerfil\" class=\"small-box-footer\">";
              echo 'Acceder a ver mi perfil<i class="fa fa-arrow-circle-right"></i>';
             echo '</a>';
           echo '</div>';


      }
       if(strcmp($estado, "revisado")==0)
      {
        echo '<div class="callout callout-info">';
                echo '<h4>Estado de mi postulación: en revisión (se ha solicitado una nueva revisión después de subsanar incidencias en la postulación original)</h4>';

                //echo '<p>Si desea modificar su postulación y los datos adjuntos a la misma, haga click en el enlace siguiente:</p>';
          echo '</div>';
      $rutaFormulario=$baseServer."/out/out.FormularioAplicacion.php";
      echo '<div class="small-box bg-primary">';
             echo '<div class="inner">';
               echo '<h3>Modificar mi perfil</h3>';

              //echo '<p>Su postulación aún se encuentra en evaluación, pero puede modificar su perfil si lo requiere</p>';
             echo '</div>';
             echo '<div class="icon">';
               echo '<i class="fa fa-pencil-square-o "></i>';
             echo '</div>';
            echo "<a href=\" $rutaModificar\" class=\"small-box-footer\">";
              echo 'Acceder a modificar mi perfil <i class="fa fa-arrow-circle-right"></i>';
             echo '</a>';
           echo '</div>';

                 echo '<div class="small-box bg-gray">';
             echo '<div class="inner">';
               echo '<h3>Ver mi perfil</h3>';
               $id=$user->getID();
               $rutaPerfil=$baseServer."/out/out.VerPostulacion.php?postulante=".$id;
              echo '<p>En el siguiente enlace puede ver un consolidado de su perfil</p>';
             echo '</div>';
             echo '<div class="icon">';
               echo '<i class="fa fa-address-book-o "></i>';
             echo '</div>';
            echo "<a href=\" $rutaPerfil\" class=\"small-box-footer\">";
              echo 'Acceder a ver mi perfil<i class="fa fa-arrow-circle-right"></i>';
             echo '</a>';
           echo '</div>';
      }
      if(strcmp($estado, "rechazado")==0)
      {
        echo '<div class="callout callout-danger">';
                echo '<h4>Estado de mi postulación: no aprobada</h4>';

                //echo '<p>Si desea modificar su postulación y los datos adjuntos a la misma, haga click en el enlace siguiente:</p>';
          echo '</div>';
      $rutaFormulario=$baseServer."/out/out.FormularioAplicacion.php";
      echo '<div class="small-box bg-primary">';
             echo '<div class="inner">';
               echo '<h3>Modificar mi perfil</h3>';
              //echo '<p>Su postulación no fue aprobada. Pero puede modificar su perfil utilzando la función "Editar perfil" para mejorar su postulación a medidad que adquiera formación y experiencia</p>';
             echo '</div>';
             echo '<div class="icon">';
               echo '<i class="fa fa-pencil-square-o "></i>';
             echo '</div>';
            echo "<a href=\" $rutaModificar\" class=\"small-box-footer\">";
              echo 'Acceder a modificar mi perfil <i class="fa fa-arrow-circle-right"></i>';
             echo '</a>';
           echo '</div>';

                 echo '<div class="small-box bg-gray">';
             echo '<div class="inner">';
               echo '<h3>Ver mi perfil</h3>';
               $id=$user->getID();
               $rutaPerfil=$baseServer."/out/out.VerPostulacion.php?postulante=".$id;
              echo '<p>En el siguiente enlace puede ver un consolidado de su perfil</p>';
             echo '</div>';
             echo '<div class="icon">';
               echo '<i class="fa fa-address-book-o "></i>';
             echo '</div>';
            echo "<a href=\" $rutaPerfil\" class=\"small-box-footer\">";
              echo 'Acceder a ver mi perfil<i class="fa fa-arrow-circle-right"></i>';
             echo '</a>';
           echo '</div>';
      }

     ?>
          </div>



        </div>

  <!--       <div class="row">
          <div class="col-md-6">
                <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <h4><i class="icon fa fa-warning"></i> ¡Atención!</h4>
            Si tiene alguna consulta relacionado con el proceso de postulación o el uso del sistema, favor diríjase a la dirección de correo electrónico  <a href="mailto:enafop@presidencia.gob.sv?Subject=Consulta%Formulario%Docentes">enafop@presidencia.gob.sv</a>
              </div>
          </div>

           <div class="col-md-6">
          </div>
        </div> -->




<?php
     }// FIN SECCION POSTULANTES

     ?>

     <?php 
	 if($user->isGuest())
   {
    ?>
<div class="row">
  <div class="col-md-6">
    <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i>Bienvenido al buscador de docentes de la ENAFOP</h4>
                Usted puede utilizar las funciones del buscador de docentes, accediendo al enlace que se muestra a continuación:
              </div>
    </div>
 <div class="col-md-6">
<div class="info-box bg-default">
            <span class="info-box-icon"><i class="fa fa-search"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">ENAFOP</span>
               <span class="info-box-number"><a href="/out/out.Buscador.php">Acceder al buscador</a></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
</div>
        </div> <!-- /.fin-row -->
    <?php 
        }
    ?>
   
<?php 
//FIN MI CAJA CODIGO
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
// 		echo '<script src="/styles/multisis-lte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>';
// 		echo '<script src="/styles/multisis-lte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>';
// 		echo '<script type="text/javascript" src="/styles/'.$this->theme.'/dist/js/pages/dashboard2.js"></script>'."\n";
// 		echo '<script type="text/javascript" src="/styles/'.$this->theme.'/dist/js/demo.js"></script>'."\n";
// 		echo '<script type="text/javascript" src="/styles/'.$this->theme.'/dist/js/adminlte.min.js"></script>'."\n";
// echo '<script type="text/javascript" src="/styles/'.$this->theme.'/bower_components/jquery/dist/jquery.min.js"></script>'."\n";
		$this->htmlEndPage();
	} /* }}} */
}

?>
