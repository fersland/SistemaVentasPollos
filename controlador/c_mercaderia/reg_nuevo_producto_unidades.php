<?php
    $formato = array('.jpg', '.png');
    require_once ('./'."../../datos/db/connect.php");
      
    $prove      = htmlspecialchars($_POST['proveedor']);
    $codigo     = htmlspecialchars(strtoupper($_POST['codigo']));
    $categ      = htmlspecialchars($_POST['categoria']);
    $nombre     = htmlspecialchars($_POST['nombre']);
    
    $pneto     = htmlspecialchars($_POST['pneto']);
    $pmerma     = htmlspecialchars($_POST['pmerma']);
    
    $hoy        = date('Y-m-d');
    $status     = 'A';
    
    // TIPOS DE MEDIDA
    $cantidad   = htmlspecialchars($_POST['tunidad']); // NUMERO
    $tunidad    = htmlspecialchars($_POST['tipo']);
        
    // DIFERENTES PRECIOS
    $pve = htmlspecialchars($_POST['precio_venta']);
    $pgr = htmlspecialchars($_POST['precio_gr']);
    $plt = htmlspecialchars($_POST['precio_lt']);
    $pkg = htmlspecialchars($_POST['precio_kg']);
    $plb = htmlspecialchars($_POST['precio_lb']);
    
    if ($tunidad == 'Kilos') {
        $ckg = $cantidad;
        $clb = $cantidad * 2.20;
        $cgr = $cantidad * 1000;
        $clt = 0;
        $cun = 0;
    }elseif ($tunidad == 'Libras') {
        $clb = $cantidad;
        $ckg = $cantidad * 0.45;
        $cgr = $cantidad * 453.592;    
        $clt = 0;
        $cun = 0;
    }elseif ($tunidad == 'Litros') {
        $clt = $cantidad;
        $cgr = 0;
        $ckg = 0;
        $clb = 0;
        $cun = 0;
    }elseif ($tunidad == 'Gramos') {
        $cgr = $cantidad;
        $ckg = 0;
        $clb = 0;
        $clt = 0;
        $cun = 0;
    }elseif ($tunidad == 'Unidad'){
        $cun = $cantidad;
        $cgr = 0;
        $ckg = 0;
        $clb = 0;
        $clt = 0;
    }
    
    
   /* for($var=1; $var <= 8; $var++ ) { $barras = rand(1,10000); }
    $one = '1'.$barras;

        echo '<script>
                alert("Error, debe seleccionar la categoria");
                window.location.href = "in.php?cid=mercaderia/frm_mercaderia";
              </script>';*/
              
        // INGRESO DE MERCADERIA CON FOTO DE PRODUCTO
        $nombrearchivo = $_FILES['img']['name'];
        $nombretmparchivo = $_FILES['img']['tmp_name'];
        $ext = substr($nombrearchivo, strrpos($nombrearchivo, '.'));
    
        if (in_array($ext, $formato)) { $nombrearchivo = $nombrearchivo; }else{ $nombrearchivo = 'sinfoto.png'; }        
        if (move_uploaded_file($nombretmparchivo,  "../../init/img/$nombrearchivo")) { }else{}  
        
        $args = DBSTART::abrirDB()->prepare("SELECT * FROM c_mercaderia WHERE codproducto = '$codigo' AND estado = 'A'");
        $args->execute();
        $cann = $args->rowCount();
        
        if ($cann == 0) {
        // Realizar la compra        
        $env = DBSTART::abrirDB()->prepare("INSERT INTO c_mercaderia 
            (id_proveedor, categoria, codproducto, nombreproducto, precio_venta, existencia, ruta, fechacompra, estado, 
                gramo, litro, libra, kilo, pre_gr, pre_lt, pre_lb, pre_kg, tunidad, pneto, pmerma)
            VALUES (:prov, :cate, :codi, :nomb, :pven, :exis, :ruta, :fech, :stat, :cgra, :cltr, :clbr, :cklo, :pgra, :pltr, :plbr, :pklo, :tuni, :pneto, :pmerma)");
            
            $env->bindParam(':prov', $prove,  PDO::PARAM_INT);
            $env->bindParam(':cate', $categ,  PDO::PARAM_INT);
            $env->bindParam(':codi', $codigo, PDO::PARAM_STR);
            $env->bindParam(':nomb', $nombre, PDO::PARAM_STR);
            
            $env->bindParam(':pven', $pve,              PDO::PARAM_STR);
            $env->bindParam(':exis', $cun,              PDO::PARAM_STR);
            $env->bindParam(':ruta', $nombrearchivo,    PDO::PARAM_STR);
            $env->bindParam(':fech', $hoy,              PDO::PARAM_STR);
            $env->bindParam(':stat', $status,           PDO::PARAM_STR);
            
            $env->bindParam(':cgra', $cgr, PDO::PARAM_STR);
            $env->bindParam(':cltr', $clt, PDO::PARAM_STR);
            $env->bindParam(':clbr', $clb, PDO::PARAM_STR);
            $env->bindParam(':cklo', $ckg, PDO::PARAM_STR);
            
            $env->bindParam(':pgra', $pqr, PDO::PARAM_STR);
            $env->bindParam(':pltr', $plt, PDO::PARAM_STR);
            $env->bindParam(':plbr', $plb, PDO::PARAM_STR);
            $env->bindParam(':pklo', $pkg, PDO::PARAM_STR);
            $env->bindParam(':tuni', $tunidad, PDO::PARAM_INT);
            $env->bindParam(':pneto', $pneto, PDO::PARAM_STR);
            $env->bindParam(':pmerma', $pmerma, PDO::PARAM_STR);
            
            if ($env->execute()){
        	   echo '<div class="alert alert-success"> <b>Producto a&ntilde;adido al Inventario!</b> </div>';
                }else{ echo '<div class="alert alert-warning"> <b>Error al guardar el producto!</b> </div>'; }
            }