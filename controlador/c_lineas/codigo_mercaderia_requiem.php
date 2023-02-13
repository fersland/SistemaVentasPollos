<?php
require_once ("../../datos/db/connect.php");
$id = $_POST['id'];

//OBTENEMOS LOS VALORES DEL PRODUCTO

$valores = DBSTART::abrirDB()->prepare("SELECT m.idp, m.nombreproducto
                                            FROM c_mercaderia m
                                            WHERE m.idp = '$id' AND m.estado='A'");
$valores ->execute();
$all = $valores->fetchAll(PDO::FETCH_ASSOC);

    foreach($all as $value) {
        $datos = array(
                        0 => $value['idp'],
                        1 => $value['nombreproducto'],
                        
                        );
        echo json_encode($datos);
    }
?>