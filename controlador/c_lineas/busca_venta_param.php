<?php

/*
    Se busca desde la base del paginador, la misma estructura, encuentra los datos escritos
*/
require_once ("../../datos/db/connect.php");
//$db = new PDO('mysql:host=localhost;dbname=expricei_tecnicentro_produccion', 'expricei_exprice', 'expriceitec2019!');

$dato = $_POST['dato'];
$empresa = 1;

//EJECUTAMOS LA CONSULTA DE BUSQUEDA

$registro = DBSTART::abrirDB()->prepare("select * from c_mercaderia e 
                inner join c_empresa p on e.id_empresa = p.id_empresa 
                inner join c_categoria cc on cc.id_categoria = e.categoria
                                 where
                                                        e.codproducto LIKE '%$dato%' AND e.id_empresa = '$empresa' and e.estado = 'A'
                                                        OR e.nombreproducto LIKE '%$dato%' AND e.id_empresa = '$empresa' and e.estado = 'A'
                                                        OR e.marca LIKE '%$dato%' AND e.id_empresa = '$empresa' and e.estado = 'A'
                                                        OR cc.nombre LIKE '%$dato%' AND e.id_empresa = '$empresa' and e.estado = 'A'
                                                        OR e.bodega = '%$dato%' AND e.id_empresa = '$empresa' and e.estado = 'A'
                                                        ");
$registro->execute();
$all = $registro->fetchAll(PDO::FETCH_ASSOC);
$cant = $registro->rowCount();
//CREAMOS NUESTRA VISTA Y LA DEVOLVEMOS AL AJAX

echo '<table class="table table-striped table-condensed table-hover">
        	<tr>
                <th>C&oacute;digo</th>
                          <th>Marca</th>
                          <th>Categoria</th>
                          <th>Nombre</th>
                          <th>Bod</th>
                          <th colspan="1">Opc</th>
            </tr>';
if( $cant > 0){
	foreach( (array) $all as $registro2 ){
		echo '<tr>
				<td>'.$registro2['codproducto'].'</td>
                <td>'.$registro2['marca'].'</td>
                <td>'.$registro2['nombre'].'</td>
                <td>'.$registro2['nombreproducto'].'</td>
                <td>'.$registro2['bodega'].'</td>
		          <td> <a href="javascript:editarProducto('.$registro2['idp'].');"><i class="fa fa-eye"></i></a></td>
				</tr>';
	}
}else{
	echo '<tr>
				<td colspan="6">No se encontraron resultados</td>
			</tr>';
}
echo '</table>';
?>