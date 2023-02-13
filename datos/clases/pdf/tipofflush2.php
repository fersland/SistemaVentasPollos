<?php
$anio = $_POST['anio'];
$mes = $_POST['mes'];
$tipo = $_POST['tipo'];

require('fpdf17/fpdf.php');
include ('./'."../../../datos/db/connect.php");
$querys = DBSTART::abrirDB()->prepare("SELECT * FROM c_empresa");
$querys->execute();
$alls = $querys->fetchAll(PDO::FETCH_ASSOC);
foreach((array) $alls as $items){
    $logo = $items['img_pdf'];
}

// EXTRAER SUCURSAL
/*
$yan = DBSTART::abrirDB()->prepare("SELECT * FROM c_sucursal WHERE id_sucursal='$sucursal'");
$yan->execute();
$yaname = $yan->fetchColumn(1);*/

$pdf = new FPDF('P','mm','A4');

$pdf->AddPage();

$pdf->SetFont('Arial','B',16);
//$pdf->Image('logo.png', 29,2,25,18,'PNG');
$pdf->Cell(189  ,10,'',0,1);//end of line
//$pdf->Cell(59	,5,$yaname,0,1);//end of line
$pdf->Cell(189  ,10,'',0,1);//end of line

$pdf->Image('../../../init/img/logo/'.$logo, 139,15,35,14,'PNG');
$pdf->Cell(59	,5,'REPORTE DE EMPLEADOS',0,1);//end of line
$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','',10);

$pdf->Cell(30  ,5,'Fecha:  '.date('Y-m-d'),0,0, 'C');
$pdf->SetFont('Arial','',12);

$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','B',11);
$pdf->Cell(90	,5,'EMPLEADO',1,0);
$pdf->Cell(20	,5,'VALOR',1,0);
$pdf->Cell(45	,5,'FECHA',1,0);
$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','',14);

$query = DBSTART::abrirDB()->prepare("SELECT p.valor, p.fecha_pago, concat(e.nombres, ' ', e.apellidos) as eply
                        FROM c_pagos p
                        INNER JOIN c_empleados e ON p.id_empleado = e.id_empleado
                        
                            WHERE p.anio = '$anio' and p.mes='$mes' and p.detalle = '$tipo' AND p.id_estado = 1");
$query->execute();
$all = $query->fetchAll(PDO::FETCH_ASSOC);
foreach((array) $all as $item){
    	$pdf->SetFont('Arial','',10);
    	$pdf->Cell(90	,5,utf8_decode(strtoupper($item['eply'])),0,0);
    	$pdf->Cell(20	,5,$item['valor'],0,0);
    	$pdf->Cell(45	,5,$item['fecha_pago'],0,0);
    	
    	$pdf->Cell(189	,0,'',0,1);//end of line
    	$pdf->Cell(100	,8,'  _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _',0,1);//end of line
}






$querytotally = DBSTART::abrirDB()->prepare("SELECT sum(p.valor) as total FROM c_pagos p
                        INNER JOIN c_empleados e ON p.id_empleado = e.id_empleado
                        
                            WHERE p.anio = '$anio' and p.mes='$mes' and p.detalle = '$tipo' AND p.id_estado = 1");
$querytotally->execute();
$all_totally = $querytotally->fetchAll(PDO::FETCH_ASSOC);
foreach((array) $all_totally as $itemtotally){
	$send = $itemtotally['total'];
}

$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->Cell(189	,10,'',0,1);//end of line

$pdf->Cell(255    ,0,'TOTAL: ',0,1,'C');$pdf->Cell(285  ,0,number_format($send,2),0,1,'C');

$pdf->Output();

?>