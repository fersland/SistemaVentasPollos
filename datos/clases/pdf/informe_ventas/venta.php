<?php
    $thefact = isset($_GET['factura']) ? $_GET['factura'] : 0;
    require('../fpdf17/fpdf.php');
    include ('./'."../../../../datos/db/connect.php");
    include ('./'."../../../../init/sin/ControlCode.php");
    $controlCode = new ControlCode();

    $env = new DBSTART;
    $db = $env->abrirDB();
    $query = $db->prepare("select v.nventa, p.ruc_empresa,p.direcc_empresa,p.mail_empresa,p.telf_empresa,p.pais, p.ciudad,c.cedula,
                            v.cliente,c.direccion_cliente,c.telefono,c.celular,c.nombres, p.img_pdf,
                            concat(epl.nombres, ' ', epl.apellidos) as name_epl, r.nombrerol, p.nom_empresa, v.forma_pago, v.iva, v.idr,
                            v.parcial, v.saldo, v.fecha_origen, v.total, v.autoriz, v.dosif
                            
                            from c_venta v
                            left join c_clientes as c on v.cliente = c.cedula
                            inner join c_venta_detalle vd on vd.nventa = v.nventa
                            left join c_empleados epl on epl.id_empleado = vd.empleado

                            left join c_roles r on r.idrol = epl.id_acceso
                            inner join c_empresa p on v.id_empresa = p.id_empresa where v.norden= '$thefact'");
    $query->execute();
    $rows = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $key => $value) {
        $numventa   = $value['nventa'];
        $ruc        = $value['ruc_empresa'];
        $nom        = $value['nom_empresa'];
        $dir        = $value['direcc_empresa'];
        $mail       = $value['mail_empresa'];
        $telf       = $value['telf_empresa'];
        $id_cl      = $value['cliente'];
        $ci         = $value['cedula'];
        $dir_cl     = $value['direccion_cliente'];
        $telf_cl    = $value['telefono'];
        $cel_cl     = $value['celular'];
        $name_cl    = $value['nombres'];
        $logo       = $value['img_pdf'];        
        $pais       = $value['pais'];
        $ciudad     = $value['ciudad'];        
        $formapago = $value['forma_pago'];
        $el_rol     = $value['name_epl'];
        $parcial = $value['parcial'];
        $saldo = $value['saldo'];
        
        $estado = '* '.$pais. ' - '.$ciudad;
        
        $valordeiva = $value['iva'];

        $idr = $value['idr'];
        $fechaorigen = $value['fecha_origen'];
        $montototal = $value['total'];

        $autoriz = $value['autoriz'];
        $dosif = $value['dosif'];
    }

    // CONSULTAR LOS NOMBRES DEL ENCARGADO
    $sflush = $db->prepare("SELECT CONCAT(nombres, ' ', apellidos) as encargado FROM c_empleados WHERE id_empleado='$idr'");
    $sflush->execute();
    $fflush = $sflush->fetchAll();
    foreach ($fflush as $key => $value_fflush) {
    	$nencargado = $value_fflush['encargado'];
    }

    if ($ci == 0 || $ci == '') {
        $ci = '';
    }

$pdf = new FPDF('P','mm', 'Letter');
$pdf->AddPage();

$pdf->SetFont('Arial','',12);
$pdf->Cell(189  ,10,'',0,1);//end of line
$pdf->SetFont('Arial','B',18); 
$pdf->Image('../../../../init/img/logo/'.$logo,15,10,30,20,'png');
        $pdf->Cell(130  ,5,''.'',0,0, 'C');
        $pdf->Cell(129,0,$nom,0,1);//end of line
        //$pdf->Cell(139,0,'FACTURA',0,1);//end of line

//$pdf->Cell(190  ,5,$invoice['nom_empresa_presenta'],0,0);
$pdf->Cell(59   ,5,'',0,1);//end of line

//$pdf->Cell(130  ,5,$invoice['nom_empresa'],0,0);

$pdf->SetFont('Arial','',16);
        $pdf->Cell(128  ,5,''.' ',0,0, 'C');
        $pdf->Cell(30  ,5,''.'FACTURA: ',0,0, 'C');
        $pdf->Cell(20,5,$numventa,0,1);//end of line
        
        
$pdf->SetFont('Arial','',6);


$pdf->Cell(59   ,5,'',0,1);//end of line
$pdf->SetFont('Arial','',18);
//$pdf->Cell(246  ,5,$nom,0,0, 'C');

