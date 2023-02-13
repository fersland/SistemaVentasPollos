<?php
	
	require 'Classes/PHPExcel.php';
	require '../db/admysql.php';
	
	$sql = "SELECT * FROM c_usuarios";
	$resultado = $con->query($sql);
	
	$fila = 2;
	
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getProperties()->setCreator("Codigos de Programacion")->setDescription("Reporte de Usuarios");
	
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setTitle("Usuarios");
	
	$objPHPExcel->getActiveSheet()->setCellValue('A1', 'ID');
	$objPHPExcel->getActiveSheet()->setCellValue('B1', 'NOMBRE');
	$objPHPExcel->getActiveSheet()->setCellValue('C1', 'PRECIO');
	$objPHPExcel->getActiveSheet()->setCellValue('D1', 'EXISTENCIA');
	$objPHPExcel->getActiveSheet()->setCellValue('E1', 'TOTAL');
	
	while($row = $resultado->fetch_assoc())
	{
		
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $row['id_usuario']);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $row['nivelacceso']);
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $row['correo']);
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $row['passw']);
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, '=C'.$fila.'*D'.$fila);
		
		$fila++;
		
	}
	
	header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header('Content-Disposition: attachment;filename="Productos.xlsx"');
	header('Cache-Control: max-age=0');
	
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save('php://output');
	
?>