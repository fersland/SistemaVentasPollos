<?php

    /* DEL FORMULARIO DE frm_facturacion.php */
    
	require_once ('./'."../../datos/db/connect.php");

	$env = new DBSTART;
	$cc = $env->abrirDB();

    if (isset($_POST['facturare'])){
        $lafactura      = htmlspecialchars($_POST['lafactura']); // numero de venta
        $elcliente      = htmlspecialchars($_POST['cliente_fc']);
        $nomcliente     = htmlspecialchars($_POST['nombrecliente']);
        $empresa = 1;
            
        // Forma pago
        $forma          = htmlspecialchars($_POST['selectpago']);
        $efectivo       = htmlspecialchars($_POST['efectivo']);
        $meses          = htmlspecialchars($_POST['meses']);
        $importe        = htmlspecialchars($_POST['el_importe']);
        $desc           = htmlspecialchars($_POST['desc']);
        $obvs           = htmlspecialchars($_POST['obsventa']); 
        $cambio         = 0;
        $total          = htmlspecialchars($_POST['total_a_pagar']);
        $iva_dolares    = htmlspecialchars($_POST['el_iva']);
        $iva_num        = htmlspecialchars($_POST['iva_num']);
        $descu          = htmlspecialchars($_POST['desc']);
        $resp = htmlspecialchars($_POST['resp']);
        
        $eply = htmlspecialchars($_POST['eply']);

        $sucursal = htmlspecialchars($_POST['sucursal']);

        $peso_menudo = htmlspecialchars($_POST['peso_menudo']);
        $parcial = htmlspecialchars($_POST['parcial']);
        $parcialm = htmlspecialchars($_POST['parcial_meses']);
        
        $solofecha = date('Y-m-d');

        $autoriz = htmlspecialchars($_POST['autorizacion']);
        $dosif = htmlspecialchars($_POST['dosificacion']);
        
        $anio = $_POST['anio'];
        $mes = $_POST['mes'];
        $dia = $_POST['dia'];
        
        /*****************************************************************
         SALDO INICIAL SUMATORIA AL INGRESO POR VENTAS
        ******************************************************************/
        // CONSULTAR SALDO INICIAL EN LA TABLA SALDO
        $sous = $cc->prepare("SELECT * FROM c_saldo");
        $sous->execute();
        $allsous = $sous->fetchAll(PDO::FETCH_ASSOC);
        
        foreach((array) $allsous as $datasaldo) {
            $saldo = $datasaldo['saldo'];
            $nuevo_saldo = $saldo + $total;
        }
        
        // ACTUALIZAR EL SALDO EN LA TABLA SALDO
            $upd = DBSTART::abrirDB()->prepare("UPDATE c_saldo SET saldo=saldo + '$total'");
            $upd->execute();
        
        // FIN SALDO INICIAL
        
        

        if ($descu == 0) {
            @$cambio = ($efectivo - $total);    
        }else{
            @$cambio = ($efectivo - $total - $desc);
        }
        
        $stdventa = 'I'; // Detalle venta finalizado
        
        //  ******* ************************************ //
            // Consultar si hay secuencial activo  // 
        //  ******* ************************************ //
        
        $active = $cc->prepare("SELECT * FROM c_secuencial");
        $active->execute();
        $cant_active = $active->rowCount();

        //  ******* ************************************ //
            // Consulta el numero de factura siguiente // 
        //  ******* ************************************ //
        
        $nume = $cc->prepare("SELECT MAX(n_s) as ultima_venta FROM c_venta");
        $nume->execute();
        $uventa = $nume->fetchAll(PDO::FETCH_ASSOC);

        foreach((array) $uventa as $dato_ultimo){
            $miventa = $dato_ultimo['ultima_venta'];
            

            if ($miventa == 0 || $miventa == ''){
                $nfactura = 1;
                $nfacturas = str_pad($nfactura,8, "0", STR_PAD_LEFT);
                $masuno = 1;
            }else{
                $nfactura = $miventa;
                $nfactura += 1;
                $nfacturas = str_pad($nfactura,8, "0", STR_PAD_LEFT);
                $masuno = $miventa + 1;
            }
        }
        
        //  ******* ************************************ //
            // Consulta el valor del IVA // 
        //  ******* ************************************ //
        
        $iva_data = $cc->prepare("SELECT * FROM c_iva WHERE estado='A'");
        $iva_data->execute();
        $valor_data_iva = $iva_data->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ((array) $valor_data_iva as $elvalor) {
            $mivalor = $elvalor['valor'];
        }
        
        $contado = 'NO';
        
        /* VERIFICAR EL ULTIMO CIERRE DE LA CAJA*/
 

        // Verificar que el numero de factura no exista
        $exista = $cc->prepare("SELECT * FROM c_venta WHERE nventa ='$nfacturas' AND estado='I'");
        $exista->execute();
        $cant_exista = $exista->rowCount();
        
        if ($cant_exista != 0) {
            echo '<script type="text/javascript">
                    alert("Este numero de factura ya se guardo anteriormente");
                    window.location.href = "../../init/app/ventas/ord.php?cid='.$lafactura.'";
                  </script>';
        }else{
            
            if ($elcliente == 0 || $elcliente == '' || strlen($elcliente) < 7 ){
                $elcliente = 0;
            }else{
                $elcliente = $elcliente;
            } 
            
            // CONSULTAR CLIENTE REPETIDO
            
            $cliente_verificacion = $cc->prepare("SELECT * FROM c_clientes WHERE cedula='$elcliente' AND estado='A'");
            $cliente_verificacion->execute();
            $count_cliente = $cliente_verificacion->rowCount();
            
            if ($count_cliente == 0) {
                $insert_cliente = $cc->prepare("INSERT INTO c_clientes (cedula, nombres, nveces, estado) VALUES ('$elcliente', '$nomcliente', 1,'A')");
                $insert_cliente->execute();
            }else{
                
            }

        if ( $forma == 'Parcial') { // INICIO PARCIAL
            if ($parcialm == '' || $parcialm < 2){ // VERIFICAR SI EL PAGO DIFERIDO SE HA SELECCIONADO LOS MESES PLAZO
                echo '<script>
                        alert("Error, debe elegir el numero de meses a diferir, debe ser minimo a 2 meses");
                        window.location.href = "../../init/app/ventas/ord.php?cid='.$lafactura.'";
                      </script>';
            }else{
            if ($descu == 0) {
                @$saldo = ($parcial - $total);    
            }else{
                @$saldo = ($parcial - $total - $desc);
            }
            if ($parcial == 0 || $parcial == "") {
                echo '<script>
                            alert("El valor recibido es insuficiente o no ha ingresado nada");
                            window.location.href = "../../init/app/ventas/ord.php?cid='.$lafactura.'";
                      </script>';
                }else{
                    $pmeses = $_POST['parcial_meses'];
                    $pdiferido = $saldo - $descu; 
                    $pdiferido = $pdiferido / $pmeses;
                    $refsaldo = abs($saldo);
                    $refdierido = abs($pdiferido);

                    $sql = $cc->prepare("INSERT INTO c_venta
                                                    (n_s, nventa, cliente, importe, forma_pago, meses, diferido, descuento, iva, iva_valor, total, 
                                                    fecha_origen, observacion,estado,norden,id_empresa,contado, id_empleado, sucursal, idr, peso_menudo, parcial, saldo, autoriz, dosif) 
                        VALUES (?,?,?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?,?, ?,?)");

                    $sql->bindParam(1, $masuno,         PDO::PARAM_INT);
                    $sql->bindParam(2, $nfacturas,      PDO::PARAM_STR);
                    $sql->bindParam(3, $elcliente,      PDO::PARAM_STR);
                    $sql->bindParam(4, $importe,        PDO::PARAM_STR);
                    $sql->bindParam(5, $forma,          PDO::PARAM_STR);

                    $sql->bindParam(6, $pmeses,          PDO::PARAM_INT);
                    $sql->bindParam(7, $refdierido,          PDO::PARAM_STR);

                    $sql->bindParam(8, $descu,          PDO::PARAM_STR);
                    $sql->bindParam(9, $iva_num,        PDO::PARAM_INT);
                    $sql->bindParam(10, $iva_dolares,    PDO::PARAM_STR);                
                    $sql->bindParam(11, $total,          PDO::PARAM_STR);                    
                    $sql->bindParam(12, $solofecha,     PDO::PARAM_STR);

                    $sql->bindParam(13, $obvs,          PDO::PARAM_STR);
                    $sql->bindParam(14, $stdventa,      PDO::PARAM_STR);
                    $sql->bindParam(15, $lafactura,     PDO::PARAM_STR);
                    $sql->bindParam(16, $empresa,       PDO::PARAM_INT);
                    $sql->bindParam(17, $contado,       PDO::PARAM_STR);
                    $sql->bindParam(18, $eply,          PDO::PARAM_INT);

                    $sql->bindParam(19, $sucursal,      PDO::PARAM_INT);
                    $sql->bindParam(20, $resp,          PDO::PARAM_INT);
                    $sql->bindParam(21, $peso_menudo,   PDO::PARAM_STR);
                    $sql->bindParam(22, $parcial,   PDO::PARAM_STR);
                    $sql->bindParam(23, $refsaldo,   PDO::PARAM_STR);

                    $sql->bindParam(24, $autoriz,   PDO::PARAM_STR);
                    $sql->bindParam(25, $dosif,   PDO::PARAM_STR);

                     
                    if ($sql->execute()) {
                        if ($cant_active == 0) { // Aumentar o generar el secuencial de la tabla secuencial
                            $insert_secuencial = $cc->prepare("INSERT INTO c_secuencial (num_secuencial, num_secuencial_orden, estado) VALUES (1,1, 'A')");
                            $insert_secuencial->execute();
                        }else{
                           /* $upd_sec = DBSTART::abrirDB()->prepare("UPDATE c_secuencial SET num_secuencial= num_secuencial+1, num_secuencial_orden=num_secuencial_orden+1, fecha_modificacion=now()");
                            $upd_sec->execute();*/
                        }
                    
                    //   REGISTRAR CUENTA EN CUENTAS POR COBRAR

                    $dif = abs($pdiferido);
                    $abs = abs($saldo);
                    $cobrar = $cc->prepare("INSERT INTO c_cxc 
                            (cedula, total,     meses,          diferido, saldo, cuotas_pagadas, cuotas_pendientes, estado, fecha_cxc) 
                VALUES ('$elcliente', '$total', '$pmeses', '$dif', '$abs', 0,                 '$pmeses',       'DEBE', now())");
                    $cobrar->execute();

                    // Activar al cliente
                    $clup = $cc->prepare("UPDATE c_clientes SET estado='A', nveces=nveces+1 WHERE cedula=?");
                    $clup->execute(array($elcliente));
                    
                    // Inhabilitar la venta detalle del numero de orden en curso    
                    $upd5 = $cc->prepare("UPDATE c_venta_detalle SET estado='F', nventa='$nfacturas' WHERE num_orden='$lafactura' AND estado='A'");
                    $upd5->execute();
                    
                    // Generar salidas del inventario
                    $buscar_productos = $cc->prepare("SELECT * FROM c_venta_detalle WHERE nventa='$nfacturas'");
                    $buscar_productos->execute();
                    $all_buscar_productos = $buscar_productos->fetchAll();
                    
                    foreach((array) $all_buscar_productos as $values_productos) {
                        $codigo_reverse = $values_productos['codigo'];
                        $cantidad_reverse = $values_productos['cantidad'];

                        $init = $cc->prepare("UPDATE c_mercaderia SET salida='$cantidad_reverse' WHERE codproducto='$codigo_reverse'");
                        $init->execute();
                    }
                    
                    // Consulta los productos del carrito que sean de la misma venta para darle de baja //
            
                    $baja = $cc->prepare("SELECT * FROM c_venta_detalle WHERE num_orden='$lafactura'");
                    $baja->execute();
                    $all_baja = $baja->fetchAll();
                    
                    foreach( (array) $all_baja as $ddd) {
                        $baja_codigo    = $ddd['codigo'];
                        $cant_codigo    = $ddd['c_aux'];
                        $tipo_cantidad  = $ddd['tcant'];
                        $lasucursal  = $ddd['sucursal'];
                        $ccajas = $ddd['cantcajas'];
                        
                        // Ingresar a caja chica
                    
                        $sqlsaldo = $cc->prepare("INSERT INTO c_resumen_gasto (param, tipo, id_empleado, valor, anio, mes, dia, entrada, salida, saldo, id_estado, sucursal) 
                                                                  VALUES (1, 6, '$eply', '$total', '$anio', '$mes', '$dia', '$total', 0, '$nuevo_saldo' ,1, '$lasucursal')");
                        $sqlsaldo->execute();
                        
                        if ($tipo_cantidad == 'Unidad') {
                            $dar_baja = $cc->prepare("UPDATE c_mercaderia SET existencia= existencia-'$cant_codigo', cajas=cajas-'$ccajas' WHERE codproducto='$baja_codigo' AND sucursal='$lasucursal'");
                            $dar_baja->execute();
                        }elseif ($tipo_cantidad == 'Kilos'){
                            $dar_baja = $cc->prepare("UPDATE c_mercaderia SET kilo= kilo-'$cant_codigo', cajas=cajas-'$ccajas' WHERE codproducto='$baja_codigo' AND sucursal='$lasucursal'");
                        $dar_baja->execute();
                        }elseif ($tipo_cantidad == 'Libras'){
                            $dar_baja = $cc->prepare("UPDATE c_mercaderia SET libra= libra-'$cant_codigo', cajas=cajas-'$ccajas' WHERE codproducto='$baja_codigo' AND sucursal='$lasucursal'");
                            $dar_baja->execute();
                        }elseif ($tipo_cantidad == 'Gramos'){
                            $dar_baja = $cc->prepare("UPDATE c_mercaderia SET gramo= gramo-'$cant_codigo', cajas=cajas-'$ccajas' WHERE codproducto='$baja_codigo' AND sucursal='$lasucursal'");
                            $dar_baja->execute();
                        }elseif ($tipo_cantidad == 'Litros'){
                            $dar_baja = $cc->prepare("UPDATE c_mercaderia SET litro=litro-'$cant_codigo', cajas=cajas-'$ccajas' WHERE codproducto='$baja_codigo' AND sucursal='$lasucursal'");
                            $dar_baja->execute();
                        }                       
                    }                    
                    
                    header('Location: ../../init/app/ventas/fl.php?cid='.$nfacturas);
                    //echo '<script>alert("realizado");</script>';
                }
                }
            } // fin else efectivo
        }else if ( $forma == 'Efectivo') { // INICIO EFECTIVO
            if ($efectivo < $total || $efectivo == "") {
                echo '<script>
                            alert("El valor recibido es insuficiente o no ha ingresado nada");
                            window.location.href = "../../init/app/ventas/ord.php?cid='.$lafactura.'";
                      </script>';
                }else{

                    $ref = abs($cambio);
                    
                    $sql = $cc->prepare("INSERT INTO c_venta
                                                    (n_s, nventa, cliente, importe, forma_pago, efectivo, cambio, descuento, 
                                                    iva, iva_valor, total, fecha_origen, observacion,estado,norden,id_empresa,contado, id_empleado, sucursal, idr, peso_menudo, autoriz, dosif) 
                        VALUES (?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?,?, ?,?)");

                    $sql->bindParam(1, $masuno,         PDO::PARAM_INT);
                    $sql->bindParam(2, $nfacturas,      PDO::PARAM_STR);
                    $sql->bindParam(3, $elcliente,      PDO::PARAM_STR);
                    $sql->bindParam(4, $importe,        PDO::PARAM_STR);
                    $sql->bindParam(5, $forma,          PDO::PARAM_STR);
                    $sql->bindParam(6, $efectivo,       PDO::PARAM_STR); 
                    $sql->bindParam(7, $ref,            PDO::PARAM_STR);
                    $sql->bindParam(8, $descu,          PDO::PARAM_STR);
                    $sql->bindParam(9, $iva_num,        PDO::PARAM_INT);
                    $sql->bindParam(10, $iva_dolares,   PDO::PARAM_STR);                
                    $sql->bindParam(11, $total,         PDO::PARAM_STR);
                    
                    $sql->bindParam(12, $solofecha,     PDO::PARAM_STR);
                    $sql->bindParam(13, $obvs,          PDO::PARAM_STR);
                    $sql->bindParam(14, $stdventa,      PDO::PARAM_STR);
                    $sql->bindParam(15, $lafactura,     PDO::PARAM_STR);
                    $sql->bindParam(16, $empresa,       PDO::PARAM_INT);
                    $sql->bindParam(17, $contado,       PDO::PARAM_STR);
                    $sql->bindParam(18, $eply,          PDO::PARAM_INT);
                    $sql->bindParam(19, $sucursal,      PDO::PARAM_INT);
                    $sql->bindParam(20, $resp,          PDO::PARAM_INT);
                    $sql->bindParam(21, $peso_menudo,   PDO::PARAM_STR);

                    $sql->bindParam(22, $autoriz,   PDO::PARAM_STR);
                    $sql->bindParam(23, $dosif,   PDO::PARAM_STR);

                     
                    if ($sql->execute()) {
                        if ($cant_active == 0) { // Aumentar o generar el secuencial de la tabla secuencial
                            $insert_secuencial = $cc->prepare("INSERT INTO c_secuencial (num_secuencial, num_secuencial_orden, estado) VALUES (1,1, 'A')");
                            $insert_secuencial->execute();
                        }else{
                           /* $upd_sec = DBSTART::abrirDB()->prepare("UPDATE c_secuencial SET num_secuencial= num_secuencial+1, num_secuencial_orden=num_secuencial_orden+1, fecha_modificacion=now()");
                            $upd_sec->execute();*/
                        }                    
                    
                    // Activar al cliente
                    $clup = $cc->prepare("UPDATE c_clientes SET estado='A', nveces=nveces+1 WHERE cedula=?");
                    $clup->execute(array($elcliente));
                    
                    // Inhabilitar la venta detalle del numero de orden en curso    
                    $upd5 = $cc->prepare("UPDATE c_venta_detalle SET estado='F', nventa='$nfacturas' WHERE num_orden='$lafactura' AND estado='A'");
                    $upd5->execute();
                    
                    // Generar salidas del inventario
                    $buscar_productos = $cc->prepare("SELECT * FROM c_venta_detalle WHERE nventa='$nfacturas'");
                    $buscar_productos->execute();
                    $all_buscar_productos = $buscar_productos->fetchAll();
                    
                    foreach((array) $all_buscar_productos as $values_productos) {
                        $codigo_reverse = $values_productos['codigo'];
                        $cantidad_reverse = $values_productos['cantidad'];

                        $init = $cc->prepare("UPDATE c_mercaderia SET salida='$cantidad_reverse' WHERE codproducto='$codigo_reverse'");
                        $init->execute();
                    }
                    
                    // Consulta los productos del carrito que sean de la misma venta para darle de baja //
            
                    $baja = $cc->prepare("SELECT * FROM c_venta_detalle WHERE num_orden='$lafactura'");
                    $baja->execute();
                    $all_baja = $baja->fetchAll();
                    
                    foreach( (array) $all_baja as $ddd) {
                        $baja_codigo    = $ddd['codigo'];
                        $cant_codigo    = $ddd['c_aux'];
                        $tipo_cantidad  = $ddd['tcant'];
                        $lasucursal  = $ddd['sucursal'];
                        $ccajas = $ddd['cantcajas'];
                        
                        // Ingresar a caja chica
                    
                        $sqlsaldo = $cc->prepare("INSERT INTO c_resumen_gasto (param, tipo, id_empleado, valor, anio, mes, dia, entrada, salida, saldo, id_estado, sucursal) 
                                                                  VALUES (1, 6, '$eply', '$total', '$anio', '$mes', '$dia', '$total', 0, '$nuevo_saldo' ,1, '$lasucursal')");
                        $sqlsaldo->execute();
                        
                        if ($tipo_cantidad == 'Unidad') {
                            $dar_baja = $cc->prepare("UPDATE c_mercaderia SET existencia= existencia-'$cant_codigo', cajas=cajas-'$ccajas' WHERE codproducto='$baja_codigo' AND sucursal='$lasucursal'");
                            $dar_baja->execute();
                        }elseif ($tipo_cantidad == 'Kilos'){
                            $dar_baja = $cc->prepare("UPDATE c_mercaderia SET kilo= kilo-'$cant_codigo', cajas=cajas-'$ccajas' WHERE codproducto='$baja_codigo' AND sucursal='$lasucursal'");
                        $dar_baja->execute();
                        }elseif ($tipo_cantidad == 'Libras'){
                            $dar_baja = $cc->prepare("UPDATE c_mercaderia SET libra= libra-'$cant_codigo', cajas=cajas-'$ccajas' WHERE codproducto='$baja_codigo' AND sucursal='$lasucursal'");
                            $dar_baja->execute();
                        }elseif ($tipo_cantidad == 'Gramos'){
                            $dar_baja = $cc->prepare("UPDATE c_mercaderia SET gramo= gramo-'$cant_codigo', cajas=cajas-'$ccajas' WHERE codproducto='$baja_codigo' AND sucursal='$lasucursal'");
                            $dar_baja->execute();
                        }elseif ($tipo_cantidad == 'Litros'){
                            $dar_baja = $cc->prepare("UPDATE c_mercaderia SET litro=litro-'$cant_codigo', cajas=cajas-'$ccajas' WHERE codproducto='$baja_codigo' AND sucursal='$lasucursal'");
                            $dar_baja->execute();
                        }                       
                    }                    
                    
                    header('Location: ../../init/app/ventas/fl.php?cid='.$nfacturas);
                    //echo '<script>alert("realizado");</script>';
                }
            } // fin else efectivo
        }else if ($forma == 'Diferido'){ // INICIO DIFERIDO
            if ($meses == '' || $meses < 2){ // VERIFICAR SI EL PAGO DIFERIDO SE HA SELECCIONADO LOS MESES PLAZO
                echo '<script>
                        alert("Error, debe elegir el numero de meses a diferir, debe ser minimo a 2 meses");
                        window.location.href = "../../init/app/ventas/ord.php?cid='.$lafactura.'";
                      </script>';
            }else{
                
            if ($meses != '' &&  $elcliente == '' && $nomcliente == ''){ // VERIFICAR SI EL PAGO DIFERIDO SE HA SELECCIONADO LOS MESES PLAZO
                echo '<script>
                        alert("Error, debe especificar el cliente que se le dara credito");
                        window.location.href = "../../init/app/ventas/ord.php?cid='.$lafactura.'";
                      </script>';
            }else{
                
                
                
                $forma = "Diferido";
                $meses = $_POST['meses'];
                $diferido = $total - $descu;
                $diferido = $diferido / $meses;                

                $sql = $cc->prepare("INSERT INTO c_venta
            (n_s, nventa, cliente, importe, forma_pago, meses, diferido, descuento,iva, iva_valor, total, fecha_origen, observacion, estado, norden,id_empresa,contado, id_empleado, sucursal, idr, peso_menudo, autoriz, dosif) 
                                        VALUES (?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?,?, ?,?)");

                $sql->bindParam(1, $masuno,         PDO::PARAM_INT);
                $sql->bindParam(2, $nfacturas,      PDO::PARAM_STR);
                $sql->bindParam(3, $elcliente,      PDO::PARAM_STR);
                $sql->bindParam(4, $importe,        PDO::PARAM_STR);
                $sql->bindParam(5, $forma,          PDO::PARAM_STR);
                $sql->bindParam(6, $meses,          PDO::PARAM_INT);
                $sql->bindParam(7, $diferido,       PDO::PARAM_STR);
                $sql->bindParam(8, $descu,          PDO::PARAM_STR);
                $sql->bindParam(9, $iva_num,        PDO::PARAM_INT);
                $sql->bindParam(10, $iva_dolares,   PDO::PARAM_STR);
                $sql->bindParam(11, $total,         PDO::PARAM_STR);
                
                $sql->bindParam(12, $solofecha,     PDO::PARAM_STR);
                $sql->bindParam(13, $obvs,          PDO::PARAM_STR);
                $sql->bindParam(14, $stdventa,      PDO::PARAM_STR);
                $sql->bindParam(15, $lafactura,     PDO::PARAM_STR);
                $sql->bindParam(16, $empresa,       PDO::PARAM_INT);
                $sql->bindParam(17, $contado,       PDO::PARAM_STR);
                $sql->bindParam(18, $eply,          PDO::PARAM_INT);
                $sql->bindParam(19, $sucursal,      PDO::PARAM_INT);
                $sql->bindParam(20, $resp,          PDO::PARAM_INT);
                $sql->bindParam(21, $peso_menudo,   PDO::PARAM_STR);

                $sql->bindParam(22, $autoriz,   PDO::PARAM_STR);
                $sql->bindParam(23, $dosif,   PDO::PARAM_STR);

                
                if ($sql -> execute() ) {
                if ($cant_active == 0) { // Aumentar o generar el secuencial de la tabla secuencial
                        $insert_secuencial = $cc->prepare("INSERT INTO c_secuencial (num_secuencial, num_secuencial_orden, estado) VALUES (1,1, 'A')");
                        $insert_secuencial->execute();
                }else{
                        /*$upd_sec = DBSTART::abrirDB()->prepare("UPDATE c_secuencial SET num_secuencial= num_secuencial+1, num_secuencial_orden=num_secuencial_orden+1, fecha_modificacion=now()");
                        $upd_sec->execute();*/
                }
                
                // Ingresar a caja chica
                    
                    $sqlsaldo = $cc->prepare("INSERT INTO c_resumen_gasto (param, tipo, id_empleado, valor, anio, mes, dia, entrada, salida, saldo, id_estado) 
                                                              VALUES (1, 6, '$eply', '$total', '$anio', '$mes', '$dia', '$total', 0, '$nuevo_saldo' ,1)");
                    $sqlsaldo->execute();
                    
                
                /**   REGISTRAR CUENTA EN CUENTAS POR COBRAR**/
                $cobrar = DBSTART::abrirDB()->prepare("INSERT INTO c_cxc (cedula, total, meses, diferido, saldo, cuotas_pagadas, cuotas_pendientes, estado, fecha_cxc) 
                                                        VALUES ('$elcliente', '$total', '$meses', '$diferido','$total',0, '$meses', 'DEBE', now())");
                $cobrar->execute();
                    // Activar al cliente
                    $clup = $cc->prepare("UPDATE c_clientes SET estado='A', nveces=nveces+1 WHERE cedula=?");
                    $clup->execute(array($elcliente));

                $upd5 = DBSTART::abrirDB()->prepare("UPDATE c_venta_detalle SET estado='F', nventa='$nfacturas' WHERE num_orden='$lafactura' AND estado='A'");
                $upd5->execute();
                
                // Consulta los productos del carrito que sean de la misma venta para darle de baja //
                $baja = $cc->prepare("SELECT * FROM c_venta_detalle WHERE num_orden='$lafactura'");
                $baja->execute();
                $all_baja = $baja->fetchAll();
                
                foreach((array) $all_baja as $ddd) {
                    $baja_codigo    = $ddd['codigo'];
                    $cant_codigo    = $ddd['cantidad'];
                    $tipo_cantidad  = $ddd['tcant'];
                    $lasucursal     = $ddd['sucursal'];
                    $ccajas         = $ddd['cantcajas'];
                     
                    if ($tipo_cantidad == 'Unidad') {
                            $dar_baja = $cc->prepare("UPDATE c_mercaderia SET existencia= existencia-'$cant_codigo', cajas=cajas-'$ccajas' WHERE codproducto='$baja_codigo' AND sucursal='$lasucursal'");
                            $dar_baja->execute();
                        }elseif ($tipo_cantidad == 'Kilos'){
                            $dar_baja = $cc->prepare("UPDATE c_mercaderia SET kilo= kilo-'$cant_codigo', cajas=cajas-'$ccajas' WHERE codproducto='$baja_codigo' AND sucursal='$lasucursal'");
                        $dar_baja->execute();
                        }elseif ($tipo_cantidad == 'Libras'){
                            $dar_baja = $cc->prepare("UPDATE c_mercaderia SET libra= libra-'$cant_codigo', cajas=cajas-'$ccajas' WHERE codproducto='$baja_codigo' AND sucursal='$lasucursal'");
                            $dar_baja->execute();
                        }elseif ($tipo_cantidad == 'Gramos'){
                            $dar_baja = $cc->prepare("UPDATE c_mercaderia SET gramo= gramo-'$cant_codigo', cajas=cajas-'$ccajas' WHERE codproducto='$baja_codigo' AND sucursal='$lasucursal'");
                            $dar_baja->execute();
                        }elseif ($tipo_cantidad == 'Litros'){
                            $dar_baja = $cc->prepare("UPDATE c_mercaderia SET litro=litro-'$cant_codigo', cajas=cajas-'$ccajas' WHERE codproducto='$baja_codigo' AND sucursal='$lasucursal'");
                            $dar_baja->execute();
                    }
                }
                header('Location: ../../init/app/ventas/fl.php?cid='.$nfacturas);
            }
            } // Fin if de la seleccion del cliente en forma de pago diferido
        } // fin else diferido
    } // fin pago diferido    
    }
}