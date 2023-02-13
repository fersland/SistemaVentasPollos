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
//$pdf->Image('logo.png', 29,2,25,18,'PNG');
$pdf->Cell(189  ,10,'',0,1);//end of line

$pdf->Image('../../../init/img/logo/'.$logo, 139,15,35,14,'PNG');
$pdf->Cell(59	,5,'Lista de Empleados',0,1);//end of line
$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','',10);

$pdf->Cell(30  ,5,'Fecha:  '.date('Y-m-d'),0,0, 'C');
$pdf->SetFont('Arial','',12);

$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','B',11);
$pdf->Cell(25	,5,'CI/NIT',1,0);
$pdf->Cell(40	,5,'NOMBRES',1,0);
$pdf->Cell(40	,5,'APELLIDOS',1,0);
$pdf->Cell(50	,5,'CORREO ELECTRONICO',1,0);
$pdf->Cell(20	,5,'CELULAR',1,0);
$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','',14);

$query = DBSTART::abrirDB()->prepare("SELECT p.id_empleado, p.cedula, p.nombres, p.apellidos, p.edad, p.correo, p.telefono, p.celular
								 FROM c_empleados p");
$query->execute();
$all = $query->fetchAll(PDO::FETCH_ASSOC);

foreach( (array) $all as $item){
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(25	,5,$item['cedula'],0,0);
	$pdf->Cell(40	,5,$item['nombres'],0,0);
	$pdf->Cell(40	,5,$item['apellidos'],0,0);
	$pdf->Cell(50	,5,$item['correo'],0,0);
    $pdf->Cell(20	,5,$item['celular'],0,0);
	
	$pdf->Cell(189	,0,'',0,1);//end of line
	$pdf->Cell(100	,8,' ________________________________________________________________________________________________________',0,1);//end of line
}
$pdf->Output();

?>