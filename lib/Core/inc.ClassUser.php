<?php
/**
 * Implementation of the user object in the ENAFOP SYSTEM
 *
 * @category   DMS
 * @package    SeedDMS_Core
 * @license    GPL 2
 * @version    @version@
 * @author     Uwe Steinmann <uwe@steinmann.cx>
 * @author     José Mario López leiva <marioleiva2011@gmail.com>
 * @copyright  Copyright (C) 2002-2005 Markus Westphal, 2006-2008 Malcolm Cowe,
 *             2010 Uwe Steinmann
 * @version    Release: 5.0.11
 */

class SeedDMS_Core_User { /* {{{ */
	/**
	 * @var integer id of user
	 *
	 * @access protected
	 */
	var $_id;

	/**
	 * @var string login name of user
	 *
	 * @access protected
	 */
	var $_login;

	/**
	 * @var string password of user as saved in database (md5)
	 *
	 * @access protected
	 */
	var $_pwd;

	/**
	 * @var string date when password expires
	 *
	 * @access protected
	 */
	var $_pwdExpiration;

	/**
	 * @var string full human readable name of user
	 *
	 * @access protected
	 */
	var $_fullName;

	/**
	 * @var string email address of user
	 *
	 * @access protected
	 */
	var $_email;

	/**
	 * @var string prefered language of user
	 *      possible values are subdirectories within the language directory
	 *
	 * @access protected
	 */
	var $_language;

	/**
	 * @var string preselected theme of user
	 *
	 * @access protected
	 */
	var $_theme;

	/**
	 * @var string comment of user
	 *
	 * @access protected
	 */
	var $_comment;

	/**
	 * @var string role of user. Can be one of SeedDMS_Core_User::role_user,
	 *      SeedDMS_Core_User::role_admin, SeedDMS_Core_User::role_guest
	 *
	 * @access protected
	 */
	var $_role;

	/**
	 * @var boolean true if user shall be hidden
	 *
	 * @access protected
	 */
	var $_isHidden;

	/**
	 * @var boolean true if user is disabled
	 *
	 * @access protected
	 */
	var $_isDisabled;

	/**
	 * @var int number of login failures
	 *
	 * @access protected
	 */
	var $_loginFailures;

	/**
	 * @var object home folder
	 *
	 * @access protected
	 */
	var $_homeFolder;

	/**
	 * @var object reference to the dms instance this user belongs to
	 *
	 * @access protected
	 */
	var $_dms;

	const role_user = '0';
	const role_admin = '1';
	const role_guest = '2';

	function __construct($id, $login, $pwd, $fullName, $email, $language, $theme, $comment, $role, $isHidden=0, $isDisabled=0, $pwdExpiration='0000-00-00 00:00:00', $loginFailures=0, $quota=0, $homeFolder=null) {
		$this->_id = $id;
		$this->_login = $login;
		$this->_pwd = $pwd;
		$this->_fullName = $fullName;
		$this->_email = $email;
		$this->_language = $language;
		$this->_theme = $theme;
		$this->_comment = $comment;
		$this->_role = $role;
		$this->_isHidden = $isHidden;
		$this->_isDisabled = $isDisabled;
		$this->_pwdExpiration = $pwdExpiration;
		$this->_loginFailures = $loginFailures;
		$this->_quota = $quota;
		$this->_homeFolder = $homeFolder;
		$this->_dms = null;
	}

	/**
	 * Create an instance of a user object
	 *
	 * @param string|integer $id Id, login name, or email of user, depending
	 * on the 3rd parameter.
	 * @param object $dms instance of dms
	 * @param string $by search by [name|email]. If 'name' is passed, the method
	 * will check for the 4th paramater and also filter by email. If this
	 * parameter is left empty, the user will be search by its Id.
	 * @param string $email optional email address if searching for name
	 * @return object instance of class SeedDMS_Core_User
	 */
	public static function getInstance($id, $dms, $by='', $email='') { /* {{{ */
		$db = $dms->getDB();

		switch($by) {
		case 'name':
			$queryStr = "SELECT * FROM `tblUsers` WHERE `login` = ".$db->qstr($id);
			if($email)
				$queryStr .= " AND `email`=".$db->qstr($email);
			break;
		case 'email':
			$queryStr = "SELECT * FROM `tblUsers` WHERE `email` = ".$db->qstr($id);
			break;
		default:
			$queryStr = "SELECT * FROM `tblUsers` WHERE `id` = " . (int) $id;
		}
		$resArr = $db->getResultArray($queryStr);

		if (is_bool($resArr) && $resArr == false) return false;
		if (count($resArr) != 1) return false;

		$resArr = $resArr[0];

		$user = new self($resArr["id"], $resArr["login"], $resArr["pwd"], $resArr["fullName"], $resArr["email"], $resArr["language"], $resArr["theme"], $resArr["comment"], $resArr["role"], $resArr["hidden"], $resArr["disabled"], $resArr["pwdExpiration"], $resArr["loginfailures"], $resArr["quota"], $resArr["homefolder"]);
		$user->setDMS($dms);
		return $user;
	} /* }}} */

	public static function getAllInstances($orderby, $dms) { /* {{{ */
		$db = $dms->getDB();

		if($orderby == 'fullname')
			$queryStr = "SELECT * FROM `tblUsers` ORDER BY `fullName`";
		else
			$queryStr = "SELECT * FROM `tblUsers` ORDER BY `login`";
		$resArr = $db->getResultArray($queryStr);

		if (is_bool($resArr) && $resArr == false)
			return false;

		$users = array();

		for ($i = 0; $i < count($resArr); $i++) {
			$user = new self($resArr[$i]["id"], $resArr[$i]["login"], $resArr[$i]["pwd"], $resArr[$i]["fullName"], $resArr[$i]["email"], (isset($resArr[$i]["language"])?$resArr[$i]["language"]:NULL), (isset($resArr[$i]["theme"])?$resArr[$i]["theme"]:NULL), $resArr[$i]["comment"], $resArr[$i]["role"], $resArr[$i]["hidden"], $resArr[$i]["disabled"], $resArr[$i]["pwdExpiration"], $resArr[$i]["loginfailures"], $resArr[$i]["quota"], $resArr[$i]["homefolder"]);
			$user->setDMS($dms);
			$users[$i] = $user;
		}

		return $users;
} /* }}} */
///////////////////////////////////////////////////// FUNCIONES AÑADIDAS POR MARIO ////////////////////////////////

function getDatoGeneralPostulante($idpostulante,$dato)
{
	    $postulaciones="";
		$db = $this->_dms->getDB();
		$consultar = "SELECT $dato FROM datosgenerales WHERE idpostulante=$idpostulante;";
		//echo "Consultar: ".$consultar;
		$res1 = $db->getResultArray($consultar);
		if($res1)
		{
			$postulaciones=$res1[0]["$dato"];
		}		
		return $postulaciones;
}
function getUsuarioPostulante($idpostulante) //me devuelve el nombre de login de un dado postulante
{
		$usuario = $this->_dms->getUser($idpostulante);
		return $usuario->getLogin();
	
}

function hayCarta($idpostulante) //me devuelve el nombre de login de un dado postulante
{
		$db = $this->_dms->getDB();
		$hay=false;
		$consultar = "SELECT id FROM cartas WHERE idpostulante=$idpostulante;";
		//echo "Consultar: ".$consultar;
		$res1 = $db->getResultArray($consultar);
		if($res1)
		{
			$hay=true;
		}		
		return $hay;	
}
function hayReferencias($idpostulante) //me devuelve el nombre de login de un dado postulante
{
		$db = $this->_dms->getDB();
		$hay=false;
		$consultar = "SELECT id FROM referencias_personales WHERE idpostulante=$idpostulante;";
		//echo "Consultar: ".$consultar;
		$res1 = $db->getResultArray($consultar);
		if($res1)
		{
			$hay=true;
		}		
		return $hay;	
}

function estaChatVacio($idpostulante) //devuelve true si el chat del postulante id está vacio
{

		$db = $this->_dms->getDB();
		$getNumChats="SELECT COUNT(id) FROM chat_log WHERE idchat=$idpostulante;";
					$tat = $db->getResultArray($getNumChats);
					$numbah=$tat[0]["COUNT(id)"];
					//echo "esta vacio: ".$getNumChats;

		return $numbah==0;
}
function ultimoEscritorChat($idchat) //devuelve true si el chat del postulante id está vacio
{

		$db = $this->_dms->getDB();
		$getNumChats="SELECT idescritor FROM chat_log WHERE idchat=$idchat ORDER BY ID DESC LIMIT 1";
					$tat = $db->getResultArray($getNumChats);
					$numbah=$tat[0]["idescritor"];
					//echo "esta vacio: ".$getNumChats;

		return $numbah;
}
function pedidoRevision($idpostulante) //devuelve true si el postulante con idpostulante, ha pedido revisión
{
		$db = $this->_dms->getDB();
		$getNumChats="SELECT estado FROM  postulaciones WHERE idpostulante=$idpostulante;";
					$tat = $db->getResultArray($getNumChats);
					$numbah=$tat[0]["estado"];
					//echo "esta vacio: ".$getNumChats;

		return strcmp($numbah, "revisado")==0;
}
function getChatID($idpostulante) //me da el id del chat para un dado postulante. SI no existe, crea el chat
{
		$chat=0;
		$db = $this->_dms->getDB();
		$consultar = "SELECT id from chat WHERE idpostulante=$idpostulante;";
		$res1 = $db->getResultArray($consultar);
		if(!$res1) //si null; debo crear el chat
		{
			$crearChat = "INSERT into chat VALUES (NULL,$idpostulante);";
			$res2 = $db->getResult($crearChat);//queda en la BD inicializaod el chat
			$consultar2 = "SELECT id from chat WHERE idpostulante=$idpostulante;";
			$res3 = $db->getResultArray($consultar2);//queda en la BD inicializaod el chat
			$chat=$res3[0]['id'];
		}
		else //si chat ya existe, devuelvo el ID
		{
			$chat=$res1[0]['id'];
		}	
	return $chat;
}
function getPostulacionesEstado($estado)
{
	    $postulaciones="";
		$idpostulante=$this->_id;
		$db = $this->_dms->getDB();
		$consultar = "SELECT COUNT(id) FROM postulaciones WHERE estado=\"$estado\"";
		//echo "Consultar: ".$consultar;
		$res1 = $db->getResultArray($consultar);
		if($res1)
		{
			$postulaciones=$res1[0]['COUNT(id)'];
		}		
		return $postulaciones;
}
function cuentaPostulaciones()
{
	    $postulaciones="";
		$idpostulante=$this->_id;
		$db = $this->_dms->getDB();
		$consultar = "SELECT COUNT(id) FROM postulaciones;";
		//echo "Consultar: ".$consultar;
		$res1 = $db->getResultArray($consultar);
		if($res1)
		{
			$postulaciones=$res1[0]['COUNT(id)'];
		}		
		return $postulaciones;
}
function getFechaPostulacion()
{
	    $estado="";
		$idpostulante=$this->_id;
		$db = $this->_dms->getDB();
		$consultar = "SELECT fecha FROM postulaciones WHERE idpostulante=$idpostulante";
		//echo "Consultar: ".$consultar;
		$res1 = $db->getResultArray($consultar);
		if($res1)
		{
			$estado=$res1[0]['fecha'];
		}		
		return $estado;
}
function getNombrePostulante()
{
	    $estado="";
		$idpostulante=$this->_id;
		$db = $this->_dms->getDB();
		$consultar = "SELECT nombre FROM datosgenerales WHERE idpostulante=$idpostulante";
		//echo "Consultar: ".$consultar;
		$res1 = $db->getResultArray($consultar);
		if($res1)
		{
			$estado=$res1[0]['nombre'];
		}		
		return $estado;
}
function getDatoGeneral($dato)
{
	    $estado="";
		$idpostulante=$this->_id;
		$db = $this->_dms->getDB();
		$consultar = "SELECT $dato FROM datosgenerales WHERE idpostulante=$idpostulante";
		//echo "Consultar: ".$consultar;
		$res1 = $db->getResultArray($consultar);
		if($res1)
		{
			$estado=$res1[0]["$dato"];
		}		
		return $estado;
}
 /**
	 * getEstadoPostulacion: me da el estado de postulacion de un usuario postulante
	 *
	 * @return true si inserción correcta
	 */
	 function getEstadoPostulacion()
	 {
	 	$estado="";
		$idpostulante=$this->_id;
		$db = $this->_dms->getDB();
		$consultar = "SELECT estado FROM postulaciones WHERE idpostulante=$idpostulante";
		//echo "Consultar: ".$consultar;
		$res1 = $db->getResultArray($consultar);
		if($res1)
		{
			$estado=$res1[0]['estado'];
		}
		
		return $estado;
	 }
	 function getIDPostulacion()
	 {
	 	$estado="";
		$idpostulante=$this->_id;
		$db = $this->_dms->getDB();
		$consultar = "SELECT id FROM postulaciones WHERE idpostulante=$idpostulante";
		//echo "Consultar: ".$consultar;
		$res1 = $db->getResultArray($consultar);
		if($res1)
		{
			$estado=$res1[0]['id'];
		}
		
		return $estado;
	 }
	 function getEstadoPostulacionByUser($idUser)
	 {
	 	$estado="";
		$db = $this->_dms->getDB();
		$consultar = "SELECT estado FROM postulaciones WHERE idpostulante=$idUser";
		//echo "Consultar: ".$consultar;
		$res1 = $db->getResultArray($consultar);
		if($res1)
		{
			$estado=$res1[0]['estado'];
		}
		
		return $estado;
	 }
	 function getPostulantePublico($idUser)
	 {
	 	$estado="";
		$db = $this->_dms->getDB();
		$consultar = "SELECT publico FROM datosgenerales where idpostulante=$idUser;";
		//echo "Consultar: ".$consultar;
		$res1 = $db->getResultArray($consultar);
		if($res1)
		{
			$estado=$res1[0]['publico'];
		}
		
		return $estado;
	 }

