<?php

require_once ("../../datos/db/connect.php");

$id = $_POST['id'];

//OBTENEMOS LOS VALORES DEL PRODUCTO

$valores = DBSTART::abrirDB()->prepare("SELECT t1.producto, t1.codigo, t1.categoria, t1.cant_unit, t1.cant_kg, t1.pnuevo, t1.pkilo, t4.cajas, t1.categoria, t3.cedula, t3.nombres

                                    FROM c_convenios t1 

                                         INNER JOIN c_mercaderia t4 ON t1.producto = t4.idp

                                        INNER JOIN c_clientes t3 ON t3.cedula = t1.cliente

                                        WHERE t1.id='$id' AND t1.id_estado = 1");

$valores ->execute();

$all = $valores->fetchAll(PDO::FETCH_ASSOC);



    foreach($all as $value) {

        $datos = array(

                                    0 => $value['producto'],

                                    1 => $value['codigo'],

                                    2 => $value['categoria'],

                                    3 => $value['cant_unit'],

                                    4 => $value['pnuevo'],

                                    5 => $value['pkilo'],

                                    6 => $value['cant_kg'],

                                    7 => $value['cajas'],

                                    8 => $value['categoria'],

                                    9 => $value['cedula'],
                                    10 => $value['nombres']

                        

                        );

        echo json_encode($datos);

    }