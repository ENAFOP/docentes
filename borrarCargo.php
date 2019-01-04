<?php
include("./inc/inc.Settings.php");
include("./inc/inc.Utils.php");
include("./inc/inc.Init.php");
include("./inc/inc.DBInit.php");
 $id=$_GET['id'];
 $idpostulacion=$_GET['idpostulacion'];
$estadopostulacion=$_GET['estadopostulacion'];
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
    echo "borrarCargo.php: Error: no se pudo conectar a la BD para borrar cargo ";
	exit;
  } 
  $modificar="DELETE FROM cargos WHERE id=$id";
   $resultado1=$manejador->getResult($modificar);
        $historico="INSERT INTO historial VALUES (NULL,$idpostulacion,'$estadopostulacion',NOW(),'Se eliminó una entrada de la sección experiencia laboral')";		 
		  $resultado2=$manejador->getResult($historico);
   header('Location: '."/out/out.ModificarPerfil.php");
?>