	 function getAnosLaboresODocencia($idUser,$tabla)
	 {
	 	$total=0;
		$db = $this->_dms->getDB();
		$consultar = "SELECT anoinicio,anofin FROM $tabla WHERE idpostulante=$idUser;";
		//echo "Consultar: ".$consultar;
		$res1 = $db->getResultArray($consultar);
		if($res1)
		{
			foreach ($res1 as $key) 
			{
				//print_r("Aubarray: ".$key);
				$fechaInicio=$key['anoinicio'];
				$fechaFin=$key['anofin']; 
				$fechita1=strtotime($fechaInicio);
				$fechita2=strtotime($fechaFin);
				$datediff = abs($fechita2-$fechita1);
			    $totalDias=round($datediff / (60 * 60 * 24));
			    $totalAnos=round($totalDias/365,1);
			    $total=$total+$totalAnos;
			}
		}		
		return $total;
	 }
	 function getAnosCapacitacion($idUser)
	 {
	 	$total=0;
		$db = $this->_dms->getDB();
		$consultar = "SELECT fechainicio,fechafin FROM experiencia_formacion WHERE idpostulante=$idUser;";
		//echo "Consultar: ".$consultar;
		$res1 = $db->getResultArray($consultar);
		if($res1)
		{
			foreach ($res1 as $key) 
			{
				$fechaInicio=$key['fechainicio'];
				$fechaFin=$key['fechafin']; 
				$fechita1=strtotime($fechaInicio);
				$fechita2=strtotime($fechaFin);
				$datediff = abs($fechita2-$fechita1);
			    $totalDias=round($datediff / (60 * 60 * 24));
			    $totalAnos=round($totalDias/365,1);
			    $total=$total+$totalAnos;
			}
		}		
		return $total;
	 }

	 function getFotoPostulante($idUser)
	 {
	 	$enlace=false;
		$usuario=$this->_dms->getUser($idUser);
		if($usuario->hasImage())
		{
			$enlace="/out/out.UserImage.php?userid=$idUser";
		}
		return $enlace;
	 }
	 function getFotoPostulante2($idUser)
	 {
	 	$enlace=false;
		$usuario=$this->_dms->getUser($idUser);
		if($usuario->hasImage())
		{
			$enlace=$usuario->getImage();
		}
		return $enlace;
	 }



       /**
	 * crearPostulacion: mete datos sobre la postulacion
	 *
	 * @return true si inserción correcta
	 */
		function crearPostulacion()
		{
		$res=true;
		$idpostulante=$this->_id;
		$db = $this->_dms->getDB();
		$insertar = "INSERT INTO postulaciones VALUES (NULL,$idpostulante,NOW(),'postulado');";
		//echo "query crear postulacion: ".$insertar;
		$res1 = $db->getResultArray($insertar);
		//echo "res1: ".$res1;
		if (!$res1)
		{
			//echo "aqui...";
			$res=false;
		}
		//echo "res: ".$res;
		return $res;
		}

//////////////PESTAÑA 1
		/**
	 * insertarDatos: ingresa datos de la pestaña 1
	 *
	 * @param idUsuario
	 * @return true si inserción correcta
	 */
	 function insertarDatos($nombre,$correo,$pais,$tipodocumento,$numerodocumento,$nit,$telefono,$departamento,$municipio,$publico,$genero,$edad)
	 {
	 	$res=true;
		$idpostulante=$this->_id;
		$db = $this->_dms->getDB();
		$insertar = "INSERT INTO datosgenerales VALUES(NULL,$idpostulante,'$nombre','$correo','$pais','$tipodocumento','$numerodocumento','$nit','$telefono','$departamento','$municipio',$publico,'$genero',$edad)";
		//echo "INSERTAR: ".$insertar;
		$res1 = $db->getResult($insertar);
		if (!$res1)
		{
			$res=false;
		}
		return $res;
	 }
	 //////////////PESTAÑA 2
	 /**
	 * insertarCargo: ingresa una experiencia laboral de un postulante (pestaña 2)
	 *
	 * @param idUsuario
	 * @return true si inserción correcta
	 */
	function insertarCargo($cargo,$anoInicio,$anoFin,$funciones,$institucion) 
	{
		$res=true;
		$idpostulante=$this->_id;
		$db = $this->_dms->getDB();
		$insertarCargo = "INSERT INTO `cargos` VALUES (NULL,$idpostulante,'$cargo','$funciones','$institucion','$anoInicio','$anoFin')";
		//echo "QUERY INSERCION CARGO. ".$insertarCargo;
		$res1 = $db->getResult($insertarCargo);
		if (!$res1)
		{
			$res=false;
		}	
		return $res;
	}
    //////////////PESTAÑA 3
	function insertarPestanaGrado($tabla,$idCarpeta,$titulo,$nombreTitulo,$ano,$institucion,$ubicacionTemporal,$fileTipo,$userFileTipo,$userFileNombre) 
	{
		$res=true;
		$idpostulante=$this->_id;
		$db = $this->_dms->getDB();
//SUBIDA DE FICHERO;
$idAtestado=0;
		$folder=$this->_dms->getFolder($idCarpeta);
        if (!is_object($folder)) 
        {
	UI::exitError(getMLText("folder_title", array("foldername" => getMLText("invalid_folder_id"))),getMLText("invalid_folder_id"));
		}

		$folderPathHTML = getFolderPathHTML($folder, true);
		if ($folder->getAccessMode($this) < M_READWRITE) 
		{
			UI::exitError(getMLText("folder_title", array("foldername" => $folder->getName())),"Acceso denegado para subir ficheros en insertarPestanaGrado (3 pestaña)");
		}
    	$comment="Este es un atestado sobre la formación del postulante";
    	$owner=$this; //el mismo que subé será el dueño
    	$keywords="";
    	$atributos=array(); //no se manejan categorías en este sistema
    	$arrayCategorias=array();
	      $sequence=1;
	      $reviewers=array();
	      $approvers=array();
	       $reqversion=1;
        $version_comment="";
  $subida=$folder->addDocument(basename($userFileNombre),$comment,0,$owner,$keywords,$arrayCategorias,$ubicacionTemporal,basename($userFileNombre),$fileTipo,$userFileTipo,$sequence,$reviewers,$approvers,$reqversion,$version_comment,$atributos,NULL,NULL);
     if (is_bool($subida) && !$subida) 
     {
      UI::exitError(getMLText("folder_title", array("foldername" => "Pestaña 3 error al subir fichero")),getMLText("error_occured"));
     } 
        //-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.--.-.-.-.--.-..-.-.-.-.-.-.-.-.-.-.-.-..-.-.
		////////ahora si, hago la metida		 
	    if (!$subida)
		{
			$res=false;
		}
		else 
		{
		//ECHO "ULLALA SE PUDO SUBIR";
		$document = $subida[0];
			if(isset($GLOBALS['SEEDDMS_HOOKS']['addDocument'])) {
				foreach($GLOBALS['SEEDDMS_HOOKS']['addDocument'] as $hookObj) {
					if (method_exists($hookObj, 'postAddDocument')) 
					{
						$hookObj->postAddDocument($document);
					}
				}
			}
			$idAtestado=$document->getID();
		///////////metida en BD
	$insertarCargo = "INSERT INTO `$tabla` VALUES (NULL,$idpostulante,'$titulo','$nombreTitulo','$ano','$institucion',$idAtestado)";
		$res1 = $db->getResult($insertarCargo);
		if (!$res1)
		{
			$res=false;
		}	
		return $res;
	}
}
	
