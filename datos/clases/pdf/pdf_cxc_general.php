<?php

require('fpdf17/fpdf.php');
include ('./'."../../../datos/db/connect.php");

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
        $this->Cell(0,10,'Lista de Cuentas x Cobrar',1,0,'C');
        //$pdf->Cell(59	,5,'Lista de Empleados',0,1);//end of line
        $this->Ln(20);
        
        $this->Cell(330  ,5,'Fecha:  '.date('Y-m-d'),0,0, 'C');
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


$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);

$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','B',11);
$pdf->Cell(90	,5,'CLIENTE',1,0);
$pdf->Cell(30	,5,'SALDO',1,0);
$pdf->Cell(30	,5,'TOTAL',1,0);
$pdf->Cell(40	,5,'FECHA DESDE',1,0);
$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','',12);

$query = DBSTART::abrirDB()->prepare("SELECT t2.nombres, t1.total, t1.saldo, t1.fecha_cxc FROM c_cxc t1 INNER JOIN c_clientes t2 ON t1.cedula = t2.cedula
                                         WHERE t1.estado = 'DEBE'");
$query->execute();
$all = $query->fetchAll(PDO::FETCH_ASSOC);
    foreach((array) $all as $item){
    	$pdf->SetFont('Arial','',8);
    	$pdf->Cell(90	,5,strtoupper($item['nombres']),0,0);
        $pdf->Cell(30	,5,$item['saldo'],0,0);
        $pdf->Cell(30	,5,$item['total'],0,0);
    	$pdf->Cell(40	,5,$item['fecha_cxc'],0,0);
    	
    	$pdf->Cell(189	,0,'',0,1);//end of line
    	$pdf->Cell(100	,8,' ______________________________________________________________________________________________________________________',0,1);//end of line
    }
$pdf->Output();

?>