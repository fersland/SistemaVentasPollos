<?php
	require_once ('./'."../../datos/db/connect.php");

	$env = new DBSTART;
	$cc = $env->abrirDB();
    
        $nombre = htmlspecialchars($_POST['nombre']);
        $abrev 	= htmlspecialchars($_POST['abrv']);
        $dec    = htmlspecialchars($_POST['dec']);
        $signo  = htmlspecialchars($_POST['signo']);
        $estado = 1;
        
        if ($nombre == "") {
            echo '<div class="alert alert-warning">
                <b>Debe asignar un nombre de moneda!</b>
            </div>';
        }else{

		// Consultar cédula repetida
		$stmt = $cc->prepare("SELECT * FROM c_moneda WHERE nombre='$nombre' AND estado = 1");
		$stmt->execute();
		$cant = $stmt->rowCount();

		if ( $cant == 0 ) {
            $veces = 0;
			$sql = $cc->prepare("INSERT INTO c_moneda (nombre, abrv, decimales, signo, estado) VALUES (:nom, :abr, :dec, :sig, :est)");
			$sql->bindParam(':nom', $nombre,     PDO::PARAM_STR);
            $sql->bindParam(':abr', $abrev,     PDO::PARAM_STR);
            $sql->bindParam(':dec', $dec,     PDO::PARAM_INT);
            $sql->bindParam(':sig', $signo,     PDO::PARAM_STR);
            $sql->bindParam(':est', $estado, 	  PDO::PARAM_INT);
			if ($sql -> execute() ) {
			     echo '<div class="alert alert-success">
                <b>Moneda nueva guardada!</b>
            </div>';
                
			}else{
			     echo '<div class="alert alert-danger">
                        <b>Error al registrar!</b>
                       </div>';
			}
            
            
            
		}else{
			echo '<div class="alert alert-danger">
                <b>Error, este nombre de moneda ya existe en el sistema!</b>
            </div>';
		}
    }