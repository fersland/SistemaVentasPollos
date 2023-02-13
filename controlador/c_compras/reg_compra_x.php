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
    $meses      = htmlspecialchars($_POST['meses']);
    $desc       = htmlspecialchars($_POST['desc']);
    $total      = htmlspecialchars($_POST['total_comprado']);
    $obs        = htmlspecialchars($_POST['obs']);
    $estado     = 'A';
    
    $date = date('Y-m-d');


    $validate = DBSTART::abrirDB()->prepare("SELECT * FROM c_compra WHERE ncompra='$ncompra' AND id_proveedor='$elpro' AND estado='A'");
    $validate->execute();
    $rows = $validate->rowCount();
    //$params = $validate->fetchAll(PDO::FETCH_ASSOC);

    if($rows == 0) { // NO ES COMPRA REPETIDA

        if ($forma == 'Efectivo') {
                $insert = DBSTART::abrirDB()->prepare("INSERT INTO c_compra (
            id_empresa,ncompra,id_proveedor,fechacompra,importe,forma_pago,descuento,iva,dinero_iva,total, observacion, estado)
                          VALUES (:emp, :nco, :idp, :fco, :imp, :for, :des, :iva, :dva, :tot, :obs, :est)");
                $insert -> bindParam(':emp', $empresa,  PDO::PARAM_INT);
                $insert -> bindParam(':nco', $ncompra,  PDO::PARAM_STR);
                $insert -> bindParam(':idp', $elpro,    PDO::PARAM_INT);
                $insert -> bindParam(':fco', $lafecha,  PDO::PARAM_STR);
                $insert -> bindParam(':imp', $importe,  PDO::PARAM_STR);
                $insert -> bindParam(':for', $forma,    PDO::PARAM_STR);
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
                    
                    // ACTIVAR LOS PRODUCTOS COMPRADOS EN INVENTARIO DIRECTAMENTE
                    
                    $args = DBSTART::abrirDB()->prepare("SELECT * FROM c_compra_detalle WHERE ncompra='$ncompra' AND estado='I'");
                    $args->execute();
                    $sleep = $args->fetchAll();
                    
                    foreach((array) $sleep as $comeback) {
                        $codigo = $comeback['codigo'];
                        $cant = $comeback['cantidad'];
                        $cate = $comeback['idcat'];
                        $ruta = $comeback['ruta'];
                        $pc = $comeback['precio_compra'];
                        $pve = $comeback['precio_venta'];
                        $desc = $comeback['descripcion'];
                        
                        // VERIFICAR SI EL PRODUCTO EXISTE EN EL INVENTARIO
                        $veer = DBSTART::abrirDB()->prepare("SELECT * FROM  c_mercaderia WHERE codproducto = '$codigo' AND estado = 'A'");
                        $ver->execute();
                        $cantidad = $ver->rowCount();
                        
                        if ($cantidad == 0) {
                            $one = DBSTART::abrirDB()->prepare("INSERT INTO c_mercaderia 
                            (id_proveedor, categoria, codproducto, nombreproducto, precio_compra, precio_venta, existencia, ruta, fechacompra, estado, existe, entrada) VALUES
                            ('$elpro', '$cate', '$codigo', '$desc', '$pc', '$pve', '$cant', '$ruta', '$date', 'A', '$cant', '$cant')");
                            $one->execute();
                        }else{
                            $two = DBSTART::abrirDB()->prepare("UPDATE c_mercaderia SET existencia=existencia + '$cant' WHERE codproducto='$codigo'");
                            $two->execute();
                        }
                    }
                    
                echo '<div class="alert alert-success">
                            <p> <i class="fa fa-check"></i> Compra Guardada!</p>
                      </div>';
                }else{
                    echo '<div class="alert alert-danger">
                            <p>Error al girdar la compra</p>
                      </div>';
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
                        id_empresa,ncompra,id_proveedor,fechacompra,importe,forma_pago,meses,diferido,descuento,iva,dinero_iva,total, observacion, estado) 
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
            $stmt = DBSTART::abrirDB()->prepare("UPDATE c_compra_detalle SET estado = 'I' WHERE ncompra = '$ncompra' AND estado = 'A'");
            $stmt -> execute();
            
            // Activar los productos comprados en entrada
            $entrada = DBSTART::abrirDB()->prepare("UPDATE c_mercaderia SET estado='A' WHERE ncompra='$ncompra'");
            $entrada->execute();
                    
            /**   REGISTRAR CUENTA EN CUENTAS POR PAGAR**/
            $pagar = DBSTART::abrirDB()->prepare("INSERT INTO c_cxp
                        (id_proveedor, total, meses, diferido, saldo, cuotas_pagadas, cuotas_pendientes, estado, fecha_cxp, ncompra) 
                        VALUES ('$elpro', '$total', '$meses', '$diferido','$total',0, '$meses', 'DEBE', now(), '$ncompra')");
            $pagar->execute();
            
            // ACTIVAR LOS PRODUCTOS COMPRADOS EN INVENTARIO DIRECTAMENTE
                    
                    $args = DBSTART::abrirDB()->prepare("SELECT * FROM c_compra_detalle WHERE ncompra='$ncompra' AND estado='I'");
                    $args->execute();
                    $sleep = $args->fetchAll();
                    
                    foreach((array) $sleep as $comeback) {
                        $codigo = $comeback['codigo'];
                        $cant = $comeback['cantidad'];
                        $cate = $comeback['idcat'];
                        $ruta = $comeback['ruta'];
                        $pc = $comeback['precio_compra'];
                        $pve = $comeback['precio_venta'];
                        $desc = $comeback['descripcion'];
                        
                        // VERIFICAR SI EL PRODUCTO EXISTE EN EL INVENTARIO
                        $veer = DBSTART::abrirDB()->prepare("SELECT * FROM  c_mercaderia WHERE codproducto = '$codigo' AND estado = 'A'");
                        $ver->execute();
                        $cantidad = $ver->rowCount();
                        
                        if ($cantidad == 0) {
                            $one = DBSTART::abrirDB()->prepare("INSERT INTO c_mercaderia 
                            (id_proveedor, categoria, codproducto, nombreproducto, precio_compra, precio_venta, existencia, ruta, fechacompra, estado, existe, entrada) VALUES
                            ('$elpro', '$cate', '$codigo', '$desc', '$pc', '$pve', '$cant', '$ruta', '$date', 'A', '$cant', '$cant')");
                            $one->execute();
                        }else{
                            $two = DBSTART::abrirDB()->prepare("UPDATE c_mercaderia SET existencia=existencia + '$cant' WHERE codproducto='$codigo'");
                            $two->execute();
                        }
                    }
                    
            echo '<div class="alert alert-success">
                        <p><i class="fa fa-check"></i> Compra en diferido Guardada!</p><br />
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