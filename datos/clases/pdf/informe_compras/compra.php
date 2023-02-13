<?php
if (isset($_REQUEST['factura'])) {
	$thefact = $_REQUEST['factura'];
	require('../fpdf17/fpdf.php');
            
            
    include ('./'."../../../../datos/db/connect.php");

    $query = DBSTART::abrirDB()->prepare("select * from c_compra c inner join c_proveedor p on p.id_proveedor = c.id_proveedor 
                                    where c.ncompra= '$thefact' and c.estado= 'A'");
    $query->execute();
    $all = $query->fetchAll(PDO::FETCH_ASSOC);
    foreach((array) $all as $invoice){


$pdf = new FPDF('L','mm','A4');
$pdf->AddPage();

$pdf->Cell(189  ,10,'',0,1);//end of line
$pdf->SetFont('Arial','B',18);
$pdf->Cell(200	,5,$invoice['nombreproveedor'],0,0);

$pdf->SetFont('Arial','',16);
$pdf->Cell(200	,5,'FACTURA : '.$invoice['ncompra'],0,0);
$pdf->Cell(59	,5,'',0,1);//end of line

$pdf->Cell(59	,5,'',0,1);//end of line
$pdf->SetFont('Arial','',12);
$pdf->Cell(100	,5,'CI/NIT '.$invoice['ruc'],0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(59	,5,'',0,1);//end of line

$pdf->Cell(120	,5,'Telefono: '.$invoice['telefono'],0,0);
$pdf->Cell(120	,5,'E-mail: '.$invoice['correo'],0,0);

$pdf->Cell(59	,5,'',0,1);//end of line

$pdf->Cell(120	,5,'Direccion : '.$invoice['direccion'],0,0);
$pdf->Cell(59	,5,'',0,1);//end of line
$pdf->Cell(120	,5,'Fecha Factura de Compra: '.$invoice['fechacompra'],0,0);
//$pdf->Cell(23	,5,'R.C.U. / C.I.: _ _ _ _ _ _ _ _ _ _ _',0,0);$pdf->Cell(43	,5,$invoice['ruc'],0,0);$pdf->Cell(60	,5,'Guia de Remision: _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _',0,0); 

$pdf->Cell(259	,10,'',0,1);//end of line
}

$pdf->SetFont('Arial','B',9);
$pdf->Cell(15   ,5,'PCAJAS',1,0);
$pdf->Cell(15   ,5,'CCAJAS',1,0);

$pdf->Cell(15	,5,'CANT',1,0);
$pdf->Cell(20	,5,'CODIGO',1,0);
$pdf->Cell(90	,5,'DESCRIPCION',1,0);
$pdf->Cell(23	,5,'PESO_NETO',1,0);
$pdf->Cell(25	,5,'PESO_MERMA',1,0);
$pdf->Cell(20	,5,'V.UNITARIO',1,0);
$pdf->Cell(15	,5,'DESC %',1,0);
$pdf->Cell(20	,5,'TOTAL',1,0);//end of line
$pdf->Cell(20   ,5,'IMPOR.2.5%',1,1);//end of line

$pdf->SetFont('Arial','',9);

$fetch = DBSTART::abrirDB()->prepare("select
                    vd.cantidad,
                    vd.cantidad_litros,
                    vd.codigo,
                    vd.precio_compra,
                    vd.descripcion,
                    vd.importe as vd_importe,
                    v.total,
                    v.iva,
                    v.dinero_iva,
                    v.forma_pago,
                    v.meses,
                    v.diferido,
                    v.descuento as desccompra,
                    vd.descuento as desc_vd,
                    v.importe,
                    v.fecha_registro,
                    vd.pneto,
                    vd.pmerma,
                    vd.falta,
                    vd.cantcajas,
                    vd.pesocajas,
                    vd.tipo,
                    vd.ckg,
                    vd.cja

                    from c_compra_detalle vd
                    	inner join c_compra v on v.ncompra = vd.ncompra
                        where v.estado = 'A' and v.ncompra = '$thefact'
                        AND vd.descripcion NOT LIKE '%churiqui%'
                        AND vd.descripcion NOT LIKE '%pata%'
                        AND vd.descripcion NOT LIKE '%higado%'");
$fetch->execute();
$alls = $fetch->fetchAll(PDO::FETCH_ASSOC);

/***
 * 
 * 
 * TEMA MENUDO
 */

$fetch_menudo = DBSTART::abrirDB()->prepare("select
vd.cantidad,
vd.cantidad_litros,
vd.codigo,
vd.precio_compra,
vd.descripcion,
vd.importe as vd_importe,
v.total,
v.iva,
v.dinero_iva,
v.forma_pago,
v.meses,
v.diferido,
v.descuento as desccompra,
vd.descuento as desc_vd,
v.importe,
v.fecha_registro,
vd.pneto,
vd.pmerma,
vd.falta,
vd.cantcajas,
vd.pesocajas,
vd.tipo,
vd.ckg,
vd.cja

from c_compra_detalle vd
    inner join c_compra v on v.ncompra = vd.ncompra
    where 
v.estado = 'A' and v.ncompra = '$thefact' AND vd.sidescuento = 1 AND vd.descripcion LIKE '%churiqui%' 
OR v.estado = 'A' and v.ncompra = '$thefact' AND vd.sidescuento = 1 AND vd.descripcion LIKE '%pata%'
OR v.estado = 'A' and v.ncompra = '$thefact' AND vd.sidescuento = 1 AND vd.descripcion LIKE '%higado%'");
$fetch_menudo->execute();
$alls_menudo = $fetch_menudo->fetchAll(PDO::FETCH_ASSOC);

 /**
  * 
  ** FIN TEMA MENUDO
  */
$amount = 0; //total amount

foreach((array) $alls as $item){
    $dutil = $item['desccompra'];
    $nn = $item['cantidad'];    
    $pre = $item['precio_compra'];    
    $desc = $item['desc_vd'];

    // EXTRAER EL TIPO
    if ($item['tipo'] == 1) { // UNIDAD
        $xquant = $item['cantidad'];
    }elseif ($item['tipo'] == 2) {
        $xquant = $item['ckg']; // KILO
    }elseif ($item['tipo'] == 3) {
        $xquant = $item['cja']; // CAJA
    }
    
    $el_importe_por_item = $item['vd_importe'];
    
    $importe = 0;
    $importe = ($nn * $pre);
    if ($desc == 0 ) {
        $importe = $importe;
    }else{
        $condesc = 0;
        $condesc = ($importe * $desc /100);
        $importe = $importe - $condesc;
    }
    
	$pdf->Cell(15   ,5,$item['pesocajas'],1,0,'');
    $pdf->Cell(15   ,5,$item['cantcajas'],1,0,'');
    $pdf->Cell(15	,5,$xquant,1,0,'C');
    
    $pdf->Cell(20	,5,$item['codigo'],1,0,'');
	$pdf->Cell(90	,5,$item['descripcion'],1,0);
    $pdf->Cell(23	,5,$item['pneto'],1,0);
    $pdf->Cell(25	,5,$item['pmerma'],1,0);
	$pdf->Cell(20	,5,number_format($item['precio_compra'],2,'.',''),1,0,'C');
    $pdf->Cell(15	,5,bcdiv($item['desc_vd'], '1', 0),1,0,'C');
    $pdf->Cell(20	,5,bcdiv($el_importe_por_item, '1', 2),1,0,'C');
    $pdf->Cell(20   ,5,number_format($item['falta'],2,'.',''),1,0,'C');
    $pdf->Cell(189	,5,'',0,1);//end of line
    
	$efecti = number_format($item['efectivo'],2,'.','');
	$cambio = number_format($item['cambio'],2,'.','');
    $import = number_format($item['importe'],2,'.','');    

    $dd = number_format($item['descuento'],2,'.','');
    $total = number_format($item['total'],2,'.','');
    
    $iva = number_format($item['iva'],2,'.','');
    $total = number_format($item['total'],2,'.','');    
    
    $mes = $item['meses'];
    $dif = $item['diferido'];
    $formp = $item['forma_pago'];
    $newval = $item['dinero_iva'];
    $ffecha = $item['fecha_registro'];
}

$pdf->Cell(259  ,10,'',0,1);//end of line

$pdf->SetFont('Arial','B',9);
$pdf->Cell(15   ,5,'PCAJAS',1,0);
$pdf->Cell(15   ,5,'CCAJAS',1,0);

$pdf->Cell(15	,5,'CANT',1,0);
$pdf->Cell(20	,5,'CODIGO',1,0);
$pdf->Cell(90	,5,'DESCRIPCION',1,0);
$pdf->Cell(23	,5,'PESO_NETO',1,0);
$pdf->Cell(25	,5,'PESO_MERMA',1,0);
$pdf->Cell(20	,5,'V.UNITARIO',1,0);
$pdf->Cell(15	,5,'DESC %',1,0);
$pdf->Cell(20	,5,'TOTAL',1,0);//end of line
$pdf->Cell(20   ,5,'IMPOR.2.5%',1,1);//end of line
$pdf->SetFont('Arial','',9);
foreach((array) $alls_menudo as $item_menudo){
    $dutil = $item_menudo['desccompra'];
    $nn = $item_menudo['cantidad'];    
    $pre = $item_menudo['precio_compra'];    
    $desc = $item_menudo['desc_vd'];

    // EXTRAER EL TIPO
    if ($item_menudo['tipo'] == 1) { // UNIDAD
        $xquant = $item_menudo['cantidad'];
    }elseif ($item_menudo['tipo'] == 2) {
        $xquant = $item_menudo['ckg']; // KILO
    }elseif ($item_menudo['tipo'] == 3) {
        $xquant = $item_menudo['cja']; // CAJA
    }
    
    $el_importe_por_item = $item_menudo['vd_importe'];
    
    $importe = 0;
    $importe = ($nn * $pre);
    if ($desc == 0 ) {
        $importe = $importe;
    }else{
        $condesc = 0;
        $condesc = ($importe * $desc /100);
        $importe = $importe - $condesc;
    }
    
	$pdf->Cell(15   ,5,$item_menudo['pesocajas'],1,0,'');
    $pdf->Cell(15   ,5,$item_menudo['cantcajas'],1,0,'');
    $pdf->Cell(15	,5,$xquant,1,0,'C');
    
    $pdf->Cell(20	,5,$item_menudo['codigo'],1,0,'');
	$pdf->Cell(90	,5,$item_menudo['descripcion'],1,0);
    $pdf->Cell(23	,5,$item_menudo['pneto'],1,0);
    $pdf->Cell(25	,5,$item_menudo['pmerma'],1,0);
	$pdf->Cell(20	,5,number_format($item_menudo['precio_compra'],2,'.',''),1,0,'C');
    $pdf->Cell(15	,5,bcdiv($item_menudo['desc_vd'], '1', 0),1,0,'C');
    $pdf->Cell(20	,5,bcdiv($el_importe_por_item, '1', 2),1,0,'C');
    $pdf->Cell(20   ,5,number_format($item_menudo['falta'],2,'.',''),1,0,'C');
    $pdf->Cell(189	,5,'',0,1);//end of line
    
	$efecti = number_format($item_menudo['efectivo'],2,'.','');
	$cambio = number_format($item_menudo['cambio'],2,'.','');
    $import = number_format($item_menudo['importe'],2,'.','');    

    $dd = number_format($item_menudo['descuento'],2,'.','');
    $total = number_format($item_menudo['total'],2,'.','');
    
    $iva = number_format($item_menudo['iva'],2,'.','');
    $total = number_format($item_menudo['total'],2,'.','');    
    
    $mes = $item_menudo['meses'];
    $dif = $item_menudo['diferido'];
    $formp = $item_menudo['forma_pago'];
    $newval = $item_menudo['dinero_iva'];
    $ffecha = $item_menudo['fecha_registro'];
}
$pdf->Cell(259  ,10,'',0,1);//end of line

$fetchu = DBSTART::abrirDB()->prepare("
                    select * from c_compra where estado = 'A' AND ncompra = '$thefact'");
$fetchu->execute();
$allsu = $fetchu->fetchAll(PDO::FETCH_ASSOC);

foreach((array) $allsu as $itemu){
    $pdf->Cell(15   ,5,$itemu['max_pcajas'],1,0,'');
    $pdf->Cell(15   ,5,$itemu['max_ccajas'],1,0,'');
    $pdf->Cell(15   ,5,$itemu['max_cant'],1,0,'');
    $pdf->Cell(20   ,5,'',1,0,'');
    $pdf->Cell(90   ,5,'',1,0,'');
    $pdf->Cell(23   ,5,$itemu['max_pneto'],1,0,'');
    $pdf->Cell(25   ,5,$itemu['max_pmerma'],1,0,'');
    $pdf->Cell(20   ,5,$itemu['max_punit'],1,0,'');
    $pdf->Cell(15   ,5,'',1,0,'');
    $pdf->Cell(20   ,5,$itemu['max_total'],1,0,'');
    $pdf->Cell(20   ,5,$itemu['max_menos'],1,0,'');
}


$pdf->Cell(259  ,10,'',0,1);//end of line
// OTRA CONSULTA

$pdf->Cell(189	,5,'',0,1);//end of line
$pdf->Cell(130	,5,'',0,0);
$pdf->Cell(25	,5,'Forma de Pago',0,0);
$pdf->Cell(34	,5,$formp,1,1,'C');//end of line

if ($formp == 'Efectivo') {
    
}else{
    $pdf->Cell(130  ,5,'',0,0);
    $pdf->Cell(25   ,5,'Plazos',0,0);
    $pdf->Cell(4    ,5,'N',1,0);
    $pdf->Cell(30   ,5,$mes,1,1,'C');//end of line
    
    $pdf->Cell(130  ,5,'',0,0);
    $pdf->Cell(25   ,5,'Valores',0,0);
    $pdf->Cell(4    ,5,'$',1,0);
    $pdf->Cell(30   ,5,$dif,1,1,'C');//end of line
}


$pdf->Cell(130	,5,'',0,0);
$pdf->Cell(25	,5,'Total',0,0);
$pdf->Cell(4	,5,'Bs',1,0);
$pdf->Cell(30	,5,number_format($total,2,'.',''),1,1,'C');//end of line


$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->Cell(189	,10,'',0,1);//end of line

$pdf->Cell(120	,5,'Fecha de Ingreso de compra: '.$ffecha,0,0);
$pdf->Output();
}

$pdf->Cell(59	,5,'',0,1);//end of line
?>

