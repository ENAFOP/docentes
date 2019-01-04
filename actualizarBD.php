<?php
header("Content-type:application/json");
include("./inc/inc.Settings.php");
include("./inc/inc.Utils.php");
include("./inc/inc.Init.php");
include("./inc/inc.DBInit.php");
/////////////////////////////////////////////////////////////////////////////////////////////////////////// MAIN ////////////////////////////////////////////////////////////////////////////////////////////////
$respuesta=true;
$paisResidencia = $_GET['paisResidencia'];
$numeroDocumento = $_GET['numeroDocumento'];
$telefono = $_GET['telefono'];
$correo = $_GET['correo'];		
$tipoDocumento = $_GET['tipoDocumento'];		
$telefono = $_GET['telefono'];
$idpostulante = $_GET['idpostulante'];
$nit = $_GET['nit'];
$genero = $_GET['genero'];
$edad = $_GET['edad'];
$departamento = $_GET['departamento'];
$municipio = $_GET['municipio'];
$estadoPostulacion = $_GET['estadoPostulacion'];				
$idpostulacion = $_GET['idpostulacion'];
$pestana = $_GET['pestana'];														
		  
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
    echo "actualizarBD.php: Error: no se pudo conectar a la BD para modificar a ";
	exit;
  } 
  // echo "Pais, numero, telefono, correo,tipo,nit: ".$paisResidencia.$numeroDocumento.$telefono.$correo.$tipoDocumento.$nit;
   
   if($pestana==1)
   {
		$modificar="UPDATE datosgenerales  SET correo = '$correo', pais='$paisResidencia', tipodocumento='$tipoDocumento', numerodocumento='$numeroDocumento', nit='$nit', telefono='$telefono', genero='$genero', edad='$edad', departamento='$departamento',municipio='$municipio' WHERE idpostulante=$idpostulante;";
		  //error_log ("mi query: ".$obtenerID);
		  $resultado1=$manejador->getResult($modificar);
		  if(!$resultado1)
		  {
			$respuesta=false;
		  }
		  $historico="INSERT INTO historial VALUES (NULL,$idpostulacion,'$estadoPostulacion',NOW(),'Cambios realizados en la sección datos generales')";
		  $resultado2=$manejador->getResult($historico);
		   if(!$resultado2)
		  {
			$respuesta=false;
		  }
   }
  // $obtenerID="SELECT id FROM departamentos WHERE departamento='$departamento'";
  // //error_log ("mi query: ".$obtenerID);
  // $resultado1=$manejador->getResultArray($obtenerID);
  // $idEfectivo=$resultado1[0]['id'];  
   // ////
  // $obtenerMunicipios="SELECT municipio FROM municipios WHERE idepartamento=$idEfectivo;";
  // $resultado2=$manejador->getResultArray($obtenerMunicipios); 
  // ////////////////////// EL SELECT
  // foreach ($resultado2 as $a) 
  // {
    // foreach ($a as $valor) 
    // {
       // $arrayMunicipios[]="<option value=\"".$valor."\">".$valor."</option>";
	   // //echo "Municipio: ".$valor;
    // }
  // }
echo json_encode($respuesta);
?>