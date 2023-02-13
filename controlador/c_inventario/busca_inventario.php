<?php

/*
    Se busca desde la base del paginador, la misma estructura, encuentra los datos escritos
*/
require_once ("../../datos/db/connect.php");

$dato = $_POST['dato'];
$empresa = $_SESSION['id_empresa'];

//EJECUTAMOS LA CONSULTA DE BUSQUEDA

$registro = DBSTART::abrirDB()->prepare("select * from c_venta 
                                            WHERE  
                                                    nventa LIKE '%$dato%'
                                                    OR cliente LIKE '%$dato%'
                                                    ORDER BY nventa DESC");
$registro->execute();
$all = $registro->fetchAll(PDO::FETCH_ASSOC);
$cant = $registro->rowCount();
//CREAMOS NUESTRA VISTA Y LA DEVOLVEMOS AL AJAX

echo '<table class="table table-striped table-condensed table-hover">
        	<tr>
                <th>NUMERO</th>
                          <th>MOVIMIENTO</th>
                          <th>CLIENTE</th>
                          <th>IMPORTE</th>
                          <th>FECHA</th> 
            </tr>';
if( $cant > 0){
	foreach( (array) $all as $registro2 ){
		echo '<tr>
                <td>'.$registro2['nventa'].'</td>
                          <td>VENTA</td>
                          <td>'.$registro2['cliente'].'</td>
                          <td>'.$registro2['importe'].'</td>
                          <td>'.$registro2['fecharegistro'].'</td>  
				</tr>';
	}
}else{
	echo '<tr>
				<td colspan="6">No se encontraron resultados</td>
			</tr>';
}
echo '</table>';
?>