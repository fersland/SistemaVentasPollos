<?php

require('fpdf17/fpdf.php');
include ('./'."../../db/connect.php");

class PDF extends FPDF{
    function Header(){
        $querys = DBSTART::abrirDB()->prepare("SELECT * FROM c_empresa");
        $querys->execute();
        $alls = $querys->fetchAll(PDO::FETCH_ASSOC);
        foreach((array) $alls as $items){
            $logo = $items['img_pdf'];
            $name_company = $items['nom_empresa'];
        }
    
        $pdf->Image('../../../../init/img/logo/'.$logo,15,10,30,20,'png');
        // Arial bold 15
        $this->SetFont('Arial','B',15);
    
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(0,10,$name_company,1,0,'C');
        //$pdf->Cell(59	,5,'Lista de Empleados',0,1);//end of line
        $this->Ln(20);
        
        $this->Cell(330  ,5,'Fecha:  '.date('Y-m-d'),0,0, 'C');
        $this->Cell(189	,10,'',0,1);//end of line
    }
}