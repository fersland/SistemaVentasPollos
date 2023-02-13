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

$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();

$pdf->Cell(189  ,10,'',0,1);//end of line
$pdf->SetFont('Arial','B',18);
$pdf->Cell(130	,5,$invoice['nombreproveedor'],0,0);

$pdf->SetFont('Arial','',16);
$pdf->Cell(100	,5,'FACTURA : '.$invoice['ncompra'],0,0);
$pdf->Cell(59	,5,'',0,1);//end of line

$pdf->Cell(59	,5,'',0,1);//end of line
$pdf->SetFont('Arial','',12);
$pdf->Cell(100	,5,'R.U.C. '.$invoice['ruc'],0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(59	,5,'',0,1);//end of line

$pdf->Cell(120	,5,'Telefono: '.$invoice['telefono'],0,0);
$pdf->Cell(120	,5,'E-mail: '.$invoice['correo'],0,0);

$pdf->Cell(59	,5,'',0,1);//end of line

$pdf->Cell(120	,5,'Direccion : '.$invoice['direccion'],0,0);
$pdf->Cell(59	,5,'',0,1);//end of line
$pdf->Cell(120	,5,'Fecha Factura de Compra: '.$invoice['fechacompra'],0,0);
//$pdf->Cell(23	,5,'R.C.U. / C.I.: _ _ _ _ _ _ _ _ _ _ _',0,0);$pdf->Cell(43	,5,$invoice['ruc'],0,0);$pdf->Cell(60	,5,'Guia de Remision: _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _',0,0); 

$pdf->Cell(189	,10,'',0,1);//end of line
}

$pdf->SetFont('Arial','B',9);
$pdf->Cell(15	,5,'CANT',1,0);
$pdf->Cell(35	,5,'CODIGO',1,0);
$pdf->Cell(90	,5,'DESCRIPCION',1,0);
$pdf->Cell(20	,5,'V.UNITARIO',1,0);
$pdf->Cell(15	,5,'DESC %',1,0);
$pdf->Cell(15	,5,'TOTAL',1,1);//end of line

$pdf->SetFont('Arial','',7);

$fetch = DBSTART::abrirDB()->prepare("select
                    vd.cantidad,
                    vd.cantidad_litros,
                    vd.codigo,
                    vd.precio_compra,
                    vd.descripcion,
                    v.efectivo,
                    v.cambio,
                    vd.importe as vd_importe,
                    v.total,
                    v.iva,
                    v.dinero_iva,
                    v.forma_pago,
                    v.meses,
                    v.diferido,
                    v.descuento,
                    vd.descuento as desc_vd,
                    v.importe,
                    v.fecha_registro

                    from c_compra_detalle vd
                    	inner join c_compra v on v.ncompra = vd.ncompra
                        where v.estado = 'A' and v.ncompra = '$thefact'");
$fetch->execute();
$alls = $fetch->fetchAll(PDO::FETCH_ASSOC);

$amount = 0; //total amount

foreach((array) $alls as $item){
    $nn = $item['cantidad'];    
    $pre = $item['precio_compra'];    
    $desc = $item['desc_vd'];
    
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
    
	$pdf->Cell(15	,5,$nn,1,0,'C');
    $pdf->Cell(35	,5,$item['codigo'],1,0,'');
	$pdf->Cell(90	,5,$item['descripcion'],1,0);
	$pdf->Cell(20	,5,number_format($item['precio_compra'],2,'.',''),1,0,'C');
    $pdf->Cell(15	,5,bcdiv($item['desc_vd'], '1', 0),1,0,'C');
    $pdf->Cell(15	,5,bcdiv($el_importe_por_item, '1', 2),1,0,'C');
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

// OTRA CONSULTA
$querys = mysqli_query($con,

	"select sum(descuento_valores) as descv from c_compra_detalle 
                where estado = 'I' and ncompra = '$thefact'");
while($items = mysqli_fetch_array($querys)){
    $desctotal = $items['descv'];
}

$pdf->Cell(189	,5,'',0,1);//end of line

$pdf->Cell(130	,5,'',0,0);
$pdf->Cell(25	,5,'Forma de Pago',0,0);
$pdf->Cell(34	,5,$formp,1,1,'C');//end of line

$pdf->Cell(130	,5,'',0,0);
$pdf->Cell(25	,5,'Sub-Total',0,0);
$pdf->Cell(4	,5,'$',1,0);
$pdf->Cell(30	,5,$import,1,1,'C');//end of line

$pdf->Cell(130	,5,'',0,0);
$pdf->Cell(25	,5,'Desc',0,0);
$pdf->Cell(4	,5,'$',1,0);
$pdf->Cell(30	,5,$desctotal,1,1,'C');//end of line

$pdf->Cell(130	,5,'',0,0);
$pdf->Cell(25	,5,'IVA 12%',0,0);
$pdf->Cell(4	,5,'',1,0);
$pdf->Cell(30	,5,$newval,1,1,'C');//end of line

$pdf->Cell(130  ,5,'',0,0);
$pdf->Cell(25   ,5,'Recibido',0,0);
$pdf->Cell(4    ,5,'$',1,0);
$pdf->Cell(30   ,5,$efecti,1,1,'C');//end of line

$pdf->Cell(130  ,5,'',0,0);
$pdf->Cell(25   ,5,'Cambio',0,0);
$pdf->Cell(4    ,5,'$',1,0);
$pdf->Cell(30   ,5,$cambio,1,1,'C');//end of line

$pdf->Cell(130  ,5,'',0,0);
$pdf->Cell(25   ,5,'Plazos',0,0);
$pdf->Cell(4    ,5,'N',1,0);
$pdf->Cell(30   ,5,$mes,1,1,'C');//end of line

$pdf->Cell(130  ,5,'',0,0);
$pdf->Cell(25   ,5,'Valores',0,0);
$pdf->Cell(4    ,5,'$',1,0);
$pdf->Cell(30   ,5,$dif,1,1,'C');//end of line

$pdf->Cell(130	,5,'',0,0);
$pdf->Cell(25	,5,'Total',0,0);
$pdf->Cell(4	,5,'$',1,0);
$pdf->Cell(30	,5,$total,1,1,'C');//end of line


$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->Cell(189	,10,'',0,1);//end of line

$pdf->Cell(120	,5,'Fecha de Ingreso de compra: '.$ffecha,0,0);
$pdf->Output();
}

$pdf->Cell(59	,5,'',0,1);//end of line
?>