	//////////////PESTAÑA 4
	function insertarTema($sufijo,$nombreTema,$catego) 
	{
		$res=true;
		$idpostulante=$this->_id;
		$db = $this->_dms->getDB();
	$insertarCargo = "INSERT INTO `temas_$sufijo` VALUES (NULL,$idpostulante,'$nombreTema','$catego')";
		$res1 = $db->getResult($insertarCargo);
		if (!$res1)
		{
			$res=false;
		}	
		return $res;
	}
	function insertarConocimentosAdicionales($conocimentos) //adenda de observaciones feb. 2018
	{
		$res=true;
		$idpostulante=$this->_id;
		$db = $this->_dms->getDB();
	$insertarCargo = "INSERT INTO `conocimientos_adicionales` VALUES (NULL,$idpostulante,'$conocimentos')";
	//echo "insertar conocimentos: ".$insertarCargo; exit;
		$res1 = $db->getResult($insertarCargo);
		if (!$res1)
		{
			$res=false;
		}	
		return $res;
	}
	function hayConocimientosAdicionales($idpostulante) //adenda de observaciones feb. 2018
	{
		$db = $this->_dms->getDB();
		$getNumChats="SELECT COUNT(idpostulante) FROM conocimientos_adicionales WHERE idpostulante=$idpostulante";
					$tat = $db->getResultArray($getNumChats);
					$numbah=$tat[0]["COUNT(idpostulante)"];
					//echo "esta vacio: ".$getNumChats;
		return $numbah!=0;
	}

	function getConocimientosAdicionales($idpostulante) //adenda de observaciones feb. 2018
	{
		$db = $this->_dms->getDB();
		$getNumChats="SELECT conocimientos,id FROM conocimientos_adicionales WHERE idpostulante=$idpostulante";
					$tat = $db->getResultArray($getNumChats);
					$numbah=$tat[0]['conocimientos'];
					//echo "esta vacio: ".$getNumChats;
		return $numbah;
	}


	//PESTAÑA 5
	function insertarMaterias($idCarpeta,$ubicacionTemporal,$fileType,$userFileTipo,$userFileNombre,$materia,$institucion,$fechaInicio,$fechaFin,$modalidad) 
	{
		$res=true;
		$idpostulante=$this->_id;
		$db = $this->_dms->getDB();
		$idAtestado=0;
		$folder=$this->_dms->getFolder($idCarpeta);
        if (!is_object($folder)) 
        {
	UI::exitError(getMLText("folder_title", array("foldername" => getMLText("invalid_folder_id"))),getMLText("invalid_folder_id"));
		}

		$folderPathHTML = getFolderPathHTML($folder, true);
		if ($folder->getAccessMode($this) < M_READWRITE) 
		{
			UI::exitError(getMLText("folder_title", array("foldername" => $folder->getName())),"Acceso denegado para subir atestados de Materias (Pestaña 5)");
		}

    	$comment="Este es un atestado sobre la experiencia en impartición de docencia del postulante";
    	$owner=$this; //el mismo que subé será el dueño
    	$keywords="";
    	$atributos=array(); //no se manejan categorías en este sistema
    	$arrayCategorias=array();
	    $catego=$this->_dms->getDocumentCategoryByName("Práctica docencia");
	    //$idCatego=$catego->getID(); 
	    $arrayCategorias[]=$catego;
	      $sequence=1;
	      $reviewers=array();
	      $approvers=array();
	       $reqversion=1;
        $version_comment="";

    	//-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.--.-.-.-.--.-..-.-.-.-.-.-.-.-.-.-.-.-..-.-.
    	/**
        addDocument(string $name, string $comment, integer $expires, object $owner, string $keywords, array $categories, string $tmpFile, 
        string $orgFileName, string $fileType, string $mimeType, float $sequence, array $reviewers, array $approvers, string $reqversion, 
        string $version_comment, array $attributes, array $version_attributes,  $workflow) : \array/boolean
        **/
  $subida=$folder->addDocument(basename($userFileNombre),$comment,0,$owner,$keywords,$arrayCategorias,$ubicacionTemporal,basename($userFileNombre),$fileType,$userFileTipo,$sequence,$reviewers,$approvers,$reqversion,$version_comment,$atributos,NULL,NULL);
     if (is_bool($subida) && !$subida) 
     {
      UI::exitError(getMLText("folder_title", array("foldername" => "Pestaña 5 error al subir fichero")),getMLText("error_occured"));
     } 
        //-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.--.-.-.-.--.-..-.-.-.-.-.-.-.-.-.-.-.-..-.-.
		////////ahora si, hago la metida		 
	    if (!$subida)
		{
			$res=false;
		}
		else 
		{
			//ECHO "ULLALA SE PUDO SUBIR";
		$document = $subida[0];


			if(isset($GLOBALS['SEEDDMS_HOOKS']['addDocument'])) {
				foreach($GLOBALS['SEEDDMS_HOOKS']['addDocument'] as $hookObj) {
					if (method_exists($hookObj, 'postAddDocument')) 
					{
						$hookObj->postAddDocument($document);
					}
				}
			}
			$idAtestado=$document->getID();
			//echo "ID DEl nuevo creado fichero: ".$idAtestado;
			$insertarCargo = "INSERT INTO `materias_docencia` VALUES (NULL,$idpostulante,'$materia','$institucion','$fechaInicio','$fechaFin','$modalidad',$idAtestado)";
		    $res1 = $db->getResult($insertarCargo);	
		    if(!$res1)
		    {
		    	$res=false;
		    }
		}
		return $res;
	}
	//PESTAÑA 6
	function insertarTalleres($idCarpeta,$ubicacionTemporal,$fileType,$userFileTipo,$userFileNombre,$taller,$totalHoras,$fechaInicio,$fechaFin,$institucion,$modalidad) 
	{
		$res=true;
		$idpostulante=$this->_id;
		$db = $this->_dms->getDB();
		$idAtestado=0;
		$folder=$this->_dms->getFolder($idCarpeta);
		// echo " <br> Core: ID de folder donde me han dicho meta este documento: ".$idCarpeta."<br>";
  //       echo "Core: modalidad con que me llaman: ".$modalidad."<br>";
       
  //       echo "Core: ubicacion temporal con que me llaman: ".$ubicacionTemporal."<br>";
  //       echo "Core: fileType con que me llaman: ".$fileType."<br>";
  //       echo "Core: userFileNombre con que me llaman: ".$userFileNombre."<br>";
        //llamo a la api PARA PODER METER EL DOCUMENTO EN LA CARPETA CORRECTA
        if (!is_object($folder)) 
        {
	UI::exitError(getMLText("folder_title", array("foldername" => getMLText("invalid_folder_id"))),getMLText("invalid_folder_id"));
		}

		$folderPathHTML = getFolderPathHTML($folder, true);

		if ($folder->getAccessMode($this) < M_READWRITE) {
			UI::exitError(getMLText("folder_title", array("foldername" => "Pestaña 6 error al subir fichero")),getMLText("access_denied"));
		}

    	$comment="Este es un atestado sobre la experiencia en formación y capacitación del postulante";
    	$owner=$this; //el mismo que subé será el dueño
    	$keywords="";
    	$atributos=array(); //no se manejan categorías en este sistema
    	$arrayCategorias=array();
	    $catego=$this->_dms->getDocumentCategoryByName("Experiencia en formación");
	    //$idCatego=$catego->getID(); 
	    $arrayCategorias[]=$catego;
	      $sequence=1;
	      $reviewers=array();
	      $approvers=array();
	       $reqversion=1;
        $version_comment="";

    	//-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.--.-.-.-.--.-..-.-.-.-.-.-.-.-.-.-.-.-..-.-.
    	/**
        addDocument(string $name, string $comment, integer $expires, object $owner, string $keywords, array $categories, string $tmpFile, 
        string $orgFileName, string $fileType, string $mimeType, float $sequence, array $reviewers, array $approvers, string $reqversion, 
        string $version_comment, array $attributes, array $version_attributes,  $workflow) : \array/boolean
        **/
  $subida=$folder->addDocument(basename($userFileNombre),$comment,0,$owner,$keywords,$arrayCategorias,$ubicacionTemporal,basename($userFileNombre),$fileType,$userFileTipo,$sequence,$reviewers,$approvers,$reqversion,$version_comment,$atributos,NULL,NULL);
     if (is_bool($subida) && !$subida) 
     {
      UI::exitError(getMLText("folder_title", array("foldername" => $folder->getName())),getMLText("error_occured"));
     } 
        //-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.--.-.-.-.--.-..-.-.-.-.-.-.-.-.-.-.-.-..-.-.
		////////ahora si, hago la metida		 
	    if (!$subida)
		{
			$res=false;
		}
		else 
		{
		$document = $subida[0];
			if(isset($GLOBALS['SEEDDMS_HOOKS']['addDocument'])) {
				foreach($GLOBALS['SEEDDMS_HOOKS']['addDocument'] as $hookObj) {
					if (method_exists($hookObj, 'postAddDocument')) 
					{
						$hookObj->postAddDocument($document);
					}
				}
			}
			$idAtestado=$document->getID();
			$insertarCargo = "INSERT INTO `experiencia_formacion` VALUES (NULL,$idpostulante,'$taller',$totalHoras,'$fechaInicio','$fechaFin','$modalidad','$institucion',$idAtestado)";
		    $res1 = $db->getResult($insertarCargo);	
		    if(!$res1)
		    {
		    	$res=false;
		    }
		}
		return $res;
	}
   //PESTAÑA 7	
	function insertarMetodologia($sufijo,$idCarpeta,$ubicacionTemporal,$fileType,$userFileTipo,$userFileNombre,$experiencia) 
	{
		$res=true;
		$idpostulante=$this->_id;
		$db = $this->_dms->getDB();
		$idAtestado=0;
		$folder=$this->_dms->getFolder($idCarpeta);
        //llamo a la api PARA PODER METER EL DOCUMENTO EN LA CARPETA CORRECTA
        if (!is_object($folder)) 
        {
	UI::exitError(getMLText("folder_title", array("foldername" => getMLText("invalid_folder_id"))),getMLText("invalid_folder_id"));
		}

		$folderPathHTML = getFolderPathHTML($folder, true);

		if ($folder->getAccessMode($this) < M_READWRITE) {
			UI::exitError(getMLText("folder_title", array("foldername" => $folder->getName())),"Acceso denegado al querer subir archivo en insertarMetodologia (Pestaña 7)");
		}
    	$comment="Este es un atestado sobre la experiencia en manejo de metodologías del postulante";
    	$owner=$this; //el mismo que subé será el dueño
    	$keywords="";
    	$atributos=array(); //no se manejan categorías en este sistema
    	$arrayCategorias=array();
	    $catego=$this->_dms->getDocumentCategoryByName("Manejo de metodologías");
	    $arrayCategorias[]=$catego;
	      $sequence=1;
	      $reviewers=array();
	      $approvers=array();
	       $reqversion=1;
        $version_comment="";
    	//-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.--.-.-.-.--.-..-.-.-.-.-.-.-.-.-.-.-.-..-.-.
    	/**
        addDocument(string $name, string $comment, integer $expires, object $owner, string $keywords, array $categories, string $tmpFile, 
        string $orgFileName, string $fileType, string $mimeType, float $sequence, array $reviewers, array $approvers, string $reqversion, 
        string $version_comment, array $attributes, array $version_attributes,  $workflow) : \array/boolean
        **/
  $subida=$folder->addDocument(basename($userFileNombre),$comment,0,$owner,$keywords,$arrayCategorias,$ubicacionTemporal,basename($userFileNombre),$fileType,$userFileTipo,$sequence,$reviewers,$approvers,$reqversion,$version_comment,$atributos,NULL,NULL);
     if (is_bool($subida) && !$subida) 
     {
      UI::exitError(getMLText("folder_title", array("foldername" => "Pestaña 7 error al subir fichero")),getMLText("error_occured"));
     } 
        //-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.--.-.-.-.--.-..-.-.-.-.-.-.-.-.-.-.-.-..-.-.
		////////ahora si, hago la metida		 
	    if (!$subida)
		{
			$res=false;
		}
		else 
		{
		$document = $subida[0];
			if(isset($GLOBALS['SEEDDMS_HOOKS']['addDocument'])) {
				foreach($GLOBALS['SEEDDMS_HOOKS']['addDocument'] as $hookObj) {
					if (method_exists($hookObj, 'postAddDocument')) 
					{
						$hookObj->postAddDocument($document);
					}
				}
			}
			$idAtestado=$document->getID();
			$insertarCargo = "INSERT INTO `metodologias_$sufijo` VALUES (NULL,$idpostulante,'$experiencia',$idAtestado)";
		    $res1 = $db->getResult($insertarCargo);	
		    if(!$res1)
		    {
		    	$res=false;
		    }
		}
		return $res;
	}
	//pestaña 8

