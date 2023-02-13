<?php
    require_once ('./'."../../datos/db/connect.php");
    
    $empresa    = htmlspecialchars($_POST['nempresa']);
    $ncompra    = htmlspecialchars($_POST['ncompra']);
    $elpro      = htmlspecialchars($_POST['elprove']);
    $lafecha    = htmlspecialchars($_POST['fecha']);
    $importe    = htmlspecialchars($_POST['importe']);
    $iva        = htmlspecialchars($_POST['iva']);
    $dinero_iva = htmlspecialchars($_POST['dinero_iva']);
    $forma      = htmlspecialchars($_POST['forma']);
    $efectivo   = htmlspecialchars($_POST['efectivo']);
    $meses      = htmlspecialchars($_POST['meses']);
    $desc       = htmlspecialchars($_POST['desc']);
    $total      = htmlspecialchars($_POST['total_comprado']);
    $obs        = htmlspecialchars($_POST['obs']);
    $estado     = 'A';

    // Validar compra repetida

    $validate = DBSTART::abrirDB()->prepare("SELECT * FROM c_compra WHERE ncompra='$ncompra' AND id_proveedor='$elpro' AND estado='A'");
    $validate->execute();
    $rows = $validate->rowCount();
    //$params = $validate->fetchAll(PDO::FETCH_ASSOC);

    if($rows == 0) { // NO ES COMPRA REPETIDA
    

        if ($forma == 'Efectivo') {
            if ( $efectivo < $total || $efectivo == "" ) {
                echo '<script>alert("El efectivo es insuficiente");
                            window.location.href = "../app/in.php?cid=compras/frm_compras_ingreso";
                      </script>';
            }else{
    
                $cambio = 0;
                $cambio = ($efectivo - $total);
                
                $insert = DBSTART::abrirDB()->prepare("INSERT INTO c_compra (
            id_empresa,ncompra,id_proveedor,fechacompra,importe,forma_pago,efectivo,cambio,descuento,
            iva,dinero_iva,total, observacion, estado) 
                          VALUES (:emp, :nco, :idp, :fco, :imp, :for, :efe, :cam, :des, :iva, :dva, :tot, :obs, :est)");
                $insert -> bindParam(':emp', $empresa,  PDO::PARAM_INT);
                $insert -> bindParam(':nco', $ncompra,  PDO::PARAM_STR);
                $insert -> bindParam(':idp', $elpro,    PDO::PARAM_INT);
                $insert -> bindParam(':fco', $lafecha,  PDO::PARAM_STR);
                $insert -> bindParam(':imp', $importe,  PDO::PARAM_STR);
                $insert -> bindParam(':for', $forma,    PDO::PARAM_STR);
                $insert -> bindParam(':efe', $efectivo, PDO::PARAM_STR);
                $insert -> bindParam(':cam', $cambio,   PDO::PARAM_STR);
                $insert -> bindParam(':des', $desc,     PDO::PARAM_STR);
                $insert -> bindParam(':iva', $iva,      PDO::PARAM_INT);
                $insert -> bindParam(':dva', $dinero_iva,   PDO::PARAM_STR);
                $insert -> bindParam(':tot', $total,    PDO::PARAM_STR);
                $insert -> bindParam(':obs', $obs,      PDO::PARAM_STR);
                $insert -> bindParam(':est', $estado,   PDO::PARAM_STR);
                
                if ($insert ->execute()) {
                    // Inactivar lista de compras de la tabla compra_detalle
                    $stmt = DBSTART::abrirDB()->prepare("UPDATE c_compra_detalle SET estado = 'I' 
                                                            WHERE ncompra = '$ncompra' AND estado = 'A'");
                    $stmt -> execute();
                    
                    // Activar los productos comprados en entrada
                    $entrada = DBSTART::abrirDB()->prepare("UPDATE c_mercaderia SET estado='A' WHERE ncompra='$ncompra'");
                    $entrada->execute();
                echo '<div class="alert alert-info">
                            <p> <i class="fa fa-check"></i> Compra Guardada!</p>
                            <br />
                        <p><i class="fa fa-info"></i> Ir al inventario para poner en stock los productos comprados <a href="?cid=mercaderia/mercaderia"> aqu&iacute;</a></p>
                      </div>';
                }else{
                    echo '<div class="alert alert-danger">
                            <p>Error al girdar la compra</p>
                      </div>';
                }
            }
    }else if ($forma == 'Diferido') {
        if ( $meses < 2 || $meses == "" ) {
                echo '<script>alert("ERROR, LOS MESES A DIFERIR NO PUEDE SER INFERIOR A 2");
                        window.location.href = "../app/in.php?cid=compras/frm_compras_ingreso";
                      </script>';
            }else{
        $diferido = 0;
        $diferido = ($total / $meses);
        $insert = DBSTART::abrirDB()->prepare("INSERT INTO c_compra (
            id_empresa,ncompra,id_proveedor,fechacompra,importe,forma_pago,meses,
            diferido,descuento,iva,dinero_iva,total, observacion, estado) 
                      VALUES (:emp, :nco, :idp, :fco, :imp, :for, :mes, :dif, :des, :iva, :dva, :tot, :obs, :est)");
        $insert -> bindParam(':emp', $empresa,      PDO::PARAM_INT);
        $insert -> bindParam(':nco', $ncompra,      PDO::PARAM_STR);
        $insert -> bindParam(':idp', $elpro,        PDO::PARAM_INT);
        $insert -> bindParam(':fco', $lafecha,      PDO::PARAM_STR);
        $insert -> bindParam(':imp', $importe,      PDO::PARAM_STR);
        $insert -> bindParam(':for', $forma,        PDO::PARAM_STR);
        $insert -> bindParam(':mes', $meses,        PDO::PARAM_INT);
        $insert -> bindParam(':dif', $diferido,     PDO::PARAM_STR);
        $insert -> bindParam(':des', $desc,         PDO::PARAM_STR);
        $insert -> bindParam(':iva', $iva,          PDO::PARAM_INT);
        $insert -> bindParam(':dva', $dinero_iva,   PDO::PARAM_STR);
        $insert -> bindParam(':tot', $total,        PDO::PARAM_STR);
        $insert -> bindParam(':obs', $obs,          PDO::PARAM_STR);
        $insert -> bindParam(':est', $estado,       PDO::PARAM_STR);
        
        if ($insert ->execute()) {
            $stmt = DBSTART::abrirDB()->prepare("UPDATE c_compra_detalle SET estado = 'I' 
                                                            WHERE ncompra = '$ncompra' AND estado = 'A'");
            $stmt -> execute();
            
            // Activar los productos comprados en entrada
            $entrada = DBSTART::abrirDB()->prepare("UPDATE c_mercaderia SET estado='A' WHERE ncompra='$ncompra'");
            $entrada->execute();
                    
            /**   REGISTRAR CUENTA EN CUENTAS POR PAGAR**/
            $pagar = DBSTART::abrirDB()->prepare("INSERT INTO c_cxp
                        (id_proveedor, total, meses, diferido, saldo, cuotas_pagadas, cuotas_pendientes, estado, fecha_cxp, ncompra) 
                        VALUES ('$elpro', '$total', '$meses', '$diferido','$total',0, '$meses', 'DEBE', now(), '$ncompra')");
            $pagar->execute();
                    
            echo '<div class="alert alert-success">
                        <p><i class="fa fa-check"></i> Compra en diferido Guardada!</p><br />
                        <p>Ir al inventario para poner en stock los productos comprados <a href="?cid=mercaderia/mercaderia"> aqu&iacute;</a></p>
                  </div>';
        }else{
            echo '<div class="alert alert-alert">
                        <p>Error al guardar la compra!</p>
                  </div>';
        }
    }
    }
}else{
    echo '<script type="text/javascript">
            alert("Error, esta compra con el proveedor ingresado ya se encuentra en el sistema");
            window.location.href = "../app/in.php?cid=compras/frm_compras_ingreso";
          </script>';
}