<?php 

	class EnlacesPaginas {

		public function EnlacesInicioModel($enlacesModel) {
			if ( $enlacesModel == "clientes" || $enlacesModel == "log" || $enlacesModel == "about" ||
					$enlacesModel == "servicios" || $enlacesModel == "contacto" || 
					$enlacesModel == "portfolio1" || $enlacesModel == "portfolio2" ||
					$enlacesModel == "portfolio3" || $enlacesModel == "portfolio4" ||
					$enlacesModel == "portfolioitem" || $enlacesModel == "bloghome" ||
					$enlacesModel == "bloghome2" || $enlacesModel == "blogpost" ||
					$enlacesModel == "fullwidth" || $enlacesModel == "sidebar" ||
					$enlacesModel == "faq" || $enlacesModel == "404" || $enlacesModel == "precio" ||
					$enlacesModel == "ventas") {
			
				$modules = "/web/".$enlacesModel . ".php";

			} else if ($enlacesModel == "index") {
				$modules = "login.php";
			}

			return $modules;
		}
	}