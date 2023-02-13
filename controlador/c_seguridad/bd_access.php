<?php 
	require_once ('./'."../../datos/db/connect.php");

	$env = new DBSTART;
	$cc = $env->abrirDB();

        $acceso 	= sha1($_POST['acceso']);
        
        //Consultar el valor de iva actual
        $sql = $cc->prepare("SELECT * FROM c_empresa");
        $sql->execute();
        $extract = $sql->fetchAll(PDO::FETCH_ASSOC);
        foreach ( (array) $extract as $items ) {
            $valor = $items['clave_acceso'];
        }
        
        if ($acceso == $valor) {
            
            echo '<script> window.location.href="?cid=seguridad/backup_fflush"</script>';
        }else{
            
                echo '<div class="alert alert-warning">
                        <b>La clave introducida es incorrecta!</b>
                    </div>';
              
        }