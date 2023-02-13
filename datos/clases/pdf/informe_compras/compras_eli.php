<?php
if (isset($_REQUEST['factura'])) {
	$thefact = $_REQUEST['factura'];
	require('../fpdf17/fpdf.php');
    
    include ("../../../../datos/db/admysql.php");

    $query = mysqli_query($con,"select * from c_empresa e 
                                            inner join c_compra c on c.id_empresa = e.id_empresa 
                                            inner join c_proveedor p on p.id_proveedor = c.id_proveedor
                                                where c.id_empresa = 1 and c.ncompra= '$thefact' and c.estado= 'X'");
            $invoice = mysqli_fetch_array($query);

$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();

$pdf->Cell(189  ,10,'',0,1);//end of line
$pdf->SetFont('Arial','B',18);
$pdf->Cell(130	,5,$invoice['nombreproveedor'],0,0);

$pdf->SetFont('Arial','',16);
//$pdf->Cell(110,0,'Factura: ',0,0);$pdf->Cell(20,0,'',$invoice['ncompra'],0,0);
$pdf->Cell(100	,5,'FACTURA : '.$invoice['ncompra'],0,0);
$pdf->Cell(59	,5,'',0,1);//end of line

$pdf->Cell(59	,5,'',0,1);//end of line
$pdf->SetFont('Arial','',12);
$pdf->Cell(100	,5,'R.U.C. '.$invoice['ruc'],0,0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(59	,5,'',0,1);//end of line
$pdf->Cell(140	,5,'Direccion : '.$invoice['direccion'],0,0);
$pdf->Cell(140	,5,'E-mail: '.$invoice['correo'],0,0);
$pdf->Cell(59	,5,'',0,1);//end of line
$pdf->Cell(30	,5,'Telefono: '.$invoice['telefono'],0,0);
//$pdf->Cell(23	,5,'R.C.U. / C.I.: _ _ _ _ _ _ _ _ _ _ _',0,0);$pdf->Cell(43	,5,$invoice['ruc'],0,0);$pdf->Cell(60	,5,'Guia de Remision: _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _',0,0); 

$pdf->Cell(189	,10,'',0,1);//end of line


$pdf->SetFont('Arial','B',9);
$pdf->Cell(15	,5,'CANT',1,0);
$pdf->Cell(45	,5,'CODIGO',1,0);
$pdf->Cell(80	,5,'DESCRIPCION',1,0);
$pdf->Cell(25	,5,'V.UNITARIO',1,0);
$pdf->Cell(25	,5,'VALOR TOTAL',1,1);//end of line

$pdf->SetFont('Arial','',9);

$query = mysqli_query($con,

	"select
                    vd.cantidad,
                    vd.cantidad_litros,
                    vd.codigo,
                    vd.precio_compra,
                    vd.descripcion,
                    v.efectivo,
                    v.cambio,
                    v.descuento,
                    v.total,
                    v.descuento,
                    v.iva,
                    v.dinero_iva,
                    v.forma_pago,
                    v.meses,
                    v.diferido,
                    v.importe

                    from c_compra_detalle vd
                    	inner join c_compra v on v.ncompra = vd.ncompra
                        where vd.estado = 'X' and v.ncompra = '$thefact' and vd.estado = 'X'");


$amount = 0; //total amount

while($item = mysqli_fetch_array($query)){
    $nn = $item['cantidad'];    
    $pre = $item['precio_compra'];
    
    $importe = 0;
    $importe = ($nn * $pre);
	$pdf->Cell(15	,5,$nn,1,0,'C');
    $pdf->Cell(45	,5,$item['codigo'],1,0,'');
	$pdf->Cell(80	,5,$item['descripcion'],1,0);
	$pdf->Cell(25	,5,number_format($item['precio_compra'],2,'.',''),1,0,'C');
    $pdf->Cell(25	,5,number_format($importe, 2, '.', ''),1,0,'C');
    $pdf->Cell(189	,5,'',0,1);//end of line
    
    
	$efecti = number_format($item['efectivo'],2,'.','');
	$cambio = number_format($item['cambio'],2,'.','');
    $import = number_format($item['importe'],2,'.','');    

    $dp = $item['descuento_porc'];
    $dd = number_format($item['descuento'],2,'.','');
    $total = number_format($item['total'],2,'.','');
    
    
    $iva = number_format($item['iva'],2,'.','');
    $total = number_format($item['total'],2,'.','');    
    
    $mes = $item['meses'];
    $dif = $item['diferido'];
    $formp = $item['forma_pago'];
    $newval = $item['dinero_iva'];
}
$pdf->Cell(189	,5,'',0,1);//end of line

$pdf->Cell(130	,5,'',0,0);
$pdf->Cell(25	,5,'Forma de Pago',0,0);
$pdf->Cell(34	,5,$formp,1,1,'C');//end of line

$pdf->Cell(130	,5,'',0,0);
$pdf->Cell(25	,5,'Importe',0,0);
$pdf->Cell(4	,5,'$',1,0);
$pdf->Cell(30	,5,$import,1,1,'C');//end of line

$pdf->Cell(130	,5,'',0,0);
$pdf->Cell(25	,5,'Desc',0,0);
$pdf->Cell(4	,5,'$',1,0);
$pdf->Cell(30	,5,$dd,1,1,'C');//end of line

$pdf->Cell(130	,5,'',0,0);
$pdf->Cell(25	,5,'IVA',0,0);
$pdf->Cell(4	,5,'%',1,0);
$pdf->Cell(30	,5,$iva,1,1,'C');//end of line

$pdf->Cell(130	,5,'',0,0);
$pdf->Cell(25	,5,'Valor IVA',0,0);
$pdf->Cell(4	,5,'$',1,0);
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

$pdf->Output();

}
?>