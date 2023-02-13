<?php
require_once ("../../datos/db/connect.php");
$id = $_POST['id'];

//OBTENEMOS LOS VALORES DEL PRODUCTO

$valores = DBSTART::abrirDB()->prepare("SELECT id_cliente, cedula, nombres
                                            FROM c_clientes
                                            WHERE id_cliente = '$id' and estado='A'");
$valores ->execute();
$all = $valores->fetchAll(PDO::FETCH_ASSOC);

    foreach($all as $value) {
        $datos = array(
                        0 => $value['id_cliente'],
                        1 => $value['cedula'],
                        2 => $value['nombres']
                        );
        echo json_encode($datos);
    }
?>