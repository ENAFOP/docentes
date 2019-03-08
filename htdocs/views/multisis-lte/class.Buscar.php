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
 function removeAccents($str) {
  $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ', 'Ά', 'ά', 'Έ', 'έ', 'Ό', 'ό', 'Ώ', 'ώ', 'Ί', 'ί', 'ϊ', 'ΐ', 'Ύ', 'ύ', 'ϋ', 'ΰ', 'Ή', 'ή');
  $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o', 'Α', 'α', 'Ε', 'ε', 'Ο', 'ο', 'Ω', 'ω', 'Ι', 'ι', 'ι', 'ι', 'Υ', 'υ', 'υ', 'υ', 'Η', 'η');
  return str_replace($a, $b, $str);
}
 function pasaFiltro($idpostulante,$arraymaestro,$definiciones)
 {
 	$verdad=true;
 	$arrayChecks=array(); //array de booleans
 	for ($i=0; $i<count($arraymaestro); $i++) 
 	{
 		//echo "LONGITUD DE ARRAYCITO: ".count($arraymaestro[$i])."<br>";
     
 	  if($definiciones[$i]==true)
 	  {
 	  		//echo "ARRAYCITO FUE DEFINIDO <br>" ;
		if(in_array($idpostulante, $arraymaestro[$i]))
		{
			//echo "$idpostulante está en arraycito <br>";
			$arrayChecks[]=true;
		}
		else
		{
			$arrayChecks[]=false;
		}
 	  }		
				
 	}
 	foreach ($arrayChecks as $check) 
 	{
 		//echo "CECHIN: ".$check."</br>";
 		if($check==false)
 		{
 			$verdad=false;	
 		}
 	}
 	//echo "BOOLEANO DE PASO FILTRO: ".$verdad;
 	return $verdad;
 }
function startsWith($haystack, $needle)
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}

function cumplenExperiencia($experiencia,$db) //devuelve array de IDS unicos de aquellos postulantes cuya suma de experiencia laboral es mayor al valor $experiencia
{
	$devolver=array();
		
		$consultarids="SELECT idpostulante FROM cargos;";
		$arrayIDS=array();
		$res2 = $db->getResultArray($consultarids);
		foreach ($res2 as $id) 
		{
			$elid=$id['idpostulante'];
			$arrayIDS[]=$elid;
		}
		$arrayIDS=array_unique($arrayIDS);		
		foreach ($arrayIDS as $key) 
		{
			$total=0;
			//echo "ID DEL QUE VOY A SACAR LA SUMA: ".$key;
			$consultar = "SELECT anoinicio,anofin FROM cargos WHERE idpostulante=$key;";
			$res1 = $db->getResultArray($consultar);
			if($res1)
			{
				foreach ($res1 as $tar) 
				{
					//print_r("Aubarray: ".$key);
					$anoInicio=$tar['anoinicio'];
					$anoFin=$tar['anofin']; 
				    $total=$total+(abs($anoFin-$anoInicio));
				}
			}
			if($total>=$experiencia)
			{
				//echo "EL ID $key tiene más cargo que lo que se pide ".$total.">".$experiencia;
				$devolver[]=$key;
			}
		}		
		return $devolver;

}

function cumplenTitulo($nombreTitulo)
{
         $arrayresu = searchAllDB($nombreTitulo);
         $devolver=array();
        foreach ($arrayresu as $key) 
		{							
							
		$idpostulante=$key[0];
		$devolver[]=$idpostulante;
		}
		$devolver=array_unique($devolver);
		return $devolver;
}

