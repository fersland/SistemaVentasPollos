<?php 
	require_once ('./'."../../datos/db/connect.php");

	$env = new DBSTART;
	$cc = $env->abrirDB();

        $nombres 	= htmlspecialchars($_POST['nombres']);
        $direccion 	= htmlspecialchars($_POST['direccion']);
        $fecha   	= htmlspecialchars($_POST['creacion']);
        $estado = 1;
        
        if ($nombres == "") {
            echo '<div class="alert alert-danger">
                        <b>Debe asignar el nombre de la Sucursal!</b>
                    </div>';
        }else{

		// Consultar cédula repetida
		$stmt = $cc->prepare("SELECT * FROM c_sucursal WHERE nombre = '$nombres' AND id_estado = 1");
		$stmt->execute();
		$cant = $stmt->rowCount();

		if ( $cant == 0 ) {
			$sql = $cc->prepare("INSERT INTO c_sucursal (nombre, direccion, fecha_creacion, id_estado) VALUES (?,?,?,?)");
            $sql->bindParam(1, $nombres, 	     PDO::PARAM_STR);
			$sql->bindParam(2, $direccion,       PDO::PARAM_STR);
            $sql->bindParam(3, $fecha,           PDO::PARAM_STR);
            $sql->bindParam(4, $estado, 	     PDO::PARAM_INT);
			
            if ( $sql -> execute() ){
                echo '<div class="alert alert-success">
                        <b>Sucursal guardada!</b>
                    </div>';
            }else{
                echo '<div class="alert alert-danger">
                        <b>Error al guardar la Sucursal!</b>
                    </div>';
            }			
		}else{
			echo '<div class="alert alert-danger">
                        <b>Error, esta Sucursal con este nombre ya existe en el sistema!</b>
                    </div>';
		}		
	}