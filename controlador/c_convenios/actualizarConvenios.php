<?php
	require_once ("../../../datos/db/connect.php");

	$idp = htmlspecialchars($_POST['idp']);    

    $punidad = htmlspecialchars($_POST['punidad']);

    $pkilo = htmlspecialchars($_POST['pkilo']);

    $caduca = htmlspecialchars($_POST['caduca']);

    $cantkilo = htmlspecialchars($_POST['cantkilo']);
    
    $catel = htmlspecialchars($_POST['catel']);    

    $codconvenio = htmlspecialchars($_POST['codconvenio']);

    $random = rand(10000, 99999);    

    // AGREGAR EL CODIGO PROMOCIONAL AL CLIENTE

    $stmt = DBSTART::abrirDB()->prepare("UPDATE c_convenios SET pnuevo='$punidad', pkilo='$pkilo' WHERE id = '$idp' ");
        if ($stmt->execute()) {

            echo '<div class="alert alert-success">
                <b><i class="fa fa-check"></i> El Convenio se ha actualizado correctamente.</b>
                </div>';
                    /*$generarcod = $db->prepare("UPDATE c_clientes SET codigo = '$random' WHERE cedula = '$clienteid'");
                    $generarcod->execute();*/
        }else{
            echo '<div class="alert alert-warning">
                <b><i class="fa fa-reverse"></i> El Convenio no se actualizo.</b>
                </div>';
        }