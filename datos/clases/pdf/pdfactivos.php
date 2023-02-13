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
$pdf->Cell(189  ,10,'',0,1); //end of line

$pdf->Image('../../../init/img/logo/'.$logo, 139,15,35,14,'PNG');
$pdf->Cell(59	,5,'Lista de Activos',0,1);//end of line
$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','',10);

$pdf->Cell(30  ,5,'Fecha:  '.date('Y-m-d'),0,0, 'C');
$pdf->SetFont('Arial','',12);

$pdf->Cell(189	,10,'',0,1); //end of line
$pdf->SetFont('Arial','B',11);
$pdf->Cell(50	,5,'Responsable',1,0);
$pdf->Cell(40	,5,'Descripcion',1,0);
$pdf->Cell(20	,5,'Cantidad',1,0);
$pdf->Cell(35	,5,'Proveedor',1,0);
$pdf->Cell(25	,5,'Fech Adq',1,0);
$pdf->Cell(15	,5,'Factura',1,0);
$pdf->Cell(189	,10,'',0,1); //end of line
$pdf->SetFont('Arial','',14);

$query = DBSTART::abrirDB()->prepare("SELECT * FROM c_activos WHERE estado = 'A'");
$query->execute();
$all = $query->fetchAll(PDO::FETCH_ASSOC);
foreach((array) $all as $item){
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(50	,5,$item['persona_resp'],0,0);
    $pdf->Cell(40	,5,$item['descripcion'],0,0);
    $pdf->Cell(20	,5,$item['cantidad'],0,0);
	$pdf->Cell(35	,5,$item['proveedor'],0,0);
	$pdf->Cell(25	,5,$item['fecha_adq'],0,0);
    $pdf->Cell(15	,5,$item['numero_factura'],0,0);
	
	$pdf->Cell(189	,0,'',0,1);//end of line
	$pdf->Cell(100	,8,' ____________________________________________________________________________________________________________________',0,1);//end of line
}
$pdf->Output();

?>