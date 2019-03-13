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
 function pasarDMY($ymd)
 {
//Convert it into a timestamp.
$timestamp = strtotime($ymd);
 
$dmy = date("d-m-Y", $timestamp);
return $dmy;
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
 function getIdPostulacion($idPostulante,$db)
{
	$miQuery="SELECT id FROM postulaciones WHERE idpostulante=$idPostulante;";
	$resultado=$db->getResultArray($miQuery);
	return $resultado[0]['id'];
}
function imprimirTemasManejados($idpostulante,$db)
{	
		//query de consulta:
	 $arrayTablas=array("temas_abierto","temas_calidad","temas_capacitacion","temas_electronico","temas_enfoque","temas_etica","temas_gerencia","temas_gobierno","temas_planificacion","temas_relaciones","temas_talento");

	 $arrayTitulos=array("Gobierno abierto y participación ciudadana","Gestión de calidad en el sector público","Gestión de capacitación en el sector público","Gobierno electrónico","Enfoque de derechos en la gestión pública","Ética y transparencia en la gestión pública","Gerencia pública","Gobierno y territorio","Planificación para el desarrollo","Relaciones laborales en el sector público","Gestión del talento humano por competencias en el sector público");
		for($i=0;$i<count($arrayTablas);$i++)
		{
			$nom=$arrayTablas[$i];
			$consultar1="SELECT nombretema FROM $nom WHERE idpostulante=$idpostulante;";
			$res1 = $db->getResultArray($consultar1);
			if(count($res1)!=0)//no tiene temas
			{
				$titulo=$arrayTitulos[$i];
				echo "<p>$titulo</p>";
				foreach ($res1 as $resultado) 
				{
					$tema=$resultado['nombretema'];
	   				 echo "<small>$tema</small>";
				}
			}
		}//fin bucle
}
function imprimeMetodologias($idpostulante,$db)
{	
		//query de consulta:
	 $arrayTablas=array("metodologias_disenocartas","metodologias_elaboracion","metodologias_evaluacion","metodologias_facilitacion","metodologias_linea","metodologias_participativa","metodologias_programas");

	 $arrayTitulos=array("Diseño de cartas didácticas (diseños instruccionales)","Elaboración de material de apoyo (manuales, guías, lecturas. Cuáles)","Evaluación de procesos de formación (en cuales procesos, metodología)","Facilitación de talleres o cursos de formación o capacitación (cuáles)","Metodologías en línea (si es diseñador instruccional, contenidista o solo tutor)","Metodologías participativas (cuáles)"," Diseño de programas y/o proyectos de formación y/o capacitación (curricular)");
		for($i=0;$i<count($arrayTablas);$i++)
		{
			$nom=$arrayTablas[$i];
			$consultar1="SELECT experiencia,idatestado FROM $nom WHERE idpostulante=$idpostulante;";
			$res1 = $db->getResultArray($consultar1);
			if(count($res1)!=0)//no tiene temas
			{
				$titulo=$arrayTitulos[$i];
				echo "<p>$titulo</p>";
				foreach ($res1 as $resultado) 
				{
					$tema=$resultado['experiencia'];
					$idatestado=$resultado['idatestado'];
	   				 echo "<small><a href=\"out.ViewDocument.php?documentid=$idatestado\">$tema</a></small>";
				}
			}
		}//fin bucle
}
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
	   				 //echo "<small><a href=\"out.ViewDocument.php?documentid=$idcarta\">$titulo</a></small>";
	   			echo "<li><a href=\"out.ViewDocument.php?documentid=$iddoc\">$titulo<span class=\"pull-right badge bg-aqua\">ADJUNTO</span></a></li>";
				
			}
		}//fin bucle
		
               
}

