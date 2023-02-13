<?php 
	require_once ("../../datos/db/connect.php");

	$env = new DBSTART;
	$cc = $env->abrirDB();
		
		$user       = htmlspecialchars($_POST['usuario']);
        $act        = htmlspecialchars(sha1($_POST['actual']));
        $npassw 	= htmlspecialchars($_POST['new_passw']);
        $rpassw 	= htmlspecialchars($_POST['rep_passw']);
        $estado = 'A';
		
        // Consultar si la clave actual coincide
        $actual = $cc->prepare("SELECT * FROM c_usuarios WHERE id_usuario ='$user' AND passw='$act'");
        $actual->execute();
        $an = $actual->rowCount();

        if ($an == 0) {
        	echo '<script>alert("La clave actual no coinciden");
                window.location.href = "in.php?cid=usuarios/usuarios";</script>';
        }else if ($an > 0){
			if ( $npassw == $rpassw ) { // Consultar si las claves coinciden
				$cambio = sha1($npassw);
				$sql = $cc->prepare("UPDATE c_usuarios SET passw='$cambio', cl='$rpassw' WHERE id_usuario='$user' AND estado='A'");
				if ($sql -> execute() ) {
				     echo '<div class="alert alert-success">
	                    <b>Nueva Clave Guardada!</b>
	                </div>';
				}else{
				     echo '<div class="alert alert-danger">
	                    <b>Error al cambiar la clave!</b>
	                </div>';
				}	
			}else{
				echo '<div class="alert alert-danger">
	                <b>Error, las claves no coinciden!</b>
	            </div>';
			}
	}