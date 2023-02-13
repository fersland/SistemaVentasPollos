<?php

/*
    Se busca desde la base del paginador, la misma estructura, encuentra los datos escritos
*/
require_once ("../../datos/db/connect.php");

$dato = $_POST['dato'];
$empresa = $_SESSION['id_empresa'];

//EJECUTAMOS LA CONSULTA DE BUSQUEDA

$registro = DBSTART::abrirDB()->prepare("SELECT * FROM c_empresa WHERE est_empresa = 'A' AND nom_empresa LIKE '%$dato%' OR ruc_empresa LIKE '$dato%' ORDER BY id_empresa ASC");
$registro->execute();
$all = $registro->fetchAll(PDO::FETCH_ASSOC);
$cant = $registro->rowCount();
//CREAMOS NUESTRA VISTA Y LA DEVOLVEMOS AL AJAX

echo '<table class="table table-striped table-condensed table-hover">
        	<tr>
            	<th>Ruc</th>
                <th>Nombre</th>
                <th>telefono</th>
                <th>Correo</th>
                <th colspan="3">Opciones</th>
            </tr>';
if( $cant > 0){
	foreach( (array) $all as $registro2 ){
		echo '<tr>
				<td>'.$registro2['ruc_empresa'].'</td>
				<td>'.$registro2['nom_empresa'].'</td>
				<td>'.$registro2['telf_empresa'].'</td>
				<td>'.$registro2['mail_empresa'].'</td>
				<td><a href="../app/empresa/frm_empresa_act.php?cid='.$registro2['id_empresa'].'" <i class="fa fa-edit"></i></a></td>
                <td><a href="../app/empresa/frm_empresa_eli.php?cid='.$registro2['id_empresa'].'" ><i class="fa fa-trash"></i></a></td>
		          <td> <a href="javascript:editarProducto('.$registro2['id_empresa'].');"><i class="fa fa-eye"></i></a></td>
				</tr>';
	}
}else{
	echo '<tr>
				<td colspan="6">No se encontraron resultados</td>
			</tr>';
}
echo '</table>';
?>