function cumplenTema($titulo,$db) //devuelve array con idpostulante de todos aquelos postulantes que cumplen que tienen 
//el Titulo que se les pasa por argumetno
{
	$arrayResu=array();
	$arrayTablas=array("temas_abierto","temas_calidad","temas_capacitacion","temas_electronico","temas_enfoque","temas_etica","temas_gerencia","temas_gobierno","temas_planificacion","temas_relaciones","temas_talento");

	 $arrayTitulos=array("Gobierno abierto y participación ciudadana","Gestión de calidad en el sector público","Gestión de capacitación en el sector público","Gobierno electrónico","Enfoque de derechos en la gestión pública","Ética y transparencia en la gestión pública","Gerencia pública","Gobierno y territorio","Planificación para el desarrollo","Relaciones laborales en el sector público","Gestión del talento humano por competencias en el sector público");
	 $nombreTabla="";
	 for ($i=0;$i<count($arrayTablas); $i++) 
	 {
	 		if(strcmp($titulo,$arrayTitulos[$i])==0)
	 		{
	 			$nombreTabla=$arrayTablas[$i];
	 			break;
	 		}
	 }	
	$consultar = "SELECT idpostulante FROM `$nombreTabla` WHERE TRIM(nombretema) > ''";
	//echo "Consultar: ".$consultar;
	$res = $db->getResultArray($consultar);
	foreach ($res as $key) 
	{
		$idpostulante=$key['idpostulante'];
		$arrayResu[]=$idpostulante;
		//echo "CUMPLEMTEMA: ID ENCONTRADO QUE CUMPLE EL TEMA ".$titulo." es: ".$idpostulante;
	}
	$resultado = array_unique($arrayResu);
	return $resultado;
}


