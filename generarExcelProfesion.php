<?php
/**
	******************** GENERAR INDICE DE INFORMACION RESERVADA DEL ENTE OBLIGADO **********************************
	V1.0 27/09/17
	@author JOSE MARIO LOPEZ LEIVA
	marioleiva2011@gmail.com
	Script que lee de la aplicación de reserva de información y genera un Excel con el índice.
	
**/
/**
-------------------------------------- Parámetros que recibo a través del método POST desde el formulario ubicado en /views/multisis-lte/class.GenerarIndice.php

   -nombreUsuario: nombre del Oficial de Información
   -nombreEnteObligado: nombre del ente
   -fechaGeneracion: timestamp de la hora de creación del índice
   -fotoEnte: foto, si está definida, del logo del ente obligado
   -nombresDocumentos[]: array, conteniendo los nombres de los documentos que se van a reservar
   -unidadesEnte: array, con las unidades administrativas que generaron los documentos
   -numerosReserva: array, con los números de las reservas 
   -tiposReserva: total/parcial
   -autoridadReserva: autoridad que reserva, ejemplo, Dirección de auditoría interna
   -fundamentoLegal: array de arrays, con varios posibles literales del art. 19 LAIP
   -fechaClasificacion: fecha de clasificación de reservas, array de esto
   -fechaDesclasificacion: array de fechas de caducidad de reservas
   -motivoReserva: motivo de la reserva array.

   ----- para el indice de desclasificación

   
**/




if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/Classes/PHPExcel.php';
    // echo "Hola, prueba de crear un excel y pushearlo al navegador";
	 //echo "<br>";
	 

	
///////////////////////// OBTENGO PARÁMETROS DESDE EL FORMULARIO

	$licAprobados=$_GET["licAprobados"];
  $licPostulados=$_GET["licPostulados"];


  $ingenierosAprobados=$_GET["ingenierosAprobados"];
  $ingenierosPostulados=$_GET["ingenierosPostulados"];

  $masteresAprobados=$_GET["masteresAprobados"];
  $masteresPostulados=$_GET["masteresPostulados"];

  $doctoresAprobados=$_GET["doctoresAprobados"];
  $doctoresPostulados=$_GET["doctoresPostulados"];

   $otrosAprobados=$_GET["otrosAprobados"];
  $otrosPostulados=$_GET["otrosPostulados"];

    $diplomadoPostulados=$_GET["diplomadoPostulados"];
  $diplomadoAprobados=$_GET["diplomadoAprobados"];

      $cursosAprobados=$_GET["cursosAprobados"];
  $cursosPostulados=$_GET["cursosPostulados"];

  $fechaIni=$_GET["fechaIni"];
  $fechaFin=$_GET["fechaFin"];




	 
//////////// CREO EL EXCEL
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator($creadorExcel)
							 ->setLastModifiedBy($creadorExcel)
							 ->setTitle("Reporte de estadísticas de SIGDENAFOP")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Reporte de las estadísticas de SIGDENAFOP para la categoría profesión de los postulantes")
							 ->setKeywords("enafop seteplan estadisticas docentes")
							 ->setCategory("Indice de información reservada");
//METER CABECERAS
// $datosOficial="Oficial de Información: ".$creadorExcel;
// $ultimaActualizacion="Última actualización: ".$fechaGeneracion;
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Estadísticas sobre profesión de los postulantes')
			->setCellValue('A2', "Estadísticas en el periodo comprendido entre $fechaIni y $fechaFin")
      ->setCellValue('A3', "Fecha de generación:" .date("Y-m-d H:i:s")); 				
$objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
$style1 = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    );

 $objPHPExcel->getActiveSheet()->getStyle('A1:J1')->applyFromArray($style1);

$objPHPExcel->getActiveSheet()->mergeCells('A2:C2');

 //cabeceras de columnas
 $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A5', 'Título obtenido')
             ->setCellValue('B5', 'Aprobados')
            ->setCellValue('C5', 'Postulantes');
            //->setCellValue('D5', 'Problema jurídico')
            
            //->setCellValue('F5', 'Ratio Decidiendi');					

for($col = 'A'; $col !== 'N'; $col++) {
    $objPHPExcel->getActiveSheet()
        ->getColumnDimension($col)
        ->setAutoSize(true);
}
$style5 = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        ),
        'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => '#0c0104'),
        'size'  => 15,
        'name'  => 'Corbel'
    ),
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '00c7ff')
        )
    );
 $objPHPExcel->getActiveSheet()->getStyle('A5:D5')->applyFromArray($style5);
////////////////////////////////////// 									empezar a poblar con los datos reales 			/	////////////////////////////////////////////////////////////////////////////////////////
  //FECHA DE DESCLASIFICACION.  A PARTIR DE LA J6
$profesiones=array("Licenciatura","Ingeniería","Maestría","Doctorado","Curso especializado","Diplomado","Otro");
$limite=count($profesiones);
$cont=0;
$col=0; //columnas desde cero: 0=A, 1=B, etc  G=6 H=7 E=4 I=8 F=5 J=9
//columna D Unidades 
$row=6; //filas empiezan desde 1 (numeración arábiga) Y DESDE EL 6 PARA MI TABLA, SIEMPRE
for($cont=0;$cont<$limite;$cont++)
{
	//echo "Bucle meter numeros de reserva";
	$data=$profesiones[$cont];
	//echo "data: ".$data;
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data);
	$row++;
	//echo "hola";
}

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B6', $licAprobados)
            ->setCellValue('C6', $licPostulados)
            ->setCellValue('B7', $ingenierosAprobados)
            ->setCellValue('C7', $ingenierosPostulados)
            ->setCellValue('B8', $masteresAprobados)
            ->setCellValue('C8', $masteresPostulados)
            ->setCellValue('B9', $doctoresAprobados)
            ->setCellValue('C9', $doctoresPostulados)
            ->setCellValue('B10', $cursosAprobados)
            ->setCellValue('C10', $cursosPostulados)
            ->setCellValue('B11', $diplomadoAprobados)
            ->setCellValue('C11', $diplomadoPostulados)
             ->setCellValue('B12', $otrosAprobados)
            ->setCellValue('C12', $otrosPostulados);

$objPHPExcel->getActiveSheet()->setTitle("Resultado buscador");


/////////////////////////////////////////////////////////////////////////////
ob_end_clean();
$nombreFicheroFinal="estadisticas_profesion_enafop.xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"".$nombreFicheroFinal."\"");
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0
//header('Location: /generarExcel.php');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');

exit;

?>