$pdf->SetFont('Arial','',10);
$pdf->Cell(35  ,5,'CI/NIT. '.$ruc,0,0, 'C');
$pdf->Cell(59   ,5,'',0,1);//end of line
$pdf->Cell(100  ,5,$dir,0,1);//end of line
$pdf->Cell(130  ,5,'E-mail: '.$mail,0,0);
//$pdf->Cell(110  ,5,'Empleado: '.'',0,0);
$pdf->Cell(59   ,5,'',0,1);//end of line
$pdf->Cell(30   ,5,'Cel: '.$telf,0,0);$pdf->Cell(100  ,5,$estado,0,0);
//$pdf->Cell(60   ,5,strtoupper($el_rol),0,0);
$pdf->Cell(59   ,5,'',0,1);//end of line



$pdf->Cell(359   ,5,'',0,1);//end of line
$pdf->Cell(100  ,5,'Forma de Pago: '.strtoupper($formapago),0,0);
//$pdf->Cell(180  ,5,'Encargado: '.strtoupper(utf8_decode($nencargado)),0,0);
$pdf->Cell(59   ,5,'',0,1);//end of line


// NUMERO DE AUTORIZACION
// NUMERO DE FACTURA
// NUMERO DE NIT CEDULA
// FECHA DE TRANSACCION
// MONTO DE LA TRANSACCION
// LLAVE DE DOSIFICACION

$bodytag = str_replace("-", "", $fechaorigen);
$code = $controlCode->generate($autoriz, $numventa, $ci, $bodytag, $montototal, $dosif);
$pdf->Cell(100  ,5,'CODIGO DE CONTROL: '.strtoupper($code),0,0);
$pdf->Cell(59   ,5,'',0,1);//end of line                
$pdf->Cell(59   ,5,'',0,1);//end of line       

if ($id_cl == 0) {
    $dato = 'CONSUMIDOR FINAL';
}else{
    $dato = $name_cl;
}
$pdf->Cell(19   ,7,'Sr(a): _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _',0,0);$pdf->Cell(189   ,7,strtoupper($dato),0,0);

$pdf->Cell(189  ,10,'',0,1);//end of line
$pdf->Cell(23   ,5,'C.I/NIT: _ _ _ _ _ _ _ _ _ _ _',0,0);$pdf->Cell(43 ,5,$ci,0,0);$pdf->Cell(30    ,5,'Direccion: _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _',0,0);$pdf->Cell(123  ,5,$dir_cl,0,0); 

$pdf->Cell(189  ,10,'',0,1);//end of line
$pdf->Cell(19   ,5,'Telefono:  _ _ _ _ _ _ _ _ _',0,0);$pdf->Cell(85    ,5,$telf_cl,0,0); $pdf->Cell(16 ,5,'Celular: _ _ _ _ _ _ _ _ _ _',0,0); $pdf->Cell(10   ,5,$cel_cl,0,0);

$pdf->Cell(189  ,10,'',0,1);//end of line


$pdf->SetFont('Arial','B',9);
$pdf->Cell(25   ,5,'CANTIDAD',1,0,'C');
$pdf->Cell(25   ,5,'CATEGORIA',1,0,'C');
$pdf->Cell(90  ,5,'DESCRIPCION',1,0,'C');
$pdf->Cell(32   ,5,'PRECIO UNITARIO',1,0,'C');
$pdf->Cell(27   ,5,'TOTAL',1,1,'C');//end of line

$pdf->SetFont('Arial','',11);

