<?php
	require_once ('./'."../../datos/db/connect.php");

	$env = new DBSTART;
	$cc = $env->abrirDB();
    
        $marca 	= htmlspecialchars(strtoupper($_POST['marca']));
        $modelo 	= htmlspecialchars(strtoupper($_POST['modelo']));
        $placa 	= htmlspecialchars(strtoupper($_POST['placa']));
        $color 	= htmlspecialchars(strtoupper($_POST['color']));
        $propietario 	= htmlspecialchars(strtoupper($_POST['propietario']));
        $anio 	= htmlspecialchars(strtoupper($_POST['anio']));
        $estado = 1;
        $veces = 1;
        $dis = 'SI';
        
        if ($marca == "") {
            echo '<div class="alert alert-warning">
                <b>Debe asignar la marca del Vehiculo!</b>
            </div>';
        }else{

		// Consultar cédula repetida
		$stmt = $cc->prepare("SELECT * FROM c_vehiculo WHERE marca='$marca' AND modelo='$modelo' AND placa='$placa' AND id_estado = 1");
		$stmt->execute();
		$cant = $stmt->rowCount();

		if ( $cant == 0 ) {
		  
    
            $veces = 0;
			$sql = $cc->prepare("INSERT INTO c_vehiculo (marca, modelo, placa, color, propietario, anio, id_estado, veces, disponible)
                                        VALUES (:mar, :mod, :pla, :col, :pro, :ani, :est, :vec, :dis)");
            $sql->bindParam(':mar', $marca, 	  PDO::PARAM_STR);
			$sql->bindParam(':mod', $modelo,     PDO::PARAM_STR);
            $sql->bindParam(':pla', $placa, 	  PDO::PARAM_STR);
            $sql->bindParam(':col', $color, 	  PDO::PARAM_STR);
            $sql->bindParam(':pro', $propietario, 	  PDO::PARAM_STR);
            $sql->bindParam(':ani', $anio, 	  PDO::PARAM_STR);
            $sql->bindParam(':est', $estado,       PDO::PARAM_INT);
            $sql->bindParam(':vec', $veces, 	  PDO::PARAM_INT);
            $sql->bindParam(':dis', $dis, PDO::PARAM_STR);
			if ($sql -> execute() ) {
			     echo '<div class="alert alert-success">
                <b>Nuevo Dato guardado!</b>
            </div>';
                
			}else{
			     echo '<div class="alert alert-danger">
                        <b>Error al registrar!</b>
                       </div>';
			}
            
            
            
		}else{
			echo '<div class="alert alert-danger">
                <b>Error, este dato ya existe en el sistema!</b>
            </div>';
		}
    }