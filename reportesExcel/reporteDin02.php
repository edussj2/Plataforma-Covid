<?php
	require "../Classes/PHPExcel.php";
	require "../config/configDB.php";

	if(isset($_POST['conferencia-reg'])){
		$id = $_POST['conferencia-reg'];
	}else{
		$id = 1;
	}
	
	
	$conexion = new PDO(SGBD,USER,PASS);

	/*CONSULTA*/
	$consulta = "SELECT C.ConferenciaTitulo as titulo, U.UsuarioNombres AS nombres, U.UsuarioApellidoPaterno AS apellidosP,U.UsuarioApellidoMaterno AS apellidosM,D.FechaDetalle AS fecha
	FROM detalle_conferencia AS D 
	INNER JOIN usuario AS U ON U.idUsuario = D.idUsuario
	INNER JOIN conferencia AS C ON C.idConferencia = D.idConferencia
	WHERE C.idConferencia=$id
	ORDER BY D.FechaDetalle ASC";

	/**-----CONECTAMOS Y GUARDAMOS LOS DATOS----**/
    $resultado = $conexion->query($consulta);
    $fila = 7; //Establecemos en que fila inciara a imprimir los datos
	
	$gdImage = imagecreatefrompng('img/logoUnprg.png');//Logotipo
	
	//Objeto de PHPExcel
	$objPHPExcel  = new PHPExcel();
	
	//Propiedades de Documento
	$objPHPExcel->getProperties()->setCreator("Sistema COESPE")->setDescription("Reporte de Participantes Por Conferencia");
	
	//Establecemos la pestaña activa y nombre a la pestaña
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setTitle("Participantes");
	
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
	
	$objPHPExcel->getActiveSheet()->setCellValue('B3', 'REPORTE DE PARTCIPANTES');
	$objPHPExcel->getActiveSheet()->mergeCells('B3:D3');
	
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(50);
	$objPHPExcel->getActiveSheet()->setCellValue('A6', 'CONFERENCIA');
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
	$objPHPExcel->getActiveSheet()->setCellValue('B6', 'NOMBRES');
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(80);
	$objPHPExcel->getActiveSheet()->setCellValue('C6', 'APELLIDOS');
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(80);
	$objPHPExcel->getActiveSheet()->setCellValue('D6', 'FECHA');
	
	//Recorremos los resultados de la consulta y los imprimimos
	while($rows = $resultado->fetch()){
		
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $rows['titulo']);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $rows['nombres']);
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila,$rows['apellidosP']." ".$rows['apellidosM']);
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila,$rows['fecha'] );
		$fila++; //Sumamos 1 para pasar a la siguiente fila
	}
	
	$fila = $fila-1;
	
	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A7:D".$fila);
	
	$filaGrafica = $fila+2;
	
	header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header('Content-Disposition: attachment;filename="reporteDinamico02.xlsx"');
	header('Cache-Control: max-age=0');
	
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save('php://output');
?>
