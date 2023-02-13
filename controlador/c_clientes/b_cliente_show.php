<?php
require_once ("../../datos/db/connect.php");

$id = $_POST['id'];

//OBTENEMOS LOS VALORES DEL PRODUCTO

$valores = DBSTART::abrirDB()->prepare("SELECT * FROM c_clientes WHERE id_cliente = '$id'");
$valores ->execute();
$all = $valores->fetchAll(PDO::FETCH_ASSOC);

    foreach($all as $value) {
        $datos = array(
                        0 => $value['cedula'],
                        1 => $value['nombres'],
                        2 => $value['correo'],
                        3 => $value['celular'],
                        4 => $value['direccion_cliente'],               
        				);
        echo json_encode($datos);
    }
?>