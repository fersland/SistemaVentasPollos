<?php
require_once ("../../datos/db/connect.php");

$id = $_POST['id'];

//OBTENEMOS LOS VALORES DEL PRODUCTO

$valores = DBSTART::abrirDB()->prepare("SELECT * FROM c_mercaderia WHERE codproducto = '$id' and estado='A'");
$valores ->execute();
$all = $valores->fetchAll(PDO::FETCH_ASSOC);

    foreach($all as $value) {
        $datos = array(
                        0 => $value['nombreproducto'],
                        1 => $value['ruta'],
        				);
        echo json_encode($datos);
    }
?>