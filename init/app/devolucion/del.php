<?php
    /***************
        DEVOLVER PRODUCTO, ELIMINACION DE VENTA DETALLE
    
    *********/
 session_start();
 if(isset($_SESSION["acceso"])) {   
	require_once ("../head_unico.php");
?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Devolución
        <small>Recibir Producto</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="../in.php?cid=dashboard/init"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Ventas</a></li>
        <li class="active"><a href="../in.php?cid=devolucion/dev">Facturación</a></li>
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
    $upd_sto       = strtoupper($_POST['p_stock']);
    $upd_can       = strtoupper($_POST['p_nuevo']);
    $upd_pre       = $_POST['p_precio'];
    $upd_ord       = $_POST['p_orden'];
    $upd_act       = $_POST['p_actual'];
    $upd_pro       = $_POST['p_producto'];
    $dev           = $_POST['devuelta'];
    $venta         = $_POST['deventa'];
    $updcodigo = $_POST['elcodigo'];
    
    $dinero = 0;
    $dinero = $upd_pre * $dev;
    
    if ( $dev > $upd_can) {
        echo '<div class="alert alert-danger">
                <b>Error, no puede recibir mas de lo vendido!</b>
              </div>';
    }else{    
    
    // Incrementar el inventario
    $inc = $db->prepare("UPDATE c_mercaderia SET existencia = existencia + '$dev' WHERE codproducto = '$upd_pro'");
    if ($inc->execute()){
        $stmt = $db->prepare("INSERT INTO c_devolucion_item 
        (codigo, cantidad, precio, dinero, orden, factura, estado) VALUES 
        ('$updcodigo','$dev', '$upd_pre', '$dinero', '$upd_ord', '$venta', 'D')");
        $stmt->execute();
        
        // Actualizar el stock en inventario
        $inventario = $db->prepare("UPDATE c_venta_detalle SET dev='SI' WHERE idventa='$upd_id'");
        $inventario->execute();
        
        echo '<div class="alert alert-success">
            <b>Se ha realizado la devoluci&oacute;n correctamente!</b> <span class="badge bg-orange"><a href="volt.php?arg='.$upd_ord.'">Volver</a></span>
          </div>'; ?>              
<?php }else{
        echo '<div class="alert alert-danger">
                <b>Error al eliminar los datos!</b>
              </div>';
           }
    }
}

    $laid = isset($_GET['arg']) ? $_GET['arg'] : 0;

    $sql = $db->prepare("SELECT vd.cantidad, vd.codigo, m.nombreproducto, m.existencia, vd.idventa, vd.precio, vd.nventa, 
                                    vd.num_orden, m.codproducto, vd.dev
                                            FROM c_venta_detalle vd INNER JOIN c_mercaderia m ON m.codproducto = vd.codigo
                                            WHERE idventa = '$laid'");
    $sql->execute();
    $cantidad_param = $sql->rowCount();
    $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $key => $value) {
      $cid_idv        = $value['idventa'];
      $cod            = $value['codigo']; // Para devolucion
      $nventa         = $value['nventa']; //
      $cid_nom        = $value['nombreproducto'];
      $cid_can        = $value['cantidad']; //
      $cid_pre        = $value['precio'];
      $cid_ord        = $value['num_orden'];
      $cid_pro        = $value['codproducto'];
    }
?>
  </div>
    <div class="col-md-6">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Recibir producto</h3>
            </div>
            <form method="POST" class="form-horizontal">
                <div class="box-body">
                    <input type="hidden" name="pid" value="<?php echo $cid_idv ?>" />
                    <input type="hidden" name="p_precio" value="<?php echo $cid_pre ?>" />
                    <input type="hidden" name="p_orden" value="<?php echo $cid_ord ?>" />
                    <input type="hidden" name="p_actual" value="<?php echo $cid_can ?>" />
                    <input type="hidden" name="p_producto" value="<?php echo $cid_pro ?>" />
                    <input type="hidden" name="deventa" value="<?php echo $nventa ?>" />
                    <input type="hidden" name="elcodigo" value="<?php echo $cod ?>" />

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Nombre Producto </label>
                  <div class="col-sm-8">
                    <input type="text" name="p_cedula" value="<?php echo $cid_nom ?>" class="form-control" readonly="" />
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Cantidad Vendida </label>
                  <div class="col-sm-8">
                    <input type="text" name="p_nuevo" value="<?php echo $cid_can ?>" class="form-control" readonly="" />
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Cantidad Devuelta </label>
                  <div class="col-sm-8">
                    <input type="number" min="1" value="1" name="devuelta" class="form-control" />
                  </div>
                </div>
            </div>

              <div class="box-footer">
                <a href="volt.php?arg=<?php echo $cid_ord ?>" class="btn bg-navy">Volver</a>
                <button type="reset" class="btn btn-default">Cancelar</button>
                
                <?php if ($cantidad_param > 0): ?>
                <button type="submit" class="btn btn-warning pull-right" name="update">Recibir Producto</button>
                <?php endif; ?>
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