function searchAllDB($search) //devuelve un array de arrays, cada array devuelto lleva lo siguiente:
//[idpostulante, categoria]. Luego, con el categoria, podre rellenar la "Categoria" qye se muestra en la búsqueda
{
	$resultado=array();
    global $mysqli;
    $settings = new Settings(); //acceder a parámetros de settings.xml con _antes
    $driver=$settings->_dbDriver;
    $host=$settings->_dbHostname;
    $user=$settings->_dbUser;
    $pass=$settings->_dbPass;
    $base=$settings->_dbDatabase;
    // Conectarse a y seleccionar una base de datos de MySQL llamada sakila
// Nombre de host: 127.0.0.1, nombre de usuario: tu_usuario, contraseña: tu_contraseña, bd: sakila
$mysqli = new mysqli($host, $user, $pass, $base);
// ¡Oh, no! Existe un error 'connect_errno', fallando así el intento de conexión
if ($mysqli->connect_errno) 
{
    // La conexión falló. ¿Que vamos a hacer? 
    // Se podría contactar con uno mismo (¿email?), registrar el error, mostrar una bonita página, etc.
    // No se debe revelar información delicada

    // Probemos esto:
    echo "Lo sentimos, este sitio web está experimentando problemas en la BD de datos: no se puede buscar [out.Buscar.php].";

    // Algo que no se debería de hacer en un sitio público, aunque este ejemplo lo mostrará
    // de todas formas, es imprimir información relacionada con errores de MySQL -- se podría registrar
    echo "Error: Fallo al conectarse a MySQL debido a: \n";
    echo "Errno: " . $mysqli->connect_errno . "\n";
    echo "Error: " . $mysqli->connect_error . "\n";
    
    // Podría ser conveniente mostrar algo interesante, aunque nosotros simplemente saldremos
    exit;
}

    $out = "";
    //excluyo las tablas: departamentos, municipios, cartas, referencias_personales, historial, postulaciones, 
    $exclusiones=array("cartas","departamentos","historial","municipios","postulaciones","referencias_personales");
    $sql = "show tables";
    $rs = $mysqli->query($sql);
    if($rs->num_rows > 0){
        while($r = $rs->fetch_array())
        {
            $table = $r[0];
            if(!startsWith($table,"tbl"))
            {

            $out .= $table.";";
            $sql_search = "select * from ".$table." where ";
            $sql_search_fields = Array();
            $sql2 = "SHOW COLUMNS FROM ".$table;
            $rs2 = $mysqli->query($sql2);
            if($rs2->num_rows > 0)
            {
                while($r2 = $rs2->fetch_array()){
                    $colum = $r2[0];
                    $sql_search_fields[] = $colum." like('%".$search."%')";
                }
                $rs2->close();
            }
            $sql_search .= implode(" OR ", $sql_search_fields);
           //echo "SQL :".$sql_search;
            $rs3 = $mysqli->query($sql_search);
            $out .= $rs3->num_rows."\n";

            //$algo= mysqli_fetch_array ($rs3);
            while($algo= mysqli_fetch_array ($rs3))
				{
				   //echo "row<br>";
				       if(!empty($algo))
            {
            	if(!in_array($table, $exclusiones))
            	{
	            	$categoria="";
	            	//echo "algo: ".print_r($algo)."<br>";
	            	$idpostulante=$algo['idpostulante'];            
	            	if(startsWith($table,"metodologias_"))
	            	{
	            		$categoria="Manejo de metodologías";
	            	}
	            	if(startsWith($table,"cargos"))
	            	{
	            		$categoria="Experiencia laboral";
	            	}
	            	if(startsWith($table,"cartas"))
	            	{
	            		$categoria="Carta de motivación";
	            	}
	            	if(startsWith($table,"datosgenerales"))
	            	{
	            		$categoria="Datos personales del postulante";
	            	}
	            	if(startsWith($table,"experiencia_"))
	            	{
	            		$categoria="Experiencia en formación";
	            	}
	            	if(startsWith($table,"materias_"))
	            	{
	            		$categoria="Experiencia docente";
	            	}
	            	if(startsWith($table,"otros"))
	            	{
	            		$categoria="Otra información relevante";
	            	}
	            	if(startsWith($table,"temas_"))
	            	{
	            		$categoria="Temas de la administración pública en los que se especializa";
	            	}
	            	if(startsWith($table,"titulos_"))
	            	{
	            		$categoria="Formación académica del postulante";
	            	}
	            	if(startsWith($table,"idiomas"))
	            	{
	            		$categoria="Idiomas dominados por el postulante";
	            	}
	            	if(startsWith($table,"chat"))
	            	{
	            		$categoria="Observaciones a la postulación";
	            	}
	            	if(startsWith($table,"conocimientos_adicionales"))
	            	{
	            		$categoria="Conocimientos adicionales en temas de la administración pública";
	            	}
	            	//////////////
	            	$subArray=array($idpostulante,$categoria);
	            	$resultado[]=$subArray;
            	} //fin de exclusion
            }

				} 
            if($rs3->num_rows > 0)
            {
                $rs3->close();
            }
            } //fin de excluir tablas de seeddms
        }//fin
        $rs->close();
    }
    return $resultado;
}
class SeedDMS_View_Buscar extends SeedDMS_Bootstrap_Style 
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
		$terminos = $this->params['terminos'];
		$area = $this->params['area'];  
		$experiencia = $this->params['experiencia'];
		$titulo = $this->params['titulo'];
		$filtroArea=false;
		$filtroTitulo=false;
		$filtroExperiencia=false;
		$hayFiltros=false;
		//combinatoria: posibles 5 filtros : ningun filtro / los 3 filtros / area-experiencia / area-titulo /
		if(strcmp($area, "")!=0) //si hay un área
		{
				$filtroArea=true;
				$hayFiltros=true;
							
		}
		if($experiencia!=0) //si hay un área
		{
			$filtroExperiencia=true;
			$hayFiltros=true;						
		}
		if(strcmp($titulo, "")!=0) //si hay un área
		{
			$filtroTitulo=true;
			$hayFiltros=true;
			$titulo=removeAccents($titulo);							
		}
		$db = $dms->getDB();
		$previewer = new SeedDMS_Preview_Previewer($cachedir, $previewwidth, $timeout);
		echo $this->callHook('startPage');
		if($user->isAdmin())
		{
			$this->htmlStartPage("Resultados de la búsqueda", "skin-blue sidebar-mini sidebar-collapse");
		}
		else
		{
			$this->htmlStartPage("Resultados de la búsqueda", "skin-blue layout-top-nav");
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
  
 $this->startBoxPrimary("Resultados de la búsqueda para los términos:  $terminos");
$this->contentContainerStart();

//echo "resultado: ".$resultado; 
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
                  <th>Nombre del postulante</th>
                  <th>Categoría en la que aparece el resultado</th>
                  <th>Estado del postulante</th>
                  <th>Acceso al perfil</th>
         
                </tr>
                </thead>
                <tbody>
                <?php
                //////////
                $IDQueCumplenTodosFiltros=array();//array de idpostulantes que cumplen los 3 filtros;$
                $cumplenArea=array(); $definidoArea=false;
                $cumplenTitulo=array(); $definidoTitulo=false;
                $cumplenAnos=array();  $definidoAnos=false;
                if($filtroArea==true)
                {      
                  // echo "Se mete en filtro area. ".$filtroArea;
                     $definidoArea=true;         
                	$cumplenArea=cumplenTema($area,$db); //array de idpostulantes que cumplen el filtro "AREA"
                	//echo "Devueltops que pasan el firltro area: ".count($cumplenArea);
                }
                if($filtroExperiencia)
                {
                	//echo "Se mete en filtro anos. ".$filtroArea; 
                	$definidoAnos=true; 
                	$cumplenAnos=cumplenExperiencia($experiencia,$db);
                	//echo "Devueltops que pasan el firltro años de experiencia minimos: ".count($cumplenAnos);
                }
                if($filtroTitulo)
                {
                	$definidoTitulo=true;
                	//echo "Se mete en filtro titulo. ".$filtroArea.$titulo;  
                	$cumplenTitulo=cumplenTitulo($titulo);
                	//echo "Devueltops que pasan el filtro titulo: ".count($cumplenTitulo);
                }
               $arrayMaestro=array($cumplenArea,$cumplenAnos,$cumplenTitulo);
               $definiciones=array($definidoArea,  $definidoAnos,  $definidoTitulo);
                //////////
               $terminos = removeAccents($terminos);
                $resultado=searchAllDB($terminos);// devuelve arrays del tipo [idpostulante, categoria,textoCoincidente]
	
						foreach ($resultado as $key) 
						{							
							$idpostulante=$key[0];
							//echo "ID postulante: ".$idpostulante;
							$categoria=$key[1];	
							//echo "categoria: ".$categoria;
							if(!$hayFiltros)
							{
								//echo "no HAY FILTROS solo lo hago--------";
							$consultar = "SELECT estado FROM postulaciones WHERE idpostulante=$idpostulante";
							$res = $db->getResultArray($consultar);
							$estado=$res[0]['estado'];
							$consultar2="SELECT nombre  FROM datosgenerales WHERE idpostulante=$idpostulante";
							$res2 = $db->getResultArray($consultar2);
							$nombreFull=$res2[0]['nombre'];
							//
							 echo  '<tr>';
			                  echo "<td>$nombreFull</td>";
			                  echo "<td>$categoria</td>";
			                   echo "<td>$estado</td>";
			               echo "<td><a href=\"out.VerPostulacion.php?postulante=$idpostulante\">Acceder al perfil </a></td>";
		                    echo '</tr>';
							}//fin de si no hay filtros, hago la mera búsqueda
							if($hayFiltros)
							{	
								//echo "HAY FILTROS--------";
								if(pasaFiltro($idpostulante,$arrayMaestro,$definiciones))
								{
									//echo "!!!!!!!!!!! PASE FILTRO";
										//Obtenog nombre
							$consultar = "SELECT estado FROM postulaciones WHERE idpostulante=$idpostulante";
							$res = $db->getResultArray($consultar);
							$estado=$res[0]['estado'];
							$consultar2="SELECT nombre  FROM datosgenerales WHERE idpostulante=$idpostulante";
							$res2 = $db->getResultArray($consultar2);
							$nombreFull=$res2[0]['nombre'];
							//
							 echo  '<tr>';
			                  echo "<td>$nombreFull</td>";
			                  echo "<td>$categoria</td>";
			                   echo "<td>$estado</td>";
			               echo "<td><a href=\"out.VerPostulacion.php?postulante=$idpostulante\">Acceder al perfil </a></td>";
		                    echo '</tr>';
								}						
							
							}//fin de si cumplo filtros
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
