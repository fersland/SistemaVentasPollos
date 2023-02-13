<?php
require_once ("../../datos/db/connect.php");

$id = $_POST['id'];

//OBTENEMOS LOS VALORES DEL PRODUCTO

$valores = DBSTART::abrirDB()->prepare("SELECT * FROM c_empresa WHERE id_empresa = '$id' and est_empresa='A'");
$valores ->execute();
$all = $valores->fetchAll(PDO::FETCH_ASSOC);

    foreach($all as $value) {
        $datos = array(
                        0 => $value['id_pais'],
                        1 => $value['id_provincia'],
        				2 => $value['id_ciudad'],
                        3 => $value['ruc_empresa'],
                        4 => $value['nom_empresa'],
                        5 => $value['direcc_empresa'],
                        6 => $value['telf_empresa'],
                        7 => $value['mail_empresa'],
                        
                       
        				);
        echo json_encode($datos);
    }
?>