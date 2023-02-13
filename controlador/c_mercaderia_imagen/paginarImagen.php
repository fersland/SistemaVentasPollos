<?php

    require_once ("../../datos/db/connect.php");
	$paginaActual = $_POST['partida'];    

    $empresa = 1;
    /*
        La primera consulta es para contar todos los datos de la tabla y dividirlos, y asi realizar una serie de paginas de paginador
    */
    $nroProductos = DBSTART::abrirDB()->prepare("select * from c_mercaderia e inner join c_empresa p on e.id_empresa = p.id_empresa 
                                                    where e.id_empresa = '$empresa' and e.estado = 'A'");
    $nroProductos->execute();
    $ncantidad = $nroProductos->rowCount();
    $nroLotes = 12;
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
  	$registro = DBSTART::abrirDB()->prepare("select * from c_mercaderia e inner join c_empresa p 
      on e.id_empresa = p.id_empresa where e.id_empresa = '$empresa' and e.estado = 'A' LIMIT $limit, $nroLotes  ");
    $registro->execute();
    $all = $registro->fetchAll(PDO::FETCH_ASSOC);
    
  	$tabla = $tabla.'<table class="table table-striped table-condensed table-hover">
			            <tr>
                          <th>Código</th>
                          <th>Nombre</th>
                          <th>Imagen</th>
                          <th colspan="3">Opciones</th>
			            </tr>';
				
	foreach($all as $registro2){
		$tabla = $tabla.'<tr>
            		      <td>'.$registro2['codproducto'].'</td>
                          <td>'.$registro2['nombreproducto'].'</td>
    <td><img src="../../img/'. $registro2['ruta'].'" style="border: 3px solid gray; padding: 5px; width: 10%" /></td>
              
		        <td><a href="../app/imagen_producto/frm_imagen_act.php?cid='.$registro2['codproducto'].'" <i class="fa fa-edit"></i></a></td>
                <td><a href="../app/imagen_producto/frm_imagen_eli.php?cid='.$registro2['codproducto'].'" ><i class="fa fa-trash"></i></a></td>
						  </tr>';		
	}        

    $tabla = $tabla.'</table>';

    $array = array(0 => $tabla,
    			   1 => $lista);

    echo json_encode($array);
    
  
?>