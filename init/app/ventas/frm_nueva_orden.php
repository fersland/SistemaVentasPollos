<?php
    require_once ("../head_unico.php");
	require_once ("../../../../datos/db/connect.php");
    
	$env = new DBSTART;
	$cc = $env->abrirDB();
    $empresa = $_SESSION['id_empresa'];
    
    $cid = isset($_GET['cid']) ? $_GET['cid'] : 0;
        
    // Poner en espera la orden actual
    $sql = $cc->prepare("UPDATE c_orden_trabajo SET estado='E' WHERE ntrabajo='$cid' AND id_empresa = '$empresa'");
        
    if ($sql->execute()) {
        $sql2 = $cc->prepare("UPDATE c_orden_trabajo_items SET estado='E' WHERE norden='$cid' AND id_empresa = '$empresa'");
        $sql2->execute();
        sleep(2);
            
        $act = $cc->prepare("UPDATE c_secuencial SET num_secuencial_orden=num_secuencial_orden+1 WHERE id_empresa='$empresa'");
        $act->execute();
            
        echo '<script type="text/javascript">
                window.location.href = "../in.php?cid=ventas/frm_orden_trabajo";
              </script>';   
    }