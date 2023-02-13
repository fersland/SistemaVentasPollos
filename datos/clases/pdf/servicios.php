<?php

	require('fpdf17/fpdf.php');

include ("../../../datos/db/admysql.php");


$pdf = new FPDF('P','mm','A4');

$pdf->AddPage();

$pdf->SetFont('Arial','B',16);
//$pdf->Image('logo.png', 29,2,25,18,'PNG');
$pdf->Cell(189  ,10,'',0,1);//end of line

$pdf->Image('../../../inicializador/img/logo.PNG', 139,15,35,14,'PNG');
$pdf->Cell(59	,5,'LSITADO DE SERVICIOS',0,1);//end of line

$pdf->SetFont('Arial','',10);

$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','B',11);
$pdf->Cell(10	,5,'#',1,0);
$pdf->Cell(80	,5,'NOMBRE DE SERVICIO',1,0);
$pdf->Cell(40	,5,'FECHA REGISTRO',1,0);
$pdf->Cell(45	,5,'FECHA MODIFICACION',1,0);
$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','',14);

$query = mysqli_query($con,"SELECT * FROM c_servicios WHERE estado = 'A'");

while($item = mysqli_fetch_array($query)){
	$pdf->SetFont('Arial','',9);
    $pdf->Cell(10	,5,$item['id_servicios'],0,0);
	$pdf->Cell(80	,5,$item['nombre_servicio'],0,0);
	$pdf->Cell(40	,5,$item['fecha_registro'],0,0);
	$pdf->Cell(45	,5,$item['fecha_modificacion'],0,0);
 
    
	
	$pdf->Cell(189	,0,'',0,1);//end of line
	$pdf->Cell(100	,8,' ______________________________________________________________________________________________________________',0,1);//end of line
}
$pdf->Output();

?>