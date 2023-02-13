<?php
	require_once ("llenarVentas.php");
	
	$obj = new Ventas();
	echo json_encode($obj->obtenerDatosProducto($_POST['idpro']));

 ?>