<?php
require_once ("../../datos/db/connect.php");

$id = $_POST['id'];

//OBTENEMOS LOS VALORES DEL PRODUCTO

$valores = DBSTART::abrirDB()->prepare("SELECT 
    p.id_proveedor, m.ncompra,  m.codproducto, id_categoria, m.bodega,m.percha, m.nombreproducto, 
    m.aceite_presentacion,m.cantidad_litros, m.filtro, m.aceite, m.existencia,m.viscosidad, 
    m.fechacompra, m.marca,m.medida, m.precio_venta, m.observacion,m.precio_venta_litro
                        
                            FROM c_mercaderia m                        
                                left JOIN c_categoria c ON c.id_categoria = m.categoria
                                left JOIN c_proveedor p ON p.id_proveedor = m.id_proveedor  
                                    WHERE m.idp = '$id' and m.id_empresa=1 and m.estado='A'");
$valores ->execute();
$all = $valores->fetchAll(PDO::FETCH_ASSOC);

    foreach($all as $value) {
        $datos = array(
                        0 => $value['id_proveedor'],
                        1 => $value['ncompra'],
                        2 => $value['codproducto'],
        				3 => $value['id_categoria'],
                        4 => $value['bodega'],
                        5 => $value['percha'],
                        6 => $value['nombreproducto'],
                        
                        7 => $value['aceite_presentacion'],
                        8 => $value['cantidad_litros'],
                        9 => $value['filtro'],
                        10 => $value['aceite'],
                        11 => $value['existencia'],
                        12 => $value['viscosidad'],
                        
                        13 => $value['marca'],
                        14 => $value['medida'],                 
                        15 => $value['precio_venta'],
                        16 => $value['observacion'],
                        17 => $value['precio_venta_litro'],
                        );
        echo json_encode($datos);
    }
?>