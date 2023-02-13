<?php
	include('conexion.php');
	$paginaActual = $_POST['partida'];

    $nroProductos = mysql_num_rows(mysql_query("select mi.idcm, r.nombrerol, m.nombremodulo, mi.nombreitem, mi.estado, mi.fecha_registro
                      from c_modulos_items mi
                      inner join c_modulos m on m.idmodulo = mi.idmodulo
                      inner join c_roles r on r.idrol = mi.nivelacceso"));
    $nroLotes = 4;
    $nroPaginas = ceil($nroProductos/$nroLotes);
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

  	$registro = mysql_query("select mi.idcm, r.nombrerol, m.nombremodulo, mi.nombreitem, mi.estado, mi.fecha_registro
                      from c_modulos_items mi
                      inner join c_modulos m on m.idmodulo = mi.idmodulo
                      inner join c_roles r on r.idrol = mi.nivelacceso LIMIT $limit, $nroLotes ");


  	$tabla = $tabla.'<table class="table table-striped table-condensed table-hover">
			            <tr>
			                <th width="300">MODULO</th>
			                <th width="200">NIVEL ACCESO</th>
			                <th width="150">PERMISO A</th>
			                <th width="150">FECHA ASIGNADO</th>
			                <th width="150">ESTADO</th>
			                <th width="50">OPCION</th>
			            </tr>';
				
	while($registro2 = mysql_fetch_array($registro)){
		$tabla = $tabla.'<tr>
							<td>'.$registro2['nombremodulo'].'</td>
							<td>'.$registro2['nombrerol'].'</td>
							<td>'.$registro2['nombreitem'].'</td>
							<td>'.$registro2['fecha_registro'].'</td>';

              if ($value['estado'] == "ACTIVO") {
                $tabla = $tabla.'<td><span class="badge badge-success" style="background-color: green">'.$registro2['estado'].'</span></td>';
              }else{
                $tabla = $tabla.'<td><span class="badge badge-danger" style="background-color: #de3030">'.$registro2['estado'].'</span></td>';
              }	
	}

    $tabla = $tabla.'</table>';



    $array = array(0 => $tabla,
    			   1 => $lista);

    echo json_encode($array);
?>