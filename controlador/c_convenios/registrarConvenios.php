<?php 

	require_once ("../../../datos/db/connect.php");
 	$coder = htmlspecialchars($_POST['coder']);

    $cliente = htmlspecialchars($_POST['cliente']);

    $idp = htmlspecialchars($_POST['idp']);    

    $punidad = htmlspecialchars($_POST['punidad']);

    $pkilo = htmlspecialchars($_POST['pkilo']);    

    $cantkilo = htmlspecialchars($_POST['cantkilo']);

    $nombreproducto = htmlspecialchars($_POST['nombreproducto']);

    $cantexistencia = htmlspecialchars($_POST['cantexistencia']);
    
    $catel = htmlspecialchars($_POST['catel']);    

    $codconvenio = htmlspecialchars($_POST['codconvenio']);

    $caduca = htmlspecialchars($_POST['fechacaduca']);

    $random = rand(10000, 99999);    

    // AGREGAR EL CODIGO PROMOCIONAL AL CLIENTE



    $consultar = DBSTART::abrirDB()->prepare("SELECT * FROM c_convenios WHERE cliente = '$cliente' AND producto='$idp'");

    $consultar->execute();

    $canter = $consultar->rowCount();

            

    if ($canter == 0) {

        $stmt = DBSTART::abrirDB()->prepare("INSERT INTO c_convenios 

                            (id_empresa, producto, codigo, nombreproducto, cant_unit, cant_kg, cliente,
                             pnuevo, pkilo, fechacaduca, id_estado, categoria)

                    VALUES

                            (1, '$idp', '$coder', '$nombreproducto', '$cantexistencia', '$cantkilo', '$cliente', '$punidad', '$pkilo', '$caduca', 1, '$catel')");

                

                if ($stmt->execute()) {

                    echo '<div class="alert alert-success">

                                <b><i class="fa fa-check"></i> Nuevo Convenio Agregado Correctamente.</b>

                            </div>';

                    }else{

                        echo '<div class="alert alert-warning">

                                <b><i class="fa fa-remove"></i> Error al procesar.</b>

                              </div>';

                    }

    }

     ?>