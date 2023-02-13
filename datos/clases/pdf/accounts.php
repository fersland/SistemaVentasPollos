<?php
$param = isset($_GET['cid']) ? $_GET['cid'] : 0;
require('fpdf17/fpdf.php');
include ('./'."../../../datos/db/connect.php");
$querysw = DBSTART::abrirDB()->prepare("SELECT * FROM c_empresa");
$querysw->execute();
$allse = $querysw->fetchAll(PDO::FETCH_ASSOC);
foreach((array) $allse as $itemsw){
    $logo = $itemsw['img_pdf'];
}

$querys = DBSTART::abrirDB()->prepare("SELECT cl.nombres, cl.cedula, cd.num_cuotas, cd.valor_cuotas, 
                                            cd.recibido, cd.cambio, cd.fecha_pago,
                                            c.total, c.cuotas_pagadas, c.meses, concat(eply.nombres, ' ', eply.apellidos) as eleply
                            FROM c_cxc_detalle cd 
                                INNER JOIN c_cxc c ON cd.account = c.id 
                                INNER JOIN c_clientes cl ON cl.cedula = c.cedula
                                INNER JOIN c_empleados eply ON cd.empleado = eply.id_empleado
                                WHERE cd.id='$param'");
$querys->execute();
$alls = $querys->fetchAll(PDO::FETCH_ASSOC);
foreach((array) $alls as $items){
    $factura    = $items['account'];
    $total      = $items['total'];
    $fecha      = $items['fecha_pago'];
    $recibido   = $items['recibido'];
    $ci         = $items['cedula'];
    $nombres    = $items['nombres'];
    $cambio = $items['cambio'];
    $n_cuotas = $items['num_cuotas'];
    $v_cuotas = $items['valor_cuotas'];
    
    $c_pagadas = $items['cuotas_pagadas'];
    $c_totales = $items['meses'];
    $el_empleado = $items['eleply'];
}

$pdf = new FPDF('P','mm','A4');

$pdf->AddPage();

$pdf->SetFont('Arial','B',16);
//$pdf->Image('logo.png', 29,2,25,18,'PNG');
$pdf->Cell(189  ,10,'',0,1);//end of line

$pdf->Image('../../../init/img/logo/'.$logo, 139,15,35,14,'PNG');
$pdf->Cell(59	,5,'FACTURA DE PAGO',0,1);//end of line
$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','',10);

$pdf->Cell(10  ,5,'CI/NIT:  ',0,0, 'C');
$pdf->Cell(20  ,5,$ci,0,0, 'C');
$pdf->Cell(210  ,5,'CLIENTE:  '.$nombres,0,0, 'C');
$pdf->Cell(189  ,10,'',0,1);//end of line
$pdf->Cell(45  ,5,'FECHA:  '.$fecha,0,0, 'C');$pdf->Cell(188  ,5,'TOTAL:  '.number_format($total,2),0,0, 'C');
$pdf->Cell(189  ,10,'',0,1);//end of line
$pdf->Cell(17  ,5,'CUOTAS:  '.$n_cuotas,0,0, 'C');$pdf->Cell(254  ,5,'TOTAL CUOTAS:  '.$c_pagadas.'/'.$c_totales,0,0, 'C');

$pdf->Cell(189  ,10,'',0,1);//end of line
$pdf->Cell(20  ,5,'EMPLEADO:  ',0,0, 'C');
$pdf->Cell(34  ,5,$el_empleado,0,0, 'C');


$pdf->SetFont('Arial','',12);

$pdf->Cell(189  ,10,'',0,1);//end of line
$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','B',11);
$pdf->Cell(25	,5,'CUENTA',1,0);
$pdf->Cell(25	,5,'CANTIDAD',1,0);
$pdf->Cell(60	,5,'PAGO',1,0);
$pdf->Cell(40	,5,'FECHA PAGO',1,0);
$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','',14);

$query = DBSTART::abrirDB()->prepare("SELECT cl.nombres, cl.cedula, cd.num_cuotas, cd.valor_cuotas, 
                                            cd.recibido, cd.cambio, cd.fecha_pago,
                                            c.total, c.cuotas_pagadas, c.meses, cd.account
                            FROM c_cxc_detalle cd 
                                INNER JOIN c_cxc c ON cd.account = c.id 
                                INNER JOIN c_clientes cl ON cl.cedula = c.cedula
                                WHERE cd.id='$param'");
$query->execute();
$all = $query->fetchAll(PDO::FETCH_ASSOC);
foreach((array) $all as $item){
    $saldo = $item['saldo'];
    $recibido_valor = $item['recibido'];
    $cambio_recibir = $item['cambio'];
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(25	,5,$item['account'],0,0);
    $pdf->Cell(25	,5,$item['num_cuotas'],0,0);
	$pdf->Cell(60	,5,number_format($item['valor_cuotas'],2),0,0);
	$pdf->Cell(40	,5,$item['fecha_pago'],0,0);
    
    
	
	$pdf->Cell(189	,0,'',0,1);//end of line
}
$pdf->Cell(189	,0,'',0,1);//end of line
$pdf->Cell(189	,0,'',0,1);//end of line
$pdf->Cell(100	,8,' _____________________________________________________________________________',0,1);//end of line
$pdf->Cell(189  ,5,'',0,1);//end of line
$pdf->Cell(189  ,5,'',0,1);//end of line
$pdf->SetFont('Arial','B',12);
$pdf->Cell(270    ,0,'RECIBIDO: ',0,1,'C');$pdf->Cell(325  ,0,number_format($recibido_valor,2),0,1,'C');

$pdf->Cell(189  ,10,'',0,1);//end of line
$pdf->Cell(270    ,0,'CAMBIO: ',0,1,'C');$pdf->Cell(325  ,0,number_format($cambio_recibir,2),0,1,'C');
$pdf->Cell(189  ,10,'',0,1);//end of line
$pdf->SetFont('Arial','',7);
   
$pdf->Output();

?>