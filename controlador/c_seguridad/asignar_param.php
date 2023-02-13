<?php 

	function verPermisos($cc, $param) {

    // M O D U L O      1
	$arg = $cc->prepare("select r.nombrerol, m.nombremodulo, mis.nombreitem, mi.estado, mi.fecha_registro,mi.fecha_modificacion
                                            from c_permisos mi
                                            inner join c_modulos m on m.idmodulo = mi.idmodulo
                                            inner join c_roles r on r.idrol = mi.nivelacceso
                                            inner join c_modulos_items mis on mis.idcm = mi.id_item
                                            WHERE mi.nivelacceso = '$param' AND m.idmodulo=1");
	$arg->execute();
	$datas = $arg->fetchAll(PDO::FETCH_ASSOC);
	$count = $arg->rowCount();

    // M O D U L O      2

    $arg2 = $cc->prepare("select r.nombrerol, m.nombremodulo, mis.nombreitem, mi.estado, mi.fecha_registro,mi.fecha_modificacion
                                            from c_permisos mi
                                            inner join c_modulos m on m.idmodulo = mi.idmodulo
                                            inner join c_roles r on r.idrol = mi.nivelacceso
                                            inner join c_modulos_items mis on mis.idcm = mi.id_item
                                            WHERE mi.nivelacceso = '$param' AND m.idmodulo=2");
    $arg2->execute();
    $datas2 = $arg2->fetchAll(PDO::FETCH_ASSOC);
    $count2 = $arg2->rowCount();


     // M O D U L O      3

    $arg3 = $cc->prepare("select r.nombrerol, m.nombremodulo, mis.nombreitem, mi.estado, mi.fecha_registro,mi.fecha_modificacion
                                            from c_permisos mi
                                            inner join c_modulos m on m.idmodulo = mi.idmodulo
                                            inner join c_roles r on r.idrol = mi.nivelacceso
                                            inner join c_modulos_items mis on mis.idcm = mi.id_item
                                            WHERE mi.nivelacceso = '$param' AND m.idmodulo=4");
    $arg3->execute();
    $datas3 = $arg3->fetchAll(PDO::FETCH_ASSOC);
    $count3 = $arg3->rowCount();


    // M O D U L O      4

    $arg4 = $cc->prepare("select r.nombrerol, m.nombremodulo, mis.nombreitem, mi.estado, mi.fecha_registro,mi.fecha_modificacion
                                            from c_permisos mi
                                            inner join c_modulos m on m.idmodulo = mi.idmodulo
                                            inner join c_roles r on r.idrol = mi.nivelacceso
                                            inner join c_modulos_items mis on mis.idcm = mi.id_item
                                            WHERE mi.nivelacceso = '$param' AND m.idmodulo=4");
    $arg4->execute();
    $datas4 = $arg4->fetchAll(PDO::FETCH_ASSOC);
    $count4 = $arg4->rowCount();





    // M O D U L O      5

    $arg5 = $cc->prepare("select r.nombrerol, m.nombremodulo, mis.nombreitem, mi.estado, mi.fecha_registro,mi.fecha_modificacion
                                            from c_permisos mi
                                            inner join c_modulos m on m.idmodulo = mi.idmodulo
                                            inner join c_roles r on r.idrol = mi.nivelacceso
                                            inner join c_modulos_items mis on mis.idcm = mi.id_item
                                            WHERE mi.nivelacceso = '$param' AND m.idmodulo=5");
    $arg5->execute();
    $datas5 = $arg5->fetchAll(PDO::FETCH_ASSOC);
    $count5 = $arg5->rowCount();


     ?>
    <table class="table table-striped table-hover bg-dark">
<thead >
        <th><i class="fa fa-archive"></i> MODULO</th>
        <th><i class="fa fa-check"></i> NIVEL ACCESO</th>
        <th><i class="fa fa-unlock"></i> PERMISO A</th>
        <th><i class="fa fa-clock-o"></i> FECHA ASIGNADO</th>
        <th><i class="fa fa-clock-o"></i> FECHA MODIFICADO</th>
        <th><i class="fa fa-bullseye"></i> ESTADO</th>
        <th><i class="fa fa-star-half"></i> OPCIÓN</th>
    </thead>
</table>

<div class="panel-group" id="accordion">
<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><p style="color: red; font-weight: bold">SEGURIDAD</p></a>
        </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse">
 <table class="table table-striped table-hover bg-dark">
 <?php 
 if ( $count == 0 ) {
 	echo '<tr><td> No se encontraron resultados</td></tr>';
 	}else{?>
<?php foreach ($datas as $key => $value): ?>
	
    <tbody>
        <td><?php echo $value['nombremodulo'] ?></td>
        <td><?php echo $value['nombrerol'] ?></td>
        <td><?php echo $value['nombreitem'] ?></td>
        <td><?php echo $value['fecha_registro'] ?></td>
        <td><?php echo $value['fecha_modificacion'] ?></td>
        <?php if ($value['estado'] == "ACTIVO"){?>
		<td><span class="badge badge-success" style="background-color: green"><?php echo $value['estado'] ?></span></td>

	<?php }else{ ?>
		<td><span class="badge badge-success" style="background-color: #de3030"><?php echo $value['estado'] ?></span></td>
	<?php } ?>
        <td><a name="press" href="../../../../controlador/c_seguridad/nuevoestado.php?id=<?php echo $value['idcm'] ?>" ><span class="badge badge-info"> <i class="fa fa-refresh"></i> Cambiar</span></a></td>
    </tbody>

<?php endforeach ?>
 	<?php }?>
</table>
</div>
</div></div>




<div class="panel-group" id="accordion">
<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseConf"><p style="color: red; font-weight: bold">CONFIGURACIÓN Y ADMINISTRACIÓN</p></a>
        </h4>
    </div>
    <div id="collapseConf" class="panel-collapse collapse">
<table class="table table-striped table-hover bg-dark">

    <?php foreach ($datas2 as $key => $value2): ?>
    <tbody>
        <td><?php echo $value2['nombremodulo'] ?></td>
        <td><?php echo $value2['nombrerol'] ?></td>
        <td><?php echo $value2['nombreitem'] ?></td>
        <td><?php echo $value2['fecha_registro'] ?></td>
        <td><?php echo $value2['fecha_modificacion'] ?></td>
        <?php if ($value2['estado'] == "ACTIVO"){?>
        <td><span class="badge badge-success" style="background-color: green"><?php echo $value2['estado'] ?></span></td>

    <?php }else{ ?>
        <td><span class="badge badge-success" style="background-color: #de3030"><?php echo $value2['estado'] ?></span></td>
    <?php } ?>
        <td><a name="press" href="../../../../controlador/c_seguridad/nuevoestado.php?id=<?php echo $value2['idcm'] ?>" ><span class="badge badge-info"> <i class="fa fa-refresh"></i> Cambiar</span></a></td>
    </tbody>

<?php endforeach ?>
 </table>
</div></div></div>








<div class="panel-group" id="accordion">
<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseCompras"><p style="color: red; font-weight: bold">COMPRAS</p></a>
        </h4>
    </div>
    <div id="collapseCompras" class="panel-collapse collapse">
<table class="table table-striped table-hover bg-dark">

    <?php foreach ($datas3 as $key => $value3): ?>
    <tbody>
        <td><?php echo $value3['nombremodulo'] ?></td>
        <td><?php echo $value3['nombrerol'] ?></td>
        <td><?php echo $value3['nombreitem'] ?></td>
        <td><?php echo $value3['fecha_registro'] ?></td>
        <td><?php echo $value3['fecha_modificacion'] ?></td>
        <?php if ($value3['estado'] == "ACTIVO"){?>
        <td><span class="badge badge-success" style="background-color: green"><?php echo $value3['estado'] ?></span></td>

    <?php }else{ ?>
        <td><span class="badge badge-success" style="background-color: #de3030"><?php echo $value3['estado'] ?></span></td>
    <?php } ?>
        <td><a name="press" href="../../../../controlador/c_seguridad/nuevoestado.php?id=<?php echo $value3['idcm'] ?>" ><span class="badge badge-info"> <i class="fa fa-refresh"></i> Cambiar</span></a></td>
    </tbody>

<?php endforeach ?>
 </table>
</div></div></div>






<div class="panel-group" id="accordion">
<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseVentas"><p style="color: red; font-weight: bold">VENTAS</p></a>
        </h4>
    </div>
    <div id="collapseVentas" class="panel-collapse collapse">
<table class="table table-striped table-hover bg-dark">

    <?php foreach ($datas4 as $key => $value4): ?>
    <tbody>
        <td><?php echo $value4['nombremodulo'] ?></td>
        <td><?php echo $value4['nombrerol'] ?></td>
        <td><?php echo $value4['nombreitem'] ?></td>
        <td><?php echo $value4['fecha_registro'] ?></td>
        <td><?php echo $value4['fecha_modificacion'] ?></td>
        <?php if ($value4['estado'] == "ACTIVO"){?>
        <td><span class="badge badge-success" style="background-color: green"><?php echo $value4['estado'] ?></span></td>

    <?php }else{ ?>
        <td><span class="badge badge-success" style="background-color: #de3030"><?php echo $value4['estado'] ?></span></td>
    <?php } ?>
        <td><a name="press" href="../../../../controlador/c_seguridad/nuevoestado.php?id=<?php echo $value4['idcm'] ?>" ><span class="badge badge-info"> <i class="fa fa-refresh"></i> Cambiar</span></a></td>
    </tbody>

<?php endforeach ?>
 </table>
</div></div></div>



<div class="panel-group" id="accordion">
<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseInve"><p style="color: red; font-weight: bold">INVENTARIO</p></a>
        </h4>
    </div>
    <div id="collapseInve" class="panel-collapse collapse">
<table class="table table-striped table-hover bg-dark">

    <?php foreach ($datas5 as $key => $value5): ?>
    <tbody>
        <td><?php echo $value5['nombremodulo'] ?></td>
        <td><?php echo $value5['nombrerol'] ?></td>
        <td><?php echo $value5['nombreitem'] ?></td>
        <td><?php echo $value5['fecha_registro'] ?></td>
        <td><?php echo $value5['fecha_modificacion'] ?></td>
        <?php if ($value5['estado'] == "ACTIVO"){?>
        <td><span class="badge badge-success" style="background-color: green"><?php echo $value5['estado'] ?></span></td>

    <?php }else{ ?>
        <td><span class="badge badge-success" style="background-color: #de3030"><?php echo $value5['estado'] ?></span></td>
    <?php } ?>
        <td><a name="press" href="../../../../controlador/c_seguridad/nuevoestado.php?id=<?php echo $value5['idcm'] ?>" ><span class="badge badge-info"> <i class="fa fa-refresh"></i> Cambiar</span></a></td>
    </tbody>

<?php endforeach ?>
 </table>
</div></div></div>

<?php } ?>