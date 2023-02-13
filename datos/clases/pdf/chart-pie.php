<?php
require('pdf-sector.php');

$pdf = new PDF_SECTOR('P','mm','A4'); //use new class
$pdf->AddPage();

//chart data
$data=Array(
	'lorem'=>[
		'color'=>[255,0,0],
		'value'=>100],
	'ipsum'=>[
		'color'=>[255,255,0],
		'value'=>300],
	'dolor'=>[
		'color'=>[50,0,255],
		'value'=>150],
	'sit'=>[
		'color'=>[255,0,255],
		'value'=>50],
	'amet'=>[
		'color'=>[0,255,0],
		'value'=>240]
	);

//pie and legend properties
$pieX=105;
$pieY=60;
$r=40;//radius
$legendX=150;
$legendY=70;

//get total data summary
$dataSum=0;
foreach($data as $item){
	$dataSum+=$item['value'];
}

//get scale unit for each degree
$degUnit=360/$dataSum;

//variable to store current angle
$currentAngle=0;
//store current legend Y position
$currentLegendY=$legendY;

$pdf->SetFont('Arial','',9);

//simplify the code by drawing both pie and legend in one loop
foreach($data as $index=>$item){
	//draw the pie
	//slice size
	$deg=$degUnit*$item['value'];
	//set color
	$pdf->SetFillColor($item['color'][0],$item['color'][1],$item['color'][2]);
	//remove border
	$pdf->SetDrawColor($item['color'][0],$item['color'][1],$item['color'][2]);
	//draw the slice
	$pdf->Sector($pieX,$pieY,$r,$currentAngle,$currentAngle+$deg);
	//add slice angle to currentAngle var
	$currentAngle+=$deg;
	
	//draw the legend	
	$pdf->Rect($legendX,$currentLegendY,5,5,'DF');
	$pdf->SetXY($legendX + 6,$currentLegendY);
	$pdf->Cell(50,5,$index,0,0);
	$currentLegendY+=5;
}






























$pdf->Output();
