<?php
  if (isset($_POST['upd'])) {
	require_once ('./'."../../datos/db/connect.php");
	$env = new DBSTART;
	$db = $env->abrirDB();

    $visit = $_SESSION["rol"];
    if ($visit == 'Visitante') {
            echo '<script>window.location.href = "../../init/app/in.php?cid=empresa/frm_empresa";</script>';
        }else{
    try{
       $formato = array('.jpg', '.png');       
       $nombrearchivo = htmlspecialchars($_FILES['img']['name']);
       $nombretmparchivo = htmlspecialchars($_FILES['img']['tmp_name']);

       $ext = substr($nombrearchivo, strrpos($nombrearchivo, '.'));       
       if (in_array($ext, $formato)) {
            if (move_uploaded_file($nombretmparchivo, "../../init/img/presentacion/$nombrearchivo")) {           
		      $stmt = $db->prepare("UPDATE c_empresa SET img_wall='$nombrearchivo'");
    		if ($stmt->execute()){
            echo '<script type="text/javascript">
                        alert("Imagen Cambiada");
                        window.location.href = "../../init/app/in.php?cid=empresa/frm_empresa";
                    </script>';     
		      }else{
			     echo '<script type="text/javascript">
                        alert("Error");
                        window.location.href = "../../init/app/in.php?cid=empresa/frm_empresa";
                    </script>';
		      }
            }
        }
	}catch(PDOException $e){
		echo $e->getMessage();
	}
 }

 }