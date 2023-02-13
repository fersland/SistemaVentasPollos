<?php

/*
    Se busca desde la base del paginador, la misma estructura, encuentra los datos escritos
*/
require_once ("../../datos/db/connect.php");

$dato = $_POST['dato'];
$empresa = $_SESSION['id_empresa'];

//EJECUTAMOS LA CONSULTA DE BUSQUEDA

$registro = DBSTART::abrirDB()->prepare("SELECT * FROM c_mercaderia e inner join c_empresa p on p.id_empresa = e.id_empresa
    WHERE p.id_empresa = 1 AND e.estado = 'A' AND e.nombreproducto LIKE '%$dato%' ORDER BY e.idp DESC");
$registro->execute();
$all = $registro->fetchAll(PDO::FETCH_ASSOC);
$cant = $registro->rowCount();
//CREAMOS NUESTRA VISTA Y LA DEVOLVEMOS AL AJAX

echo '<table class="table table-striped table-condensed table-hover">
        	<tr>
                <th>Código</th>
                          <th>Nombre</th>
                          <th>Imagen</th>
                          <th colspan="3">Opciones</th>
            </tr>';
if( $cant > 0){
	foreach( (array) $all as $registro2 ){
		echo '<tr>
				<td>'.$registro2['codproducto'].'</td>
                          <td>'.$registro2['nombreproducto'].'</td>
    <td><img src="../../img/'. $registro2['ruta'].'" style="border: 3px solid gray; padding: 5px; width: 10%" /></td>
              
		        <td><a href="../app/imagen_producto/frm_imagen_act.php?cid='.$registro2['codproducto'].'" <i class="fa fa-edit"></i></a></td>
                <td><a href="../app/imagen_producto/frm_imagen_eli.php?cid='.$registro2['codproducto'].'" ><i class="fa fa-trash"></i></a></td>
				</tr>';
	}
}else{
	echo '<tr>
				<td colspan="6">No se encontraron resultados</td>
			</tr>';
}
echo '</table>';
?>