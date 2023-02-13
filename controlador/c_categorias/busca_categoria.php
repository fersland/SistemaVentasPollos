<?php

/*
    Se busca desde la base del paginador, la misma estructura, encuentra los datos escritos
*/
require_once ("../../datos/db/connect.php");

$dato = $_POST['dato'];
$empresa = $_SESSION['id_empresa'];

//EJECUTAMOS LA CONSULTA DE BUSQUEDA

$registro = DBSTART::abrirDB()->prepare("SELECT * FROM c_categoria e INNER JOIN c_empresa p ON p.id_empresa = e.id_empresa
    WHERE p.id_empresa = 1 AND e.estado = 'A' AND e.nombre LIKE '%$dato%' ORDER BY e.id_categoria ASC");
$registro->execute();
$all = $registro->fetchAll(PDO::FETCH_ASSOC);
$cant = $registro->rowCount();
//CREAMOS NUESTRA VISTA Y LA DEVOLVEMOS AL AJAX

echo '<table class="table table-striped table-condensed table-hover">
        	<tr>
            	<th>Nombre</th>
                <th>Fecha Ingreso</th>
                <th colspan="3">Opciones</th>
            </tr>';
if( $cant > 0){
	foreach( (array) $all as $registro2 ){
		echo '<tr>
				<td>'.$registro2['nombre'].'</td>
				<td>'.$registro2['fecha_registro'].'</td>
				<td><a href="../app/categoria/frm_categoria_act.php?cid='.$registro2['id_categoria'].'" <i class="fa fa-edit"></i></a></td>
                <td><a href="../app/categoria/frm_categoria_eli.php?cid='.$registro2['id_categoria'].'" ><i class="fa fa-trash"></i></a></td>
               <td> <a href="javascript:editarProducto('.$registro2['id_categoria'].');"><i class="fa fa-eye"></i></a></td>
				</tr>';
	}
}else{
	echo '<tr>
				<td colspan="6">No se encontraron resultados</td>
			</tr>';
}
echo '</table>';
?>