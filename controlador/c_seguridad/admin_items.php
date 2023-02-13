<?php 
	if (isset($_REQUEST['cid'])) {
        $cid = $_REQUEST['cid'];

        require_once ("../../datos/db/connect.php");


	$param =  DBSTART::abrirDB()->prepare("INSERT INTO c_permisos (id_empresa, nivelacceso, idmodulo, id_item, src_h, src_hu,icons, estado) VALUES 
(1,'$cid',1,1,'?cid=seguridad/nivel','../in.php?cid=seguridad/nivel','fa fa-caret-right','ACTIVO'),
(1,'$cid',2,3,'?cid=empresa/frm_empresa','../in.php?cid=empresa/frm_empresa','fa fa-cogs','ACTIVO'),
(1,'$cid',2,4,'?cid=facturero/frm_factureros','../in.php?cid=facturero/frm_factureros','fa fa-stack-overflow','ACTIVO'),
(1,'$cid',2,5,'?cid=iva/frm_iva','../in.php?cid=iva/frm_iva','fa fa-info-circle','ACTIVO'),
(1,'$cid',2,6,'?cid=empleados/frm_empleados','../in.php?cid=empleados/frm_empleados','fa fa-user fa-fw','ACTIVO'),
(1,'$cid',2,7,'?cid=clientes/frm_clientes','../in.php?cid=clientes/frm_clientes','fa fa-users fa-fw','ACTIVO'),
(1,'$cid',2,8,'?cid=proveedor/frm_proveedor','../in.php?cid=proveedor/frm_proveedor','fa fa-cart-plus','ACTIVO'),
(1,'$cid',2,9,'?cid=trabajo/frm_trabajo','../in.php?cid=trabajo/frm_trabajo','fa fa-edit','ACTIVO'),
(1,'$cid',2,10,'?cid=bodega/frm_bodega','../in.php?cid=bodega/frm_bodega','fa fa-inbox','ACTIVO'),
(1,'$cid',2,11,'?cid=categoria/frm_categoria_producto','../in.php?cid=categoria/frm_categoria_producto','fa fa-plus-square','ACTIVO'),
(1,'$cid',2,12,'?cid=tipo_aceites/frm_tipo_aceites','../in.php?cid=tipo_aceites/frm_tipo_aceites','fa fa-flask','ACTIVO'),
(1,'$cid',2,13,'?cid=tipo_filtros/frm_tipo_filtros','../in.php?cid=tipo_filtros/frm_tipo_filtros','fa fa-filter','ACTIVO'),
(1,'$cid',2,14,'?cid=servicios/frm_servicios','../in.php?cid=servicios/frm_servicios','fa fa-bolt','ACTIVO'),
(1,'$cid',2,15,'?cid=tipo_vehiculos/frm_tipo_vehiculos','../in.php?cid=tipo_vehiculos/frm_tipo_vehiculos','fa fa-car','ACTIVO'),
(1,'$cid',2,16,'?cid=tipo_presentacion/frm_tipo_presentacion','../in.php?cid=tipo_presentacion/frm_tipo_presentacion','fa fa-warning','ACTIVO'),
(1,'$cid',3,17,'?cid=mercaderia/frm_mercaderia','../in.php?cid=mercaderia/frm_mercaderia','fa fa-cube','ACTIVO'),
(1,'$cid',3,18,'?cid=compras/frm_ver_compras','../in.php?cid=compras/frm_ver_compras','fa fa-barcode','ACTIVO'),
(1,'$cid',3,19,'?cid=compras/frm_compras_anuladas','../in.php?cid=compras/frm_compras_anuladas','fa fa-ban','ACTIVO'),
(1,'$cid',4,20,'?cid=ventas/frm_orden_trabajo','../in.php?cid=ventas/frm_orden_trabajo','fa fa-calendar-o','ACTIVO'),
(1,'$cid',4,21,'?cid=ventas/show_pendientes','../in.php?cid=ventas/show_pendientes','fa fa-shopping-cart','ACTIVO'),
(1,'$cid',4,22,'?cid=ventas/frm_ventas_facturadas','../in.php?cid=ventas/frm_ventas_facturadas','fa fa-file-text','ACTIVO'),
(1,'$cid',4,23,'?cid=ventas/frm_ver_ventas','../in.php?cid=ventas/frm_ver_ventas','fa fa-barcode','ACTIVO'),
(1,'$cid',4,24,'?cid=ventas/frm_ventas_anuladas','../in.php?cid=ventas/frm_ventas_anuladas','fa fa-ban','ACTIVO'),
(1,'$cid',5,25,'?cid=mercaderia/frm_inventario','../in.php?cid=mercaderia/frm_inventario','fa fa-table','ACTIVO'),
(1,'$cid',5,26,'?cid=mercaderia/bodegas','../in.php?cid=mercaderia/bodegas','fa fa-inbox','ACTIVO'),
(1,'$cid',5,27,'../mercaderia/galeria.php','../mercaderia/galeria.php','fa fa-camera','ACTIVO'),
(1,'$cid',5,28,'?cid=activos/frm_activos','../in.php?cid=activos/frm_activos','fa fa-sign-out','ACTIVO'),
(1,'$cid',5,29,'?cid=activos/frm_activos','../in.php?cid=Herramientas/frm_herramientas','fa fa-wrench','ACTIVO');
");
    
    sleep(3);
    $param->execute();

    echo '<script>
            alert("Estableciendo permisos de Administrador");
			window.history.back();
		  </script>';
}
?>