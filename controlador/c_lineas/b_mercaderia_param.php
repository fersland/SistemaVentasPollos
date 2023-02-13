<?php
require_once ("../../datos/db/connect.php");
$id = $_POST['id'];

//OBTENEMOS LOS VALORES DEL PRODUCTO

$valores = DBSTART::abrirDB()->prepare("SELECT m.idp, m.codproducto,m.precio_venta,m.existencia,m.bodega
                                            FROM c_mercaderia m
                                            WHERE m.idp = '$id' and m.id_empresa=1 and m.estado='A'");
$valores ->execute();
$all = $valores->fetchAll(PDO::FETCH_ASSOC);

    foreach($all as $value) {
        $datos = array(
        				0 => $value['idp'],
                        1 => $value['codproducto'],
                        2 => $value['precio_venta'],
                        3 => $value['existencia'],
                        4 => $value['bodega'],
                        
                        );
        echo json_encode($datos);
    }
?>