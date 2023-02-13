<?php

/*
    Se busca desde la base del paginador, la misma estructura, encuentra los datos escritos
*/
require_once ("../../datos/db/connect.php");

$dato = $_POST['dato'];
$empresa = 1;

//EJECUTAMOS LA CONSULTA DE BUSQUEDA

$registro = DBSTART::abrirDB()->prepare("select * from c_compra e 
                                            inner join c_empresa p on e.id_empresa = p.id_empresa
                                            inner join c_proveedor pv on pv.id_proveedor = e.id_proveedor
      
                                        where
                                                e.ncompra LIKE '%$dato%' AND e.id_empresa = '$empresa' and e.estado = 'A'
                                        OR      pv.nombreproveedor LIKE '%$dato%' AND e.id_empresa = '$empresa' and e.estado = 'A'
                                
                ");
$registro->execute();
$all = $registro->fetchAll(PDO::FETCH_ASSOC);
$cant = $registro->rowCount();
//CREAMOS NUESTRA VISTA Y LA DEVOLVEMOS AL AJAX

echo '<table class="table table-striped table-condensed table-hover" style="background-color:#f7bf5952">
        	<tr>
                <th>Factura</th>
                <th>Proveedor</th>
                <th>Total</th>
                <th>Fecha</th>
                <th colspan="2">Opc</th>
            </tr>';
if( $cant > 0){
	foreach( (array) $all as $registro2 ){
		echo '<tr>
				<td>'.$registro2['ncompra'].'</td>
                          <td>'.$registro2['nombreproveedor'].'</td>
                          <td>'.$registro2['total'].'</td>
                          <td>'.$registro2['fecha_registro'].'</td>
               
                <td>
                <a href="../app/compras/frm_compras_act.php?cid='.$registro2['ncompra'].'" ><i class="fa fa-edit"></i> Actualizar</a>&nbsp;
                <a href="../app/compras/frm_compras_total_eli.php?cid='.$registro2['ncompra'].'" ><i class="fa fa-trash"></i> Eliminar</a>&nbsp;
                <a target="_blank" href="../../../datos/clases/pdf/informe_compras/compra.php?factura='.$registro2['ncompra'].'" ><i class="fa fa-print"></i> Ver Compra</a>
               </td>
		      </tr>';
	}
}else{
	echo '<tr>
				<td colspan="6">No se encontraron resultados</td>
			</tr>';
}
echo '</table>';
?>