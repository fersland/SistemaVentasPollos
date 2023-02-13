<?php
 session_start();
 if(isset($_SESSION["acceso"])) {   
	require_once ("../head_unico.php");
?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Ventas
        <small>Anular Venta</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="../in.php?cid=dashboard/init"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Ventas</a></li>
        <li class="active"><a href="../in.php?cid=devolucion/dev">Anular Venta</a></li>
      </ol>
    </section>

<!-- Main content -->
<section class="content">
<div class="row"><br />
<div class="col-lg-12">
            <div class="alert alert-danger" style="margin-top: 10px; height: 100px">
              <h4><i class="fa fa-info"></i> Precaución:</h4>
              
              <p>Al confirmar la eliminación de la venta, los pagos realizados de la cuenta por cobrar de esta venta 
              seran eliminados.</p>
            </div>
        </div>
  <div class="col-md-12">
<?php
 // Actualizar datos
 if (isset($_POST['update'])) {

    $venta_anular        = $_POST['venta_anular'];
    $orden_anular        = $_POST['orden_anular'];
    
    // Devolver al inventario los productos vendidos
    $al_inventario = $db->prepare("SELECT * FROM c_venta_detalle WHERE nventa='$venta_anular'");
    $al_inventario->execute();
    $rows_al = $al_inventario->fetchAll(PDO::FETCH_ASSOC);
    
    // Recorrer los productos por su codigo y cantidad al inventario de vuelta
    foreach((array) $rows_al as $recorrer) {
        $el_codigo      = $recorrer['codigo'];
        $la_cantidad    = $recorrer['cantidad'];
        
        // Actualizar el stock de la tabla mercaderia
        $mercaderia = $db->prepare("UPDATE c_mercaderia SET existencia=existencia+'$la_cantidad' WHERE codproducto='$el_codigo'");
        $mercaderia->execute();
    }
    
    // Anular venta
    $anular_venta = $db->prepare("UPDATE c_venta SET estado='X' WHERE nventa = '$venta_anular'");
    $anular_venta->execute();
    
    // Anular venta detalle
    $anular_venta_d = $db->prepare("UPDATE c_venta_detalle SET estado='X' WHERE nventa = '$venta_anular'");
    $anular_venta_d->execute();
    
    $inc = $db->prepare("UPDATE c_mercaderia SET existencia = existencia + '$dev' WHERE codproducto = '$upd_pro'");
    if ($inc->execute()){
        
        // Actualizar el stock en inventario
        $inventario = $db->prepare("UPDATE c_venta_detalle SET dev='SI' WHERE idventa='$upd_id'");
        $inventario->execute();
        
        echo '<div class="alert alert-success">
            <b>Cambios guardados!</b> <span class="badge bg-orange"><a href="../in.php?cid=ventas/frm_ver_ventas">Volver</a></span>
          </div>';            
        }else{
            echo '<div class="alert alert-danger">
                <b>Error al eliminar los datos!</b>
              </div>';
           }
}

    $laid = isset($_GET['cid']) ? $_GET['cid'] : 0;

    $sql = $db->prepare("SELECT * FROM c_venta WHERE norden = '$laid'");
    $sql->execute();
    $cantidad_param = $sql->rowCount();
    $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $key => $value) {
      $norden         = $value['norden'];
      $nventa         = $value['nventa'];
    }
?>
  </div>
    <div class="col-md-6">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Eliminar esta factura</h3>
            </div>
            <form method="POST" class="form-horizontal">
                <div class="box-body">

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Número de factura </label>
                  <div class="col-sm-8">
                  <input name="orden_anular" type="hidden" value="<?php echo $norden ?>" />
                    <input type="text" name="venta_anular" value="<?php echo $nventa ?>" class="form-control" readonly="" />
                  </div>
                </div>
            </div>

              <div class="box-footer">
                <a href="../in.php?cid=ventas/frm_ver_ventas" class="btn bg-navy">Volver</a>
                <button type="reset" class="btn btn-default">Cancelar</button>
                
                <?php if ($cantidad_param > 0): ?>
                <button type="submit" class="btn btn-danger pull-right" name="update">Eliminar Esta Factura</button>
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