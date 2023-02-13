<?php
$param = $_REQUEST['fecha'];
$emple = $_REQUEST['empleado'];
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
//$pdf->Image('logo.png', 29,2,25,18,'PNG');
$pdf->Cell(189  ,10,'',0,1);//end of line
$pdf->Cell(59	,5,$yaname,0,1);//end of line
$pdf->Cell(189  ,10,'',0,1);//end of line

$pdf->Image('../../../../init/img/logo/'.$logo, 139,15,35,14,'PNG');
$pdf->Cell(59	,5,'Gastos Por Empleado - DIARIO',0,1);//end of line
$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','',10);

$pdf->Cell(30  ,5,'Fecha:  '.date('Y-m-d'),0,0, 'C');
$pdf->SetFont('Arial','',12);

$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','B',11);
$pdf->Cell(85	,5,'TIPO',1,0);
$pdf->Cell(30	,5,'VALOR',1,0);
$pdf->Cell(55	,5,'FECHA',1,0);
$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','',14);

$query = DBSTART::abrirDB()->prepare("SELECT p.id, r.cedula, r.nombres, r.apellidos, p.valor, p.fecha, pd.nombre as tipo
                        FROM c_resumen_gasto p
                            INNER JOIN c_empleados r ON p.id_empleado = r.id_empleado
                            INNER JOIN c_tipo_gastos pd ON pd.id = p.tipo 
                            WHERE p.id_estado = 1 AND p.id_empleado = '$emple' AND p.sucursal='$sucursal' ");
$query->execute();
$all = $query->fetchAll(PDO::FETCH_ASSOC);
foreach((array) $all as $item){
    	$pdf->SetFont('Arial','',11);
    	$pdf->Cell(85	,5,$item['tipo'],0,0);
    	$pdf->Cell(30	,5,$item['valor'],0,0);
    	$pdf->Cell(55	,5,$item['fecha'],0,0);
    	
    	$pdf->Cell(189	,0,'',0,1);//end of line
    	$pdf->Cell(100	,8,' ____________________________________________________________________________',0,1);//end of line
}






$querytotally = DBSTART::abrirDB()->prepare("SELECT sum(p.valor) as total
                        FROM c_resumen_gasto p
                            INNER JOIN c_empleados r ON p.id_empleado = r.id_empleado 
                            WHERE p.id_estado = 1 AND p.id_empleado = '$emple' AND p.sucursal='$sucursal'");
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