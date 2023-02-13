<?php

	class Ventas{

		public function obtenerDatosProducto($idproducto){
			include ("../datos/db/connect.php");
			
			$env = new DBSTART;
            $db = $env->abrirDB();
            
			$sql = $db->prepare("SELECT a.cedula, a.nombres FROM c_clientes as a WHERE a.cedula like '$idproducto'");
			$sql->execute();

			$rows = $sql->fetchAll(PDO::FETCH_ASSOC);
			
			foreach($rows as $data) {
    			$data = array('nombres' => $ver[1]);
    
    			return $data;
    		}
    	}
	}