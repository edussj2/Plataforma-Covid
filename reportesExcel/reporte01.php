<?php
	require "../Classes/PHPExcel.php";
	require "../config/configDB.php";

	$conexion = new PDO(SGBD,USER,PASS);

	/*CONSULTA*/
	$consulta = "SELECT E.EspecialistaNombres AS nombres, E.EspecialistaApellidos AS apellidos, E.EspecialistaCorreo AS correo, E.EspecialistaCelular AS celular, ES.EspecialidadDescripcion AS especialidad, Dep.DepartamentoDescripcion AS departamento, E.EspecialistaCentro AS centro
	FROM Especialista AS E 
	INNER JOIN especialidad AS ES ON ES.idEspecialidad = E.idEspecialidad
	INNER JOIN departamento AS Dep ON Dep.idDepartamento = E.idDepartamento
	ORDER BY E.EspecialistaApellidos ASC";

	/**-----CONECTAMOS Y GUARDAMOS LOS DATOS----**/
    $resultado = $conexion->query($consulta);
    $fila = 7; //Establecemos en que fila inciara a imprimir los datos
	
	$gdImage = imagecreatefrompng('img/logoUnprg.png');//Logotipo
	
	//Objeto de PHPExcel
	$objPHPExcel  = new PHPExcel();
	
	//Propiedades de Documento
	$objPHPExcel->getProperties()->setCreator("Sistema UNPRG")->setDescription("Reporte General de ESPECIALISTAS");
	
	//Establecemos la pestaña activa y nombre a la pestaña
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setTitle("Especialistas");
	
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
	
	$objPHPExcel->getActiveSheet()->getStyle('A1:G5')->applyFromArray($estiloTituloReporte);
	$objPHPExcel->getActiveSheet()->getStyle('A6:G6')->applyFromArray($estiloTituloColumnas);
	
	$objPHPExcel->getActiveSheet()->setCellValue('B3', 'REPORTE DE ESPECIALISTAS');
	$objPHPExcel->getActiveSheet()->mergeCells('B3:D3');
	
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
	$objPHPExcel->getActiveSheet()->setCellValue('A6', 'NOMBRES');
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
	$objPHPExcel->getActiveSheet()->setCellValue('B6', 'APELLIDOS');
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
	$objPHPExcel->getActiveSheet()->setCellValue('C6', 'CORREO');
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	$objPHPExcel->getActiveSheet()->setCellValue('D6', 'CELULAR');
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
	$objPHPExcel->getActiveSheet()->setCellValue('E6', 'ESPECIALIDAD');
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
	$objPHPExcel->getActiveSheet()->setCellValue('F6', 'DEPARTAMENTO');
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
	$objPHPExcel->getActiveSheet()->setCellValue('G6', 'CENTRO');
	
	//Recorremos los resultados de la consulta y los imprimimos
	while($rows = $resultado->fetch()){
		
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $rows['nombres']);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $rows['apellidos']);
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $rows['correo']);
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $rows['celular']);
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $rows['especialidad']);
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $rows['departamento']);
		$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $rows['centro']);
		
		$fila++; //Sumamos 1 para pasar a la siguiente fila
	}
	
	$fila = $fila-1;
	
	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A7:G".$fila);
	
	$filaGrafica = $fila+2;
	
	header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header('Content-Disposition: attachment;filename="especialistas.xlsx"');
	header('Cache-Control: max-age=0');
	
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save('php://output');
?>
