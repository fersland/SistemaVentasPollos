<?php
//$cliente = $_POST['cliente'];
require('fpdf17/fpdf.php');
include ('./'."../../../datos/db/connect.php");

class PDF extends FPDF {
    function Header(){
        $querys = DBSTART::abrirDB()->prepare("SELECT t3.img_pdf, t2.nombres FROM c_convenios t1 
                                                        INNER JOIN c_clientes t2 ON t1.cliente = t2.cedula
                                                        INNER JOIN c_empresa t3 ON t1.id_empresa = t3.id_empresa");
        $querys->execute();
        $alls = $querys->fetchAll(PDO::FETCH_ASSOC);
        foreach((array) $alls as $items){
            $logo = $items['img_pdf'];
            $ncliente = $items['nombres'];
        }


        $this->Image('../../../init/img/logo/'.$logo, 5,5,35,20,'PNG');
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(0,10,'CONVENIOS DE PRODUCTOS',1,0,'C');
        //$pdf->Cell(59	,5,'Lista de Empleados',0,1);//end of line
        $this->Ln(20);
        
        $this->Cell(30  ,5,'CLIENTE:  ',0,0, 'C');
        $this->Cell(30  ,5,$ncliente,0,0, 'C');
        
        $this->Cell(350  ,5,'Fecha:  '.date('Y-m-d'),0,0, 'C');
        $this->Cell(89	,10,'',0,1);//end of line
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
    }
}


$pdf = new PDF('P','mm','A3');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);

$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','B',11);
$pdf->Cell(50	,5,'CLIENTE',1,0);
$pdf->Cell(25	,5,'CODIGO',1,0);
$pdf->Cell(80	,5,'PRODUCTO',1,0);
$pdf->Cell(28	,5,'PRE NORMAL',1,0);
$pdf->Cell(28	,5,'PRE UNIDAD',1,0);
$pdf->Cell(20	,5,'PRE KILO',1,0);
$pdf->Cell(30	,5,'INGRESO',1,0);
$pdf->Cell(25	,5,'CADUCA',1,0);
$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','',12);

$query = DBSTART::abrirDB()->prepare("SELECT t2.codproducto, t2.nombreproducto, t2.precio_venta, t1.pnuevo, t1.pkilo, t1.fecha_registro, t1.fechacaduca, t3.nombres 
                                            FROM c_convenios t1 
                                                INNER JOIN c_mercaderia t2 ON t1.codigo = t2.codproducto
                                                INNER JOIN c_clientes t3 ON t1.cliente = t3.cedula
                                                WHERE t1.id_estado = 1");
$query->execute();
$all = $query->fetchAll(PDO::FETCH_ASSOC);
    foreach((array) $all as $item){
    	$pdf->SetFont('Arial','',8);
    	$pdf->Cell(50	,5,strtoupper($item['nombres']),0,0);
        $pdf->Cell(25	,5,$item['codproducto'],0,0);
    	$pdf->Cell(80	,5,$item['nombreproducto'],0,0);
        $pdf->Cell(28	,5,$item['precio_venta'],0,0);
        $pdf->Cell(28	,5,$item['pnuevo'],0,0);
        $pdf->Cell(20	,5,$item['pkilo'],0,0);
    	$pdf->Cell(30	,5,$item['fecha_registro'],0,0);
        $pdf->Cell(25	,5,$item['fechacaduca'],0,0);
    	
    	$pdf->Cell(189	,0,'',0,1);//end of line
    	$pdf->Cell(100	,8,' _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _',0,1);//end of line
    }
$pdf->Output();

?>