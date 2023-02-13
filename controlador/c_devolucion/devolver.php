
<?php

    require_once ("../../datos/db/connect.php");

    $env = new DBSTART;
    $cc = $env->abrirDB();

    $cid = isset($_GET['cid']) ? $_GET['cid'] : 0;

    $delete = $cc->prepare("UPDATE c_venta SET estado='X' WHERE norden = '$cid'");
    if ($delete->execute()){
        
        $dselete = $cc->prepare("UPDATE c_venta_detalle SET estado='X' WHERE nun_orden = '$cid'");
        $dselete->execute();
        echo '<script>
                alert("El registro ha sido eliminado correctamente!");
                window.location.href = "../../init/app/in.php?cid=devolucion/dev";
              </script>';
    }