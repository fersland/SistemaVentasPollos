<?php
	require_once ("llenarCompras.php");
	
	$obj = new Ventas();
	echo json_encode($obj->obtenerDatosProducto($_POST['idpro']));

 ?>