$stmt = $db->prepare("SELECT v.nventa, vd.cantidad,vd.codigo,vd.precio,vd.importe as imp_vd,
                        v.efectivo,v.cambio,v.descuento,v.total,v.iva,v.iva_valor, v.forma_pago,v.meses,v.diferido,v.importe,
                        m.codproducto,m.nombreproducto, vd.tcant, vd.categoria
                        
                        FROM c_venta as v 
                            INNER JOIN c_venta_detalle AS vd ON vd.num_orden = v.norden
                            LEFT JOIN c_mercaderia m ON m.codproducto = vd.codigo 
                            
                            WHERE v.norden = '$thefact' AND vd.estado = 'F'");
$stmt->execute();
$fetch = $stmt->fetchAll();

foreach($fetch as $item){   
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(25   ,5,$item['cantidad'] . ' ('. $item['tcant'].')',1,0,'C');
    $pdf->Cell(25   ,5,$item['categoria'], 1,0,'C');
    $pdf->Cell(90  ,5,$item['nombreproducto'],1,0,'C');
    $pdf->Cell(32   ,5,bcdiv($item['precio'],'1',2),1,0,'C');
    $pdf->Cell(27   ,5,bcdiv($item['imp_vd'],'1',2),1,0,'C');
    

    // El importe total
    $el_importe = 0;
    //$el_importe = ()
    $efecti = number_format($item['efectivo'],2,'.','');
    $cambio = number_format($item['cambio'],2,'.','');
    $import = number_format($item['importe'],2,'.','');
    $dd = bcdiv($item['descuento'],'1',2);
    //$siva = bcdiv($item['sin_iva'],'1',2);
    


    $total = number_format($item['total'],2,'.','');

    $pdf->Cell(189  ,5,'',0,1);//end of line
    
    $iva = number_format($item['iva'],2,'.','');
    $total = number_format($item['total'],2,'.','');
    
    $mes = $item['meses'];
    $dif = $item['diferido'];
    $formp = $item['forma_pago'];
    $ivad = $item['iva_valor'];
    // Valor del iva
    
    //$obse = $item['observacion'];
}

$pdf->Cell(189  ,5,'',0,1);//end of line
$pdf->Cell(189  ,5,'',0,1);//end of line

                  $pdf->Cell(315    ,0,'SUB-TOTAL',0,1,'C');$pdf->Cell(355  ,0,$import,0,1,'C');
$pdf->SetFont('Arial','',7);
                           
$pdf->Cell(20   ,5,'',0,1);                               $pdf->Cell(315    ,0,'I.V.A. 0%',0,1,'C');$pdf->Cell(355  ,0,'0.00',0,1,'C');
             
$pdf->Cell(20   ,5,'',0,1);                               $pdf->Cell(315    ,0,'I.V.A. '.$valordeiva.'%',0,1,'C');$pdf->Cell(355 ,0,$ivad,0,1,'C');

$pdf->Cell(20   ,5,'',0,1);                               $pdf->Cell(315    ,0,'DESC',0,1,'C');$pdf->Cell(355   ,0,$dd,0,1,'C');

if ($formapago == 'Parcial') {
    $pdf->Cell(20   ,5,'',0,1);                               $pdf->Cell(315    ,0,'PARCIAL',0,1,'C');$pdf->Cell(355   ,0,$parcial,0,1,'C');
    $pdf->Cell(20   ,5,'',0,1);                               $pdf->Cell(315    ,0,'SALDO',0,1,'C');$pdf->Cell(355   ,0,$saldo,0,1,'C');    
}

$pdf->SetFont('Arial','B',10);
$pdf->Cell(20   ,5,'',0,1);                               $pdf->Cell(315    ,0,'TOTAL ',0,1,'C');$pdf->Cell(355    ,0,$total,0,1,'C');
$pdf->Cell(130  ,5,'',0,0);

$pdf->Cell(189  ,10,'',0,1);//end of line
//$pdf->Cell(8    ,5,'SON: __________________________________________________________________________________________________________________________________',0,0);$pdf->Cell(125    ,5,strtoupper($invoice['son']),0,0); 

$pdf->Cell(189  ,10,'',0,1);//end of line
//$pdf->Cell(21   ,5,'OBSERVACION: _________________________________________________________________________________________________________________________',0,0);$pdf->Cell(125 ,5,strtoupper($obse),0,0);
$pdf->Cell(189  ,10,'',0,1);//end of line
$pdf->Cell(189  ,10,'',0,1);//end of line

$pdf->Cell(20   ,5,'',0,0);$pdf->Cell(90    ,5,'_____________________________',0,0);$pdf->Cell(80   ,5,'____________________________',0,0);
$pdf->Cell(199  ,5,'',0,1);//end of line
$pdf->Cell(30   ,5,'',0,0);$pdf->Cell(90    ,5,'Firma Autorizada',0,0);$pdf->Cell(90    ,5,'Recibi Conforme',0,0);
$pdf->Cell(189  ,10,'',0,1);//end of line

//$pdf->Cell(10 ,5,'',0,0);$pdf->Cell(90    ,5,'______________________________________________________________________________________________________________________',0,0);
//$pdf->Cell(189    ,10,'',0,1);//end of line

//$pdf->SetFont('Arial','',8);
/*$pdf->Cell(40 ,5,''.'',0,0);
    $pdf->Cell(12   ,5,'Del: '.$invoice['numero_desde'],0,0);
    $pdf->Cell(10   ,5,'Al: '.$invoice['numero_hasta'],0,0);
    $pdf->Cell(50   ,5,'FECHA AUTORIZACION: '.$invoice['fecha_desde'],0,0);
    $pdf->Cell(12   ,5,'CADUCIDAD: '.$invoice['fecha_hasta'],0,0);
    $pdf->Cell(59   ,3,'',0,1);//end of line
$pdf->Cell(60   ,5,''.'',0,0);
    $pdf->Cell(12   ,5,'ORIGINAL ADQUIRIENTE * COPIA EMISOR'.'',0,0);
*/
$pdf->Output();


?>