<?php
$anio = $_POST['anio'];
$mes = $_POST['mes'];
$empleado = $_POST['empleado'];
$sucursal = $_POST['sucursal'];

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
$pdf->Cell(59	,5,'Gastos Por Empleado - MES',0,1);//end of line
$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','',10);

$pdf->Cell(30  ,5,'Fecha:  '.date('Y-m-d'),0,0, 'C');
$pdf->SetFont('Arial','',12);

$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','B',11);
$pdf->Cell(25	,5,'CEDULA',1,0);
$pdf->Cell(55	,5,'PERSONAL',1,0);
$pdf->Cell(70	,5,'TIPO',1,0);
$pdf->Cell(16	,5,'VALOR',1,0);
$pdf->Cell(30	,5,'FECHA',1,0);
$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','',14);

$query = DBSTART::abrirDB()->prepare("SELECT r.cedula, concat(r.nombres, ' ', r.apellidos) epl, p.valor, p.fecha, pd.nombre as tipo
                        FROM c_resumen_gasto p
                            INNER JOIN c_empleados r ON p.id_empleado = r.id_empleado
                            INNER JOIN c_tipo_gastos pd ON pd.id = p.tipo 
                            WHERE p.id_empleado = '$empleado' and p.anio = '$anio' and p.mes='$mes' and p.sucursal='$sucursal'");
$query->execute();
$all = $query->fetchAll(PDO::FETCH_ASSOC);
foreach((array) $all as $item){
    	$pdf->SetFont('Arial','',10);
    	$pdf->Cell(25	,5,$item['cedula'],0,0);
    	$pdf->Cell(55	,5,$item['epl'],0,0);
    	$pdf->Cell(70	,5,$item['tipo'],0,0);
    	$pdf->Cell(16	,5,$item['valor'],0,0);
    	$pdf->Cell(30	,5,$item['fecha'],0,0);
    	
    	$pdf->Cell(189	,0,'',0,1);//end of line
    	$pdf->Cell(100	,8,' _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _',0,1);//end of line
}






$querytotally = DBSTART::abrirDB()->prepare("SELECT sum(p.valor) as total
                        FROM c_resumen_gasto p WHERE p.id_empleado = '$empleado' and p.anio = '$anio' and p.mes='$mes' and p.sucursal = '$sucursal' ");
$querytotally->execute();
$all_totally = $querytotally->fetchAll(PDO::FETCH_ASSOC);
foreach((array) $all_totally as $itemtotally){
	$send = $itemtotally['total'];
}

$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->Cell(189	,10,'',0,1);//end of line

$pdf->Cell(240    ,0,'TOTAL GASTADO ESTE MES: ',0,1,'C');$pdf->Cell(325  ,0,number_format($send,2),0,1,'C');

$pdf->Output();

?>