<?php

require('fpdf17/fpdf.php');
include ('./'."../../../datos/db/connect.php");

$fecha_actual = date('Y-m-d');
$sucursal = $_GET['sucursal'];


class PDF extends FPDF{
    function Header(){
        $sucursal = $_GET['sucursal'];
        $empire = DBSTART::abrirDB()->prepare("SELECT * FROM c_sucursal WHERE id_sucursal ='$sucursal'");
        $empire->execute();
        $allempire = $empire->fetchColumn(1);

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
        $this->Cell(40);
        // Title
        $this->Cell(0,0,'Por caducar en : '. $allempire,0,0,'C');
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
$pdf->Cell(45	,5,'TIPO',1,0);
$pdf->Cell(25	,5,'CADUCA',1,0);
$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','',12);

$query = DBSTART::abrirDB()->prepare("SELECT now(), caducidad - interval 5 day as vencimiento,
                                                c.nombre,
                                                m.nombreproducto,
                                                m.caducidad
                                        
                                        FROM c_mercaderia m
                                        LEFT JOIN c_categoria c ON c.nombre = m.categoria
                                        
                                        WHERE m.estado = 'A' AND m.sucursal = '$sucursal' ORDER BY m.nombreproducto ASC");
$query->execute();
$all = $query->fetchAll(PDO::FETCH_ASSOC);
    foreach((array) $all as $item){
    	$pdf->SetFont('Arial','',9);
     
            //if ($fecha_actual >= $item['vencimiento']) {
                $pdf->Cell(100	,5,utf8_decode($item['nombreproducto']),0,0);
                $pdf->Cell(45	,5,utf8_decode($item['nombre']),0,0);
            	$pdf->Cell(25	,5,$item['caducidad'],0,0);
            	
            	$pdf->Cell(189	,0,'',0,1);//end of line
            	$pdf->Cell(100	,8,' _______________________________________________________________________________________________',0,1);//end of line   
            //}
    }
$pdf->Output();

?>