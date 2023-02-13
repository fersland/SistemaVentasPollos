<?php
/*
$codigo = '200105';
//$buscar1 = array('0105', '0109', '2100', '2112');
$buscar1 = '0105';
/*$buscar1 = '01035';
$buscar1 = '01005';
$buscar1 = '01035';*/
    
  /*  $pos = strpos($codigo, $buscar1);
    if ($pos === true) {
    	echo 1;
    }else{
    	echo 0;
    }*/


$string = 'This is a 100105';
$lastChar = substr($string, -3);
echo "The last char of the string is $lastChar.";