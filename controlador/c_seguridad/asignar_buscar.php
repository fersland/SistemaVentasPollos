<?php 

	require_once ("../../datos/db/connect.php");

	$desde = $_POST['desde'];
	$hasta = $_POST['hasta'];

	if ( isset($desde) == false ) {
		$desde = $hasta;
	}

	if ( isset($hasta) == false) {
		$hasta = $desde;
	}

	$arg = DBSTART::abrirDB()->prepare("select mi.idcm, r.nombrerol, m.nombremodulo, mi.nombreitem, mi.estado, mi.fecharegistro
											from c_modulos_items mi
											inner join c_modulos m on m.idmodulo = mi.idmodulo
											inner join c_roles r on r.idrol = mi.nivelacceso
								WHERE mi.nivelacceso = '$desde' AND mi.idmodulo = '$hasta'");
	$arg->execute();
	$datas = $arg->fetchAll(PDO::FETCH_ASSOC);
	$count = $arg->rowCount(); ?>


 <table class="table table-striped table-hover bg-dark">
 <?php 
 if ( $count == 0 ) {
 		echo '<tr><td> No se encontraron resultados</td></tr>';
 	}else{ ?>
 	<thead>
        <th>MODULO</th>
        <th>NIVEL ACCESO</th>
        <th>PERMISO A</th>
        <th>FECHA ASIGNADO</th>
    	<th>ESTADO</th>
        <th>OPCIÓN</th>
    </thead>
<?php foreach ($datas as $key => $value): ?>
	
    <tbody>
        <td><?php echo $value['nombremodulo'] ?></td>
        <td><?php echo $value['nombrerol'] ?></td>
        <td><?php echo $value['nombreitem'] ?></td>
        <td><?php echo $value['fecharegistro'] ?></td>
        <?php if ($value['estado'] == "ACTIVO"){?>
		<td><span class="badge badge-success" style="background-color: green"><?php echo $value['estado'] ?></span></td>

	<?php }else{ ?>
		<td><span class="badge badge-success" style="background-color: #de3030"><?php echo $value['estado'] ?></span></td>
		
	<?php } ?>
        <td><a name="press" href="../../../controlador/c_seguridad/nuevoestado.php?id=<?php echo $value['idcm'] ?>" ><span class="badge badge-info">Cambiar</span></a></td>
    </tbody>
<?php endforeach ?>
 	<?php }?>
 </table>