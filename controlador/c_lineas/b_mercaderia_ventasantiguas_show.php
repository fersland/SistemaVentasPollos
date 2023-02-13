<?php
require_once ("../../datos/db/connect.php");
$id = $_POST['id'];

//OBTENEMOS LOS VALORES DEL PRODUCTO

$valores = DBSTART::abrirDB()->prepare("SELECT m.codproducto, m.nombreproducto,m.precio_venta,m.existencia, m.gramo, m.litro, m.libra, m.kilo,
                                            m.pre_lt, m.pre_kg, m.pre_lb, m.pre_gr, m.sucursal, m.categoria, m.pmerma, m.ncompra, m.cajas, m.positivo
                                            FROM c_mercaderia m
                                            WHERE m.idp = '$id' AND m.estado='A'");
$valores ->execute();
$all = $valores->fetchAll(PDO::FETCH_ASSOC);

    foreach( (array) $all as $value) {
        $datos = array(
                        0 => $value['codproducto'],
                        1 => $value['precio_venta'],
                        2 => $value['existencia'],
                        3 => $value['categoria'],
                        4 => $value['gramo'],
                        5 => $value['litro'],
                        6 => $value['libra'],
                        7 => $value['kilo'],                        
                        8 => $value['pre_lt'],
                        9 => $value['pre_kg'],
                        10 => $value['pre_lb'],
                        11 => $value['pre_gr'],
                        12 => $value['sucursal'],
                        13 => $value['categoria'],
                        14 => $value['pmerma'],
                        15 => $value['ncompra'],
                        16 => $value['cajas'],
                        17 => $value['positivo']
                        
                        
                        );
        echo json_encode($datos);
    }
?>