<?php

require('fpdf17/fpdf.php');
include ('./'."../../../datos/db/connect.php");

$fecha_actual = date('Y-m-d');

class PDF extends FPDF{
    function Header(){
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
        $this->Cell(80);
        // Title
        $this->Cell(0,10,'Inventario General',1,0,'C');
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


$pdf = new PDF('P','mm','A3');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);

$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','B',11);
$pdf->Cell(120	,5,'PRODUCTO',1,0);
$pdf->Cell(30	,5,'CATEGORIA',1,0);
$pdf->Cell(45	,5,'PRECIO_COMPRA',1,0);
$pdf->Cell(25	,5,'CANT* KG',1,0);
$pdf->Cell(25	,5,'CANT* UNID',1,0);
$pdf->Cell(25	,5,'CADUCA',1,0);
$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','',12);

$query = DBSTART::abrirDB()->prepare("SELECT 
                                                c.nombre,
                                                m.nombreproducto,
                                                m.caducidad,
                                                m.precio_compra,
                                                m.kilo,
                                                m.existencia
                                        
                                        FROM c_mercaderia m
                                        LEFT JOIN c_categoria c ON c.nombre = m.categoria
                                        
                                        WHERE m.estado = 'A' ORDER BY m.nombreproducto ASC");
$query->execute();
$all = $query->fetchAll(PDO::FETCH_ASSOC);

$pc = DBSTART::abrirDB()->prepare("SELECT SUM(precio_compra * existencia) as delaexistencia, SUM(precio_compra * kilo) as delkilo FROM c_mercaderia WHERE estado = 'A'");
$pc->execute();
$allpc = $pc->fetchAll(PDO::FETCH_ASSOC);
foreach((array) $allpc as $lasuma) {
    $laexistencia = $lasuma['delaexistencia'];
    $lakilos = $lasuma['delkilo'];
}

$plus = $laexistencia + $lakilos;


    foreach((array) $all as $item){
    	$pdf->SetFont('Arial','',9);
     
            //if ($fecha_actual >= $item['vencimiento']) {
                $pdf->Cell(120	,5,utf8_decode($item['nombreproducto']),0,0);
                $pdf->Cell(30	,5,utf8_decode($item['nombre']),0,0);
                $pdf->Cell(45	,5,utf8_decode($item['precio_compra']),0,0);
                $pdf->Cell(25	,5,utf8_decode($item['kilo']),0,0);
                $pdf->Cell(25	,5,utf8_decode($item['existencia']),0,0);
            	$pdf->Cell(25	,5,$item['caducidad'],0,0);
            	
            	$pdf->Cell(189	,0,'',0,1);//end of line
            	$pdf->Cell(100	,8,' ______________________________________________________________________________________________________________________________________________________',0,1);//end of line   
            //}
    }
    
    $pdf->Cell(189	,10,'',0,1);//end of line
    $pdf->Cell(189	,0,'',0,1);//end of line
    $pdf->SetFont('Arial','B',15);
    $pdf->Cell(450  ,5,'Total Invertido:  '.number_format($plus, 2),0,0, 'C');
$pdf->Output();

?>