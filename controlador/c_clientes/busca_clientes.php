<?php

/*
    Se busca desde la base del paginador, la misma estructura, encuentra los datos escritos
*/
require_once ("../../datos/db/connect.php");

$dato = $_POST['dato'];
//$empresa = $_SESSION['id_empresa'];

//EJECUTAMOS LA CONSULTA DE BUSQUEDA

$registro = DBSTART::abrirDB()->prepare("SELECT * FROM c_clientes e 
                                            INNER JOIN c_empresa p ON p.id_empresa = e.id_empresa
                            WHERE  
                                    e.nombres LIKE '%$dato%' AND p.id_empresa = 1 AND e.estado = 'A'
                            OR
                                    e.cedula LIKE '%$dato%' AND p.id_empresa = 1 AND e.estado = 'A'
                            OR
                                    e.correo LIKE '%$dato%' AND p.id_empresa = 1 AND e.estado = 'A'
                            OR
                                    e.celular LIKE '%$dato%' AND p.id_empresa = 1 AND e.estado = 'A'
                            ORDER BY e.id_cliente ASC");
$registro->execute();
$all = $registro->fetchAll(PDO::FETCH_ASSOC);
$cant = $registro->rowCount();
//CREAMOS NUESTRA VISTA Y LA DEVOLVEMOS AL AJAX

echo '<table class="table table-striped table-condensed table-hover">
        	<tr>
            	<th>C&eacute;dula</th>
                          <th>Nombres</th>
                          <th>Correo</th>
                          <th>Tel&eacute;fono</th>
                          <th>Celular</th>
                          <th>Visitas</th>
                          <th>Ultima Visita</th>
                          <th colspan="3">Opciones</th>
            </tr>';
if( $cant > 0){
	foreach( (array) $all as $registro2 ){
	   if ($registro2['fecha_modificacion'] == "") {
            $data = $registro2['fecha_registro'];
        }else{
            $data = $registro2['fecha_modificacion'];
        }
		echo '<tr>
				<td>'.$registro2['cedula'].'</td>
                          <td>'.$registro2['nombres'].'</td>
                          <td>'.$registro2['correo'].'</td>
                          <td>'.$registro2['telefono'].'</td> 
                          <td>'.$registro2['celular'].'</td>
                          <td>'.$registro2['nveces'].'</td>
                          <td>'.$data.'</td>
              
		        <td><a href="../app/clientes/frm_clientes_act.php?cid='.$registro2['id_cliente'].'" <i class="fa fa-edit"></i></a></td>
                <td><a href="../app/clientes/frm_clientes_eli.php?cid='.$registro2['id_cliente'].'" ><i class="fa fa-trash"></i></a></td>
               <td data-toggle="modal" data-target="#myModal2"> <a href="javascript:editarProducto('.$registro2['id_cliente'].');"><i class="fa fa-eye"></i></a></td>
				</tr>';
	}
}else{
	echo '<tr>
				<td colspan="6">No se encontraron resultados</td>
			</tr>';
}
echo '</table>';
?>