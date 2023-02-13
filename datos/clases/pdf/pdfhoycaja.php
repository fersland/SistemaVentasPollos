<?php

require('fpdf17/fpdf.php');
include ('./'."../../../datos/db/connect.php");
$hoy = date('Y-m-d');
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
        $this->Cell(0,10,'REGISTROS CAJA CHICA HOY',1,0,'C');
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
$pdf->Cell(20	,5,'TIPO',1,0);
$pdf->Cell(40	,5,'DE',1,0);
$pdf->Cell(80	,5,'DESCRIPCION',1,0);
$pdf->Cell(21	,5,'ENTRADA',1,0);
$pdf->Cell(20	,5,'SALIDA',1,0);
$pdf->Cell(15	,5,'SALDO',1,0);
$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','',12);



$query = DBSTART::abrirDB()->prepare("SELECT t1.entrada, t1.salida, t2.nombre as tipogasto, t3.nombre as tipoconta, t1.obs, t1.saldo  
                                        FROM c_resumen_gasto t1 
                                        LEFT JOIN c_tipo_gastos t2 ON t1.tipo = t2.id 
                                    LEFT JOIN c_conta t3 ON t1.param = t3.id
                                    WHERE t1.fecha_sin = '$hoy' AND t1.id_estado = 1");
$query->execute();
$all = $query->fetchAll(PDO::FETCH_ASSOC);
    foreach((array) $all as $item){
    	$pdf->SetFont('Arial','',8);
    	$pdf->Cell(20	,5,$item['tipoconta'],0,0);
        $pdf->Cell(40	,5,$item['tipogasto'],0,0);    	
    	$pdf->Cell(80	,5,$item['obs'],0,0);
        $pdf->Cell(20	,5,$item['entrada'],0,0);
        $pdf->Cell(20	,5,$item['salida'],0,0);
        $pdf->Cell(15	,5,$item['saldo'],0,0);
    	
    	$pdf->Cell(189	,0,'',0,1);//end of line
    	$pdf->Cell(100	,8,' __________________________________________________________________________________________________________________________',0,1);//end of line
    }
$pdf->Output();

?>