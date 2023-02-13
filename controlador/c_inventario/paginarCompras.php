<?php
    require_once ("../../datos/db/connect.php");
	$paginaActual = $_POST['partida'];    

    $empresa = 1;
    /*
        La primera consulta es para contar todos los datos de la tabla y dividirlos, y asi realizar una serie de paginas de paginador
    */
    $nroProductos = DBSTART::abrirDB()->prepare("select * from c_compra e inner join c_empresa p on e.id_empresa = p.id_empresa 
                                                    where e.id_empresa = '$empresa' and e.estado = 'A'");
    $nroProductos->execute();
    $ncantidad = $nroProductos->rowCount();
    $nroLotes = 1000;
    $nroPaginas = ceil($ncantidad/$nroLotes);
    $lista = '';
    $tabla = '';

    if($paginaActual > 1){
        $lista = $lista.'<li><a href="javascript:pagination('.($paginaActual-1).');">Anterior</a></li>';
    }
    for($i=1; $i<=$nroPaginas; $i++){
        if($i == $paginaActual){
            $lista = $lista.'<li class="active"><a href="javascript:pagination('.$i.');">'.$i.'</a></li>';
        }else{
            $lista = $lista.'<li><a href="javascript:pagination('.$i.');">'.$i.'</a></li>';
        }
    }
    if($paginaActual < $nroPaginas){
        $lista = $lista.'<li><a href="javascript:pagination('.($paginaActual+1).');">Siguiente</a></li>';
    }
  
  	if($paginaActual <= 1){
  		$limit = 0;
  	}else{
  		$limit = $nroLotes*($paginaActual-1);
  	}

    /* Esta segunda consulta, muestra los datos segun la primera lista asignada del paginador*/
  	$registro = DBSTART::abrirDB()->prepare("select * from c_compra e 
                                                inner join c_empresa p on e.id_empresa = p.id_empresa
                                                inner join c_proveedor pv on pv.id_proveedor = e.id_proveedor
                                                where e.id_empresa = '$empresa' 
                                                    and e.estado = 'A'
                                                    ORDER BY e.idc_compra DESC LIMIT $limit, $nroLotes ");
    $registro->execute();
    $all = $registro->fetchAll(PDO::FETCH_ASSOC);
    
  	$tabla = $tabla.'<table class="table table-striped table-condensed table-hover" style="background-color:#f7bf5952">
			            <tr>
                          <th>Factura</th>
                          <th>Proveedor</th>
                          <th>Fecha</th>
                          <th colspan="1">VER</th>
			            </tr>';
	foreach($all as $registro2){
		$tabla = $tabla.'<tr>
                          <td style="font-size:11px">'.$registro2['ncompra'].'</td>
                          <td style="font-size:11px">'.$registro2['nombreproveedor'].'</td>
                          <td style="font-size:11px">'.$registro2['fecha_registro'].'</td>
               
               
                <td>
                <a target="_blank" href="../../../datos/clases/pdf/informe_compras/compra.php?factura='.$registro2['ncompra'].'" ><i class="fa fa-print"></i></a>
               </td>
						  </tr>';		
	}        

    $tabla = $tabla.'</table>';

    $array = array(0 => $tabla,
    			   1 => $lista);

    echo json_encode($array);
?>