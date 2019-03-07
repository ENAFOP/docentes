<?php
include("./inc/inc.Settings.php");
include("./inc/inc.Language.php");
include("./inc/inc.Init.php");
include("./inc/inc.Extension.php");
include("./inc/inc.DBInit.php");
include("./inc/inc.ClassUI.php");
include("./inc/inc.Authentication.php");
$folderid = $_POST["folderid"];
$estadopostulacion = $_POST["estadopostulacion"];
$idpostulacion = $_POST["idpostulacion"];
 $carpetaUsuario=$dms->getFolder($folderid);
$listaCarpetas=$carpetaUsuario->getSubFolders("n");
//////ESTE BUCLE DE RECORRER CARPETAS SOLO LO HAGO ONCE
$idCarpetaDocencia=0;
$idCarpetaTalleres=0;
$idCarpetaMetodologias=0;
$idCarpetaAdjuntos=0;
foreach ($listaCarpetas as $carpeta) 
{
    $nom=$carpeta->getName();
    if(strcmp($nom, "Atestados práctica docencia")==0)
    {
        $idCarpetaDocencia=$carpeta->getID();
    }
    if(strcmp($nom, "Atestados experiencia en formación")==0)
    {
        $idCarpetaTalleres=$carpeta->getID();
    }

    if(strcmp($nom, "Atestados manejo de metodologías")==0)
    {
        $idCarpetaMetodologias=$carpeta->getID();
    }
    if(strcmp($nom, "Documentos adjuntos")==0)
    {
        $idCarpetaAdjuntos=$carpeta->getID();
    }
}//FIN DE RECORRER CARPETAS PARA VER ID DE CARPETA. EXIGE TENERLAS CREADAS DE ANTEMANO
$manejoIngles="";
$manejoPrezi="";
$relevante="";
if (isset($_POST["manejoIngles"])) 
{
    $manejoIngles=$_POST["manejoIngles"];
    $arrayIdiomas=array();
    if(strcmp($manejoIngles, "si")==0)
    {
            if (isset($_POST["idiomas"])) 
            {
                $arrayIdiomas=$_POST["idiomas"];
                $arrayHablados=$_POST["hablados"];
                $arrayEscuchados=$_POST["escuchados"];
                $arrayEscritos=$_POST["escritos"];
                 $numIdiomas=count($arrayIdiomas);
                for ($i=0;$i<$numIdiomas;$i++) 
                {
                    $idioma=$arrayIdiomas[$i];
                    $hablado=$arrayHablados[$i];
                    $escuchado=$arrayEscuchados[$i];
                    $escrito=$arrayEscritos[$i];
                    $user->insertarIdiomas($idioma,$hablado,$escuchado,$escrito);
                }
            }   
        }
}
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
    echo "anadirTalleres.php: Error: no se pudo conectar a la BD para modificar a ";
	exit;
  } 
    $historico="INSERT INTO historial VALUES (NULL,$idpostulacion,'$estadopostulacion',NOW(),'Añadido un nuevo(s) idioma(s) en la sección idiomas dominados')";
		  //echo "Query historica: ".$historico;
		  $resultado2=$manejador->getResult($historico);
header('Location: '."out/out.ModificarPerfil.php"); 
?>