	function insertarPrezi($manejoIngles,$manejoPrezi,$relevante)
	{
		$res=true;
		$idpostulante=$this->_id;
		$db = $this->_dms->getDB();
		$insertarCargo = "INSERT INTO `otros` VALUES (NULL,$idpostulante,'$manejoIngles','$manejoPrezi','$relevante')";
		    $res1 = $db->getResult($insertarCargo);	
		    if(!$res1)
		    {
		    	$res=false;
		    }
	}
	//////////////PESTAÑA 8
	function insertarIdiomas($idioma,$hablado,$escuchado,$escrito) 
	{
		$res=true;
		$idpostulante=$this->_id;
		$db = $this->_dms->getDB();
	    $insertarCargo = "INSERT INTO `idiomas` VALUES (NULL,$idpostulante,'$idioma',$hablado,$escuchado,$escrito)";
		$res1 = $db->getResult($insertarCargo);
		if (!$res1)
		{
			$res=false;
		}	
		return $res;
	}	
	//pestaña 9
	function insertarAdjunto($sufijo,$idCarpeta,$ubicacionTemporal,$fileType,$userFileTipo,$userFileNombre) 
	{
		$res=true;
		$idpostulante=$this->_id;
		$db = $this->_dms->getDB();
		$idAtestado=0;
		$folder=$this->_dms->getFolder($idCarpeta);
		//echo "Nombre del folder donde meto: ".$folder->getName();
        //llamo a la api PARA PODER METER EL DOCUMENTO EN LA CARPETA CORRECTA
        if (!is_object($folder)) 
        {
	UI::exitError(getMLText("folder_title", array("foldername" => getMLText("invalid_folder_id"))),getMLText("invalid_folder_id"));
		}

		$folderPathHTML = getFolderPathHTML($folder, true);

		if ($folder->getAccessMode($this) < M_READWRITE) 
		{
			UI::exitError(getMLText("folder_title", array("foldername" => $folder->getName())),"Acceso denegado para subir adjuntos en la Pestaña 9 (carta de motivación y referencias)");
		}
    	$comment="Este es un documento anexo subido por el postulante";
    	$owner=$this; //el mismo que subé será el dueño
    	$keywords="";
    	$atributos=array(); //no se manejan categorías en este sistema
    	$arrayCategorias=array();
	      $sequence=1;
	      $reviewers=array();
	      $approvers=array();
	       $reqversion=1;
        $version_comment="";
    	//-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.--.-.-.-.--.-..-.-.-.-.-.-.-.-.-.-.-.-..-.-.
    	/**
        addDocument(string $name, string $comment, integer $expires, object $owner, string $keywords, array $categories, string $tmpFile, 
        string $orgFileName, string $fileType, string $mimeType, float $sequence, array $reviewers, array $approvers, string $reqversion, 
        string $version_comment, array $attributes, array $version_attributes,  $workflow) : \array/boolean
        **/
  $subida=$folder->addDocument(basename($userFileNombre),$comment,0,$owner,$keywords,$arrayCategorias,$ubicacionTemporal,basename($userFileNombre),$fileType,$userFileTipo,$sequence,$reviewers,$approvers,$reqversion,$version_comment,$atributos,NULL,NULL);
     if (is_bool($subida) && !$subida) 
     {
      UI::exitError(getMLText("folder_title", array("foldername" => $folder->getName())),"Error subiendo el archivo $userFileNombre");
     } 
        //-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.--.-.-.-.--.-..-.-.-.-.-.-.-.-.-.-.-.-..-.-.
		////////ahora si, hago la metida		 
	    if (!$subida)
		{
			$res=false;
		}
		else 
		{
		$document = $subida[0];
			if(isset($GLOBALS['SEEDDMS_HOOKS']['addDocument'])) {
				foreach($GLOBALS['SEEDDMS_HOOKS']['addDocument'] as $hookObj) {
					if (method_exists($hookObj, 'postAddDocument')) 
					{
						$hookObj->postAddDocument($document);
					}
				}
			}
			$idAtestado=$document->getID();
			$insertarCargo = "INSERT INTO `$sufijo` VALUES (NULL,$idpostulante,$idAtestado)";
		    $res1 = $db->getResult($insertarCargo);	
		    if(!$res1)
		    {
		    	$res=false;
		    }
		}
		return $res;
	}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function setDMS($dms) {
		$this->_dms = $dms;
	}

	function getID() { return $this->_id; }

	function getLogin() { return $this->_login; }

	function setLogin($newLogin) { /* {{{ */
		$db = $this->_dms->getDB();

		$queryStr = "UPDATE `tblUsers` SET `login` =".$db->qstr($newLogin)." WHERE `id` = " . $this->_id;
		$res = $db->getResult($queryStr);
		if (!$res)
			return false;

		$this->_login = $newLogin;
		return true;
	} /* }}} */

	function getFullName() { return $this->_fullName; }


	function setFullName($newFullName) { /* {{{ */
		$db = $this->_dms->getDB();

		$queryStr = "UPDATE `tblUsers` SET `fullName` = ".$db->qstr($newFullName)." WHERE `id` = " . $this->_id;
		$res = $db->getResult($queryStr);
		if (!$res)
			return false;

		$this->_fullName = $newFullName;
		return true;
	} /* }}} */

	function getPwd() { return $this->_pwd; }

	function setPwd($newPwd) { /* {{{ */
		$db = $this->_dms->getDB();

		$queryStr = "UPDATE `tblUsers` SET `pwd` =".$db->qstr($newPwd)." WHERE `id` = " . $this->_id;
		$res = $db->getResult($queryStr);
		if (!$res)
			return false;

		$this->_pwd = $newPwd;
		return true;
	} /* }}} */

	function getPwdExpiration() { return $this->_pwdExpiration; }

	function setPwdExpiration($newPwdExpiration) { /* {{{ */
		$db = $this->_dms->getDB();

		if(trim($newPwdExpiration) == '' || trim($newPwdExpiration) == 'never')
			$newPwdExpiration = '0000-00-00 00:00:00';
		elseif(trim($newPwdExpiration) == 'now')
			$newPwdExpiration = date('Y-m-d H:i:s');
		$queryStr = "UPDATE `tblUsers` SET `pwdExpiration` =".$db->qstr($newPwdExpiration)." WHERE `id` = " . $this->_id;
		$res = $db->getResult($queryStr);
		if (!$res)
			return false;

		$this->_pwdExpiration = $newPwdExpiration;
		return true;
	} /* }}} */

	function getEmail() { return $this->_email; }

