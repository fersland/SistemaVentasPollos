<?php 
	
	/**
	 * Mostrar las vistas al usuario
	   Enviar las acciones del usuario al controlador
     *
    **/

	require_once ("controlador/controller.php");
	require_once ("datos/clases/model.php");
	$mvc = new MvcController();
	$mvc -> elInicio();