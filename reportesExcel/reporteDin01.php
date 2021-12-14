<?php
	require "../Classes/PHPExcel.php";
	require "../config/configDB.php";
	if(isset($_POST['fechaMin'])){
		$min = $_POST['fechaMin'];
		$max = $_POST['fechaMax'];
	}else{
		$min = '2007-01-01';
		$max = '2020-12-31';
	}
	
	
	$conexion = new PDO(SGBD,USER,PASS);

	/*CONSULTA*/
	$consulta = "SELECT A.AtencionDescripcion as descripcion, U.UsuarioNombres AS nombres, U.UsuarioApellidoPaterno AS apellidosP,U.UsuarioApellidoMaterno AS apellidosM,E.EspecialistaNombres AS nombresE, E.EspecialistaApellidos AS apellidosE, D.DiagnosticoDescripcion as respuesta
	FROM atencion AS A 
	INNER JOIN usuario AS U ON U.idUsuario = A.idUsuario
	INNER JOIN especialista AS E ON E.idEspecialista = A.idEspecialista
	INNER JOIN diagnostico AS D ON D.idAtencion = A.idAtencion
	WHERE A.AtencionFecha>='$min' AND A.AtencionFecha<='$max'
	ORDER BY A.AtencionFecha ASC";

	/**-----CONECTAMOS Y GUARDAMOS LOS DATOS----**/
    $resultado = $conexion->query($consulta);
    $fila = 7; //Establecemos en que fila inciara a imprimir los datos
	
	$gdImage = imagecreatefrompng('img/logoUnprg.png');//Logotipo
	
	//Objeto de PHPExcel
	$objPHPExcel  = new PHPExcel();
	
	//Propiedades de Documento
	$objPHPExcel->getProperties()->setCreator("Sistema COESPE")->setDescription("Reporte de Atenciones Por Fecha");
	
	//Establecemos la pestaña activa y nombre a la pestaña
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setTitle("Atenciones");
	
	$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
	$objDrawing->setName('Logotipo');
	$objDrawing->setDescription('Logotipo');
	$objDrawing->setImageResource($gdImage);
	$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_PNG);
	$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
	$objDrawing->setHeight(100);
	$objDrawing->setCoordinates('A1');
	$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
	
	$estiloTituloReporte = array(
    'font' => array(
	'name'      => 'Arial',
	'bold'      => true,
	'italic'    => false,
	'strike'    => false,
	'size' =>13
    ),
    'fill' => array(
	'type'  => PHPExcel_Style_Fill::FILL_SOLID
	),
    'borders' => array(
	'allborders' => array(
	'style' => PHPExcel_Style_Border::BORDER_NONE
	)
    ),
    'alignment' => array(
	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
	);
	
	$estiloTituloColumnas = array(
    'font' => array(
	'name'  => 'Arial',
	'bold'  => true,
	'size' =>10,
	'color' => array(
	'rgb' => 'FFFFFF'
	)
    ),
    'fill' => array(
	'type' => PHPExcel_Style_Fill::FILL_SOLID,
	'color' => array('rgb' => '538DD5')
    ),
    'borders' => array(
	'allborders' => array(
	'style' => PHPExcel_Style_Border::BORDER_THIN
	)
    ),
    'alignment' =>  array(
	'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
	);
	
	$estiloInformacion = new PHPExcel_Style();
	$estiloInformacion->applyFromArray( array(
    'font' => array(
	'name'  => 'Arial',
	'color' => array(
	'rgb' => '000000'
	)
    ),
    'fill' => array(
	'type'  => PHPExcel_Style_Fill::FILL_SOLID
	),
    'borders' => array(
	'allborders' => array(
	'style' => PHPExcel_Style_Border::BORDER_THIN
	)
    ),
	'alignment' =>  array(
	'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
	));
	
	$objPHPExcel->getActiveSheet()->getStyle('A1:D5')->applyFromArray($estiloTituloReporte);
	$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->applyFromArray($estiloTituloColumnas);
	
	$objPHPExcel->getActiveSheet()->setCellValue('B3', 'REPORTE DE ATENCIONES');
	$objPHPExcel->getActiveSheet()->mergeCells('B3:D3');
	
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(50);
	$objPHPExcel->getActiveSheet()->setCellValue('A6', 'USUARIO');
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
	$objPHPExcel->getActiveSheet()->setCellValue('B6', 'ESPECIALISTA');
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(80);
	$objPHPExcel->getActiveSheet()->setCellValue('C6', 'DESCRIPCION');
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(80);
	$objPHPExcel->getActiveSheet()->setCellValue('D6', 'RESPUESTA');
	
	//Recorremos los resultados de la consulta y los imprimimos
	while($rows = $resultado->fetch()){
		
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $rows['apellidosP']." ".$rows['apellidosM']." ".$rows['nombres']);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $rows['apellidosE']." ".$rows['nombresE']);
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila,$rows['descripcion'] );
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila,$rows['respuesta'] );
		$fila++; //Sumamos 1 para pasar a la siguiente fila
	}
	
	$fila = $fila-1;
	
	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A7:D".$fila);
	
	$filaGrafica = $fila+2;
	
	header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header('Content-Disposition: attachment;filename="reporteDinamico01.xlsx"');
	header('Cache-Control: max-age=0');
	
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save('php://output');
?>
