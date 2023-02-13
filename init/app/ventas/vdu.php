<?php
 session_start();
 if(isset($_SESSION["acceso"])) {
	require_once ("../head_unico.php");
?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>VENTAS / <b>FACTURACI&Oacute;N</b> / ACTUALIZACI&Oacute;N</h1>
      <ol class="breadcrumb">
        <li><a href="../in.php?cid=dashboard/init"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Ventas</a></li>
        <li class="active"><a href="../in.php?cid=clientes/frm_clientes">Facturación</a></li>
      </ol>
    </section>

<!-- Main content -->
<section class="content">
<div class="row"><br />
  <div class="col-md-12">
<?php
 // Actualizar datos
 if (isset($_POST['update'])) {

    $upd_id        = $_POST['pid'];
    
    $upd_can       = htmlspecialchars($_POST['p_nuevo']);
    $upd_pre       = $_POST['p_precio'];
    $upd_ord       = $_POST['p_orden'];
    $upd_act       = $_POST['p_actual'];
    $upd_pro       = $_POST['p_producto'];
    
    $upd_sto         = htmlspecialchars($_POST['p_stock']);
    $upd_stokg       = htmlspecialchars($_POST['p_stockkg']);
    $upd_stolb       = htmlspecialchars($_POST['p_stocklb']);
    $upd_stogr       = htmlspecialchars($_POST['p_stockgr']);
    $upd_stolt       = htmlspecialchars($_POST['p_stocklt']);
    
    // PRECIOS POR SELECCION
        $precio = htmlspecialchars($_POST['_precio']);
        $pkg    = htmlspecialchars($_POST['pkg']);
        $plt    = htmlspecialchars($_POST['plt']);
        $plb    = htmlspecialchars($_POST['plb']);
        $pgr    = htmlspecialchars($_POST['pgr']);
    
    $seleccion = htmlspecialchars($_POST['tp']);
    
    $importe_final = 0;
    $importe_final = ($upd_pre * $upd_can);
    
    
        if ($seleccion == 'Libras') {
                if ($upd_can > $upd_stolb) { echo '<div class="alert alert-danger"><b>Error, no puede llevar mas Libras!</b></div>';
                    $val = 0; 
                }else {
                    $val = 1;
                    $importe  = $plb * $upd_can;
                    
                    // ACTUALIZAR LOS PRODUCTOS EN EL CARRITO
                    $stmt = $db->prepare("UPDATE c_venta_detalle SET cantidad = '$upd_can', importe = '$importe' WHERE idventa='$upd_id'");
                    if ( $stmt->execute() ) {
                    echo '<div class="alert alert-success">
                                <b>Cambios guardados!</b>
                            </div>';
                   }else{
                     echo '<div class="alert alert-danger">
                                <b>Error al cambiar datos!</b>
                            </div>';
                   }
                }
            }elseif ($seleccion == 'Kilos') {
                if ($upd_can > $upd_stokg) { echo '<div class="alert alert-danger"><b>Error, no puede llevar mas Kilos!</b></div>'; 
                    $val = 0;
                }else {
                    $val = 1;
                    $importe  = $pkg * $upd_can;
                    
                    // ACTUALIZAR LOS PRODUCTOS EN EL CARRITO
                    $stmt = $db->prepare("UPDATE c_venta_detalle SET cantidad = '$upd_can', importe = '$importe' WHERE idventa='$upd_id'");
                    if ( $stmt->execute() ) {
                    echo '<div class="alert alert-success">
                                <b>Cambios guardados!</b>
                            </div>';
                   }else{
                     echo '<div class="alert alert-danger">
                                <b>Error al cambiar datos!</b>
                            </div>';
                   }
                }
            }elseif ($seleccion == 'Gramos'){
                if ($upd_can > $upd_stogr) { echo '<div class="alert alert-danger"><b>Error, no puede llevar mas Gramos!</b></div>'; 
                    $val = 0;
                }else {
                    $val = 1;
                    $importe  = $pgr * $upd_can;
                    
                    // ACTUALIZAR LOS PRODUCTOS EN EL CARRITO
                    $stmt = $db->prepare("UPDATE c_venta_detalle SET cantidad = '$upd_can', importe = '$importe' WHERE idventa='$upd_id'");
                    if ( $stmt->execute() ) {
                        echo '<div class="alert alert-success"><b>Cambios guardados!</b></div>';
                   }else{echo '<div class="alert alert-danger"><b>Error al cambiar datos!</b></div>';
                   }
                }
            }elseif ($seleccion == 'Litros'){
                if ($upd_can > $upd_stolt) { echo '<div class="alert alert-danger"><b>Error, no puede llevar mas Kilos!</b></div>';
                    $val = 0;
                 }else {
                    $val = 1;
                    $importe  = $plt * $upd_can;
                    
                    // ACTUALIZAR LOS PRODUCTOS EN EL CARRITO
                    $stmt = $db->prepare("UPDATE c_venta_detalle SET cantidad = '$upd_can', importe = '$importe' WHERE idventa='$upd_id'");
                    if ( $stmt->execute() ) {
                    echo '<div class="alert alert-success"><b>Cambios guardados!</b></div>';
                   }else{
                     echo '<div class="alert alert-danger"><b>Error al cambiar datos!</b></div>';
                   }
                 }
            }elseif ($seleccion == 'Unidad') {
                if ($upd_can > $upd_sto) { echo '<div class="alert alert-danger"><b>Error, no puede llevar mas unidades!</b></div>';
                    $val = 0;
                }else { 
                    $val = 1;
                    $importe  = $precio * $upd_can;
                    
                    // ACTUALIZAR LOS PRODUCTOS EN EL CARRITO
                    $stmt = $db->prepare("UPDATE c_venta_detalle SET cantidad = '$upd_can', importe = '$importe' WHERE idventa='$upd_id'");
                    if ( $stmt->execute() ) {
                    echo '<div class="alert alert-success"><b>Cambios guardados!</b></div>';
                   }else{
                     echo '<div class="alert alert-danger"><b>Error al cambiar datos!</b></div>';
                   }
                }   
            }                
    }   // FIN DE CANTIDAD APROBADA      



    $laid = isset($_GET['cid']) ? $_GET['cid'] : 0;

    $sql = $db->prepare("SELECT vd.cantidad, vd.codigo, m.nombreproducto, m.existencia, vd.idventa, vd.precio, vd.num_orden, m.codproducto,
                                m.kilo, m.libra, m.gramo, m.litro, vd.tcant, m.pre_kg, m.pre_lb, m.pre_lt, m.pre_gr
                                            FROM c_venta_detalle vd INNER JOIN c_mercaderia m ON m.codproducto = vd.codigo
                                            WHERE idventa = '$laid'");
    $sql->execute();
    $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $key => $value) {
      $cid_idv        = $value['idventa'];
      $cid_nom        = $value['nombreproducto'];
      $cid_can        = $value['cantidad'];
      $cid_sto        = $value['existencia'];
      $cid_pre        = $value['precio'];
      $cid_ord        = $value['num_orden'];
      $cid_pro        = $value['codproducto'];
      
      $cid_gr        = $value['gramo'];
      $cid_lt        = $value['litro'];
      $cid_kg        = $value['kilo'];
      $cid_lb        = $value['libra'];
      
      
      // LISTAR PRECIOS
      $cid_pgr        = $value['pre_gr'];
      $cid_plt        = $value['pre_lt'];
      $cid_pkg        = $value['pre_kg'];
      $cid_plb        = $value['pre_lb'];
      
      $cid_tcant        = $value['tcant'];
    }
    
    
    $tp = $db->prepare("SELECT * FROM c_tipo_unidad WHERE estado = 1");
    $tp->execute();
    $alltp = $tp->fetchAll();

?>
  </div>
    <div class="col-md-6">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Actualizar datos del producto</h3>
            </div>
            <form method="POST" class="form-horizontal">
                <div class="box-body">
                    <input type="hidden" name="pid" value="<?php echo $cid_idv ?>" />
                    
                    <input type="hidden" name="p_orden" value="<?php echo $cid_ord ?>" />
                    <input type="hidden" name="p_actual" value="<?php echo $cid_can ?>" />
                    <input type="hidden" name="p_producto" value="<?php echo $cid_pro ?>" />

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Nombre Producto </label>

                  <div class="col-sm-8">
                    <input type="text" name="p_cedula" value="<?php echo $cid_nom ?>" class="form-control" readonly="" />
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Stock Unidad </label>

                  <div class="col-sm-8">
                    <input type="text" name="p_stock" value="<?php echo $cid_sto ?>" class="form-control" readonly="" />
                    <input type="hidden" name="_precio" value="<?php echo $cid_pre ?>" />
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Stock Kilos </label>

                  <div class="col-sm-8">
                    <input type="text" name="p_stockkg" value="<?php echo $cid_kg ?>" class="form-control" readonly="" />
                    <input type="hidden" name="pkg" value="<?php echo $cid_pkg ?>" />
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Stock Libras </label>

                  <div class="col-sm-8">
                    <input type="text" name="p_stocklb" value="<?php echo $cid_lb ?>" class="form-control" readonly="" />
                    <input type="hidden" name="plb" value="<?php echo $cid_plb ?>" />
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Stock Gramos </label>

                  <div class="col-sm-8">
                    <input type="text" name="p_stockgr" value="<?php echo $cid_gr ?>" class="form-control" readonly="" />
                    <input type="hidden" name="pgr" value="<?php echo $cid_pgr ?>" />
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Stock Litros </label>

                  <div class="col-sm-8">
                    <input type="text" name="p_stocklt" value="<?php echo $cid_lt ?>" class="form-control" readonly="" />
                    <input type="hidden" name="plt" value="<?php echo $cid_plt ?>" />
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Tipo Unidad </label>

                  <div class="col-sm-8">
                    <select class="form-control" name="tp">
                        <?php foreach((array) $alltp as $ddd):
                            if ($ddd['nombre'] == $cid_tcant) : ?>
                            <option selected style="background:coral"><?php echo $ddd['nombre'] ?></option>
                            <?php else: ?>
                            <option><?php echo $ddd['nombre'] ?></option>
                        <?php endif;
                            endforeach; ?>
                    </select>
                  </div>
                </div>
                
                
                
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Cantidad </label>

                  <div class="col-sm-8">
                    <input type="text" name="p_nuevo" value="<?php echo $cid_can ?>" class="form-control" />
                  </div>
                </div>
                
            </div>
                <!-- /.box-body -->
              <div class="box-footer">
                <a href="ord.php?cid=<?php echo $cid_ord ?>" class="btn bg-navy">Volver</a>
                <button type="reset" class="btn btn-default">Cancelar</button>
                <button type="submit" class="btn btn-warning pull-right" value="ACTUALIZAR DATOS AHORA" name="update">Actualizar Datos</button>
              </div>
    </form>
</div>
</div>
</div>
</section>
</div>

<?php 
require_once ("../foot_unico.php");

}else{
    session_unset();
    session_destroy();
    header('Location:  ../../../index.php');
} 

 ?>