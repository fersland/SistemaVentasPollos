<?php

	class Ventas{

		public function obtenerDatosProducto($idproducto){
			include ("../../datos/db/connect.php");
			
			$env = new DBSTART;
            $db = $env->abrirDB();
            
			$sql = $db->prepare("SELECT nombreproducto FROM c_mercaderia WHERE categoria like '$idproducto'");
			$sql->execute();

			$rows = $sql->fetchAll(PDO::FETCH_ASSOC);
			
			foreach($rows as $data) {
    			$data = array('nombreproducto' => $ver[0]);
    
    			return $data;
    		}
    	}
	}