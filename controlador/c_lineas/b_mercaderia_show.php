<?php
require_once ("../../datos/db/connect.php");

$id = $_POST['id'];

//OBTENEMOS LOS VALORES DEL PRODUCTO

$valores = DBSTART::abrirDB()->prepare("SELECT 
                 c.id_categoria, m.codproducto, m.bodega, m.nombreproducto, m.aceite_presentacion,m.cantidad_litros, 
                    m.filtro, m.aceite, m.viscosidad, m.fechacompra, m.marca,m.medida,
                        m.existencia, m.precio_venta, m.observacion,m.ruta
                        
                            FROM c_mercaderia m                        
                                INNER JOIN c_categoria c ON c.id_categoria = m.categoria 
                                    WHERE m.idp = '$id' and m.id_empresa=1 and m.estado='A'");
$valores ->execute();
$all = $valores->fetchAll(PDO::FETCH_ASSOC);

    foreach($all as $value) {
        $datos = array(
                        0 => $value['id_categoria'],
        				1 => $value['codproducto'],
                        2 => $value['bodega'],
                        3 => $value['nombreproducto'],
                        
                        4 => $value['aceite_presentacion'],
                        5 => $value['cantidad_litros'],
                        
                        6 => $value['filtro'],
                        7 => $value['aceite'],
                        8 => $value['viscosidad'], // nuevo
                        9 => $value['fechacompra'], // nuevo
                        10 => $value['marca'],
                        11 => $value['medida'],
                        12 => $value['existencia'],
                        13 => $value['precio_venta'],
                        14 => $value['observacion'],
                        15 => $value['ruta'],
                        );
        echo json_encode($datos);
    }
?>