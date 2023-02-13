<?php
require_once ("../../datos/db/connect.php");
$id = $_POST['id'];

//OBTENEMOS LOS VALORES DEL PRODUCTO

$valores = DBSTART::abrirDB()->prepare("SELECT m.codproducto, m.nombreproducto,m.entrada, m.estado, m.idp
                                            FROM c_mercaderia m
                                            WHERE m.idp = '$id' AND m.estado='A'");
$valores ->execute();
$all = $valores->fetchAll(PDO::FETCH_ASSOC);

    foreach($all as $value) {
        $datos = array(
                        0 => $value['codproducto'],
                        1 => $value['nombreproducto'],
                        2 => $value['entrada']
                        );
        echo json_encode($datos);
    }
?>