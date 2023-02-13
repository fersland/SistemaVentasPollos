<?php

require('fpdf17/fpdf.php');
include ('./'."../../../datos/db/connect.php");

$fecha_actual = date('Y-m-d');
$cid = $_REQUEST['sucursal'];

// EXTRAER SUCURSAL
        


class PDF extends FPDF{
    function Header(){
        $cid = $_REQUEST['sucursal'];
        $yan = DBSTART::abrirDB()->prepare("SELECT * FROM c_sucursal WHERE id_sucursal='$cid'");
        $yan->execute();
        $yaname = $yan->fetchColumn(1);
        
        $querys = DBSTART::abrirDB()->prepare("SELECT * FROM c_empresa");
        $querys->execute();
        $alls = $querys->fetchAll(PDO::FETCH_ASSOC);
        foreach((array) $alls as $items){
            $logo = $items['img_pdf'];
        }
        
        


        $this->Image('../../../init/img/logo/'.$logo, 5,5,35,20,'PNG');
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Move to the right
        $this->Cell(70);
        // Title
        $this->Cell(0,10,'INVENTARIO PARA: '.$yaname,1,0,'C');
        //$pdf->Cell(59	,5,'Lista de Empleados',0,1);//end of line
        $this->Ln(20);
        
        $this->Cell(450  ,5,'Fecha:  '.date('Y-m-d'),0,0, 'C');
        $this->Cell(189	,10,'',0,1);//end of line
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


$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);

$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','B',11);
$pdf->Cell(100	,5,'PRODUCTO',1,0);
$pdf->Cell(35	,5,'TIPO',1,0);
$pdf->Cell(30	,5,'PRE_COMPRA',1,0);
$pdf->Cell(30  ,5,'PRE_VENTA',1,0);

$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','',12);

$query = DBSTART::abrirDB()->prepare("SELECT 
                                                c.nombre,
                                                m.nombreproducto,
                                                m.precio_compra, 
                                                m.precio_venta
                                        
                                        FROM c_mercaderia m
                                        LEFT JOIN c_categoria c ON c.nombre = m.categoria
                                        
                                        WHERE m.estado = 'A' AND m.sucursal = '$cid' ORDER BY m.nombreproducto ASC");
$query->execute();
$all = $query->fetchAll(PDO::FETCH_ASSOC);
    foreach((array) $all as $item){
    	$pdf->SetFont('Arial','',9);
        
            $pdf->Cell(100	,5,utf8_decode($item['nombreproducto']),0,0);
            $pdf->Cell(35	,5,utf8_decode($item['nombre']),0,0);
        	$pdf->Cell(30	,5,$item['precio_compra'],0,0);
            $pdf->Cell(30	,5,$item['precio_venta'],0,0);
        	
        	$pdf->Cell(189	,0,'',0,1);//end of line
        	$pdf->Cell(100	,8,' ____________________________________________________________________________________________________________',0,1);//end of line   
        
    }
$pdf->Output();

?>