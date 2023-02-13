<?php

        require_once ('./'."../../datos/db/connect.php");

        $env = new DBSTART;
        $cc = $env->abrirDB();
        $numorden = htmlspecialchars($_POST['norden']);
        $empleado = htmlspecialchars($_POST['empleado']);
        
        $codigo   = htmlspecialchars($_POST['code']);
        $cantidad = htmlspecialchars($_POST['_cantidad']);
        $stock    = htmlspecialchars($_POST['_stock']);
        $activo   = 'A';
        $token    = htmlspecialchars($_POST['token']);
        
        // SELECCION
        $seleccion = htmlspecialchars($_POST['elegir']);
        $kilo = htmlspecialchars($_POST['_kilo']);
        $sucursal = htmlspecialchars($_POST['sucursal']); // TIPEADO 1
        $sucursal = 1;
        
        // PRECIOS POR SELECCION
        $precio = htmlspecialchars($_POST['_precio']);
        $pkg    = htmlspecialchars($_POST['pkg']);    
        
        $cat_idem = htmlspecialchars($_POST['categoria_idem']);

        $lamerma = htmlspecialchars($_POST['merma_venta']);
        $lacompra = htmlspecialchars($_POST['ncompra']);

        $ccajas = htmlspecialchars($_POST['_cantidad_cajas']);

        $cajasdisp = htmlspecialchars($_POST['cajasdisp']);
        $thecedula = htmlspecialchars($_POST['thecedula']);

        $peso_menudo = htmlspecialchars($_POST['_peso_menudo']); // PESO MOLLEJA
        $peso_pata = htmlspecialchars($_POST['_peso_pata']); // PESO PATA
        $peso_higado = htmlspecialchars($_POST['_peso_higado']);
                
        
       /* if ($codigo == "") { // Si no se ha especificado el código de producto retornará error
            echo '<script>
                        alert("Debe escoger el producto!");
                        window.location.href = "../../init/app/ventas/ord.php?cid='.$numorden.'";
                  </script>';
        }else{*/

            if ($cantidad > $kilo) {
                echo '<script>
                        alert("Stock no disponible!");
                        window.location.href = "../../init/app/ventas/ord.php?cid='.$numorden.'";
                  </script>';
            }else{

                if ($ccajas > $cajasdisp) {
                    echo '<script>
                        alert("El numero de cajas que eligio no esta disponible!");
                        window.location.href = "../../init/app/ventas/ord.php?cid='.$numorden.'";
                  </script>';
                }else{

                //Consultar si el numero de orden y el token del usuario coinciden, sino se agregaran los productos en una nueva orden
                $statement = $cc->prepare("SELECT * FROM c_venta_detalle WHERE empleado='$empleado' AND num_orden='$numorden' AND estado='A'");
                $statement->execute();
                $count_s = $statement->rowCount();
        
                if ($count_s == 0) { // Consultar el ultimo orden + 1
                    $orden_row = $cc->prepare("SELECT MAX(num_secuencial_orden) ultimo_s FROM c_secuencial");
                    $orden_row->execute();
                    $fetch_orden = $orden_row->fetchAll(PDO::FETCH_ASSOC);
                    foreach((array) $fetch_orden as $rr) {
                        $ext = $rr['ultimo_s'];
                        $new_ext = $ext + 1;
                    }
                    /*$upd_sec = $cc->prepare("UPDATE c_secuencial SET num_secuencial_orden= num_secuencial_orden+1, fecha_modificacion=now()");
                    $upd_sec->execute();*/
                }else{
                    $new_ext = $numorden;
                }
                
                if ($seleccion == 'Unidad') {
                    $importe = $cantidad * $precio;
                    $pp = $precio;
                    $seccion3 = 0;
                }elseif($seleccion == 'Kilos'){
                    $importe = $cantidad * $pkg;
                    $pp = $pkg;

                    // TOTAL DE CAJAS

                    $seccion1 = $ccajas * 2;    // Total de cajas x 2
                    $seccion2 = abs($seccion1 - $cantidad); // Se resta a los kg totales
                    $seccion3 = $seccion2 * $pkg;
                }
                
            /*************************************************************************/
            /*******  P R O C E S O    I N G R E S O    D E    C A R R I T O  ********/
            /*************************************************************************/

            // INGRESO A VENTA DETALLE DE DATOS DEL CARRITO Y DEL CLIENTE NUEVO CON ESTADO E
            $sql = $cc->prepare("INSERT INTO c_venta_detalle (codigo, categoria, precio,cantidad, tcant, importe,estado,num_orden,empleado,cliente,token,c_aux, sucursal, 
                                                                lamerma, lacompra, cantcajas, aux, peso_menudo, peso_pata, peso_higado)
                                        VALUES (:cod, :cat, :pre, :can, :sel, :imp, :act, :nor, :emp, :cli, :tok, :aux, :suc, :lme, :lco, :cja, :aux, :pm, :pp, :ph)");
            $sql->bindParam(':cod', $codigo,     PDO::PARAM_STR);
            $sql->bindParam(':cat', $cat_idem,   PDO::PARAM_STR);
            $sql->bindParam(':pre', $pp,         PDO::PARAM_STR);
            $sql->bindParam(':can', $cantidad,   PDO::PARAM_STR);
            $sql->bindParam(':sel', $seleccion,  PDO::PARAM_STR);
            $sql->bindParam(':imp', $importe,    PDO::PARAM_STR);
            $sql->bindParam(':act', $activo,     PDO::PARAM_STR);
            $sql->bindParam(':nor', $new_ext,    PDO::PARAM_STR);
            $sql->bindParam(':emp', $empleado,   PDO::PARAM_INT);
            $sql->bindParam(':cli', $thecedula,  PDO::PARAM_STR);
            $sql->bindParam(':tok', $token,      PDO::PARAM_INT);
            $sql->bindParam(':aux', $cantidad,   PDO::PARAM_STR);
            $sql->bindParam(':suc', $sucursal,   PDO::PARAM_INT);
            $sql->bindParam(':lme', $lamerma,    PDO::PARAM_STR);
            $sql->bindParam(':lco', $lacompra,   PDO::PARAM_STR);
            $sql->bindParam(':cja', $ccajas,     PDO::PARAM_INT);
            $sql->bindParam(':aux', $seccion3,   PDO::PARAM_STR);
            $sql->bindParam(':pm', $peso_menudo, PDO::PARAM_STR);
            $sql->bindParam(':pp', $peso_pata,   PDO::PARAM_STR);
            $sql->bindParam(':ph', $peso_higado, PDO::PARAM_STR);
            
            $sql->execute();        
                
                $upd_sec = $cc->prepare("UPDATE c_secuencial SET num_secuencial_orden= num_secuencial_orden+1, fecha_modificacion=now()");
                $upd_sec->execute();
                header('Location: ../../init/app/ventas/ord.php?cid='.$new_ext);

            // Dar baja al stock
            //$upd = $cc->prepare("UPDATE c_mercaderia SET existencia=existencia-'$cantidad' WHERE codproducto='$codigo'");
            //$upd->execute();
            

            /*************   FIN    P R O C E S O    D E    C A R R I T O   *************/ 
        // }   
    }
}