	function setEmail($newEmail) { /* {{{ */
		$db = $this->_dms->getDB();

		$queryStr = "UPDATE `tblUsers` SET `email` =".$db->qstr($newEmail)." WHERE `id` = " . $this->_id;
		$res = $db->getResult($queryStr);
		if (!$res)
			return false;

		$this->_email = $newEmail;
		return true;
	} /* }}} */

	function getLanguage() { return $this->_language; }

	function setLanguage($newLanguage) { /* {{{ */
		$db = $this->_dms->getDB();

		$queryStr = "UPDATE `tblUsers` SET `language` =".$db->qstr($newLanguage)." WHERE `id` = " . $this->_id;
		$res = $db->getResult($queryStr);
		if (!$res)
			return false;

		$this->_language = $newLanguage;
		return true;
	} /* }}} */

	function getTheme() { return $this->_theme; }

	function setTheme($newTheme) { /* {{{ */
		$db = $this->_dms->getDB();

		$queryStr = "UPDATE `tblUsers` SET `theme` =".$db->qstr($newTheme)." WHERE `id` = " . $this->_id;
		$res = $db->getResult($queryStr);
		if (!$res)
			return false;

		$this->_theme = $newTheme;
		return true;
	} /* }}} */

	function getComment() { return $this->_comment; }

	function setComment($newComment) { /* {{{ */
		$db = $this->_dms->getDB();

		$queryStr = "UPDATE `tblUsers` SET `comment` =".$db->qstr($newComment)." WHERE `id` = " . $this->_id;
		$res = $db->getResult($queryStr);
		if (!$res)
			return false;

		$this->_comment = $newComment;
		return true;
	} /* }}} */

	function getRole() { return $this->_role; }

	function setRole($newrole) { /* {{{ */
		$db = $this->_dms->getDB();

		$queryStr = "UPDATE `tblUsers` SET `role` = " . $newrole . " WHERE `id` = " . $this->_id;
		if (!$db->getResult($queryStr))
			return false;

		$this->_role = $newrole;
		return true;
	} /* }}} */

	function isAdmin() { return ($this->_role == SeedDMS_Core_User::role_admin); }

	function setAdmin($isAdmin) { /* {{{ */
		$db = $this->_dms->getDB();

		$queryStr = "UPDATE `tblUsers` SET `role` = " . SeedDMS_Core_User::role_admin . " WHERE `id` = " . $this->_id;
		if (!$db->getResult($queryStr))
			return false;

		$this->_role = SeedDMS_Core_User::role_admin;
		return true;
	} /* }}} */

	function isGuest() { return ($this->_role == SeedDMS_Core_User::role_guest); }

	function setGuest($isGuest) { /* {{{ */
		$db = $this->_dms->getDB();

		$queryStr = "UPDATE `tblUsers` SET `role` = " . SeedDMS_Core_User::role_guest . " WHERE `id` = " . $this->_id;
		if (!$db->getResult($queryStr))
			return false;

		$this->_role = SeedDMS_Core_User::role_guest;
		return true;
	} /* }}} */

	function isHidden() { return $this->_isHidden; }

	function setHidden($isHidden) { /* {{{ */
		$db = $this->_dms->getDB();

		$isHidden = ($isHidden) ? "1" : "0";
		$queryStr = "UPDATE `tblUsers` SET `hidden` = " . $isHidden . " WHERE `id` = " . $this->_id;
		if (!$db->getResult($queryStr))
			return false;

		$this->_isHidden = $isHidden;
		return true;
	}	 /* }}} */

	function isDisabled() { return $this->_isDisabled; }

	function setDisabled($isDisabled) { /* {{{ */
		$db = $this->_dms->getDB();

		$isDisabled = ($isDisabled) ? "1" : "0";
		$queryStr = "UPDATE `tblUsers` SET `disabled` = " . $isDisabled . " WHERE `id` = " . $this->_id;
		if (!$db->getResult($queryStr))
			return false;

		$this->_isDisabled = $isDisabled;
		return true;
	}	 /* }}} */

	function addLoginFailure() { /* {{{ */
		$db = $this->_dms->getDB();

		$this->_loginFailures++;
		$queryStr = "UPDATE `tblUsers` SET `loginfailures` = " . $this->_loginFailures . " WHERE `id` = " . $this->_id;
		if (!$db->getResult($queryStr))
			return false;

		return $this->_loginFailures;
	} /* }}} */

	function clearLoginFailures() { /* {{{ */
		$db = $this->_dms->getDB();

		$this->_loginFailures = 0;
		$queryStr = "UPDATE `tblUsers` SET `loginfailures` = " . $this->_loginFailures . " WHERE `id` = " . $this->_id;
		if (!$db->getResult($queryStr))
			return false;

		return true;
	} /* }}} */

	/**
	 * Calculate the disk space for all documents owned by the user
	 * 
	 * This is done by using the internal database field storing the
	 * filesize of a document version.
	 *
	 * @return integer total disk space in Bytes
	 */
	function getUsedDiskSpace() { /* {{{ */
		$db = $this->_dms->getDB();

		$queryStr = "SELECT SUM(`fileSize`) sum FROM `tblDocumentContent` a LEFT JOIN `tblDocuments` b ON a.`document`=b.`id` WHERE b.`owner` = " . $this->_id;
		$resArr = $db->getResultArray($queryStr);
		if (is_bool($resArr) && $resArr == false)
			return false;

		return $resArr[0]['sum'];
	} /* }}} */

	function getQuota() { return $this->_quota; }

	function setQuota($quota) { /* {{{ */
		$db = $this->_dms->getDB();

		$quota = intval($quota);
		$queryStr = "UPDATE `tblUsers` SET `quota` = " . $quota . " WHERE `id` = " . $this->_id;
		if (!$db->getResult($queryStr))
			return false;

		$this->_quota = $quota;
		return true;
	}	 /* }}} */

	function getHomeFolder() { return $this->_homeFolder; }

	function setHomeFolder($homefolder) { /* {{{ */
		$db = $this->_dms->getDB();

		$queryStr = "UPDATE `tblUsers` SET `homefolder` = " . ($homefolder ? (int) $homefolder : NULL) . " WHERE `id` = " . $this->_id;
		if (!$db->getResult($queryStr))
			return false;

		$this->_homeFolder = $homefolder;
		return true;
	}	 /* }}} */

