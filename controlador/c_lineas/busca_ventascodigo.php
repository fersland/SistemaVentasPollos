<?php
require_once ("../../datos/db/connect.php");

$dato = $_POST['dato'];
//EJECUTAMOS LA CONSULTA DE BUSQUEDA

$registro = DBSTART::abrirDB()->prepare("select * from c_mercaderia m
                inner join c_categoria cc on cc.id_categoria = m.categoria
                inner join c_proveedor p on p.id_proveedor = m.id_proveedor
                                 where
                                 m.nombreproducto LIKE '%$dato%' AND m.estado = 'A'");
$registro->execute();
$all = $registro->fetchAll(PDO::FETCH_ASSOC);
$cant = $registro->rowCount();
//CREAMOS NUESTRA VISTA Y LA DEVOLVEMOS AL AJAX

echo '<table class="table table-striped table-condensed table-hover">
        	<tr>
                <th>C&oacute;digo</th>
                          <th>PROVEEDOR</th>
                          <th>CATEGORIA</th>
                          <th>DESCRIPCIÓN</th>
                          <th>STOCK</th>
                          <th></th>
            </tr>';
if( $cant > 0){
	foreach( (array) $all as $registro2 ){
		echo '<tr>
				<td>'.$registro2['codproducto'].'</td>
                <td>'.$registro2['nombreproveedor'].'</td>
                <td>'.$registro2['nombre'].'</td>
                <td>'.$registro2['nombreproducto'].'</td>
                <td>'.$registro2['existencia'].'</td>
		          <td> <a href="javascript:editarProducto('.$registro2['idp'].');"><i style="font-size:35px" class="glyphicon glyphicon-heart-empty
"></i></a></td>
				</tr>';
	}
}else{
	echo '<tr>
				<td colspan="6">No se encontraron resultados</td>
			</tr>';
}
echo '</table>';
?>