<?php
require_once ("../../datos/db/connect.php");
$id = $_POST['id'];

//OBTENEMOS LOS VALORES DEL PRODUCTO

$valores = DBSTART::abrirDB()->prepare("SELECT m.codproducto, m.nombreproducto,m.precio_venta,m.existencia, m.gramo, m.litro, m.libra, m.kilo,
                                            m.pre_lt, m.pre_kg, m.pre_lb, m.pre_gr, c.nombre as ncategoria, p.nombreproveedor
                                            FROM c_mercaderia m
                                                INNER JOIN c_categoria c ON c.nombre = m.categoria
                                                INNER JOIN c_proveedor p ON m.id_proveedor = p.id_proveedor
                                            WHERE m.idp = '$id' AND m.estado='A'");
$valores ->execute();
$all = $valores->fetchAll(PDO::FETCH_ASSOC);

    foreach($all as $value) {
        $datos = array(
                        0 => $value['codproducto'],
                        1 => $value['precio_venta'],
                        2 => $value['existencia'],
                        3 => $value['nombreproducto'],
                        4 => $value['gramo'],
                        5 => $value['litro'],
                        6 => $value['libra'],
                        7 => $value['kilo'],                        
                        8 => $value['pre_lt'],
                        9 => $value['pre_kg'],
                        10 => $value['pre_lb'],
                        11 => $value['pre_gr'],
                        12 => $value['ncategoria'],
                        13 => utf8_decode($value['nombreproveedor'])
                        
                        );
        echo json_encode($datos);
    }
?>