	/**
	 * Remove the user and also remove all its keywords, notifies, etc.
	 * Do not remove folders and documents of the user, but assign them
	 * to a different user.
	 *
	 * @param object $user the user doing the removal (needed for entry in
	 *        review and approve log).
	 * @param object $assignToUser the user who is new owner of folders and
	 *        documents which previously were owned by the delete user.
	 * @return boolean true on success or false in case of an error
	 */
	function remove($user, $assignToUser=null) { /* {{{ */
		$db = $this->_dms->getDB();

		/* Records like folders and documents that formely have belonged to
		 * the user will assign to another user. If no such user is set,
		 * the function now returns false and will not use the admin user
		 * anymore.
		 */
		if(!$assignToUser)
			return;
		$assignTo = $assignToUser->getID();

		$db->startTransaction();

		// delete private keyword lists
		$queryStr = "SELECT `tblKeywords`.`id` FROM `tblKeywords`, `tblKeywordCategories` WHERE `tblKeywords`.`category` = `tblKeywordCategories`.`id` AND `tblKeywordCategories`.`owner` = " . $this->_id;
		$resultArr = $db->getResultArray($queryStr);
		if (count($resultArr) > 0) {
			$queryStr = "DELETE FROM `tblKeywords` WHERE ";
			for ($i = 0; $i < count($resultArr); $i++) {
				$queryStr .= "id = " . $resultArr[$i]["id"];
				if ($i + 1 < count($resultArr))
					$queryStr .= " OR ";
			}
			if (!$db->getResult($queryStr)) {
				$db->rollbackTransaction();
				return false;
			}
		}

		$queryStr = "DELETE FROM `tblKeywordCategories` WHERE `owner` = " . $this->_id;
		if (!$db->getResult($queryStr)) {
			$db->rollbackTransaction();
			return false;
		}

		//Benachrichtigungen entfernen
		$queryStr = "DELETE FROM `tblNotify` WHERE `userID` = " . $this->_id;
		if (!$db->getResult($queryStr)) {
			$db->rollbackTransaction();
			return false;
		}

		/* Assign documents of the removed user to the given user */
		$queryStr = "UPDATE `tblFolders` SET `owner` = " . $assignTo . " WHERE `owner` = " . $this->_id;
		if (!$db->getResult($queryStr)) {
			$db->rollbackTransaction();
			return false;
		}

		$queryStr = "UPDATE `tblDocuments` SET `owner` = " . $assignTo . " WHERE `owner` = " . $this->_id;
		if (!$db->getResult($queryStr)) {
			$db->rollbackTransaction();
			return false;
		}

		$queryStr = "UPDATE `tblDocumentContent` SET `createdBy` = " . $assignTo . " WHERE `createdBy` = " . $this->_id;
		if (!$db->getResult($queryStr)) {
			$db->rollbackTransaction();
			return false;
		}

		// Remove private links on documents ...
		$queryStr = "DELETE FROM `tblDocumentLinks` WHERE `userID` = " . $this->_id . " AND `public` = 0";
		if (!$db->getResult($queryStr)) {
			$db->rollbackTransaction();
			return false;
		}

		// ... but keep public links
		$queryStr = "UPDATE `tblDocumentLinks` SET `userID` = " . $assignTo . " WHERE `userID` = " . $this->_id;
		if (!$db->getResult($queryStr)) {
			$db->rollbackTransaction();
			return false;
		}

		// set administrator for deleted user's attachments
		$queryStr = "UPDATE `tblDocumentFiles` SET `userID` = " . $assignTo . " WHERE `userID` = " . $this->_id;
		if (!$db->getResult($queryStr)) {
			$db->rollbackTransaction();
			return false;
		}

		// unlock documents locked by the user
		$queryStr = "DELETE FROM `tblDocumentLocks` WHERE `userID` = " . $this->_id;
		if (!$db->getResult($queryStr)) {
			$db->rollbackTransaction();
			return false;
		}

		// Delete user from all groups
		$queryStr = "DELETE FROM `tblGroupMembers` WHERE `userID` = " . $this->_id;
		if (!$db->getResult($queryStr)) {
			$db->rollbackTransaction();
			return false;
		}

		// User aus allen ACLs streichen
		$queryStr = "DELETE FROM `tblACLs` WHERE `userID` = " . $this->_id;
		if (!$db->getResult($queryStr)) {
			$db->rollbackTransaction();
			return false;
		}

		// Delete image of user
		$queryStr = "DELETE FROM `tblUserImages` WHERE `userID` = " . $this->_id;
		if (!$db->getResult($queryStr)) {
			$db->rollbackTransaction();
			return false;
		}

		// Delete entries in password history
		$queryStr = "DELETE FROM `tblUserPasswordHistory` WHERE `userID` = " . $this->_id;
		if (!$db->getResult($queryStr)) {
			$db->rollbackTransaction();
			return false;
		}

		// Delete entries in password request
		$queryStr = "DELETE FROM `tblUserPasswordRequest` WHERE `userID` = " . $this->_id;
		if (!$db->getResult($queryStr)) {
			$db->rollbackTransaction();
			return false;
		}

		// mandatory review/approve
		$queryStr = "DELETE FROM `tblMandatoryReviewers` WHERE `reviewerUserID` = " . $this->_id;
		if (!$db->getResult($queryStr)) {
			$db->rollbackTransaction();
			return false;
		}

		$queryStr = "DELETE FROM `tblMandatoryApprovers` WHERE `approverUserID` = " . $this->_id;
		if (!$db->getResult($queryStr)) {
			$db->rollbackTransaction();
			return false;
		}

		$queryStr = "DELETE FROM `tblMandatoryReviewers` WHERE `userID` = " . $this->_id;
		if (!$db->getResult($queryStr)) {
			$db->rollbackTransaction();
			return false;
		}

		$queryStr = "DELETE FROM `tblMandatoryApprovers` WHERE `userID` = " . $this->_id;
		if (!$db->getResult($queryStr)) {
			$db->rollbackTransaction();
			return false;
		}

		$queryStr = "DELETE FROM `tblWorkflowMandatoryWorkflow` WHERE `userid` = " . $this->_id;
		if (!$db->getResult($queryStr)) {
			$db->rollbackTransaction();
			return false;
		}

		$queryStr = "DELETE FROM `tblWorkflowTransitionUsers` WHERE `userid` = " . $this->_id;
		if (!$db->getResult($queryStr)) {
			$db->rollbackTransaction();
			return false;
		}

		// set administrator for deleted user's events
		$queryStr = "UPDATE `tblEvents` SET `userID` = " . $assignTo . " WHERE `userID` = " . $this->_id;
		if (!$db->getResult($queryStr)) {
			$db->rollbackTransaction();
			return false;
		}

		// Delete user itself
		$queryStr = "DELETE FROM `tblUsers` WHERE `id` = " . $this->_id;
		if (!$db->getResult($queryStr)) {
			$db->rollbackTransaction();
			return false;
		}

		// TODO : update document status if reviewer/approver has been deleted
		// "DELETE FROM `tblDocumentApproveLog` WHERE `userID` = " . $this->_id;
		// "DELETE FROM `tblDocumentReviewLog` WHERE `userID` = " . $this->_id;


		$reviewStatus = $this->getReviewStatus();
		foreach ($reviewStatus["indstatus"] as $ri) {
			$queryStr = "INSERT INTO `tblDocumentReviewLog` (`reviewID`, `status`, `comment`, `date`, `userID`) ".
				"VALUES ('". $ri["reviewID"] ."', '-2', 'Reviewer removed from process', ".$db->getCurrentDatetime().", '". $user->getID() ."')";
			$res=$db->getResult($queryStr);
			if(!$res) {
				$db->rollbackTransaction();
				return false;
			}
		}

		$approvalStatus = $this->getApprovalStatus();
		foreach ($approvalStatus["indstatus"] as $ai) {
			$queryStr = "INSERT INTO `tblDocumentApproveLog` (`approveID`, `status`, `comment`, `date`, `userID`) ".
				"VALUES ('". $ai["approveID"] ."', '-2', 'Approver removed from process', ".$db->getCurrentDatetime().", '". $user->getID() ."')";
			$res=$db->getResult($queryStr);
			if(!$res) {
				$db->rollbackTransaction();
				return false;
			}
		}

		$db->commitTransaction();
		return true;
	} /* }}} */

	/**
	 * Make the user a member of a group
	 * This function uses {@link SeedDMS_Group::addUser} but checks before if
	 * the user is already a member of the group.
	 *
	 * @param object $group group to be the member of
	 * @return boolean true on success or false in case of an error or the user
	 *        is already a member of the group
	 */
	function joinGroup($group) { /* {{{ */
		if ($group->isMember($this))
			return false;

		if (!$group->addUser($this))
			return false;

		unset($this->_groups);
		return true;
	} /* }}} */

	/**
	 * Removes the user from a group
	 * This function uses {@link SeedDMS_Group::removeUser} but checks before if
	 * the user is a member of the group at all.
	 *
	 * @param object $group group to leave
	 * @return boolean true on success or false in case of an error or the user
	 *        is not a member of the group
	 */
	function leaveGroup($group) { /* {{{ */
		if (!$group->isMember($this))
			return false;

		if (!$group->removeUser($this))
			return false;

		unset($this->_groups);
		return true;
	} /* }}} */

	/**
	 * Get all groups the user is a member of
	 *
	 * @return array list of groups
	 */
	function getGroups() { /* {{{ */
		$db = $this->_dms->getDB();

		if (!isset($this->_groups))
		{
			$queryStr = "SELECT `tblGroups`.*, `tblGroupMembers`.`userID` FROM `tblGroups` ".
				"LEFT JOIN `tblGroupMembers` ON `tblGroups`.`id` = `tblGroupMembers`.`groupID` ".
				"WHERE `tblGroupMembers`.`userID`='". $this->_id ."'";
			$resArr = $db->getResultArray($queryStr);
			if (is_bool($resArr) && $resArr == false)
				return false;

			$this->_groups = array();
			$classname = $this->_dms->getClassname('group');
			foreach ($resArr as $row) {
				$group = new $classname($row["id"], $row["name"], $row["comment"]);
				$group->setDMS($this->_dms);
				array_push($this->_groups, $group);
			}
		}
		return $this->_groups;
	} /* }}} */

	/**
	 * Checks if user is member of a given group
	 *
	 * @param object $group
	 * @return boolean true if user is member of the given group otherwise false
	 */
	function isMemberOfGroup($group) { /* {{{ */
		return $group->isMember($this);
	} /* }}} */

	/**
	 * Check if user has an image in its profile
	 *
	 * @return boolean true if user has a picture of itself
	 */
	function hasImage() { /* {{{ */
		if (!isset($this->_hasImage)) {
			$db = $this->_dms->getDB();

			$queryStr = "SELECT COUNT(*) AS num FROM `tblUserImages` WHERE `userID` = " . $this->_id;
			$resArr = $db->getResultArray($queryStr);
			if ($resArr === false)
				return false;

			if ($resArr[0]["num"] == 0)	$this->_hasImage = false;
			else $this->_hasImage = true;
		}

		return $this->_hasImage;
	} /* }}} */

	/**
	 * Get the image from the users profile
	 *
	 * @return array image data
	 */
	function getImage() { /* {{{ */
		$db = $this->_dms->getDB();

		$queryStr = "SELECT * FROM `tblUserImages` WHERE `userID` = " . $this->_id;
		$resArr = $db->getResultArray($queryStr);
		if ($resArr === false)
			return false;

		if($resArr)
			$resArr = $resArr[0];
		return $resArr;
	} /* }}} */

	function setImage($tmpfile, $mimeType) { /* {{{ */
		$db = $this->_dms->getDB();

		$fp = fopen($tmpfile, "rb");
		if (!$fp) return false;
		$content = fread($fp, filesize($tmpfile));
		fclose($fp);

		if ($this->hasImage())
			$queryStr = "UPDATE `tblUserImages` SET `image` = '".base64_encode($content)."', `mimeType` = ".$db->qstr($mimeType)." WHERE `userID` = " . $this->_id;
		else
			$queryStr = "INSERT INTO `tblUserImages` (`userID`, `image`, `mimeType`) VALUES (" . $this->_id . ", '".base64_encode($content)."', ".$db->qstr($mimeType).")";
		if (!$db->getResult($queryStr))
			return false;

		$this->_hasImage = true;
		return true;
	} /* }}} */

	/**
	 * Returns all documents of a given user
	 *
	 * @param object $user
	 * @return array list of documents
	 */
	function getDocuments() { /* {{{ */
		$db = $this->_dms->getDB();

		$queryStr = "SELECT `tblDocuments`.*, `tblDocumentLocks`.`userID` as `lockUser` ".
			"FROM `tblDocuments` ".
			"LEFT JOIN `tblDocumentLocks` ON `tblDocuments`.`id`=`tblDocumentLocks`.`document` ".
			"WHERE `tblDocuments`.`owner` = " . $this->_id . " ORDER BY `sequence`";

		$resArr = $db->getResultArray($queryStr);
		if (is_bool($resArr) && !$resArr)
			return false;

		$documents = array();
		$classname = $this->_dms->getClassname('document');
		foreach ($resArr as $row) {
			$document = new $classname($row["id"], $row["name"], $row["comment"], $row["date"], $row["expires"], $row["owner"], $row["folder"], $row["inheritAccess"], $row["defaultAccess"], $row["lockUser"], $row["keywords"], $row["sequence"]);
			$document->setDMS($this->_dms);
			$documents[] = $document;
		}
		return $documents;
	} /* }}} */

	/**
	 * Returns all documents locked by a given user
	 *
	 * @param object $user
	 * @return array list of documents
	 */
	function getDocumentsLocked() { /* {{{ */
		$db = $this->_dms->getDB();

		$queryStr = "SELECT `tblDocuments`.*, `tblDocumentLocks`.`userID` as `lockUser` ".
			"FROM `tblDocumentLocks` LEFT JOIN `tblDocuments` ON `tblDocuments`.`id` = `tblDocumentLocks`.`document` ".
			"WHERE `tblDocumentLocks`.`userID` = '".$this->_id."' ".
			"ORDER BY `id` DESC";

		$resArr = $db->getResultArray($queryStr);
		if (is_bool($resArr) && !$resArr)
			return false;

		$documents = array();
		$classname = $this->_dms->getClassname('document');
		foreach ($resArr as $row) {
			$document = new $classname($row["id"], $row["name"], $row["comment"], $row["date"], $row["expires"], $row["owner"], $row["folder"], $row["inheritAccess"], $row["defaultAccess"], $row["lockUser"], $row["keywords"], $row["sequence"]);
			$document->setDMS($this->_dms);
			$documents[] = $document;
		}
		return $documents;
	} /* }}} */

