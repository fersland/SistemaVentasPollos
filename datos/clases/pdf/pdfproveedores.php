<?php

require('fpdf17/fpdf.php');
include ('./'."../../../datos/db/connect.php");
$querys = DBSTART::abrirDB()->prepare("SELECT * FROM c_empresa");
$querys->execute();
$alls = $querys->fetchAll(PDO::FETCH_ASSOC);
foreach((array) $alls as $items){
    $logo = $items['img_pdf'];
}

$pdf = new FPDF('P','mm','A4');

$pdf->AddPage();

$pdf->SetFont('Arial','B',16);
$pdf->Cell(189  ,10,'',0,1);//end of line
$pdf->Image('../../../init/img/logo/'.$logo, 139,15,35,14,'PNG');
$pdf->Cell(59	,5,'Lista de Proveedores',0,1);//end of line
$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','',10);
$pdf->Cell(30  ,5,'Fecha:  '.date('Y-m-d'),0,0, 'C');
$pdf->SetFont('Arial','',12);
$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','B',11);
$pdf->Cell(20	,5,'CI/NIT',1,0);
$pdf->Cell(55	,5,'NOMBRE',1,0);
$pdf->Cell(60	,5,'DIRECCION',1,0);
$pdf->Cell(20	,5,'FONO',1,0);
$pdf->Cell(70	,5,'CORREO',1,0);
$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','',12);

$query = DBSTART::abrirDB()->prepare("SELECT * FROM c_proveedor WHERE estado = 'A'");
$query->execute();
$all = $query->fetchAll(PDO::FETCH_ASSOC);
foreach((array) $all as $item){
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(20	,5,$item['ruc'],0,0);
	$pdf->Cell(55	,5,$item['nombreproveedor'],0,0);
	$pdf->Cell(60	,5,$item['direccion'],0,0);
	$pdf->Cell(20	,5,$item['telefono'],0,0);
	$pdf->Cell(70	,5,$item['correo'],0,0);
	
	$pdf->Cell(189	,0,'',0,1);//end of line
	$pdf->Cell(100	,8,' _____________________________________________________________________________________________________________________________________________',0,1);//end of line
}
$pdf->Output();

?>