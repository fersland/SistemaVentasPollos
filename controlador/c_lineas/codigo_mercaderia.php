<?php
require_once ("../../datos/db/connect.php");
$id = $_POST['id'];

//OBTENEMOS LOS VALORES DEL PRODUCTO

$valores = DBSTART::abrirDB()->prepare("SELECT m.codproducto, m.nombreproducto,m.precio_compra, c.id_categoria, m.precio_venta
                                            FROM c_mercaderia m INNER JOIN c_categoria c ON c.id_categoria = m.categoria
                                            WHERE m.idp = '$id' AND m.estado='A'");
$valores ->execute();
$all = $valores->fetchAll(PDO::FETCH_ASSOC);

    foreach($all as $value) {
        $datos = array(
                        0 => $value['codproducto'],
                        1 => $value['precio_compra'],
                        2 => $value['id_categoria'],
                        3 => $value['nombreproducto'],
                        4 => $value['precio_venta'],
                        
                        );
        echo json_encode($datos);
    }
?>