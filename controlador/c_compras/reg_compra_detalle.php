<?php
    require_once ('./'."../../datos/db/connect.php");
    $formato = array('.jpg', '.png');
  
    //$imgs = addslashes(file_get_contents($_FILES['img']['tmp_name'])); LAS IMAGENES VAN A DIRECTORIO
    
    //$empresa    = SEG::clean($_POST['empresa']);
    $prove      = htmlspecialchars($_POST['proveedor']);
    
    $ncompra    = htmlspecialchars($_POST['ncompra']);
    $codigo     = htmlspecialchars($_POST['codigo']);
    $categ      = htmlspecialchars($_POST['categoria']);
    $nombre     = htmlspecialchars($_POST['nombre']);
    $pc         = htmlspecialchars($_POST['precio_compra']);
    $cantidad   = htmlspecialchars($_POST['stock']  );            // SIN EFECTO AHORA ** CORREGIR **
    $desc 		= htmlspecialchars($_POST['desc']);
    $iva        = htmlspecialchars($_POST['iva']);
    $fechac     = htmlspecialchars($_POST['fechacompra']);
    
    $tipo       = htmlspecialchars($_POST['tipo']);
    $pneto      = htmlspecialchars($_POST['pneto'] );
    $pmerma     = htmlspecialchars($_POST['pmerma'] );
    
    $usuario = htmlspecialchars($_POST['usuario_session']);

    $lote = htmlspecialchars($_POST['lote'] );

    $cantcajas = htmlspecialchars($_POST['ccajas'] ); // CANTIDAD DE CAJAS
    $pesocajas = htmlspecialchars($_POST['pcajas'] );    // PESO DE CAJAS

    //$el_impuesto = htmlspecialchars();
    

    $cantunidades = htmlspecialchars($_POST['cantunidades'] );

    $utotales = htmlspecialchars($_POST['utotales']);
    $caduca = htmlspecialchars($_POST['caduca']);

    /*if (isset($_POST['valorz'])) {
        $valorz = htmlspecialchars($_POST['valorz']); // VALOR DEL IMAXN NUMERO DE 2.5 EJEMPLO <=
    }else{
        $valorz = 0;
    }*/

    $valorz = 2.5;

    
    // BUSCAR COMPRA REPETIDA DE PROVEEDOR Y NUMERO DE COMPRA
    $stmt = DBSTART::abrirDB()->prepare("SELECT * FROM c_compra WHERE ncompra='$ncompra' AND id_proveedor='$prove' AND estado = 'A'");
    $stmt->execute();
    $cant_stmt = $stmt->rowCount();

    $date = date('Y-m-d');
    $estado = 'E';
    $estadi = 'A';
    $ok = 2;
    $sucursal = 1;

    $db = new DBSTART;
    $argsdb = $db->abrirDB();
    
    if ($cant_stmt != 0 ) {
        echo '<script>
                alert("ERROR, ESTA FACTURA DE COMPRA YA LA INGRESO ANTERIORMENTE!!!");
                window.location.href = "in.php?cid=compras/frm_compras_ingreso"; 
              </script>';
    }else{
        if ($prove == "0") {
            echo '<script> 
                    alert("Error, debe seleccionar al Proveedor");
                    window.location.href = "in.php?cid=compras/frm_compras_ingreso";
                </script>';
        }else{
        
        if ($ncompra == "" ){
            echo '<script>
                    alert("ERROR, DEBE ASIGNAR EL NUMERO DE COMPRA");
                    window.location.href = "in.php?cid=compras/frm_compras_ingreso";
                </script>';
        }else{
    
        if ($categ == "0") {
            echo '<script>
                    alert("Error, debe seleccionar la categoria");
                    window.location.href = "in.php?cid=compras/frm_compras_ingreso";
                </script>';
        }else{

        // INGRESO DE MERCADERIA CON FOTO DE PRODUCTO
        $nombrearchivo = $_FILES['img']['name'];
        $nombretmparchivo = $_FILES['img']['tmp_name'];
        $ext = substr($nombrearchivo, strrpos($nombrearchivo, '.'));

        if (in_array($ext, $formato)) { $nombrearchivo = $nombrearchivo; }else{ $nombrearchivo = 'sinfoto.png'; }
        if (move_uploaded_file($nombretmparchivo,  "../../init/img/$nombrearchivo")) { }else{}


        if ($tipo == 2) { // Kilos
            $ckg = $cantidad;
            $cun = 0;
            $cj = 0;
        }elseif ($tipo == 1){ // Unidad
            $cun = $cantidad;
            $ckg = 0;
            $cj = 0;
        }elseif ($tipo == 3){ // Caja
            $cun = 0;
            $ckg = 0;
            $cj = $cantidad;
        }
        
        /*
        if ($desc == 0 ) {
            $importe = $importe;
        }else{
            
        }*/


        if (isset($_POST['el_impuesto'])) {
            $importe = 0;
            $importe = $cantidad * $pc;

            $max = ($pmerma * $valorz) / 100;
            $menos = ($importe * $valorz) / 100;
            $falta_cero =  $valorz / 100;
            $falta = $importe - ($importe * $falta_cero);
            $sidescuento = 1;

        }else{
            $importe = 0;
            $importe = $cantidad * $pc;
            $importe = $utotales * $pc;

            $max = 0;
            $menos = 0;
            $falta = 0;
            $sidescuento = 2;
        }

        $importe = $importe - $desc;


        // NUEVO INGRESO

        $localizar = substr($categ, -3);

        if ($localizar == 106 || $localizar == 107 || $localizar == 108 || $localizar == 109){
            $positivo = 1;
        }else{
            $positivo = 2;
        }

        if ($cantcajas == '' || $cantcajas <= 0) {
            $cantcajas = 0;
        }else{
            $cantcajas = $cantcajas;
        }

        if ($pesocajas == '' || $pesocajas <= 0) {
            $pesocajas = 0;
        }else{
            $pesocajas = $pesocajas;
        }

        if ($pneto == '' || $pneto <= 0) {
            $pneto = 0;
        }else{
            $pneto = $pneto;
        }

        if ($pmerma == '' || $pmerma <= 0) {
            $pmerma = 0;
        }else{
            $pmerma = $pmerma;
        }

        if ($cantunidades == '' || $cantunidades <= 0) {
            $cantunidades = 0;
        }else{
            $cantunidades = $cantunidades;
        }

        
        if ($utotales == '' || $utotales <= 0) {
            $utotales = 0;
        }else{
            $utotales = $utotales;
        }


                $env = DBSTART::abrirDB()->prepare("INSERT INTO c_compra_detalle 
                                        (id_empresa, ncompra, codigo, descripcion, precio_compra, cantidad, descuento, 
                                        importe, estado, id_prov_cd, iva, fechac, ruta, idcat, pneto, pmerma, tipo, ckg, cja, id_usuario, lote,
                                        imax, imaxn, menosvalor, falta, pesocajas, cantcajas, cantunidades, aux_cant, positivo, utotales, sidescuento)
                    
                    VALUES (?,?,?,?,?,?,?,
                            ?,?,?,?,?,?,?,
                            ?,?,?,?,?,?,?,
                            ?,?,?,?,?,?,?,
                            ?,?,?,?)");

                $env->bindParam(1,         $empresa, PDO::PARAM_INT);  // 1
                $env->bindParam(2,         $ncompra, PDO::PARAM_STR);  // 2
                $env->bindParam(3,          $codigo, PDO::PARAM_STR);   // 3
                $env->bindParam(4,         $nombre, PDO::PARAM_STR);  // 4
                $env->bindParam(5,         $pc, PDO::PARAM_STR);       // 5
                $env->bindParam(6,        $cun, PDO::PARAM_INT);      // 6
                $env->bindParam(7,       $desc, PDO::PARAM_STR);     // 7
                $env->bindParam(8,         $importe, PDO::PARAM_STR);  // 8
                $env->bindParam(9,          $estadi, PDO::PARAM_STR);   // 9
                $env->bindParam(10,       $prove, PDO::PARAM_INT);    // 10
                $env->bindParam(11,            $iva, PDO::PARAM_INT);      // 11
                $env->bindParam(12,          $fechac, PDO::PARAM_STR);   // 12
                $env->bindParam(13,            $nombrearchivo, PDO::PARAM_STR); // 13
                $env->bindParam(14,       $categ, PDO::PARAM_STR);        // 14
                $env->bindParam(15,           $pneto, PDO::PARAM_STR);        // 15

                $env->bindParam(16,          $pmerma, PDO::PARAM_STR);       // 16
                $env->bindParam(17,            $tipo, PDO::PARAM_INT);         // 17
                $env->bindParam(18,             $ckg, PDO::PARAM_STR);          // 18
                $env->bindParam(19,             $cj, PDO::PARAM_STR);           // 19
                $env->bindParam(20,         $usuario, PDO::PARAM_INT);      // 20
                $env->bindParam(21,            $lote, PDO::PARAM_STR);         // 21
                $env->bindParam(22,            $max, PDO::PARAM_STR);          // 22
                $env->bindParam(23,           $valorz, PDO::PARAM_STR);       // 23
                $env->bindParam(24,          $menos, PDO::PARAM_STR);        // 24
                $env->bindParam(25,           $falta, PDO::PARAM_STR);        // 25
                $env->bindParam(26,        $pesocajas, PDO::PARAM_STR);    // 26
                $env->bindParam(27,        $cantcajas, PDO::PARAM_STR);    // 27
                $env->bindParam(28,      $cantunidades, PDO::PARAM_STR);     // 28
                $env->bindParam(29,         $utotales, PDO::PARAM_STR);     // 29
                $env->bindParam(30,        $positivo, PDO::PARAM_INT);     // 30
                $env->bindParam(31,        $utotales, PDO::PARAM_STR);     // 31
                $env->bindParam(32,     $sidescuento, PDO::PARAM_INT);  // 32

                $env->execute();


                $one = DBSTART::abrirDB()->prepare("INSERT INTO c_mercaderia 
                            (ncompra, id_proveedor, categoria, codproducto, nombreproducto, precio_compra, 
                                existencia, ruta, fechacompra, estado, existe, entrada, 
                                kilo, tunidad, pneto, pmerma, ok, caducidad, sucursal, cajas, positivo, utotales)

                            VALUES (?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?)");

                $one->bindParam(1, $ncompra,        PDO::PARAM_STR);
                $one->bindParam(2, $prove,          PDO::PARAM_INT);
                $one->bindParam(3, $categ,          PDO::PARAM_STR);
                $one->bindParam(4, $codigo,         PDO::PARAM_STR);
                $one->bindParam(5, $nombre,         PDO::PARAM_STR);
                $one->bindParam(6, $pc,             PDO::PARAM_STR);
                $one->bindParam(7, $pmerma,         PDO::PARAM_STR);
                $one->bindParam(8, $nombrearchivo,  PDO::PARAM_STR);
                $one->bindParam(9, $date,           PDO::PARAM_STR);
                $one->bindParam(10, $estado,        PDO::PARAM_STR);
                $one->bindParam(11, $pmerma,        PDO::PARAM_INT);
                $one->bindParam(12, $pmerma,        PDO::PARAM_STR);
                $one->bindParam(13, $ckg,           PDO::PARAM_STR);
                $one->bindParam(14, $tipo,          PDO::PARAM_INT);
                $one->bindParam(15, $pneto,         PDO::PARAM_STR);
                $one->bindParam(16, $pmerma,        PDO::PARAM_STR);
                $one->bindParam(17, $ok,            PDO::PARAM_INT);
                $one->bindParam(18, $caduca,        PDO::PARAM_STR);
                $one->bindParam(19, $sucursal,      PDO::PARAM_INT);
                $one->bindParam(20, $cantcajas,     PDO::PARAM_STR);
                $one->bindParam(21, $positivo,      PDO::PARAM_INT);
                $one->bindParam(22, $utotales,      PDO::PARAM_STR);

                if($one->execute()){
                

                    /*
                echo '<div class="alert alert-success">
                                <b><i class="fa fa-check"></i> Añadido a la lista!</b>
                            </div>';
                            */

                echo '<script>
                        window.location.href = "in.php?cid=compras/frm_compras_ingreso&success=true";
                    </script>';

                    }else{
                        echo '<div class="alert alert-warning">
                                <b>Error al guardar el producto!</b>
                            </div>';
                    }
  } } } }
?>