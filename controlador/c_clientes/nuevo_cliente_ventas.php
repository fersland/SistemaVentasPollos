<?php

    /*************************************************/
    /* Ultima actualización: 17-Mar-2020*/
    /* Por: Fernando Reyes N */
    /*************************************************/
    
	require_once ('./'."../../datos/db/connect.php");

	$env = new DBSTART;
	$cc = $env->abrirDB();
    
    if (isset($_POST['register'])) {
        $cedula 	= htmlspecialchars($_POST['cedula']);
        $nombres 	= htmlspecialchars($_POST['nombres']);
        $correo 	= htmlspecialchars($_POST['correo']);
        $telefono 	= htmlspecialchars($_POST['telefono']);
        $celular 	= htmlspecialchars($_POST['celular']);
        $direcc 	= htmlspecialchars($_POST['direccion']);
        
		$laorden = $_POST['laorden'];
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
            $veces = 1;
			$sql = $cc->prepare("INSERT INTO c_clientes (cedula,nombres,correo,telefono,celular,direccion_cliente,nveces,estado,orden)
                                        VALUES (:ced,:nom,:cor,:tel,:cel,:dir,:vec,:est, :ord)");
            $sql->bindParam(':ced', $cedula, 	  PDO::PARAM_STR);
			$sql->bindParam(':nom', $nombres,     PDO::PARAM_STR);
            $sql->bindParam(':cor', $correo, 	  PDO::PARAM_STR);
            $sql->bindParam(':tel', $telefono, 	  PDO::PARAM_STR);
            $sql->bindParam(':cel', $celular, 	  PDO::PARAM_STR);
            $sql->bindParam(':dir', $direcc, 	  PDO::PARAM_STR);
            $sql->bindParam(':vec', $veces,       PDO::PARAM_INT);
            $sql->bindParam(':est', $estado, 	  PDO::PARAM_STR);
            $sql->bindParam(':ord', $laorden, 	  PDO::PARAM_INT);

			if ($sql -> execute() ) {
			     $msg = 'Cliente guardado!';
                 $type = 'success';
        
                 header('Location: ../../init/app/ventas/ord.php?cid='.$laorden);
                
			}else{
			     $msg = 'Error, no se guardo el cliente!';
                 $type = 'danger';
			}
		}else{
			echo '<div class="alert alert-danger">
                <b>Error, esta cedula ya existe en el sistema!</b>
            </div>';
		}
    }
  }