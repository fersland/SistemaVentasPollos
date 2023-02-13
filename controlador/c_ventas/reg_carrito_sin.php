<?php
//    if (isset($_POST['register'])){
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
        $libra = htmlspecialchars($_POST['_libra']);
        $gramo = htmlspecialchars($_POST['_gramo']);
        $litro = htmlspecialchars($_POST['_litro']);
        
        // PRECIOS POR SELECCION
        $precio = htmlspecialchars($_POST['_precio']);
        $pkg    = htmlspecialchars($_POST['pkg']);
        $plt    = htmlspecialchars($_POST['plt']);
        $plb    = htmlspecialchars($_POST['plb']);
        $pgr    = htmlspecialchars($_POST['pgr']);
        
        

        $ec = 'E';

        if ($codigo == "") { // Si no se ha especificado el código de producto retornará error
            echo '<script>
                        alert("Debe escoger el producto!");
                        window.location.href = "../../init/app/ventas/ord.php?cid='.$numorden.'";
                  </script>';
        }else{ // Si ha especificado el código.. continua

            if ($seleccion == 'Libras') {
                if ($cantidad > $libra) { echo '<script>alert("No puede llevar mas del Stock de libras!"); window.location.href = "../../init/app/ventas/ord.php?cid='.$numorden.'"; </script>';
                    $val = 0; 
                }else {
                    $val = 1;
                    $importe  = $plb * $cantidad;
                    
                    $pp = $plb;
                }
            }elseif ($seleccion == 'Kilos') {
                if ($cantidad > $kilo) { echo '<script> alert("No puede llevar mas del Stock de kilos!"); window.location.href = "../../init/app/ventas/ord.php?cid='.$numorden.'"; </script>'; 
                    $val = 0;
                }else {
                    $val = 1;
                    $importe  = $pkg * $cantidad;
                    $pp = $pkg;
                }
            }elseif ($seleccion == 'Gramos'){
                if ($cantidad > $gramo) { echo '<script> alert("No puede llevar mas del Stock de gramos!"); window.location.href = "../../init/app/ventas/ord.php?cid='.$numorden.'"; </script>'; 
                    $val = 0;
                }else {
                    $val = 1;
                    $importe  = $pgr * $cantidad;
                    $pp = $pgr;
                }
            }elseif ($seleccion == 'Litros'){
                if ($cantidad > $litro) { echo '<script> alert("No puede llevar mas del Stock de litros!"); window.location.href = "../../init/app/ventas/ord.php?cid='.$numorden.'"; </script>';
                    $val = 0;
                 }else { 
                    $val = 1;
                    $importe  = $plt * $cantidad;
                    $pp = $plt;
                 }
            }elseif ($seleccion == 'Unidad') {
                if ($cantidad > $stock) { echo '<script> alert("No puede llevar mas del Stock del producto!"); window.location.href = "../../init/app/ventas/ord.php?cid='.$numorden.'"; </script>';
                    $val = 0;
                }else { 
                    $val = 1;
                    $importe  = $precio * $cantidad;
                    $pp = $precio;
                    }
            }

            if ($val == 1) {
                
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
                $upd_sec = $cc->prepare("UPDATE c_secuencial SET num_secuencial_orden= num_secuencial_orden+1, fecha_modificacion=now()");
                $upd_sec->execute();
            }else{
                $new_ext = $numorden;
            }
                
            /*************************************************************************/
            /*******  P R O C E S O    I N G R E S O    D E    C A R R I T O  ********/
            /*************************************************************************/

            // INGRESO A VENTA DETALLE DE DATOS DEL CARRITO Y DEL CLIENTE NUEVO CON ESTADO E
            $sql = $cc->prepare("INSERT INTO c_venta_detalle (codigo,precio,cantidad, tcant, importe,estado,num_orden,empleado,cliente,token,c_aux) 
                                        VALUES (:cod, :pre, :can, :sel, :imp, :act, :nor, :emp, :cli, :tok, :aux)");
            $sql->bindParam(':cod', $codigo,     PDO::PARAM_STR);
            $sql->bindParam(':pre', $pp,     PDO::PARAM_STR);
            $sql->bindParam(':can', $cantidad,   PDO::PARAM_STR);
            $sql->bindParam(':sel', $seleccion,  PDO::PARAM_STR);
            $sql->bindParam(':imp', $importe,    PDO::PARAM_STR);
            $sql->bindParam(':act', $activo,     PDO::PARAM_STR);
            $sql->bindParam(':nor', $new_ext,    PDO::PARAM_STR);
            $sql->bindParam(':emp', $empleado,   PDO::PARAM_INT);
            $sql->bindParam(':cli', $cl_id,      PDO::PARAM_INT);
            $sql->bindParam(':tok', $token,      PDO::PARAM_INT);
            $sql->bindParam(':aux', $cantidad,      PDO::PARAM_STR);
            $sql->execute();

            // Dar baja al stock
            //$upd = $cc->prepare("UPDATE c_mercaderia SET existencia=existencia-'$cantidad' WHERE codproducto='$codigo'");
            //$upd->execute();
            //header('Location: ../../init/app/ventas/ord.php?cid='.$new_ext);
            echo '<script>
                       
                        window.location.href = "../../init/app/ventas/ord.php?cid='.$new_ext.'";
                  </script>';

            /*************   P R O C E S O    D E    C A R R I T O   *************/ 
            }
        }
    //}