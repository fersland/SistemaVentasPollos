<?php

require('fpdf17/fpdf.php');
include ('./'."../../../datos/db/connect.php");

$id = $_GET['cid'];
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
        $this->Cell(0,10,'MENUDENCIA',1,0,'C');
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
$pdf->Cell(30	,5,'TIPO',1,0);
$pdf->Cell(30	,5,'CANT POLLO',1,0);
$pdf->Cell(30	,5,'PATA',1,0);
$pdf->Cell(30	,5,'MOLLEJA',1,0);
$pdf->Cell(30	,5,'HIGADO',1,0);
$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','',12);

$query = DBSTART::abrirDB()->prepare("SELECT * FROM menudencia t1 INNER JOIN menu t2 ON t1.nnum = t2.nnum WHERE t1.nnum='$id' AND t1.id_estado = 1");
$query->execute();
$item = $query->fetch(PDO::FETCH_ASSOC);
    	$pdf->SetFont('Arial','',10);
    	$pdf->Cell(30	,5,'105',0,0);
        $pdf->Cell(30	,5,$item['cero5cant'],0,0);
    	$pdf->Cell(30	,5,$item['cero5pata'],0,0);
    	$pdf->Cell(30	,5,$item['cero5molleja'],0,0);
        $pdf->Cell(30	,5,$item['cero5higado'],0,0);
    	
    	$pdf->Cell(189	,0,'',0,1);//end of line
    	$pdf->Cell(100	,8,'_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _',0,1);//end of line

        $pdf->Cell(30	,5,'106,107,108,109',0,0);
        $pdf->Cell(30	,5,'',0,0);
    	$pdf->Cell(30	,5,$item['cero6pata'],0,0);
    	$pdf->Cell(30	,5,$item['cero6molleja'],0,0);
        $pdf->Cell(30	,5,$item['cero6higado'],0,0);


        $pdf->Cell(189	,0,'',0,1);//end of line
    	$pdf->Cell(100	,8,'_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _',0,1);//end of line

        $pdf->Cell(30	,5,'Unidad',0,0);
        $pdf->Cell(30	,5,'',0,0);
    	$pdf->Cell(30	,5,$item['ceroudpata'],0,0);
    	$pdf->Cell(30	,5,$item['ceroudmolleja'],0,0);
        $pdf->Cell(30	,5,$item['ceroudhigado'],0,0);


        $pdf->Cell(189	,0,'',0,1);//end of line
    	$pdf->Cell(100	,8,'____________________________________________________________________________',0,1);//end of line

        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(30	,5,'TOTALES',0,0);
        $pdf->Cell(30	,5,'',0,0);
    	$pdf->Cell(30	,5,$item['sumapata'],0,0);
    	$pdf->Cell(30	,5,$item['sumamolleja'],0,0);
        $pdf->Cell(30	,5,$item['sumahigado'],0,0);

        $pdf->Cell(189	,10,'',0,1);//end of line
    	$pdf->Cell(100	,8,'____________________________________________________________________________',0,1);//end of line

        $pdf->Cell(30	,5,'TOTAL MENUDO',0,0);
        $pdf->Cell(30	,5,'',0,0);
    	$pdf->Cell(30	,5,$item['sumakg']. ' KG',0,0);

    
$pdf->Output();

?>