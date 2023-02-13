<?php
 session_start();
 if(isset($_SESSION["acceso"])) {
    require_once ("../head_unico.php");
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Devolución<small>Elegir producto</small></h1>
      <ol class="breadcrumb">
        <li><a href="../in.php?cid=dashboard/init"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="../in.php?cid=devolucion/dev">Pendientes</a></li>
        <li class="active"><a href="../in.php?cid=devolucion/dev">Devolución</a></li>
      </ol>
    </section>
<section class="content">
<div class="row"><br />
  <div class="col-md-12">
<?php
   $laid = isset($_GET['arg']) ? $_GET['arg'] : 0;
   $lavn = isset($_GET['vn']) ? $_GET['vn'] : 0;

    $sql = $db->prepare("SELECT * FROM c_venta v LEFT JOIN c_clientes c 
                                            ON v.cliente = c.cedula WHERE v.norden = ?");
    $sql->execute(array($laid));
    $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $key => $value) {
      $orden          = $value['norden'];
      $cedula         = $value['cedula'];
      $nombres        = $value['nombres'];
      $factura        = $value['nventa'];
      $fecha          = $value['fecharegistro'];
      $idcl = $value['cliente'];
    }
    
    $registro = $db->prepare("select * from c_venta_detalle vd INNER JOIN c_mercaderia m 
                                                    ON m.codproducto = vd.codigo 
                                                    where vd.num_orden = '$laid' AND vd.estado = 'F'");
    $registro->execute();
    $all = $registro->fetchAll(PDO::FETCH_ASSOC);
    $count = $registro->rowCount();
    
    // Devolucion tabla
    $devo = $db->prepare("SELECT d.codigo, d.cantidad, d.precio, d.dinero, d.orden, d.factura, d.fecha_dev
                                            FROM c_devolucion_item d INNER JOIN c_mercaderia m 
                                            ON d.codigo = m.codproducto WHERE d.orden = ?");
    $devo->execute(array($laid));
    $rows_dev = $devo->fetchAll(PDO::FETCH_ASSOC);
    
    // Dinero a devolver
    $devol = $db->prepare("SELECT sum(d.dinero) as suma FROM c_devolucion_item d INNER JOIN c_mercaderia m 
                                            ON d.codigo = m.codproducto WHERE d.orden = ?");
    $devol->execute(array($laid));
    $rows_devl = $devol->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($rows_devl as $item_devl) {
        $suma_ok = $item_devl['suma'];
    }
    
    // contador
    $conta = $db->prepare("SELECT * FROM c_devolucion_item d INNER JOIN c_mercaderia m 
                                            ON d.codigo = m.codproducto WHERE d.orden = ?");
    $conta->execute(array($laid));
    $rows_count = $conta->rowCount();


?>
  </div>
  
<div class="col-md-12">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Datos de la Factura <span class="btn btn-warning" style="font-size: 15px; font-weight: bold;"><?php echo $factura ?></span></h3>
            </div>
            <form method="POST" class="form-horizontal">
                <div class="box-body">
                    <input type="hidden" name="p_id" value="<?php echo $orden ?>" />
                <div class="form-group">
                <?php if ($idcl == 0) { ?>
                  <label for="inputEmail3" class="col-md-2 control-label">Cliente </label>
                  <div class="col-sm-4">
                    <input type="text" name="p_cedula" value="CONSUMIDOR FINAL" class="form-control" readonly="" />
                  </div>
                  <label for="inputEmail3" class="col-sm-2 control-label">Fecha Venta </label>
                  <div class="col-sm-2">
                    <input type="text" name="p_nombres" value="<?php echo $fecha ?>" class="form-control" readonly="" />
                  </div>
                <?php }else{ ?>
                  <label for="inputEmail3" class="col-md-1 control-label">Cédula </label>
                  <div class="col-sm-2">
                    <input type="text" name="p_cedula" value="<?php echo $cedula ?>" class="form-control" readonly="" />
                  </div>
                  <label for="inputEmail3" class="col-sm-1 control-label">Cliente </label>
                  <div class="col-sm-4">
                    <input type="text" name="p_nombres" value="<?php echo $nombres ?>" class="form-control" readonly="" />
                  </div>
                  <label for="inputEmail3" class="col-sm-2 control-label">Fecha Venta </label>
                  <div class="col-sm-2">
                    <input type="text" name="p_nombres" value="<?php echo $fecha ?>" class="form-control" readonly="" />
                  </div>
                  <?php } ?>
            </div>
          </div>
    </form>
</div>
</div>

<!-- DETALLE DE LA VENTA -->
<div class="col-md-12">
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><b>Lista de productos vendidos (Sin devolver) Cantidad de Productos (<?php echo $count ?>) </b>
            <a href="#" onclick="confirmar(<?php echo $laid ?>)" class="btn btn-success btn-sm"><i class="fa fa-lock"></i> Devolver Todo </a></h3>
    </div>
    <div class="box-body">
        <table id="example1" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>CÓDIGO</th>
                    <th>DESCRIPCIÓN</th>
                    <th>CANTIDAD</th>
                    <th>PRECIO</th>
                    <th>IMPORTE</th>
                    <th>Devolver</th>
                </tr>
            </thead>
            
            <tbody>
            <?php foreach($all as $registro2){ ?>
                <tr>
                    <td><?php echo $registro2['codigo'] ?></td>
                    <td><?php echo $registro2['nombreproducto'] ?></td>
                    <td><?php echo $registro2['cantidad'] ?></td>
                    <td><?php echo $registro2['precio'] ?></td>
                    <td><?php echo $registro2['importe'] ?></td>
                    
                    <?php if ($registro2['dev'] == 'SI') { ?>
                    <td>Ya se devolvi&oacute;</td>
                    <?php }elseif ($registro2['dev'] == '' || $registro2['dev'] == 'NO'){ ?>
                        <td><a href="del.php?arg=<?php echo $registro2['idventa']?> " >
                        <span class="btn btn-danger"><i class="fa fa-key"></i> Devolver</span></a></td>
                    <?php } ?>
                     
                </tr>
        <?php } ?>  
      </tbody>                      
    </table>
  </div><!-- /.box-body -->
</div><!-- /.box -->
</div>
<!-- FIN DETALLE VENTA -->

<!-- DETALLE DE LA DEVOLUCION -->
<div class="col-md-8">
<div class="box box-danger">
    <div class="box-header with-border">
        <h3 class="box-title"><b>Lista de productos devueltos (<?php echo $rows_count ?>)</b></h3>
    </div>
    <div class="box-body">
        <table id="example1" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>ORDEN</th>
                    <th>CANTIDAD</th>
                    <th>PRECIO</th>
                    <th>IMPORTE</th>
                    <th>FACTURA</th>
                </tr>
            </thead>
            
            <tbody>
            <?php foreach ($rows_dev as $key => $value_dev) {
                $lasuma = $value_dev['suma'];
                ?>
                <tr>
                    <td><?php echo $value_dev['orden'] ?></td>
                    <td><?php echo $value_dev['cantidad'] ?></td>
                    <td><?php echo $value_dev['precio'] ?></td>
                    <td><?php echo $value_dev['dinero'] ?></td>
                    <td><?php echo $value_dev['factura'] ?></td>
                </tr>
        <?php } ?>  
      </tbody>                      
    </table>
  </div><!-- /.box-body -->
</div><!-- /.box -->
</div>
<div class="col-md-4">
<div class="box box-danger">
    <div class="box-header with-border">
        <h3 class="box-title"><b>Resumen de devolución  </b></h3>
    </div>
    <div class="box-body">
        <h2 align="center">$ <?php echo $suma_ok ?></h2> 
    </div><!-- /.box-body -->
</div><!-- /.box -->
</div>
    
<!-- FIN DETALLE DEVOLUCION -->



</div>
</section>
</div>

<script>
    function confirmar(cid) {
        if (confirm('¿Seguro que desea eliminar esta venta?')){
            window.location.href = "../../../controlador/c_devolucion/devolver.php?cid=" + cid;
        }
    }
</script>
<?php
require_once ('./'."../foot_unico.php");
}else{
    session_unset();
    session_destroy();
    header('Location:  ../../../../index.php');
}?>