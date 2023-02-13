<?php 
	require_once ('./'."../../datos/db/connect.php");

	$env = new DBSTART;
	$cc = $env->abrirDB();
    $fecha = date('Y-m-d');
            
                        
    $cerrar = $cc->prepare("UPDATE c_empresa SET fcaja='$fecha', scaja='SI', caja_abierta='SI'");
    $cerrar->execute();
                        
    /*  $cerrar2 = $cc->prepare("UPDATE c_caja SET WHERE fecha='$fecha'");
        $cerrar2->execute();*/
            
    echo '<script> 
            alert("La caja ha sido abierta");
            window.location.href = "../../init/app/in.php?cid=dashboard/init";
          </script>';