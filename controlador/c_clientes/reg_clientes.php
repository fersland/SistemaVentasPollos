<?php
	require_once ('./'."../../datos/db/connect.php");

	$env = new DBSTART;
	$cc = $env->abrirDB();
    
        $cedula 	= htmlspecialchars(strtoupper($_POST['cedula']));
        $nombres 	= htmlspecialchars(strtoupper($_POST['nombres']));
        $correo 	= htmlspecialchars(strtoupper($_POST['correo']));
        $telefono 	= htmlspecialchars(strtoupper($_POST['telefono']));
        $celular 	= htmlspecialchars(strtoupper($_POST['celular']));
        $direcc 	= htmlspecialchars(strtoupper($_POST['direccion']));
		$observacion= htmlspecialchars(strtoupper($_POST['observacion']));
        $estado = 'A';
        
        if ($cedula == "") {
            echo '<div class="alert alert-warning">
                <b>Debe asignar una cédula al cliente!</b>
            </div>';
        }else{

		// Consultar cédula repetida
		$stmt = $cc->prepare("SELECT * FROM c_clientes WHERE cedula='$cedula'");
		$stmt->execute();
		$cant = $stmt->rowCount();

		if ( $cant == 0 ) {
		  
    
            $veces = 0;
			$sql = $cc->prepare("INSERT INTO c_clientes (cedula,nombres,correo,telefono,celular,direccion_cliente,nveces,estado, observacion_cliente)
                                        VALUES (:ced,:nom,:cor,:tel,:cel,:dir,:vec,:est,:obs)");
            $sql->bindParam(':ced', $cedula, 	  PDO::PARAM_STR);
			$sql->bindParam(':nom', $nombres,     PDO::PARAM_STR);
            $sql->bindParam(':cor', $correo, 	  PDO::PARAM_STR);
            $sql->bindParam(':tel', $telefono, 	  PDO::PARAM_STR);
            $sql->bindParam(':cel', $celular, 	  PDO::PARAM_STR);
            $sql->bindParam(':dir', $direcc, 	  PDO::PARAM_STR);
            $sql->bindParam(':vec', $veces,       PDO::PARAM_INT);
            $sql->bindParam(':est', $estado, 	  PDO::PARAM_STR);
            $sql->bindParam(':obs', $observacion, PDO::PARAM_STR);
			if ($sql -> execute() ) {
			     echo '<div class="alert alert-success">
                <b>Cliente nuevo guardado!</b>
            </div>';
                
			}else{
			     echo '<div class="alert alert-danger">
                        <b>Error al registrar al nuevo cliente!</b>
                       </div>';
			}
            
            
            
		}else{
			echo '<div class="alert alert-danger">
                <b>Error, esta cedula ya existe en el sistema!</b>
            </div>';
		}
    }