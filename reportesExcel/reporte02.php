<?php
	require "../Classes/PHPExcel.php";
	require "../config/configDB.php";
	
	$conexion = new PDO(SGBD,USER,PASS);

	/*CONSULTA*/
	$consulta = "SELECT E.UsuarioNombres AS nombres, E.UsuarioApellidoPaterno AS apellidosP,E.	UsuarioApellidoMaterno AS apellidosM, ES.EscuelaDescripcion AS escuela, E.UsuarioTelefono AS celular, E.UsuarioTipo AS tipo,E.UsuarioDireccion AS direccion, Dep.DistritoDescripcion AS distrito, E.UsuarioGenero AS genero
	FROM usuario AS E
	INNER JOIN escuela AS ES ON ES.idEscuela = E.idEscuela
	INNER JOIN distrito AS Dep ON Dep.idDistrito = E.idDistrito
	ORDER BY E.UsuarioApellidoPaterno ASC";

	/**-----CONECTAMOS Y GUARDAMOS LOS DATOS----**/
    $resultado = $conexion->query($consulta);
    $fila = 7; //Establecemos en que fila inciara a imprimir los datos
	
	$gdImage = imagecreatefrompng('img/logoUnprg.png');//Logotipo
	
	//Objeto de PHPExcel
	$objPHPExcel  = new PHPExcel();
	
	//Propiedades de Documento
	$objPHPExcel->getProperties()->setCreator("Sistema UNPRG")->setDescription("Reporte General de USUARIOS");
	
	//Establecemos la pestaña activa y nombre a la pestaña
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setTitle("Usuarios");
	
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
	
	$objPHPExcel->getActiveSheet()->setCellValue('B3', 'REPORTE DE USUARIOS');
	$objPHPExcel->getActiveSheet()->mergeCells('B3:D3');
	
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(50);
	$objPHPExcel->getActiveSheet()->setCellValue('A6', 'NOMBRES COMPLETO');
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
	$objPHPExcel->getActiveSheet()->setCellValue('B6', 'ESCUELA');
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
	$objPHPExcel->getActiveSheet()->setCellValue('C6', 'CELULAR');
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	$objPHPExcel->getActiveSheet()->setCellValue('D6', 'TIPO');
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
	$objPHPExcel->getActiveSheet()->setCellValue('E6', 'DIRECCION');
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
	$objPHPExcel->getActiveSheet()->setCellValue('F6', 'DISTRITO');
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
	$objPHPExcel->getActiveSheet()->setCellValue('G6', 'GENERO');
	
	//Recorremos los resultados de la consulta y los imprimimos
	while($rows = $resultado->fetch()){
		
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $rows['nombres'].' '.$rows['apellidosP'].' '.$rows['apellidosM']);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $rows['escuela']);
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $rows['celular']);
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $rows['tipo']);
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $rows['direccion']);
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $rows['distrito']);
		$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $rows['genero']);
		
		$fila++; //Sumamos 1 para pasar a la siguiente fila
	}
	
	$fila = $fila-1;
	
	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A7:G".$fila);
	
	$filaGrafica = $fila+2;
	
	header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header('Content-Disposition: attachment;filename="usuarios.xlsx"');
	header('Cache-Control: max-age=0');
	
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save('php://output');
?>
