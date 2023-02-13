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
$pdf->Cell(59	,5,'Lista de Usuarios',0,1);//end of line
$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','',10);
$pdf->Cell(30  ,5,'Fecha:  '.date('Y-m-d'),0,0, 'C');
$pdf->SetFont('Arial','',12);
$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','B',11);
$pdf->Cell(80	,5,'PERFIL',1,0);
$pdf->Cell(70	,5,'CORREO ELECTRONICO',1,0);
$pdf->Cell(40	,5,'FECHA REGISTRO',1,0);
$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','',12);

$query = DBSTART::abrirDB()->prepare("SELECT * FROM c_usuarios u INNER JOIN c_roles r ON r.idrol = u.nivelacceso WHERE u.estado = 'A'");
$query->execute();
$all = $query->fetchAll(PDO::FETCH_ASSOC);

foreach( (array) $all as $item){
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(80	,5,$item['nombrerol'],0,0);
	$pdf->Cell(70	,5,$item['correo'],0,0);
	$pdf->Cell(40	,5,$item['fecha_registro'],0,0);
	$pdf->Cell(189	,0,'',0,1);//end of line
	$pdf->Cell(100	,8,' _______________________________________________________________________________________________',0,1);//end of line
}
$pdf->Output();

?>