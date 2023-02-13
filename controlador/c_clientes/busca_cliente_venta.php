<?php
require_once ("../../datos/db/connect.php");
$dato = $_POST['dato'];
$empresa = 1;

//EJECUTAMOS LA CONSULTA DE BUSQUEDA

$registro = DBSTART::abrirDB()->prepare("select * from c_clientes where cedula LIKE '%$dato%' AND id_empresa = '$empresa' and estado = 'A'");
$registro->execute();
$all = $registro->fetchAll(PDO::FETCH_ASSOC);
$cant = $registro->rowCount();
//CREAMOS NUESTRA VISTA Y LA DEVOLVEMOS AL AJAX

echo '<table class="table table-striped table-condensed table-hover">
        	<tr>
              <th>CEDULA</th>
              <th>NOMBRES</th>
              <th>CORREO ELECTRÓNICO</th>
              <th colspan="1">Opc</th>
            </tr>';
if( $cant > 0){
	foreach( (array) $all as $registro2 ){
		echo '<tr>
                <td>'.$registro2['cedula'].'</td>
                <td>'.$registro2['nombres'].'</td>
                <td>'.$registro2['correo'].'</td>
		        <td> <a href="javascript:param('.$registro2['id_cliente'].');"><i style="font-size:25px" class="fa fa-eye"></i></a></td>
			  </tr>';
	}
}else{
	echo '<tr>
				<td colspan="6">No se encontraron resultados</td>
			</tr>';
}
echo '</table>';
?>