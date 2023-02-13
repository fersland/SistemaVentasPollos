<?php 
	require_once ("../../datos/db/connect.php");

	if (isset($_REQUEST['id'])) {
		$id = $_REQUEST['id'];

		$informe = DBSTART::abrirDB()->prepare("SELECT COUNT(*) as cant FROM c_modulos_items WHERE idcm = '$id' AND estado = 'ACTIVO'");
		$informe->execute();
		$rows = $informe->fetchAll(PDO::FETCH_ASSOC);

		foreach ($rows as $key => $value) {
			$count = $value['cant'];
		}


		if ( $count == 0 ) {
			$status = "ACTIVO";
		}else{
			$status = "INACTIVO";
		}
	    
	    $sql = DBSTART::abrirDB()->prepare("UPDATE c_modulos_items SET estado = '$status', fecha_modificacion=now() WHERE idcm = '$id'");
	    $sql->execute();

	    echo '<script>
	            window.history.back()
	         </script>';
	}