<?php 
	require_once ('./'."../../datos/db/connect.php");

	$env = new DBSTART;
	$cc = $env->abrirDB();

        $nombres 	= htmlspecialchars(strtoupper($_POST['nombre']));
		$observacion= htmlspecialchars(strtoupper($_POST['obs']));
        $estado = 'A';
        
        if ($nombres == "") {
            echo '<div class="alert alert-danger">
                        <b>Debe asignar el nombre de la categoría!</b>
                    </div>';
        }else{

		// Consultar cédula repetida
		$stmt = $cc->prepare("SELECT * FROM c_categoria WHERE nombre = '$nombres'");
		$stmt->execute();
		$cant = $stmt->rowCount();

		if ( $cant == 0 ) {
			$sql = $cc->prepare("INSERT INTO c_categoria (nombre,observacion, estado) VALUES (?,?,?)");
            $sql->bindParam(1, $nombres, 	PDO::PARAM_STR);
			$sql->bindParam(2, $observacion,PDO::PARAM_STR);
            $sql->bindParam(3, $estado, 	PDO::PARAM_STR);
			
            if ( $sql -> execute() ){
                echo '<div class="alert alert-success">
                        <b>Categoría guardada!</b>
                    </div>';
            }else{
                echo '<div class="alert alert-danger">
                        <b>Error al guardar la categoría!</b>
                    </div>';
            }			
		}else{
			echo '<div class="alert alert-danger">
                        <b>Error, esta categoría ya existe en el sistema!</b>
                    </div>';
		}		
	}