	/**
	 * Get a list of reviews
	 * This function returns a list of all reviews seperated by individual
	 * and group reviews. If the document id
	 * is passed, then only this document will be checked for reviews. The
	 * same is true for the version of a document which limits the list
	 * further.
	 *
	 * For a detailed description of the result array see
	 * {link SeedDMS_Core_User::getApprovalStatus} which does the same for
	 * approvals.
	 *
	 * @param int $documentID optional document id for which to retrieve the
	 *        reviews
	 * @param int $version optional version of the document
	 * @return array list of all reviews
	 */
	function getReviewStatus($documentID=null, $version=null) { /* {{{ */
		$db = $this->_dms->getDB();

		$status = array("indstatus"=>array(), "grpstatus"=>array());

		// See if the user is assigned as an individual reviewer.
		$queryStr = "SELECT `tblDocumentReviewers`.*, `tblDocumentReviewLog`.`status`, ".
			"`tblDocumentReviewLog`.`comment`, `tblDocumentReviewLog`.`date`, ".
			"`tblDocumentReviewLog`.`userID` ".
			"FROM `tblDocumentReviewers` ".
			"LEFT JOIN `tblDocumentReviewLog` USING (`reviewID`) ".
			"WHERE `tblDocumentReviewers`.`type`='0' ".
			($documentID==null ? "" : "AND `tblDocumentReviewers`.`documentID` = '". (int) $documentID ."' ").
			($version==null ? "" : "AND `tblDocumentReviewers`.`version` = '". (int) $version ."' ").
			"AND `tblDocumentReviewers`.`required`='". $this->_id ."' ".
			"ORDER BY `tblDocumentReviewLog`.`reviewLogID` DESC";
		$resArr = $db->getResultArray($queryStr);
		if (is_bool($resArr) && $resArr === false)
			return false;
		if (count($resArr)>0) {
			foreach ($resArr as $res) {
				if(isset($status["indstatus"][$res['documentID']])) {
					if($status["indstatus"][$res['documentID']]['date'] < $res['date']) {
						$status["indstatus"][$res['documentID']] = $res;
					}
				} else {
					$status["indstatus"][$res['documentID']] = $res;
				}
			}
		}

		// See if the user is the member of a group that has been assigned to
		// review the document version.
		$queryStr = "SELECT `tblDocumentReviewers`.*, `tblDocumentReviewLog`.`status`, ".
			"`tblDocumentReviewLog`.`comment`, `tblDocumentReviewLog`.`date`, ".
			"`tblDocumentReviewLog`.`userID` ".
			"FROM `tblDocumentReviewers` ".
			"LEFT JOIN `tblDocumentReviewLog` USING (`reviewID`) ".
			"LEFT JOIN `tblGroupMembers` ON `tblGroupMembers`.`groupID` = `tblDocumentReviewers`.`required` ".
			"WHERE `tblDocumentReviewers`.`type`='1' ".
			($documentID==null ? "" : "AND `tblDocumentReviewers`.`documentID` = '". (int) $documentID ."' ").
			($version==null ? "" : "AND `tblDocumentReviewers`.`version` = '". (int) $version ."' ").
			"AND `tblGroupMembers`.`userID`='". $this->_id ."' ".
			"ORDER BY `tblDocumentReviewLog`.`reviewLogID` DESC";
		$resArr = $db->getResultArray($queryStr);
		if (is_bool($resArr) && $resArr === false)
			return false;
		if (count($resArr)>0) {
			foreach ($resArr as $res) {
				if(isset($status["grpstatus"][$res['documentID']])) {
					if($status["grpstatus"][$res['documentID']]['date'] < $res['date']) {
						$status["grpstatus"][$res['documentID']] = $res;
					}
				} else {
					$status["grpstatus"][$res['documentID']] = $res;
				}
			}
		}
		return $status;
	} /* }}} */

	/**
	 * Get a list of approvals
	 * This function returns a list of all approvals seperated by individual
	 * and group approvals. If the document id
	 * is passed, then only this document will be checked for approvals. The
	 * same is true for the version of a document which limits the list
	 * further.
	 *
	 * The result array has two elements:
	 * - indstatus: which contains the approvals by individuals (users)
	 * - grpstatus: which contains the approvals by groups
	 *
	 * Each element is itself an array of approvals with the following elements:
	 * - approveID: unique id of approval
	 * - documentID: id of document, that needs to be approved
	 * - version: version of document, that needs to be approved
	 * - type: 0 for individual approval, 1 for group approval
	 * - required: id of user who is required to do the approval
	 * - status: 0 not approved, ....
	 * - comment: comment given during approval
	 * - date: date of approval
	 * - userID: id of user who has done the approval
	 *
	 * @param int $documentID optional document id for which to retrieve the
	 *        approvals
	 * @param int $version optional version of the document
	 * @return array list of all approvals
	 */
	function getApprovalStatus($documentID=null, $version=null) { /* {{{ */
		$db = $this->_dms->getDB();

		$status = array("indstatus"=>array(), "grpstatus"=>array());
		$queryStr =
   "SELECT `tblDocumentApprovers`.*, `tblDocumentApproveLog`.`status`, ".
			"`tblDocumentApproveLog`.`comment`, `tblDocumentApproveLog`.`date`, ".
			"`tblDocumentApproveLog`.`userID` ".
			"FROM `tblDocumentApprovers` ".
			"LEFT JOIN `tblDocumentApproveLog` USING (`approveID`) ".
			"WHERE `tblDocumentApprovers`.`type`='0' ".
			($documentID==null ? "" : "AND `tblDocumentApprovers`.`documentID` = '". (int) $documentID ."' ").
			($version==null ? "" : "AND `tblDocumentApprovers`.`version` = '". (int) $version ."' ").
			"AND `tblDocumentApprovers`.`required`='". $this->_id ."' ".
			"ORDER BY `tblDocumentApproveLog`.`approveLogID` DESC";

		$resArr = $db->getResultArray($queryStr);
		if (is_bool($resArr) && $resArr == false)
			return false;
		if (count($resArr)>0) {
			foreach ($resArr as $res) {
				if(isset($status["indstatus"][$res['documentID']])) {
					if($status["indstatus"][$res['documentID']]['date'] < $res['date']) {
						$status["indstatus"][$res['documentID']] = $res;
					}
				} else {
					$status["indstatus"][$res['documentID']] = $res;
				}
			}
		}

		// See if the user is the member of a group that has been assigned to
		// approve the document version.
		$queryStr =
			"SELECT `tblDocumentApprovers`.*, `tblDocumentApproveLog`.`status`, ".
			"`tblDocumentApproveLog`.`comment`, `tblDocumentApproveLog`.`date`, ".
			"`tblDocumentApproveLog`.`userID` ".
			"FROM `tblDocumentApprovers` ".
			"LEFT JOIN `tblDocumentApproveLog` USING (`approveID`) ".
			"LEFT JOIN `tblGroupMembers` ON `tblGroupMembers`.`groupID` = `tblDocumentApprovers`.`required` ".
			"WHERE `tblDocumentApprovers`.`type`='1' ".
			($documentID==null ? "" : "AND `tblDocumentApprovers`.`documentID` = '". (int) $documentID ."' ").
			($version==null ? "" : "AND `tblDocumentApprovers`.`version` = '". (int) $version ."' ").
			"AND `tblGroupMembers`.`userID`='". $this->_id ."' ".
			"ORDER BY `tblDocumentApproveLog`.`approveLogID` DESC";
		$resArr = $db->getResultArray($queryStr);
		if (is_bool($resArr) && $resArr == false)
			return false;
		if (count($resArr)>0) {
			foreach ($resArr as $res) {
				if(isset($status["grpstatus"][$res['documentID']])) {
					if($status["grpstatus"][$res['documentID']]['date'] < $res['date']) {
						$status["grpstatus"][$res['documentID']] = $res;
					}
				} else {
					$status["grpstatus"][$res['documentID']] = $res;
				}
			}
		}
		return $status;
	} /* }}} */

	/**
	 * Get a list of documents with a workflow
	 *
	 * @param int $documentID optional document id for which to retrieve the
	 *        reviews
	 * @param int $version optional version of the document
	 * @return array list of all workflows
	 */
	function getWorkflowStatus($documentID=null, $version=null) { /* {{{ */
		$db = $this->_dms->getDB();

		$queryStr = 'SELECT DISTINCT d.*, c.`userid` FROM `tblWorkflowTransitions` a LEFT JOIN `tblWorkflows` b ON a.`workflow`=b.`id` LEFT JOIN `tblWorkflowTransitionUsers` c ON a.`id`=c.`transition` LEFT JOIN `tblWorkflowDocumentContent` d ON b.`id`=d.`workflow` WHERE d.`document` IS NOT NULL AND a.`state`=d.`state` AND c.`userid`='.$this->_id;
		if($documentID) {
			$queryStr .= ' AND d.`document`='.(int) $documentID;
			if($version)
				$queryStr .= ' AND d.`version`='.(int) $version;
		}
		$resArr = $db->getResultArray($queryStr);
		if (is_bool($resArr) && $resArr == false)
			return false;
		$result['u'] = array();
		if (count($resArr)>0) {
			foreach ($resArr as $res) {
				$result['u'][] = $res;
			}
		}

		$queryStr = 'select distinct d.*, c.`groupid` from `tblWorkflowTransitions` a left join `tblWorkflows` b on a.`workflow`=b.`id` left join `tblWorkflowTransitionGroups` c on a.`id`=c.`transition` left join `tblWorkflowDocumentContent` d on b.`id`=d.`workflow` left join `tblGroupMembers` e on c.`groupid` = e.`groupID` where d.`document` is not null and a.`state`=d.`state` and e.`userID`='.$this->_id;
		if($documentID) {
			$queryStr .= ' AND d.`document`='.(int) $documentID;
			if($version)
				$queryStr .= ' AND d.`version`='.(int) $version;
		}
		$resArr = $db->getResultArray($queryStr);
		if (is_bool($resArr) && $resArr == false)
			return false;
		$result['g'] = array();
		if (count($resArr)>0) {
			foreach ($resArr as $res) {
				$result['g'][] = $res;
			}
		}
		return $result;
	} /* }}} */

