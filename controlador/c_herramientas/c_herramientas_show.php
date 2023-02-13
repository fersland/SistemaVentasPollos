<?php
require_once ("../../datos/db/connect.php");

$id = $_POST['id'];

//OBTENEMOS LOS VALORES DEL PRODUCTO

$valores = DBSTART::abrirDB()->prepare("SELECT 
proveedor,fecha_adq,numero_factura,descripcion,valor,estado_fisico,ubicacion_fisica,codigo,persona_resp,cantidad,observacion
                        
                            FROM c_herramientas WHERE id_herramientas = '$id' and id_empresa=1 and estado='A'");
$valores ->execute();
$all = $valores->fetchAll(PDO::FETCH_ASSOC);

    foreach($all as $value) {
        $datos = array(
                        0 => $value['proveedor'],
                        1 => $value['fecha_adq'],
                        2 => $value['numero_factura'],
        				3 => $value['descripcion'],
                        4 => $value['valor'],
                        5 => $value['estado_fisico'],
                        6 => $value['ubicacion_fisica'],                        
                        7 => $value['codigo'],
                        8 => $value['persona_resp'],
                        9 => $value['cantidad'],
                        10 => $value['observacion'],
                        );
        echo json_encode($datos);
    }
?>