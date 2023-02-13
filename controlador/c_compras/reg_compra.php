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
    $sucursal   = htmlspecialchars($_POST['sucursal']);
    $imaxn      = htmlspecialchars($_POST['imaxn']);
    $eply       = htmlspecialchars($_POST['eply']);
    $estado     = 'A';
    $sidescuento = htmlspecialchars($_POST['sidescuento']);
    
    $ok = 2;
    
    $date = date('Y-m-d');

    if ($iva == 0 || $iva == ''){
        $iva == 0;
    }else{
        $iva = $iva;
    }

    if (isset($_POST['total_comprado'])) {
        $total = htmlspecialchars($_POST['total_comprado']);
    }else{
        $total = htmlspecialchars($_POST['total_comprado']);
    }
    
    $anio = $_POST['anio'];
    $mes = $_POST['mes'];
    $dia = $_POST['dia'];

    $nuevo_saldo  = 0;    

    // CONSULTAR SALDO INICIAL EN LA TABLA SALDO

    $sous = DBSTART::abrirDB()->prepare("SELECT * FROM c_saldo");
    $sous->execute();
    $allsous = $sous->fetchAll(PDO::FETCH_ASSOC);
        
    foreach((array) $allsous as $datasaldo) {
        $saldo = $datasaldo['saldo'];
        $nuevo_saldo = $saldo - $total;
    }
        
    // ACTUALIZAR EL SALDO EN LA TABLA SALDO
    $upd = DBSTART::abrirDB()->prepare("UPDATE c_saldo SET saldo=saldo - '$total'");
    $upd->execute();
        
    // FIN SALDO INICIAL
    $validate = DBSTART::abrirDB()->prepare("SELECT * FROM c_compra WHERE ncompra='$ncompra' AND estado='A'");
    $validate->execute();
    $rows = $validate->rowCount();
    $params = $validate->fetchAll(PDO::FETCH_ASSOC);

    // SUBIR EL SCANEADO DE LA COMPRA
    $allow = array('pdf');
    $temp = explode(".", $_FILES['fichero']['name']);
    $extension = end($temp);
    $upload_file = $_FILES['fichero']['name'];
    move_uploaded_file($_FILES['fichero']['tmp_name'], "../../init/pdf/".$_FILES['fichero']['name']);
    // FIN EL SCANEADO DE LA COMPRA


    if($rows == 0) { // NO ES COMPRA REPETIDA
        $fetchu = DBSTART::abrirDB()->prepare("
                    SELECT
                        SUM(vd.pesocajas) as sumapesocajas,
                        SUM(vd.cantcajas) as sumacantcajas,
                        SUM(vd.pneto) as sumapesoneto,
                        SUM(vd.pmerma) as sumapesomerma,
                        vd.precio_compra as sumapc,
                        SUM(vd.importe) as sumaimport,
                        SUM(vd.falta) as sumaf,
                        SUM(vd.aux_cant) as sumac,
                        vd.tipo,
                        vd.ckg,
                        vd.cantidad
                    FROM c_compra_detalle vd

                        WHERE
                        vd.estado = 'A' AND vd.ncompra = '$ncompra' AND vd.positivo = 2");
            $fetchu->execute();
            $allsu = $fetchu->fetchAll(PDO::FETCH_ASSOC);

            foreach((array) $allsu as $itemu){
                $max_pesocajas = $itemu['sumapesocajas'];
                $max_cantcajas = $itemu['sumacantcajas'];
                $max_pesoneto  = $itemu['sumapesoneto'];
                $max_pesomerma = $itemu['sumapesomerma'];
                $max_pricec    = $itemu['sumapc'];
                $max_import    = $itemu['sumaimport'];
                $max_falta     = $itemu['sumaf'];
                $max_sumac     = $itemu['sumac'];
                $eltip = $itemu['tipo'];
                $elkg = $itemu['ckg'];
            }

        if ($forma == 'Efectivo') {
                $insert = DBSTART::abrirDB()->prepare("INSERT INTO c_compra (
                                    id_empresa,ncompra,id_proveedor,fechacompra,importe,forma_pago,descuento,iva,dinero_iva,total, estado, id_empleado, ruta, nvalor,
                                    max_pcajas, max_ccajas, max_pneto, max_pmerma, max_punit, max_total, max_menos, max_cant)
                          VALUES (:emp, :nco, :idp, :fco, :imp, :for, :des, :iva, :dva, :tot, :est, :epl, :ruta, :nvalor,
                            :max_pcajas, :max_ccajas, :max_pneto, :max_pmerma, :max_punit, :max_total, :max_menos, :max_canti)");
                $insert->bindParam(':emp', $empresa,  PDO::PARAM_INT);
                $insert->bindParam(':nco', $ncompra,  PDO::PARAM_STR);
                $insert->bindParam(':idp', $elpro,    PDO::PARAM_INT);
                $insert->bindParam(':fco', $lafecha,  PDO::PARAM_STR);
                $insert->bindParam(':imp', $max_import,  PDO::PARAM_STR); // $importe
                $insert->bindParam(':for', $forma,    PDO::PARAM_STR);
                $insert->bindParam(':des', $desc,     PDO::PARAM_STR);
                $insert->bindParam(':iva', $iva,      PDO::PARAM_INT);
                $insert->bindParam(':dva', $dinero_iva,   PDO::PARAM_STR);
                $insert->bindParam(':tot', $total,    PDO::PARAM_STR);
                $insert->bindParam(':est', $estado,   PDO::PARAM_STR);
                $insert->bindParam(':epl', $eply,     PDO::PARAM_INT);
                $insert->bindParam(':ruta', $upload_file,     PDO::PARAM_STR);
                $insert->bindParam(':nvalor', $imaxn,     PDO::PARAM_STR);
                $insert->bindParam(':max_pcajas', $max_pesocajas, PDO::PARAM_STR);
                $insert->bindParam(':max_ccajas', $max_cantcajas, PDO::PARAM_STR);
                $insert->bindParam(':max_pneto', $max_pesoneto, PDO::PARAM_STR);
                $insert->bindParam(':max_pmerma', $max_pesomerma, PDO::PARAM_STR);
                $insert->bindParam(':max_punit', $max_pricec, PDO::PARAM_STR);
                $insert->bindParam(':max_total', $max_import, PDO::PARAM_STR);
                $insert->bindParam(':max_menos', $max_falta, PDO::PARAM_STR);
                $insert->bindParam(':max_canti', $max_sumac, PDO::PARAM_STR);                
                if ($insert->execute()) {
                    
                    // INGRESAR A CAJA CHICA                    
                    $sqlsaldo = DBSTART::abrirDB()->prepare("INSERT INTO c_resumen_gasto (param, tipo, id_empleado, valor, anio, mes, dia, entrada, salida, saldo, id_estado, sucursal) 
                                                              VALUES (2, 7, '$eply', '$total', '$anio', '$mes', '$dia', 0, '$total', '$nuevo_saldo',1, '$sucursal')");
                    $sqlsaldo->execute();

                    // NUEVA TRANSACCION 
                    $validates = DBSTART::abrirDB()->prepare("SELECT * FROM c_compra WHERE ncompra='$ncompra' AND estado='A'");
                    $validates->execute();
                    $paramss = $validates->fetchAll(PDO::FETCH_ASSOC);

                    foreach((array) $paramss as $isss) {
                        $i_cant = $isss['max_cant'];
                        $ineto  = $isss['max_pneto'];
                        $imerma = $isss['max_pmerma'];
                        $iccaja = $isss['max_ccajas'];
                    }

                    $pmenudo = 'MENUDO-'.$ncompra;

                    if ($sidescuento === 1) {
                        // INGRESAR LA MENUDENCIA AL INVENTARIO CON EL NUMERO DE COMPRA
                        $inv = DBSTART::abrirDB()->prepare("INSERT INTO c_mercaderia (ncompra, id_proveedor, codproducto, nombreproducto, precio_compra, estado, kilo, pre_kg, tunidad, pneto, pmerma, ok, sucursal, cajas, menudo) 
                                                            VALUES ('$ncompra', '$elpro', '$ncompra', '$pmenudo', '$max_pricec', 'A', '$i_cant', '$max_pricec', '$eltip', '$ineto', '$imerma', 2, '$sucursal', '$iccaja', 1)");
                        $inv->execute();
                    }
                    
                    // ACTIVAR LOS PRODUCTOS COMPRADOS EN INVENTARIO DIRECTAMENTE
                    //$args = DBSTART::abrirDB()->prepare("SELECT * FROM c_compra_detalle WHERE ncompra='$ncompra' AND estado='A' AND positivo=1");

                    // Inactivar lista de compras de la tabla compra_detalle
                    $stmt3 = DBSTART::abrirDB()->prepare("UPDATE c_compra_detalle SET estado = 'I' WHERE ncompra = '$ncompra' AND estado = 'A'");
                    $stmt3->execute();

                    $stmt4 = DBSTART::abrirDB()->prepare("UPDATE c_mercaderia SET estado = 'A' WHERE ncompra = '$ncompra' AND estado = 'E'");
                    $stmt4->execute();

                    echo '<div class="alert alert-success">
                            <p> <i class="fa fa-check"></i> Compra Guardada!</p>
                      </div>';
                }else{
                    echo '<div class="alert alert-danger">
                            <p>Error al guardar la compra</p>
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
                        id_empresa,ncompra,id_proveedor,fechacompra,importe,forma_pago,meses,diferido,descuento,iva,dinero_iva,total, estado, id_empleado, ruta, nvalor,
                        max_pcajas, max_ccajas, max_pneto, max_pmerma, max_punit, max_total, max_menos, max_cant) 
                      VALUES (:emp, :nco, :idp, :fco, :imp, :for, :mes, :dif, :des, :iva, :dva, :tot, :est, :epl, :ruta, :nvalor,
                  :max_pcajas, :max_ccajas, :max_pneto, :max_pmerma, :max_punit, :max_total, :max_menos; :max_canti)");
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
        $insert -> bindParam(':est', $estado,       PDO::PARAM_STR);
        $insert -> bindParam(':epl', $eply,       PDO::PARAM_INT);
        $insert -> bindParam(':ruta', $upload_file,     PDO::PARAM_STR);
        $insert -> bindParam(':nvalor', $imaxn,     PDO::PARAM_STR);

        $insert -> bindParam(':max_pcajas', $max_pesocajas, PDO::PARAM_STR);
                $insert -> bindParam(':max_ccajas', $max_cantcajas, PDO::PARAM_STR);
                $insert -> bindParam(':max_pneto', $max_pesoneto, PDO::PARAM_STR);
                $insert -> bindParam(':max_pmerma', $max_pesomerma, PDO::PARAM_STR);
                $insert -> bindParam(':max_punit', $max_pricec, PDO::PARAM_STR);
                $insert -> bindParam(':max_total', $max_import, PDO::PARAM_STR);
                $insert -> bindParam(':max_menos', $max_falta, PDO::PARAM_STR);
                $insert -> bindParam(':max_canti', $max_sumac, PDO::PARAM_STR);
        
        if ($insert ->execute()) {
            // Ingresar a caja chica        
            $sqlsaldo = DBSTART::abrirDB()->prepare("INSERT INTO c_resumen_gasto (param, tipo, id_empleado, valor, anio, mes, dia, entrada, salida, saldo, id_estado, sucursal) 
                                                              VALUES (2, 7, '$eply', '$total', '$anio', '$mes', '$dia', 0, '$total', '$nuevo_saldo' ,1, '$sucursal')");
            $sqlsaldo->execute();
                        
            // Activar los productos comprados en entrada
            $entrada = DBSTART::abrirDB()->prepare("UPDATE c_mercaderia SET estado='A' WHERE ncompra='$ncompra'");
            $entrada->execute();
                    
            /**   REGISTRAR CUENTA EN CUENTAS POR PAGAR**/
            $pagar = DBSTART::abrirDB()->prepare("INSERT INTO c_cxp
                        (id_proveedor, total, meses, diferido, saldo, cuotas_pagadas, cuotas_pendientes, estado, fecha_cxp, ncompra) 
                        VALUES ('$elpro', '$total', '$meses', '$diferido','$total',0, '$meses', 'DEBE', now(), '$ncompra')");
            $pagar->execute();
            
            // ACTIVAR LOS PRODUCTOS COMPRADOS EN INVENTARIO DIRECTAMENTE
                    
                    $args = DBSTART::abrirDB()->prepare("SELECT * FROM c_compra_detalle WHERE ncompra='$ncompra' AND estado='A'");
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
                        $caduca = $comeback['caducidad'];
                        
                        $pneto = $comeback['pneto'];
                        $pmerma = $comeback['pmerma'];
                        $ttipo = $comeback['tipo'];

                        // CANTIDADES DE UNIDADES
                        $ckg = $comeback['ckg'];
                        $clb = $comeback['clb'];
                        $cgr = $comeback['cgr'];
                        $clt = $comeback['clt'];
                        $ccajas = $comeback['cantcajas'];
                        $positvo = $comeback['positivo'];
                        $utotales = $comeback['utotales'];
                        
                        // VERIFICAR SI EL PRODUCTO EXISTE EN EL INVENTARIO
                        $ver = DBSTART::abrirDB()->prepare("SELECT * FROM c_mercaderia 
                                                                WHERE 
                                                                            codproducto = '$codigo' 
                                                                            AND ncompra = '$ncompra'
                                                                            AND estado = 'A' 
                                                                            AND sucursal = '$sucursal'");
                        $ver->execute();
                        $cantidad = $ver->rowCount();
                        
                        if ($cantidad == 0) {
                            $one = DBSTART::abrirDB()->prepare("INSERT INTO c_mercaderia 
                            (id_proveedor, categoria, codproducto, nombreproducto, precio_compra, precio_venta, existencia, ruta, fechacompra, estado, existe, entrada, gramo, litro, libra, kilo, tunidad, pneto, pmerma, ok, caducidad, sucursal, cajas, positivo, utotales) VALUES
                            ('$elpro', '$cate', '$codigo', '$desc', '$pc', '$pve', '$cant', '$ruta', '$date', 'A', '$cant', '$cant', '$cgr', '$clt', '$clb', '$ckg', '$ttipo', '$pneto', '$pmerma', '$ok', '$caduca', '$sucursal', '$ccajas', '$positivo', '$utotales')");
                            $one->execute();
                        }
                    }

                    /*

                    NUEVA TRANSACCION */
                    $validates = DBSTART::abrirDB()->prepare("SELECT * FROM c_compra WHERE ncompra='$ncompra' AND estado='A'");
                    $validates->execute();
                    $paramss = $validates->fetchAll(PDO::FETCH_ASSOC);

                    foreach((array) $paramss as $isss) {
                        $i_cant = $isss['max_cant'];
                        $ineto = $isss['max_pneto'];
                        $imerma = $isss['max_pmerma'];
                        $iccaja = $isss['max_ccajas'];
                    }

                    $pmenudo = 'MENUDO-'.$ncompra;

                    if ($sidescuento == 1) {
                        // INGRESAR LA MENUDENCIA AL INVENTARIO CON EL NUMERO DE COMPRA
                        $inv = DBSTART::abrirDB()->prepare("INSERT INTO c_mercaderia (ncompra, codproducto, nombreproducto, precio_compra, estado, kilo, pre_kg, 
                                                                        tunidad, pneto, pmerma, ok, sucursal, cajas) 
                                                            VALUES ('$ncompra', '$ncompra', '$pmenudo', '$max_pricec', 'A', '$i_cant', '$max_pricec', 
                                                                '$eltip', '$ineto', '$imerma', 2, '$sucursal', '$iccaja')");
                        $inv->execute();
                    }

                    $stmt = DBSTART::abrirDB()->prepare("UPDATE c_compra_detalle SET estado = 'I' WHERE ncompra = '$ncompra' AND estado = 'A'");
                    $stmt -> execute();
                    
                echo '<div class="<div class="alert alert-success">
                            <p><i class="fa fa-check"></i> Compra en diferido Guardada!</p><br />
                      </div>';
            }else{
                echo '<div class="alert alert-warning">
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