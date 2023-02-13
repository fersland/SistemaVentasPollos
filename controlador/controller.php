<?php 

	class MvcController {

		public function elInicio() {
			include "login.php";
		}

		public function enlacesInicioController() {
			if ( isset($_GET['cid']) ) {
				$enlaceControllers = $_GET['cid'];
			} else{
				$enlaceControllers = "log";
			}			

			$respuesta = EnlacesPaginas::EnlacesInicioModel($enlaceControllers);

			include $respuesta;
		}
	}