class SeedDMS_View_VerPostulacion extends SeedDMS_Bootstrap_Style 
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
		$idpostulante = $this->params['idpostulante'];
		$nombre = $this->params['nombre'];
		$pais = $this->params['pais'];
		$tipodocumento = $this->params['tipodocumento'];
		$numerodocumento = $this->params['numerodocumento'];
		$nit = $this->params['nit'];
		$telefono = $this->params['telefono'];
		$correo = $this->params['correo'];
		$departamento = $this->params['departamento'];
		$municipio = $this->params['municipio'];
		$estadoPostulacion = $this->params['estadoPostulacion'];
		$baseServer=$this->params['settings']->_httpRoot;
		$genero = $this->params['genero'];
		$nombreUsuario = $this->params['nombreUsuario'];
		$postulantePublico = $this->params['postulantePublico'];
		$edad = $this->params['edad'];
	
		$anosLaborales = $this->params['anosLaborales'];
		$anosDocencia = $this->params['anosDocencia'];
		$anosCapacitacion = $this->params['anosCapacitacion'];
	
		$db = $dms->getDB();
		$previewer = new SeedDMS_Preview_Previewer($cachedir, $previewwidth, $timeout);
		//$ruta_pagina_salida="..out.CaducaranPronto.php";

		echo $this->callHook('startPage');
		if($user->isAdmin())
		{
			$this->htmlStartPage("Ver postulación de $nombre", "skin-blue sidebar-mini sidebar-collapse");
		}
		else
		{
			$this->htmlStartPage("Ver postulación de $nombre", "skin-blue layout-top-nav");
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
		<style>
		@media print
			{    
			    .no-print, .no-print *
			    {
			        display: none !important;
			    }
			}

		</style>
    <div class="gap-10"></div>
    <div class="row">
    <div class="col-md-12">
   <section class="content-header">
      <h1>
        Perfil
        <small>del postulante</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="out.ViewFolder.php?folderid=1"><i class="fa fa-home"></i>Inicio</a></li>
        <li class="active">ver perfil</li>
      </ol>
    </section>

   <?php
    //en este bloque php va "mi" código 
 $this->startBoxPrimary("Consolidado del perfil");
//$this->contentContainerStart();
//////INICIO MI CODIGO
?>

 <div class="col-md-4">
 	<?php 
 	//seccion reservada para si es administrador, botones para aprobar o rechazar

  		if($user->isAdmin())
  		{
  			if(strcmp($estadoPostulacion, "rechazado")==0)
		  	{
		  		echo "Postulante rechazado";
		  	}
	  		if(strcmp($estadoPostulacion, "postulado")==0 || strcmp($estadoPostulacion, "revisado")==0)
		  	{
		  	echo '<form name="formAprueba" id="formAprueba" action="out.DecidirPostulante.php" method="POST">';
		          ////////////////////////////// APROBAR
		       echo "<input type=\"hidden\" name=\"idPostulante\" id=\"idPostulante\" value=\"$idpostulante\"></input>";
		       echo "<input type=\"hidden\" name=\"nombrePostulante\" id=\"nombrePostulante\" value=\"$nombre\"></input>";
		  		echo '<div class="info-box no-print"> <span class="info-box-icon bg-green"><i class="fa fa-check"></i></span><div class="info-box-content">';
	            
	            echo '<button type="submit" name="botonAprobar" id="botonAprobar" class="btn btn-block btn-success btn-lg">Aprobar postulante</button>';
	           echo' </div></div>';
	           
	           /////////////////////////////////RECHAZAR
	           echo '<div class="info-box no-print"> <span class="info-box-icon bg-red"><i class="fa fa-close"></i></span><div class="info-box-content">';

	            echo '<button type="submit" name="botonRechazar" id="botonRechazar" class="btn btn-block btn-danger btn-lg">Rechazar postulante</button>';

	            // echo "<a href=\"out.DecidirPostulante.php?postulante=$idpostulante\"><span class=\"info-box-number\">Rechazar postulante</span></a>";
	           echo' </div></div>';
	           echo "</form>";
		  	}
		  	if(strcmp($estadoPostulacion, "rechazado")==0)
		  	{
		  	echo '<form name="formAprueba" id="formAprueba" action="out.DecidirPostulante.php" method="POST">';
		          ////////////////////////////// ESTANDO RECHAZADO, NO ME PUEDEN VOLER A RECHAZAR, PERO SI APROBAR
		       echo "<input type=\"hidden\" name=\"idPostulante\" id=\"idPostulante\" value=\"$idpostulante\"></input>";
		       echo "<input type=\"hidden\" name=\"nombrePostulante\" id=\"nombrePostulante\" value=\"$nombre\"></input>";
		  		echo '<div class="info-box"> <span class="info-box-icon bg-green"><i class="fa fa-check"></i></span><div class="info-box-content">';
	            
	            echo '<button type="submit" name="botonAprobar" id="botonAprobar" class="btn btn-block btn-success btn-lg">Aprobar postulante</button>';
	           echo' </div></div>';
	           echo "</form>";
		  	}
		  	$folderPostulante=getDefaultUserFolder($idpostulante);
		  	echo '<div class="info-box no-print">';
            echo '<span class="info-box-icon bg-yellow"><i class="fa fa-files-o"></i></span>';

            echo '<div class="info-box-content">';
              echo '<span class="info-box-text">Adjuntos</span>';
              	echo "<a href=\"out.VerArchivos.php?folderid=$folderPostulante\">Ver carpeta con documentos adjuntos</a>";
            echo '</div>';

         echo '</div>';
		  

  		}
  		$esEl=false;
  		$idChat=$user->getChatID($idpostulante);
  		$estaVacio=$user->estaChatVacio($idChat); 
  		$haPedidoRevision=$user->pedidoRevision($idpostulante); 
   		if($user->getID()==$idpostulante)
   		{
   			$esEl=true;
   		}

  		if($esEl==true && !$estaVacio && !$haPedidoRevision)
  		{
  			$idPostulacion=getIdPostulacion($idpostulante,$db);
  			echo '<form name="formAprueba" id="formAprueba" action="../ponerEnRevision.php" method="POST">';
		          ////////////////////////////// ESTANDO RECHAZADO, NO ME PUEDEN VOLER A RECHAZAR, PERO SI APROBAR
		       echo "<input type=\"hidden\" name=\"idPostulante\" id=\"idPostulante\" value=\"$idpostulante\"></input>";
		        echo "<input type=\"hidden\" name=\"idPostulacion\" id=\"idPostulacion\" value=\"$idPostulacion\"></input>";
		  		echo '<div class="info-box no-print"> <span class="info-box-icon bg-yellow"><i class="fa fa-info-circle"></i></span><div class="info-box-content">';
	            
	            echo '<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-warning">
                Solicitar una nueva revisión</button>';
	           echo' </div></div>';
	              echo '<div class="modal modal-warning fade" id="modal-warning">';
           echo '<div class="modal-dialog">';
             echo '<div class="modal-content">';
               echo '<div class="modal-header">';
                 echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                   echo '<span aria-hidden="true">&times;</span></button>';
                 echo '<h4 class="modal-title">¿Desea solicitar una revisión de la postulación?</h4>';
               echo '</div>';
               echo '<div class="modal-body">';
                echo '<p>La administración de la ENAFOP le ha solicitado hacer una corrección a su postulación (de la que puede ver un detalle en el panel de conversación de la derecha, al lado de su nombre); Haga click en el botón "Solicitar corrección"  si ya ha realizado las modificaciones pertinenes a su postulación desde la herramienta de edición de postulación; si los cambios aún no están listos, haga click en cerrar y efectúelos&hellip;</p>';
                echo '<b>Debe enviar a una nueva revisión ÚNICAMENTE si ha efectuado una modificación sustancial en su perfil.</b>';
              echo '</div>';
              echo '<div class="modal-footer">';
                echo '<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar</button>';
                echo '<button type="submit" id="solicitarCorrección" class="btn btn-outline">Solicitar corrección</button>';
              echo '</div>';
            echo '</div>';

         echo ' </div>';
        echo '</div>';

	           echo "</form>";


  		}

 	?>
 </div>


  <div class="col-md-4">
	<div class="box box-widget widget-user" media="print">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-aqua-active">
              <h3 class="widget-user-username"><?php echo $nombre ?></h3>
              <h5 class="widget-user-desc no-print">
              	
              	<?php  
              	if(strcmp($estadoPostulacion, "aprobado")==0)
              	{
              		echo "Docente aprobado";
              	}
              		if(strcmp($estadoPostulacion, "rechazado")==0)
              	{
              		echo "Postulante rechazado";
              	}
              		if(strcmp($estadoPostulacion, "postulado")==0)
              	{
              		echo "Postulante en evaluación";
              	}	

              	?>
              </h5>
            
            </div>
            <div class="widget-user-image">
            

              <?php 
              $fotoUsuario=$user->getFotoPostulante($idpostulante,$baseServer); 
              if($fotoUsuario==false)
              {
              	 echo '<img class="img-circle" src="../styles/multisis-lte/dist/img/persona.png" width="50" height="50" alt="avatar postulante">';
              }
              else
              {
              	if($user->isAdmin())
              	{
              		echo "<img class=\"img-circle no-print\" src=$fotoUsuario alt=\"avatar postulante\">";
              	}
              	else
              	{
              		echo "<img class=\"img-circle\" src=$fotoUsuario alt=\"avatar postulante\">";
              	}
              	
              }

              ?> 
            </div>

            <div class="box-footer">
              <div class="row">
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header"><?php  echo $pais?></h5>
                    <span class="description-text">País de residencia</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header"><?php  

                    if(strcmp($departamento, "")==0)
                    	{
                    		echo "N/A";
                    	}
                    	else
                    	{
                    		 echo $departamento;
                    	}
                    ?></h5>
                    <span class="description-text">Departamento</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4">
                  <div class="description-block">
                    <h5 class="description-header"><?php 
                    	if(strcmp($municipio, "")==0)
                    	{
                    		echo "N/A";
                    	}
                    	else
                    	{
                    		 echo str_replace('"', '', $municipio);   
                    	}
                    ?></h5>
                    <span class="description-text">Municipio</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
          </div>
          <!-- /.widget-user -->
         </div> <!-- /.fin de columna-user -->

       <div class="col-md-4"> <!-- /.inicio de columna-chat -->


       		<?php 
       									 echo '<div class="box no-print">';
            echo '<div class="box-header">';
              echo '<h3 class="box-title">Imprimir  postulación</h3>';
            echo '</div>';
             echo '<div class="box-body ">';
					echo '<button type="button" id="imprimirPagina" class="btn btn-default btn-block"><i class="fa fa-print"></i></button>';

              				  echo '</div></div>';
       		//condiciones para poder ver el "chat de observaciones: "
       		//que lo vea un admin
       		//que lo vea el mismo postulante
       		$esEl=false;
       		 $idChat=$user->getChatID($idpostulante);
       		if($user->getID()==$idpostulante)
       		{
       			$esEl=true;
       		}

       		if($user->isAdmin() || $esEl==true)
       		{
       			$estaVacio=$user->estaChatVacio($idChat); 
       			 $getNumChats="SELECT COUNT(id) FROM chat_log WHERE idchat=$idChat;";
					$tat = $db->getResultArray($getNumChats);
					$numbah=$tat[0]["COUNT(id)"];
              echo '<div class="box box-warning direct-chat direct-chat-warning no-print">';
                 echo '<div class="box-header with-border">';
                  echo ' <h3 class="box-title">Solicitud de correcciones, dudas, aclaraciones...</h3>';

                   echo '<div class="box-tools pull-right">';
                    echo "<span data-toggle=\"tooltip\" title=\"$numbah interacciones\" class=\"badge bg-yellow\">$numbah</span>";
                     echo '<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>';
                     echo '</button>';
                     echo '<button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Contacts"
                            data-widget="chat-pane-toggle">';
                       echo '<i class="fa fa-comments"></i></button>';
                     echo '<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>';
                     echo '</button>';
                   echo '</div>';
                 echo '</div>';
              
                echo '<div class="box-body">';
               
                  echo '<div class="direct-chat-messages">';
                  ///////////////////INICIO MENSAJES
                 $getChat="SELECT idescritor,mensaje,fecha FROM chat_log WHERE idchat=$idChat";
                // echo "GETCHAT: ".$getChat;
					$res1 = $db->getResultArray($getChat);
					if($res1)
					{
						foreach ($res1 as $key) 
						{
							//print_r("Aubarray: ".$key);
							$idescritor=$key['idescritor'];
							$mensaje=$key['mensaje'];
							$fecha=$key['fecha'];
							$usuarito=$dms->getUser($idescritor);
							if($usuarito->isAdmin()) //si el usuario es admin, pongo logo del enafop y texto gris
							{
								     echo '<div class="direct-chat-msg">';
			                      echo '<div class="direct-chat-info clearfix">';
			                        echo "<span class=\"direct-chat-name pull-left\">ENAFOP</span>";
			                        echo "<span class=\"direct-chat-timestamp pull-right\">$fecha</span>";
			                      echo '</div>';
			                     
			                     echo "<img class=\"direct-chat-img\" src=\"../images/miniEnafop.png\" alt=\"message user image\">";
			                   
			                        echo '<div class="direct-chat-text">';
			                        echo "$mensaje";
			                        echo '</div>';
			                     
			                      echo '</div>';
                   
							} //fin de si el usuario es admin, pongo logo del enafop y texto gris
							else
							{
								 echo '<div class="direct-chat-msg right">';
                        echo '<div class="direct-chat-info clearfix">';
                        echo "<span class=\"direct-chat-name pull-right\">$nombre</span>";
                        echo "<span class=\"direct-chat-timestamp pull-left\">$fecha</span>";
                        echo '</div>';
                 
                        //echo '<img class="direct-chat-img" src="dist/img/user3-128x128.jpg" alt="message user image">';
                          $fotoUsuario=$user->getFotoPostulante($idpostulante,$baseServer); 
			              if($fotoUsuario==false)
			              {
			              	 echo '<img class="direct-chat-img" src="/styles/multisis-lte/dist/img/persona.png" width="128" height="128" alt="avatar postulante">';
			              }
			              else
			              {
			              	echo "<img class=\"direct-chat-img\" src=$fotoUsuario alt=\"avatar postulante\">";
			              }
                   
                        echo '<div class="direct-chat-text">';
                        echo "$mensaje";
                        echo '</div>';
                  
                      echo '</div>';
							} //si es postulante, pongo su foto y texto amarillo
							
						}
					}
               

                                                       
              /////////////////// FIN MENSAJES
                  echo '<div class="direct-chat-contacts">';

                  
                    echo '<ul class="contacts-list">';            
                      echo '<li>';
                        echo '<a href="#">';
                          echo "<img class=\"contacts-list-img\" src=\"/styles/multisis-lte/dist/img/persona.png\" alt=\"User Image\">";


                          echo '<div class="contacts-list-info">';
                                 echo '<span class="contacts-list-name">';
                                  echo "$nombre";
                                  echo "<small class=\"contacts-list-date pull-right\">2018</small>";
                                 echo '</span>';
                            echo "<span class=\"contacts-list-msg\">Conversando con postulante $nombre</span>";
                          echo '</div>';
                     
                        echo '</a>';
                      echo '</li>';
                
                   echo ' </ul>';
          
                 echo '</div>';
                        echo '</div>';
                        echo '</div>';
            	
                echo '<div class="box-footer">';
                  if(!$user->isAdmin() && $estaVacio) //si el user es usuario, y no hay iniciada una observación, no puedo responder
                  {
                  	echo "No hay ninguna observación en la postulación";
                  }
                  else
                  {
                  	echo '<form action="../escribirChat.php" method="post">';
                    echo '<div class="input-group">';
                     
                      $idEscritor=$user->getID();
                     $correoUsuario=$dms->getUser($idpostulante)->getEmail();	
                      //echo "idChat: ".$idChat;
                      $timestamp = date('d-m-Y H:i');
                     echo '<input type="text" name="mensajito" id="mensajito" placeholder="Escriba su mensaje..." class="form-control">';
                      echo "<input type=\"hidden\" name=\"escritor\" id=\"escritor\" value=\"$idEscritor\">";
                     
                       echo "<input type=\"hidden\" name=\"postulado\" id=\"postulado\" value=\"$idpostulante\">";
                       echo "<input type=\"hidden\" name=\"chat\"   id=\"chat\"value=\"$idChat\">";
                        echo "<input type=\"hidden\" name=\"timestamp\"  id=\"timestamp\"value=\"$timestamp\">";
                      echo '<span class="input-group-btn">';
                            echo '<button type="submit" class="btn btn-warning btn-flat">Enviar</button>';
                          echo '</span>';

                     
                    echo '</div>';
                  echo '</form>';
                  }
                echo '</div>';
                echo '<small>Por favor revise en su correo, incluso en la carpeta de spam, la llegada de notificaciones.</small>';
       
               echo '</div>';
        
       		} //fin if si es admin, ver chat

       		//fin php de si es admin, ver chat de observaciones
       		?>
 		</div> <!-- /.fin de columna-chat -->
 
		 <!-- **********************AQUI IRIAN LAS GRÁFICAS********************************************* -->


 		 <div class="row">
        <div class="col-md-6">


       		<?php 
       		if($user->isAdmin())
       		{
       			echo '<div class="box box-warning no-print">'; //si es admin quito datos personales para que no los vea comite
       		}
       		else
       		{
       			echo '<div class="box box-warning">'; //si no es admin, pongo datos personales
       		}
       		?>
            <div class="box-header with-border">
              <h3 class="box-title">Datos personales</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            	  <?php 

              	if($user->isAdmin())
              	{
              		echo '<h5>';
              		echo "(Solo administradores) Nombre de usuario en el sistema: <b> $nombreUsuario </b><br> Tipo de perfil: ";
              		if($postulantePublico==true)
              		{
              			echo "<b>Perfil público</b>: visible para todo el mundo una vez sea aprobado";
              		}
              		else
              		{
              			echo "<b>Perfil privado:</b> visible, en cualquier etapa de la evaluación, solo para administradores y el mismo postulante";
              		}

              		 echo '</h5>';
              	}
              ?>
               <ul>
               		<li><b>Género: </b>   <?php echo $genero ?>  </li>
               		<li><b>Edad: </b>   <?php echo $edad ?>  </li>
               		<li><b>Tipo de documento: </b>   <?php echo $tipodocumento ?>  </li>
               		<li><b>Número de documento: </b>   <?php echo $numerodocumento ?>  </li>
               		<li><b>NIT: </b>   <?php echo $nit ?>  </li>
               		<li><b>Correo electrónico: </b>   <?php echo $correo ?>  </li>
               		<li><b>Teléfono de contacto: </b>   <?php echo $telefono ?>  </li>

               	
               </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col (right) -->
        <div class="col-md-6">
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Experiencia en números</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <p><code>Años de experiencia laboral: </code>
              	<?php echo $anosLaborales?>
              </p>
              <div class="progress progress active">
                <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $anosLaborales."%" ?>">
                  <span class="sr-only">20% Complete</span>
                </div>
              </div>


              <p><code>Años totales de práctica de la docencia</code>
              	<?php echo $anosDocencia?>
              </p>
              <div class="progress progress active">
                <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $anosDocencia."%" ?>">
                  <span class="sr-only">60% Complete (warning)</span>
                </div>
              </div>


              <p> <code>Años totales de experiencia en formación y capacitación</code>
              	<?php echo $anosCapacitacion?>
              </p>
              <div class="progress progress active">
                <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $anosCapacitacion."%" ?>">
                  <span class="sr-only">60% Complete (warning)</span>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col (left) -->

      </div>
      <!-- /.row -->

<!-- **********************AQUI IRIAN LAS tabla ingeligente********************************************* -->

      <div class="box">
            <div class="box-header">
              <h3 class="box-title">Experiencia laboral: desglose completo</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Cargo</th>
                  <th>Funciones</th>
                  <th>Institución</th>
                  <th>Periodo</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                
					//query de consulta:
					$consultar="SELECT cargo,funciones,institucion,anoinicio,anofin FROM cargos WHERE idpostulante=$idpostulante";
					$res1 = $db->getResultArray($consultar);
					if($res1)
					{
						foreach ($res1 as $key) 
						{
							//print_r("Aubarray: ".$key);
							$cargo=$key['cargo'];
							$funciones=$key['funciones'];
							$institucion=$key['institucion'];
							$anoinicio=$key['anoinicio']; $anoinicio=pasarDMY($anoinicio);
							$anofin=$key['anofin']; $anofin=pasarDMY($anofin);
							 echo  '<tr>';
			                  echo "<td>$cargo</td>";
			                  echo "<td>$funciones</td>";
			                  echo "<td>$institucion</td>";
		                  echo "<td> $anoinicio   hasta     $anofin</td>";
		                    echo '<td></td>';
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

          <!-- /.TERMINA LA TABLA DE EXPERIENCIA LABORAL Y EMPIEZA DE LA FORMACION ACADÉMICA -->
            <div class="box box-success">
            <div class="box-header">
              <h3 class="box-title">Formación académica: Estudios de grado</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="tablaGrados" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Titulo obtenido</th>
                  <th>Nombre del título</th>
                  <th>Año</th>
                  <th>Institución</th>
                  <th>Atestado</th>
                </tr>
                </thead>
                <tbody>
                <?php
                	
					//query de consulta:
					$consultar="SELECT titulo,nombretitulo,ano,institucion,idatestado FROM titulos_grado WHERE idpostulante=$idpostulante;";
					$res1 = $db->getResultArray($consultar);
					if($res1)
					{
						foreach ($res1 as $key) 
						{
							//print_r("Aubarray: ".$key);
							$titulo=$key['titulo'];
							$nombretitulo=$key['nombretitulo'];
							$ano=$key['ano'];
							$institucion=$key['institucion'];
							$idatestado=$key['idatestado'];
							 echo  '<tr>';
			                  echo "<td>$titulo</td>";
			                  echo "<td>$nombretitulo</td>";
			                  echo "<td>$ano</td>";
		                  echo "<td>$institucion</td>";
		                    echo "<td><a href=\"out.ViewDocument.php?documentid=$idatestado\">Ver atestado</a></td>";
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
          	

          <div class="row"> <!-- /.QUIERO TENER DOS TABLES EN UNA SOLA FILA -->
          	<div class="col-md-6"> 
          			 <div class="box box-success">
            <div class="box-header">
              <h3 class="box-title">Formación académica: Posgrados</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="tablaPosgrados" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Titulo obtenido</th>
                  <th>Nombre del título</th>
                  <th>Año</th>
                  <th>Institución</th>
                  <th>Atestado</th>
                </tr>
                </thead>
                <tbody>
                <?php
              
					//query de consulta:
					$consultar="SELECT titulo,nombretitulo,ano,institucion,idatestado FROM titulos_posgrado WHERE idpostulante=$idpostulante;";
					$res1 = $db->getResultArray($consultar);
					if($res1)
					{
						foreach ($res1 as $key) 
						{
							//print_r("Aubarray: ".$key);
							$titulo=$key['titulo'];
							$nombretitulo=$key['nombretitulo'];
							$ano=$key['ano'];
							$institucion=$key['institucion'];
							$idatestado=$key['idatestado'];
							 echo  '<tr>';
			                  echo "<td>$titulo</td>";
			                  echo "<td>$nombretitulo</td>";
			                  echo "<td>$ano</td>";
		                  echo "<td>$institucion</td>";
		                    echo "<td><a href=\"out.ViewDocument.php?documentid=$idatestado\">Ver atestado</a></td>";
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
          	 
          	</div>

          	<div class="col-md-6">
          		<div class="box box-success">
            <div class="box-header">
              <h3 class="box-title">Formación académica: Otros estudios</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="tablaOtros" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Titulo obtenido</th>
                  <th>Nombre del título</th>
                  <th>Año</th>
                  <th>Institución</th>
                  <th>Atestado</th>
                </tr>
                </thead>
                <tbody>
                <?php
                	
					//query de consulta:
					$consultar="SELECT titulo,nombretitulo,ano,institucion,idatestado FROM titulos_otros WHERE idpostulante=$idpostulante;";
					$res1 = $db->getResultArray($consultar);
					if($res1)
					{
						foreach ($res1 as $key) 
						{
							//print_r("Aubarray: ".$key);
							$titulo=$key['titulo'];
							$nombretitulo=$key['nombretitulo'];
							$ano=$key['ano'];
							$institucion=$key['institucion'];
							$idatestado=$key['idatestado'];
							 echo  '<tr>';
			                  echo "<td>$titulo</td>";
			                  echo "<td>$nombretitulo</td>";
			                  echo "<td>$ano</td>";
		                  echo "<td>institucion</td>";
		                    echo "<td><a href=\"out.ViewDocument.php?documentid=$idatestado\">Ver atestado</a></td>";
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
          	
          	</div>

          </div>
          
          

		<!-- /.,.,.,.,.,.,AQUI EMPIEZA LA SECCION DE TEMAS DE LA ADMINSITRACION PUBLICA QUE MANEJA .,.,.,.,.-->
	<div class="row">

		<div class="col-md-6">
				<div class="box box-solid">
            <div class="box-header with-border">
              <i class="fa fa-text-width"></i>

              <h3 class="box-title">Temas de la administración pública en los que se especializa</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <blockquote>

                <?php 
                	imprimirTemasManejados($idpostulante,$db);
                ?>
              </blockquote>

               

                <?php 
                	$hayConocimientos=$user->hayConocimientosAdicionales($idpostulante);
                	//echo "HAY CONOCIMIENBTOS: ".$hayConocimientos;
                	if($hayConocimientos==TRUE)
                	{
                		  echo '<h3>Conocimientos adicionales a estos temas</h3>';
                		echo '<blockquote>';
                		$conoci=$user->getConocimientosAdicionales($idpostulante);
                		echo $conoci;
                		echo '</blockquote>';
                	}
                ?>
              


            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
			
		</div> <!-- /.fin columna izquierda -box -->

		<div class="col-md-6">
			<div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Experiencia en práctica de la docencia (al menos los útlimos 5 años)</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="tablaDocencia" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Materia</th>
                  <th>Institución</th>
                  <th>Periodo</th>
                  <th>Modalidad</th>
                  <th>Atestado</th>
                </tr>
                </thead>
                <tbody>
                <?php            
					//query de consulta:
					$consultar="SELECT materia,institucion,anoinicio,anofin,modalidad,idatestado FROM materias_docencia WHERE idpostulante=$idpostulante;";
					$res1 = $db->getResultArray($consultar);
					if($res1)
					{
						foreach ($res1 as $key) 
						{
							//print_r("Aubarray: ".$key);
							$materia=$key['materia'];
							$institucion=$key['institucion'];
							$anoInicio=$key['anoinicio'];  $anoInicio=pasarDMY($anoInicio);
							$anoFin=$key['anofin']; $anoFin=pasarDMY($anoFin);
							$modalidad=$key['modalidad'];
							$idatestado=$key['idatestado'];
							 echo  '<tr>';
			                  echo "<td>$materia</td>";
			                  echo "<td>$institucion</td>";
			                  echo "<td>$anoInicio hasta $anoFin</td>";
		                  echo "<td>$modalidad</td>";
		                    echo "<td><a href=\"out.ViewDocument.php?documentid=$idatestado\">Ver atestado</a></td>";
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

		</div> <!-- /.fin columna derecha -box --> 
     </div> <!-- /.fin row-box -->
	
     			<div class="box box-warning">
            <div class="box-header">
              <h3 class="box-title">Experiencia en formación y capacitaciones</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="tablaCapacitaciones" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nombre del programa o taller</th>
                  <th>Total de horas impartidas</th>
                  <th>Periodo</th>
                  <th>Institución</th>
                  <th>Modalidad</th>
                  <th>Atestado</th>
                </tr>
                </thead>
                <tbody>
                <?php            
					//query de consulta:
					$consultar="SELECT taller,totalhoras,fechainicio,fechafin,institucion,modalidad,idatestado FROM experiencia_formacion WHERE idpostulante=$idpostulante;";
					$res1 = $db->getResultArray($consultar);
					if($res1)
					{
						foreach ($res1 as $key) 
						{
							//print_r("Aubarray: ".$key);
							$taller=$key['taller'];
							$totalhoras=$key['totalhoras'];
							$fechainicio=$key['fechainicio']; $fechainicio=pasarDMY($fechainicio);
							$fechafin=$key['fechafin']; $fechafin=pasarDMY($fechafin);
							$institucion=$key['institucion'];
							$modalidad=$key['modalidad'];
							$idatestado=$key['idatestado'];
							 echo  '<tr>';
			                  echo "<td>$taller</td>";
			                  echo "<td>$totalhoras</td>";
			                  echo "<td>$fechainicio hasta $fechafin</td>";
		                  echo "<td>$institucion</td>";
		                  echo "<td>$modalidad</td>";
		                    echo "<td><a href=\"out.ViewDocument.php?documentid=$idatestado\">Ver atestado</a></td>";
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

          <div class="row">
          	 <div class="col-md-6">
          	 
          	 	  <div class="box box-solid">
            <div class="box-header with-border">
              <i class="fa fa-text-width"></i>

              <h3 class="box-title">Descripción de las metodologías que maneja. Haga click en una descripción para ver el atestado</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <blockquote>

                <?php 
                	imprimeMetodologias($idpostulante,$db);
                ?>
              </blockquote>
            </div>
            <!-- /.box-body -->
          </div>  

          	 </div><!-- /.fin columna izq -->

          	 <div class="col-md-6">
          	 				<div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-yellow">
              <div class="widget-user-image">
                <img class="img-circle" src="../images/documents.png" alt="logo documentos"  height="128" width="128">
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username">Otros documentos</h3>
              <h5 class="widget-user-desc">Adjuntados en la postulación. Haga click en el texto para verlo</h5>
        
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
              	<?php
              	  imprimeAdjuntos($idpostulante,$db);
              	?>                
              </ul>
            </div>
          </div>
          	 		
          	 </div> <!-- /.fin columna derecha -->

          	 <div class="row">

          	 	<div class="col-md-3">
          	 	</div>

          	 	<div class="col-md-6">
	          	 		
	            	<?php 
             	
             	$consultar="SELECT relevante FROM otros WHERE idpostulante=$idpostulante;";
				$res = $db->getResultArray($consultar);
				if(strcmp($res[0]['relevante'], "")!=0)
				{
					echo '<div class="info-box">';
	            echo '<span class="info-box-icon bg-green"><i class="fa fa-smile-o"></i></span>';

	            echo '<div class="info-box-content">';
					echo '<span class="info-box-number">Información que el postulante indicó como aclaratoria:</span>';
					echo "<span class=\"info-box-text\">".$res[0]['relevante']."</span>";
	               
	            echo '</div> </div>';          
				}
				?>
	              
          <div class="info-box bg-green">
            <span class="info-box-icon"><i class="fa fa-globe"></i></span>

            <div class="info-box-content">
             <?php 
             	
             	$consultar1="SELECT ingles FROM otros WHERE idpostulante=$idpostulante;";
				$res1 = $db->getResultArray($consultar1);
				if(strcmp($res1[0]['ingles'], "si")==0)
				{
					
					echo "<span class=\"info-box-text\">Sí habla otros idiomas</span>";
				}
				else
				{
					echo "<span class=\"info-box-text\">No habla otros idiomas</span>";
				}

				$consultar2="SELECT prezi FROM otros WHERE idpostulante=$idpostulante;";
				$res2 = $db->getResultArray($consultar2);
				if(strcmp($res2[0]['prezi'], "si")==0)
				{
					
					echo "<span class=\"info-box-text\">Sí maneja programas de presentación (Prezi, PowerPoint...)</span>";
				}
				else
				{
					echo "<span class=\"info-box-text\">No maneja programas de presentación (Prezi, PowerPoint...)</span>";
				}


             ?>

            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          <!-- /.info-box -->
          	 	</div>

          	 	<div class="col-md-3">
          	 	</div>
          	 </div>
          </div><!-- /.fin row metodologias -->

        <?php 
        //en un bucle imprimo todos los idiomas que habla
        //query de consulta:
					$consultar="SELECT id,idioma,hablado,escuchado,escrito FROM idiomas WHERE idpostulante=$idpostulante;";
					$res1 = $db->getResultArray($consultar);
					if($res1)
					{
						foreach ($res1 as $key) 
						{
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
                  echo "<input id=$id type=\"text\" class=\"knob\" value=\"$hablado\" data-skin=\"tron\" data-thickness=\"0.2\" data-width=\"120\" data-height=\"120\" data-min=\"0\" data-max=\"5\" data-fgColor=\"#0033cc\">";

                  echo '<div class="knob-label">Hablado</div>';
                echo '</div>';
               
                echo '<div class="col-md-3 text-center">';
                  echo "<input id=$id type=\"text\" class=\"knob\" value=\"$escuchado\" data-skin=\"tron\" data-thickness=\"0.2\" data-width=\"120\" data-height=\"120\" data-min=\"0\" data-max=\"5\" data-fgColor=\"#f56954\">";

                  echo "<div class=\"knob-label\">Escuchado</div>";
                echo '</div>';
               echo '<div class="col-md-3 text-center">';
                  echo "<input id=$id type=\"text\" class=\"knob\" value=\"$escrito\" data-skin=\"tron\" data-thickness=\"0.2\" data-width=\"120\" data-height=\"120\" data-min=\"0\" data-max=\"5\" data-fgColor=\"#33cc33\">";

                  echo "<div class=\"knob-label\">Escrito</div>";
                 echo '</div>';
              
               echo '</div>';
             echo '</div>';
							
							
						}//fin bucle
					} //fin si hay resultado consulta

        ?>
  

<?php
	if($user->isAdmin())
	{
		$idPostulacion=getIdPostulacion($idpostulante,$db);
		$inicial="SELECT fecha FROM postulaciones WHERE id=$idPostulacion;";
		$res = $db->getResultArray($inicial);
		$fechaInicial=$res[0]['fecha'];	
		//echo "Fecha inicial: ".$fechaInicial;	
		$tempo=explode(" ", $fechaInicial);
		$datIni=$tempo[0];
		$horaIni=$tempo[1];
		$consultar1="SELECT estado,fecha,comentario FROM historial WHERE idpostulacion=$idPostulacion ORDER BY fecha desc;";
		//echo "consultar historial: ".$consultar1;
		$res1 = $db->getResultArray($consultar1);	
		 echo '<div class="box box-info no-print collapsed-box">';
		 echo '<div class="box-header with-border">';
             echo "<h1> Línea del tiempo <small>del histórico del proceso de evaluación del postulante (click en la cruz para desplegar)</small> </h1>";
              echo '<div class="box-tools pull-right">';
                echo '<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>';
                echo '</button></div></div>';

            echo '<div class="box-body">';
	
echo '<ul class="timeline">';

    foreach($res1 as $linea)
    {
    	
  		
    	
    	$comment=$linea['comentario'];
    	$estado=$linea['estado'];
    	$fechaCompleta=$linea['fecha'];
    	//echo "Fecha completa: ".$fechaCompleta;
    	$temp=explode(" ", $fechaCompleta);
    	$dat=$temp[0];
    	$hora=$temp[1];
    	echo '<li class="time-label">';
        echo '<span class="bg-red">';
            echo "$dat";
        echo '</span>';
        echo '</li>';
       echo '<li>';
        echo '<i class="fa fa-envelope bg-blue"></i>';
        echo '<div class="timeline-item">';
             echo "<span class=\"time\"><i class=\"fa fa-clock-o\"></i> $hora</span>";

             echo "<h3 class=\"timeline-header\"><a href=\"#\">Estado</a> $estado</h3>";

             echo '<div class="timeline-body">';
                
                 echo "$comment";
             echo '</div>';

             echo '<div class="timeline-footer">';
                 
             echo '</div>';
         echo '</div>';
    echo '</li>';
    }//fin de obtener de la bd desde el mas reciente eventos
    //al final, del todo, pongo la postulación inicial
    echo '<li class="time-label">';
        echo '<span class="bg-red">';
            echo "$datIni";
        echo '</span>';
        echo '</li>';
       echo '<li>';
        echo '<i class="fa fa-envelope bg-blue"></i>';
        echo '<div class="timeline-item">';
             echo "<span class=\"time\"><i class=\"fa fa-clock-o\"></i> $horaIni </span>";

             echo "<h3 class=\"timeline-header\"><a href=\"#\">Estado</a> Postulado</h3>";

             echo '<div class="timeline-body">';
                
                 echo "Postulación inicial";
             echo '</div>';

             echo '<div class="timeline-footer">';
                 
             echo '</div>';
         echo '</div>';
   			 echo '</li>';

echo '</ul>';	
echo '</div>'; //cierre del box body linea del tmepo
echo '</div>'; //cierre del box  linea del tmepo
}
 //////FIN MI CODIGO                 
//$this->contentContainerEnd();
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
		echo '<script src="../styles/multisis-lte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>';
        echo '<script src="../styles/multisis-lte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>';
         echo '<script src="../styles/multisis-lte/bower_components/jquery-knob/js/jquery.knob.js"></script>';
        echo '<script src="../tablasDinamicas.js"></script>';
        echo '<script src="../graficas.js"></script>';
		$this->htmlEndPage();
	} /* }}} */
}
?>
