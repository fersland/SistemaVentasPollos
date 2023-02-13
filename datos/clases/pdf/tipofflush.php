<?php
$anio = $_GET['anio'];
$mes = $_GET['mes'];
//$tipo = $_POST['tipo'];
$eply = $_GET['eply'];

require('fpdf17/fpdf.php');
include ('./'."../../../datos/db/connect.php");
$querys = DBSTART::abrirDB()->prepare("SELECT * FROM c_empresa");
$querys->execute();
$alls = $querys->fetchAll(PDO::FETCH_ASSOC);
foreach((array) $alls as $items){
    $logo = $items['img_pdf'];
}

// EXTRAER SUCURSAL
/*
$yan = DBSTART::abrirDB()->prepare("SELECT * FROM c_sucursal WHERE id_sucursal='$sucursal'");
$yan->execute();
$yaname = $yan->fetchColumn(1);*/

$pdf = new FPDF('P','mm','A3');

$pdf->AddPage();

$pdf->SetFont('Arial','B',16);
//$pdf->Image('logo.png', 29,2,25,18,'PNG');
$pdf->Cell(189  ,10,'',0,1);//end of line
//$pdf->Cell(59	,5,$yaname,0,1);//end of line
$pdf->Cell(189  ,10,'',0,1);//end of line

$pdf->Image('../../../init/img/logo/'.$logo, 239,25,35,14,'PNG');
$pdf->Cell(59	,5,'REPORTE DE EMPLEADOS',0,1);//end of line
$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','',10);

$pdf->Cell(30  ,5,'Fecha:  '.date('Y-m-d'),0,0, 'C');
$pdf->SetFont('Arial','',12);

$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','B',7);

$pdf->Cell(25	,5,'MES INGRESO',1,0);
$pdf->Cell(25	,5,'MES FINAL',1,0);
$pdf->Cell(50	,5,'TRABAJADOR',1,0);
$pdf->Cell(15	,5,'CARNET',1,0);
$pdf->Cell(25	,5,'MENSUALIDAD',1,0);

$pdf->Cell(24	,5,'DIAS TRABAJADO',1,0);
$pdf->Cell(24	,5,'DIAS DESCANSO',1,0);
$pdf->Cell(15,  5,'ANTICIPO',1,0);
$pdf->Cell(15,  5,'MULTA',1,0);
$pdf->Cell(15	,5,'BOLI.MAR',1,0);
$pdf->Cell(15	,5,'RETRAZO',1,0);
$pdf->Cell(15	,5,'TOTAL',1,0);
$pdf->Cell(189	,10,'',0,1);//end of line 

$query = DBSTART::abrirDB()->prepare("SELECT p.valor, p.fecha_pago, concat(e.nombres, ' ', e.apellidos) as eply, e.carnet, e.mensualidad, pm.ingreso, pm.final, pm.ndias, pm.multa,
                                            pm.ndesc, pm.obs, pm.anticipo, pm.bolimar, pm.retraso, pm.aux_multa_ruta, pm.aux_multa_dia, pm.boligrafo, pm.marcador, pm.deuda_anterior_mes, pm.estados
                                        FROM c_pagos p 
                                            LEFT JOIN c_empleados e ON p.id_empleado = e.id_empleado 
                                            LEFT JOIN c_pagos_mensual pm ON pm.id_empleado = p.id_empleado 
                                            WHERE p.id_empleado = '$eply' AND p.anio = '$anio' and p.mes='$mes' AND p.id_estado = 1
");
$query->execute();
$all = $query->fetchAll(PDO::FETCH_ASSOC);
foreach((array) $all as $item){
    $aux_multa_ruta = $item['aux_multa_ruta'];
    $aux_multa_dia = $item['aux_multa_dia'];
    $aux_boligrafo = $item['boligrafo'];
    $aux_marcador = $item['marcador'];
    $aux_deuda = $item['deuda_anterior_mes'];
    $aux_estados = $item['estados'];
    
    
    $obs = $item['obs'];
    	$pdf->SetFont('Arial','',8);
    	$pdf->Cell(25   ,5,$item['ingreso'],0,0);
        $pdf->Cell(25	,5,$item['final'],0,0);
        $pdf->Cell(50	,5,utf8_decode(strtoupper($item['eply'])),0,0);
    	$pdf->Cell(15	,5,$item['carnet'],0,0);
        $pdf->Cell(25	,5,$item['mensualidad'],0,0);
        
        $pdf->Cell(24	,5,$item['ndias'],0,0);
        $pdf->Cell(24   ,5,$item['ndesc'],0,0);
        $pdf->Cell(15	,5,$item['anticipo'],0,0);
        $pdf->Cell(15   ,5,$item['multa'],0,0);
    	$pdf->Cell(15	,5,$item['bolimar'],0,0);
        $pdf->Cell(15	,5,$item['retraso'],0,0);
        $pdf->Cell(15	,5,$item['valor'],0,0);
    	
    	$pdf->Cell(189	,0,'',0,1);//end of line
    	$pdf->Cell(100	,8,'  _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _',0,1);//end of line
}


$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->Cell(30  ,5,'NOTA:  '.strtoupper($obs),0,0, 'C');





$querytotally = DBSTART::abrirDB()->prepare("SELECT sum(p.valor) as total FROM c_pagos p
                        INNER JOIN c_empleados e ON p.id_empleado = e.id_empleado
                        
                            WHERE p.anio = '$anio' and p.mes='$mes' AND p.id_estado = 1");
$querytotally->execute();
$all_totally = $querytotally->fetchAll(PDO::FETCH_ASSOC);
foreach((array) $all_totally as $itemtotally){
	$send = $itemtotally['total'];
}

$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->Cell(189	,10,'',0,1);//end of line

$pdf->Cell(255    ,0,'TOTAL: ',0,1,'C');$pdf->Cell(285  ,0,number_format($send,2),0,1,'C');


$pdf->Cell(189  ,5,'',0,1);//end of line
$pdf->Cell(189  ,5,'',0,1);//end of line

                  
$pdf->SetFont('Arial','',8);
$pdf->Cell(35   ,5,'COBRO DE MULTA RUTA',1,0);                           
$pdf->Cell(20   ,5,$aux_multa_ruta,1,1,'C');                               
$pdf->Cell(35   ,5,'COBRO DE MULTA DIA',1,0);             
$pdf->Cell(20   ,5,$aux_multa_dia,1,1,'C');                             
$pdf->Cell(35   ,5,'RETRASO',1,0);
$pdf->Cell(20   ,5,'',1,1,'C');                               
$pdf->Cell(35   ,5,'BOLIGRAFO',1,0);
$pdf->Cell(20   ,5,$aux_boligrafo,1,1,'C');                               
$pdf->Cell(35   ,5,'MARCADOR',1,0);
$pdf->Cell(20   ,5,$aux_marcador,1,1,'C');                               
$pdf->Cell(35   ,5,'DEUDA ANTERIOR MES',1,0);
$pdf->Cell(20   ,5,$aux_deuda,1,1,'C');      
$pdf->Cell(35   ,5,'ESTADO',1,0);
$pdf->Cell(20   ,5,$aux_estados,1,1,'C');                         

$pdf->Cell(130  ,5,'',0,0);


$pdf->Output();

?>