	/**
	 * Get a list of mandatory reviewers
	 * A user which isn't trusted completely may have assigned mandatory
	 * reviewers (both users and groups).
	 * Whenever the user inserts a new document the mandatory reviewers are
	 * filled in as reviewers.
	 *
	 * @return array list of arrays with two elements containing the user id
	 *         (reviewerUserID) and group id (reviewerGroupID) of the reviewer.
	 */
	function getMandatoryReviewers() { /* {{{ */
		$db = $this->_dms->getDB();

		$queryStr = "SELECT * FROM `tblMandatoryReviewers` WHERE `userID` = " . $this->_id;
		$resArr = $db->getResultArray($queryStr);

		return $resArr;
	} /* }}} */

	/**
	 * Get a list of mandatory approvers
	 * See {link SeedDMS_Core_User::getMandatoryReviewers}
	 *
	 * @return array list of arrays with two elements containing the user id
	 *         (approverUserID) and group id (approverGroupID) of the approver.
	 */
	function getMandatoryApprovers() { /* {{{ */
		$db = $this->_dms->getDB();

		$queryStr = "SELECT * FROM `tblMandatoryApprovers` WHERE `userID` = " . $this->_id;
		$resArr = $db->getResultArray($queryStr);

		return $resArr;
	} /* }}} */

	/**
	 * Get the mandatory workflow
	 * A user which isn't trusted completely may have assigned mandatory
	 * workflow
	 * Whenever the user inserts a new document the mandatory workflow is
	 * filled in as the workflow.
	 *
	 * @return object workflow
	 */
	function getMandatoryWorkflow() { /* {{{ */
		$db = $this->_dms->getDB();

		$queryStr = "SELECT * FROM `tblWorkflowMandatoryWorkflow` WHERE `userid` = " . $this->_id;
		$resArr = $db->getResultArray($queryStr);
		if (is_bool($resArr) && !$resArr) return false;

		if(!$resArr)
			return null;

		$workflow = $this->_dms->getWorkflow($resArr[0]['workflow']);
		return $workflow;
	} /* }}} */

	/**
	 * Get the mandatory workflows
	 * A user which isn't trusted completely may have assigned mandatory
	 * workflow
	 * Whenever the user inserts a new document the mandatory workflow is
	 * filled in as the workflow.
	 *
	 * @return object workflow
	 */
	function getMandatoryWorkflows() { /* {{{ */
		$db = $this->_dms->getDB();

		$queryStr = "SELECT * FROM `tblWorkflowMandatoryWorkflow` WHERE `userid` = " . $this->_id;
		$resArr = $db->getResultArray($queryStr);
		if (is_bool($resArr) && !$resArr) return false;

		if(!$resArr)
			return null;

		$workflows = array();
		foreach($resArr as $res) {
			$workflows[] = $this->_dms->getWorkflow($res['workflow']);
		}
		return $workflows;
	} /* }}} */

	/**
	 * Set a mandatory reviewer
	 * This function sets a mandatory reviewer if it isn't already set.
	 *
	 * @param integer $id id of reviewer
	 * @param boolean $isgroup true if $id is a group
	 * @return boolean true on success, otherwise false
	 */
	function setMandatoryReviewer($id, $isgroup=false) { /* {{{ */
		$db = $this->_dms->getDB();

		if ($isgroup){

			$queryStr = "SELECT * FROM `tblMandatoryReviewers` WHERE `userID` = " . $this->_id . " AND `reviewerGroupID` = " . $id;
			$resArr = $db->getResultArray($queryStr);
			if (count($resArr)!=0) return true;

			$queryStr = "INSERT INTO `tblMandatoryReviewers` (`userID`, `reviewerGroupID`) VALUES (" . $this->_id . ", " . $id .")";
			$resArr = $db->getResult($queryStr);
			if (is_bool($resArr) && !$resArr) return false;

		}else{

			$queryStr = "SELECT * FROM `tblMandatoryReviewers` WHERE `userID` = " . $this->_id . " AND `reviewerUserID` = " . $id;
			$resArr = $db->getResultArray($queryStr);
			if (count($resArr)!=0) return true;

			$queryStr = "INSERT INTO `tblMandatoryReviewers` (`userID`, `reviewerUserID`) VALUES (" . $this->_id . ", " . $id .")";
			$resArr = $db->getResult($queryStr);
			if (is_bool($resArr) && !$resArr) return false;
		}

	} /* }}} */

	/**
	 * Set a mandatory approver
	 * This function sets a mandatory approver if it isn't already set.
	 *
	 * @param integer $id id of approver
	 * @param boolean $isgroup true if $id is a group
	 * @return boolean true on success, otherwise false
	 */
	function setMandatoryApprover($id, $isgroup=false) { /* {{{ */
		$db = $this->_dms->getDB();

		if ($isgroup){

			$queryStr = "SELECT * FROM `tblMandatoryApprovers` WHERE `userID` = " . $this->_id . " AND `approverGroupID` = " . (int) $id;
			$resArr = $db->getResultArray($queryStr);
			if (count($resArr)!=0) return;

			$queryStr = "INSERT INTO `tblMandatoryApprovers` (`userID`, `approverGroupID`) VALUES (" . $this->_id . ", " . $id .")";
			$resArr = $db->getResult($queryStr);
			if (is_bool($resArr) && !$resArr) return false;

		}else{

			$queryStr = "SELECT * FROM `tblMandatoryApprovers` WHERE `userID` = " . $this->_id . " AND `approverUserID` = " . (int) $id;
			$resArr = $db->getResultArray($queryStr);
			if (count($resArr)!=0) return;

			$queryStr = "INSERT INTO `tblMandatoryApprovers` (`userID`, `approverUserID`) VALUES (" . $this->_id . ", " . $id .")";
			$resArr = $db->getResult($queryStr);
			if (is_bool($resArr) && !$resArr) return false;
		}
	} /* }}} */

	/**
	 * Set a mandatory workflow
	 * This function sets a mandatory workflow if it isn't already set.
	 *
	 * @param object $workflow workflow
	 * @return boolean true on success, otherwise false
	 */
	function setMandatoryWorkflow($workflow) { /* {{{ */
		$db = $this->_dms->getDB();

		$queryStr = "SELECT * FROM `tblWorkflowMandatoryWorkflow` WHERE `userid` = " . $this->_id . " AND `workflow` = " . (int) $workflow->getID();
		$resArr = $db->getResultArray($queryStr);
		if (count($resArr)!=0) return;

		$queryStr = "INSERT INTO `tblWorkflowMandatoryWorkflow` (`userid`, `workflow`) VALUES (" . $this->_id . ", " . $workflow->getID() .")";
		$resArr = $db->getResult($queryStr);
		if (is_bool($resArr) && !$resArr) return false;
	} /* }}} */

	/**
	 * Set a mandatory workflows
	 * This function sets a list of mandatory workflows.
	 *
	 * @param array $workflows list of workflow objects
	 * @return boolean true on success, otherwise false
	 */
	function setMandatoryWorkflows($workflows) { /* {{{ */
		$db = $this->_dms->getDB();

		$db->startTransaction();
		$queryStr = "DELETE FROM `tblWorkflowMandatoryWorkflow` WHERE `userid` = " . $this->_id;
		if (!$db->getResult($queryStr)) {
			$db->rollbackTransaction();
			return false;
		}

		foreach($workflows as $workflow) {
			$queryStr = "INSERT INTO `tblWorkflowMandatoryWorkflow` (`userid`, `workflow`) VALUES (" . $this->_id . ", " . $workflow->getID() .")";
			$resArr = $db->getResult($queryStr);
			if (is_bool($resArr) && !$resArr) {
				$db->rollbackTransaction();
				return false;
			}
		}

		$db->commitTransaction();
		return true;
	} /* }}} */

	/**
	 * Deletes all mandatory reviewers
	 *
	 * @return boolean true on success, otherwise false
	 */
	function delMandatoryReviewers() { /* {{{ */
		$db = $this->_dms->getDB();
		$queryStr = "DELETE FROM `tblMandatoryReviewers` WHERE `userID` = " . $this->_id;
		if (!$db->getResult($queryStr)) return false;
		return true;
	} /* }}} */

	/**
	 * Deletes all mandatory approvers
	 *
	 * @return boolean true on success, otherwise false
	 */
	function delMandatoryApprovers() { /* {{{ */
		$db = $this->_dms->getDB();

		$queryStr = "DELETE FROM `tblMandatoryApprovers` WHERE `userID` = " . $this->_id;
		if (!$db->getResult($queryStr)) return false;
		return true;
	} /* }}} */

	/**
	 * Deletes the  mandatory workflow
	 *
	 * @return boolean true on success, otherwise false
	 */
	function delMandatoryWorkflow() { /* {{{ */
		$db = $this->_dms->getDB();
		$queryStr = "DELETE FROM `tblWorkflowMandatoryWorkflow` WHERE `userid` = " . $this->_id;
		if (!$db->getResult($queryStr)) return false;
		return true;
	} /* }}} */

	/**
	 * Get all notifications of user
	 *
	 * @param integer $type type of item (T_DOCUMENT or T_FOLDER)
	 * @return array array of notifications
	 */
	function getNotifications($type=0) { /* {{{ */
		$db = $this->_dms->getDB();
		$queryStr = "SELECT `tblNotify`.* FROM `tblNotify` ".
		 "WHERE `tblNotify`.`userID` = ". $this->_id;
		if($type) {
			$queryStr .= " AND `tblNotify`.`targetType` = ". (int) $type;
		}

		$resArr = $db->getResultArray($queryStr);
		if (is_bool($resArr) && !$resArr)
			return false;

		$notifications = array();
		foreach ($resArr as $row) {
			$not = new SeedDMS_Core_Notification($row["target"], $row["targetType"], $row["userID"], $row["groupID"]);
			$not->setDMS($this);
			array_push($notifications, $not);
		}

		return $notifications;
	} /* }}} */

} /* }}} */
?>
