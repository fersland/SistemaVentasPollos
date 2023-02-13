<?php 
	require_once ('./'."../../datos/db/connect.php");

	$env = new DBSTART;
	$cc = $env->abrirDB();
	
        $ruc   	    = htmlspecialchars($_POST['ruc']);
    	$nombres 	= htmlspecialchars($_POST['nombres']);
		$direccion 	= htmlspecialchars($_POST['direccion']);
        $telefono 	= htmlspecialchars($_POST['telefono']);
        $celular 	= htmlspecialchars($_POST['celular']);
        $correo     = htmlspecialchars($_POST['correo']);
        $observacion= htmlspecialchars($_POST['observacion']);
        $estado = 'A';
    
        if ($ruc == "" || $nombres == "" || $direccion == "" ) {
            echo '<div class="alert alert-danger">
                        <b>Los campos con (*) son obligatorios!</b>
                    </div>';
        }else{
		// Consultar ruc repetida
		$stmt = $cc->prepare("SELECT * FROM c_proveedor WHERE ruc = '$ruc'");
		$stmt->execute();
		$cant = $stmt->rowCount();

		if ( $cant == 0 ) {
			$sql = $cc->prepare("INSERT INTO c_proveedor (ruc, nombreproveedor, direccion, telefono, celular, correo,observacion, estado) VALUES (?,?,?,?,?,?,?,?)");
            $sql->bindParam(1, $ruc, 	    PDO::PARAM_STR);
            $sql->bindParam(2, $nombres, 	PDO::PARAM_STR);
			$sql->bindParam(3, $direccion,  PDO::PARAM_STR);
			$sql->bindParam(4, $telefono, 	PDO::PARAM_STR);
            $sql->bindParam(5, $celular, 	PDO::PARAM_STR);
            $sql->bindParam(6, $correo, 	PDO::PARAM_STR);
            $sql->bindParam(7, $observacion,PDO::PARAM_STR);
            $sql->bindParam(8, $estado, 	PDO::PARAM_STR);
			
            if ($sql -> execute() ){
                echo '<div class="alert alert-success">
                        <b>Proveedor guardado!</b>
                    </div>';
            }else{
                echo '<div class="alert alert-danger">
                        <b>Error al guardar al Proveedor!</b>
                    </div>';
            }			
		}else{
			echo '<div class="alert alert-danger">
                        <b>El RUC de este proveedor ya existe en el sistema!</b>
                    </div>';
		}
  }	