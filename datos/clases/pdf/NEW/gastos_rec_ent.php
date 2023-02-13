<?php
$param = $_REQUEST['fecha'];
require('../fpdf17/fpdf.php');
include ('./'."../../../../datos/db/connect.php");
$querys = DBSTART::abrirDB()->prepare("SELECT * FROM c_empresa");
$querys->execute();
$alls = $querys->fetchAll(PDO::FETCH_ASSOC);
foreach((array) $alls as $items){
    $logo = $items['img_pdf'];
}

$pdf = new FPDF('P','mm','A4');

$pdf->AddPage();

$pdf->SetFont('Arial','B',16);
//$pdf->Image('logo.png', 29,2,25,18,'PNG');
$pdf->Cell(189  ,10,'',0,1);//end of line

$pdf->Image('../../../../init/img/logo/'.$logo, 139,15,35,14,'PNG');
$pdf->Cell(59	,5,'Gastos por recojo y entrega - DIARIO',0,1);//end of line
$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','',10);

$pdf->Cell(30  ,5,'Fecha:  '.$param,0,0, 'C');
$pdf->SetFont('Arial','',12);

$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','B',11);
$pdf->Cell(85	,5,'TIPO',1,0);
$pdf->Cell(30	,5,'VALOR',1,0);
$pdf->Cell(55	,5,'FECHA',1,0);
$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','',14);

$query = DBSTART::abrirDB()->prepare("SELECT p.id_pago, r.cedula, r.nombres, r.apellidos, p.valor, p.fecha_pago, pd.nombre as tipo
                        FROM c_pagos p
                            INNER JOIN c_empleados r ON p.id_empleado = r.id_empleado
                            INNER JOIN c_pagos_detalle pd ON pd.id = p.detalle 
                            WHERE p.id_estado = 1 AND p.fecha = '$param'");
$query->execute();
$all = $query->fetchAll(PDO::FETCH_ASSOC);
foreach((array) $all as $item){
    	$pdf->SetFont('Arial','',11);
    	$pdf->Cell(85	,5,$item['tipo'],0,0);
    	$pdf->Cell(30	,5,$item['valor'],0,0);
    	$pdf->Cell(55	,5,$item['fecha_pago'],0,0);
        
    	
    	$pdf->Cell(189	,0,'',0,1);//end of line
    	$pdf->Cell(100	,8,' ____________________________________________________________________________',0,1);//end of line
}






$querytotally = DBSTART::abrirDB()->prepare("SELECT sum(p.valor) as total
                        FROM c_pagos p WHERE p.id_estado = 1 AND p.fecha = '$param'");
$querytotally->execute();
$all_totally = $querytotally->fetchAll(PDO::FETCH_ASSOC);
foreach((array) $all_totally as $itemtotally){
	$send = $itemtotally['total'];
}

$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->Cell(189	,10,'',0,1);//end of line

$pdf->Cell(260    ,0,'TOTAL GASTADO HOY: ',0,1,'C');$pdf->Cell(325  ,0,number_format($send,2),0,1,'C');

$pdf->Output();

?>