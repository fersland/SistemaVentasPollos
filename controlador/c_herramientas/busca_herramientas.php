<?php

/*
    Se busca desde la base del paginador, la misma estructura, encuentra los datos escritos
*/
require_once ("../../datos/db/connect.php");

$dato = $_POST['dato'];
$empresa = 1;

//EJECUTAMOS LA CONSULTA DE BUSQUEDA

$registro = DBSTART::abrirDB()->prepare("select * from c_herramientas a 
                                            inner join c_empresa e on e.id_empresa = a.id_empresa
      
        where 
                a.codigo LIKE '%$dato%' AND a.id_empresa = '$empresa' and a.estado = 'A'
                OR a.descripcion LIKE '%$dato%' AND a.id_empresa = '$empresa' and a.estado = 'A'
                OR a.proveedor LIKE '%$dato%' AND a.id_empresa = '$empresa' and a.estado = 'A'        
        ");
                
$registro->execute();
$all = $registro->fetchAll(PDO::FETCH_ASSOC);
$cant = $registro->rowCount();
//CREAMOS NUESTRA VISTA Y LA DEVOLVEMOS AL AJAX

echo '<table class="table table-striped table-condensed table-hover">
        	<tr>
                <th>Codigo</th>
                <th>Proveedor</th>
                <th>Fecha Adquirido</th>
                <th>Descripcion</th>
                <th>Valor</th>
                <th>Estado Fisico</th>
                <th>Persona Responsable</th>
                <th colspan="3">Ver</th>
            </tr>';
if( $cant > 0){
	foreach( (array) $all as $registro2 ){
		echo '<tr>
				<td>'.$registro2['codigo'].'</td>
                <td>'.$registro2['proveedor'].'</td>
                <td>'.$registro2['fecha_adq'].'</td>
                <td>'.$registro2['descripcion'].'</td>
                <td>'.$registro2['valor'].'</td>
                <td>'.$registro2['estado_fisico'].'</td>                
                <td>'.$registro2['persona_resp'].'</td>
		          <td><a href="../app/herramientas/frm_herramientas_act.php?cid='.$registro2['id_herramientas'].'" <i class="fa fa-edit"></i></a></td>
                            <td><a href="../app/herramientas/frm_herramientas_eli.php?cid='.$registro2['id_herramientas'].'" ><i class="fa fa-trash"></i></a></td>
                            <td> <a href="javascript:editarProducto('.$registro2['id_herramientas'].');"><i class="fa fa-eye"></i></a></td>
				</tr>';
	}
}else{
	echo '<tr>
				<td colspan="6">No se encontraron resultados</td>
			</tr>';
}
echo '</table>';
?>