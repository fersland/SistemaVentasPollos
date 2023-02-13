<?php

if (isset($_POST['foto'])) {
	require_once ("../../datos/db/connect.php");
	$env = new DBSTART;
	$db = $env->abrirDB();

    try{
       $formato = array('.jpg', '.png');       
       $nombrearchivo = $_FILES['img']['name'];
       $nombretmparchivo = $_FILES['img']['tmp_name'];
       $user = htmlspecialchars($_POST['usuario']);

       $ext = substr($nombrearchivo, strrpos($nombrearchivo, '.'));       
       if (in_array($ext, $formato)) {
            if (move_uploaded_file($nombretmparchivo, "../../init/img/$nombrearchivo")) {           
		      $stmt = $db->prepare("UPDATE c_usuarios SET imagen='$nombrearchivo' WHERE id_usuario = '$user'");
    		if ($stmt->execute()){
            echo '<script type="text/javascript">
                        alert("Imagen de perfil cambiada");
                        window.location.href="../../init/app/in.php?cid=usuarios/users";
                    </script>';     
		      }else{
			     echo '<script type="text/javascript">
                        alert("Error");
                        window.history.back();
                    </script>';
		      }
            }
        }
	}catch(PDOException $e){
		echo $e->getMessage();
	}
 }