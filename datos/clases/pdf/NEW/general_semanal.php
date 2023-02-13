<?php
date_default_timezone_set('America/Guayaquil');
$fecha = date('Y-m-d');
$sucursal = $_REQUEST['sucursal'];

require('../fpdf17/fpdf.php');
include ('./'."../../../../datos/db/connect.php");
$querys = DBSTART::abrirDB()->prepare("SELECT * FROM c_empresa");
$querys->execute();
$alls = $querys->fetchAll(PDO::FETCH_ASSOC);
foreach((array) $alls as $items){
    $logo = $items['img_pdf'];
}

// EXTRAER SUCURSAL
$yan = DBSTART::abrirDB()->prepare("SELECT * FROM c_sucursal WHERE id_sucursal='$sucursal'");
$yan->execute();
$yaname = $yan->fetchColumn(1);

$pdf = new FPDF('P','mm','A4');

$pdf->AddPage();

$pdf->SetFont('Arial','B',16);
$pdf->Cell(189  ,10,'',0,1);//end of line
$pdf->Cell(59	,5,$yaname,0,1);//end of line
$pdf->Cell(189  ,10,'',0,1);//end of line

$pdf->Image('../../../../init/img/logo/'.$logo, 159,15,35,14,'PNG');
$pdf->Cell(59	,5,'GASTOS & INGRESOS - REPORTE SEMANAL GENERAL',0,1);//end of line
$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','',10);

$pdf->Cell(30  ,5,'Fecha:  '.date('Y-m-d'),0,0, 'C');
$pdf->SetFont('Arial','',12);

$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','B',11);
$pdf->Cell(45	,5,'ENTRADA',1,0);
$pdf->Cell(40	,5,'SALIDA',1,0);
$pdf->Cell(55	,5,'GANANCIA',1,0);
$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','',14);

$query = DBSTART::abrirDB()->prepare("SELECT sum(p.entrada) as entrada, sum(p.salida) as salida
                        FROM c_resumen_gasto p
                            WHERE p.sucursal = '$sucursal' and p.id_estado = 1 AND p.fecha_sin BETWEEN CURDATE() and CURDATE() + INTERVAL 7 DAY");
$query->execute();
$all = $query->fetchAll(PDO::FETCH_ASSOC);
foreach((array) $all as $item){
    
    $goal = $item['entrada'] - $item['salida'];
    
    	$pdf->SetFont('Arial','',11);
    	$pdf->Cell(45	,5,$item['entrada'],0,0);
    	$pdf->Cell(40	,5,$item['salida'],0,0);
    	$pdf->Cell(55	,5,number_format($goal,2),0,0);
    	
    	$pdf->Cell(189	,0,'',0,1);//end of line
    	$pdf->Cell(100	,8,' _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _',0,1);//end of line
} 
$pdf->Output();

?>