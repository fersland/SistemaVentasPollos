<?php 
    require_once ("../../../datos/db/connect.php");
    
    $cantidad   = $_POST['_cant'];
    $cantidadkilos   = $_POST['_cantkilos'];
    $codd       = $_POST['_codigo'];
    $nombrepr   = htmlspecialchars($_POST['nombrepro']);
    $id_form    = htmlspecialchars($_POST['upd_id']);
    $lprove     = htmlspecialchars($_POST['prove']);
    $lcate      = htmlspecialchars($_POST['cate']);
    $precio_venta = htmlspecialchars($_POST['precioventa']);

    $pkg            = htmlspecialchars($_POST['precio_kg']);
    $pkgs           = htmlspecialchars($_POST['precio_kgs']);
    $precio_molleja = htmlspecialchars($_POST['precio_molleja']);
    $precio_pata    = htmlspecialchars($_POST['precio_pata']);
    $precio_higado  = htmlspecialchars($_POST['precio_higado']);
    $tunidad        = htmlspecialchars($_POST['tipo']);

    if (isset($_POST['checko'])) {
        $press = 1;
    }else{
        $press = 2;
    }

    if ($cantidad >= 0) {
        $stmt = DBSTART::abrirDB()->prepare("UPDATE c_mercaderia SET id_proveedor = :proveedor,
                                                                    categoria = :categoria,
                                                                    nombreproducto = :producto,
                                                                    precio_venta = :pventa,
                                                                    existencia = :existencia,
                                                                    kilo = :kilo,
                                                                    pre_kg = :prekg,    
                                                                    pre_kgs = :prekgs,
                                                                    pre_molleja = :molleja,
                                                                    pre_pata = :pata,
                                                                    pre_higado = :higado,
                                                                    tunidad = :tunidad,
                                                                    ok = :okk

                                            WHERE idp=:idp AND estado='A'");

            $stmt->bindParam(':proveedor', $lprove,       PDO::PARAM_INT);
            $stmt->bindParam(':categoria', $lcate,        PDO::PARAM_STR);
            $stmt->bindParam(':producto', $nombrepr,      PDO::PARAM_STR);
            $stmt->bindParam(':pventa', $precio_venta,    PDO::PARAM_STR);
            $stmt->bindParam(':existencia', $cantidad,    PDO::PARAM_STR);
            $stmt->bindParam(':kilo', $cantidadkilos,     PDO::PARAM_STR);
            $stmt->bindParam(':prekg', $pkg,              PDO::PARAM_STR);
            $stmt->bindParam(':prekgs', $pkgs,            PDO::PARAM_STR);
            $stmt->bindParam(':molleja', $precio_molleja, PDO::PARAM_STR);
            $stmt->bindParam(':pata', $precio_pata,       PDO::PARAM_STR);
            $stmt->bindParam(':higado', $precio_higado,   PDO::PARAM_STR);
            $stmt->bindParam(':tunidad', $tunidad,        PDO::PARAM_INT);
            $stmt->bindParam(':okk', $press,              PDO::PARAM_INT);
            $stmt->bindParam(':idp', $id_form,            PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo '<div class="alert alert-success">
                        <b><i class="fa fa-check"></i> Actualizado correctamente.</b>
                    </div>';
            }else{
                echo '<div class="alert alert-danger">
                        <b><i class="fa fa-remove"></i> Error al actualizar.</b>
                      </div>';
            }
     }else{
        echo '<div class="alert alert-danger">
                <b><i class="fa fa-remove"></i> Error, debe ingresar un valor mayor e igual a 0</b>
            </div>';
     }