<?php
require_once ("../../datos/db/connect.php");
$id = $_POST['id'];

//OBTENEMOS LOS VALORES DEL PRODUCTO

$valores = DBSTART::abrirDB()->prepare("SELECT nombre, observacion FROM c_categoria
                                            WHERE nombre = '$id' AND estado='A'");
$valores ->execute();
$all = $valores->fetchAll(PDO::FETCH_ASSOC);

    foreach($all as $value) {
        $datos = array(
                            0 => $value['nombre'],
                            1 => $value['observacion']
                        
                        );
        echo json_encode($datos);
    }
?>