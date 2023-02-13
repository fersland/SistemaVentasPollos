<?php

    if (isset($_POST['anual'])) {
        setlocale(LC_MONETARY, 'en_US');
        
        $anual = $_POST['anio'];
        require('fpdf17/fpdf.php');
        include ("../../../datos/db/admysql.php");


$pdf = new FPDF('P','mm','A4');

$pdf->AddPage();

$pdf->SetFont('Arial','B',16);
//$pdf->Image('logo.png', 29,2,25,18,'PNG');
$pdf->Cell(189  ,10,'',0,1);//end of line

$pdf->Image('../../../inicializador/img/logo.PNG', 165,15,35,14,'PNG');
$pdf->Cell(132	,5,'INFORME DE INVERSIONES Y GANANCIAS DEL',0,0); $pdf->Cell(20	,5,$anual,0,0);

$pdf->SetFont('Arial','',10);

$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','B',13);
$pdf->Cell(10	,5,'COMPRAS',0,0);
$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','',14);


$pdf->Cell(100	,5,'Inversion Total :',0,0);

$query = mysqli_query($con,"SELECT SUM(total) as total_compra FROM c_compra WHERE EXTRACT(YEAR FROM fechacompra) = '$anual' ");

while($item = mysqli_fetch_array($query)){
    $total_compra = $item['total_compra'];
      
    $pdf->Cell(80	,5,money_format('%(#10n', $total_compra),0,0);
	
	$pdf->Cell(189	,0,'',0,1);//end of line
	$pdf->Cell(100	,8,' __________________________________________________________________',0,1);//end of line
    $pdf->Cell(189	,0,'',0,1);//end of line
    $pdf->Cell(189	,0,'',0,1);//end of line
}
$pdf->Cell(189	,0,'',0,1);//end of line

// 2


$pdf->Cell(100	,5,'En Inventario :',0,0);

$query2 = mysqli_query($con,"SELECT SUM(total) as total_compra FROM c_compra WHERE EXTRACT(YEAR FROM fechacompra) = '$anual' ");

while($item2 = mysqli_fetch_array($query2)){
    $total_compra = $item2['total_compra'];
    $ganancia = 0;
    $ganancia = ($total_compra * 40 / 100);
    $total_con = 0;
    $total_con = ($total_compra + $ganancia);
    
    $pdf->Cell(80	,5,money_format('%(#10n', $total_con),0,0);
	
	$pdf->Cell(189	,0,'',0,1);//end of line
	$pdf->Cell(100	,8,' __________________________________________________________________',0,1);//end of line
    $pdf->Cell(189	,0,'',0,1);//end of line
}





// 3


$pdf->Cell(100	,5,'Ganancias :',0,0);

$query3 = mysqli_query($con,"SELECT SUM(total) as total_compra FROM c_compra WHERE EXTRACT(YEAR FROM fechacompra) = '$anual' ");

while($item3 = mysqli_fetch_array($query3)){
    $total_compra = $item3['total_compra'];
    $ganancia = 0;
    $ganancia = ($total_compra * 40 / 100);
    
    $pdf->Cell(80	,5,money_format('%(#10n', $ganancia),0,0);
    
	
	$pdf->Cell(189	,0,'',0,1);//end of line
	$pdf->Cell(100	,8,' __________________________________________________________________',0,1);//end of line
    $pdf->Cell(189	,0,'',0,1);//end of line
}
$pdf->Output();
}
?>