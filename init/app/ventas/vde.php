<?php
 session_start();
 if(isset($_SESSION["acceso"])) {
	require_once ("../head_unico.php");
?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Facturación
        <small>Eliminar Producto</small>
      </h1>
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
    $upd_sto       = strtoupper($_POST['p_stock']);
    $upd_can       = strtoupper($_POST['p_nuevo']);
    $upd_pre       = $_POST['p_precio'];
    $upd_ord       = $_POST['p_orden'];
    $upd_act       = $_POST['p_actual'];
    $upd_pro       = $_POST['p_producto'];
                
    // Actualizar el stock en inventario
    // Incrementar el inventario
    $inc = $db->prepare("UPDATE c_mercaderia SET existencia = existencia + '$upd_act' WHERE codproducto = '$upd_pro'");
    if ($inc->execute()){
        $stmt = $db->prepare("UPDATE c_venta_detalle SET estado='X' WHERE idventa='$upd_id'");
        $stmt->execute();
        
        echo '<div class="alert alert-success">
            <b>Cambios guardados!</b> <span class="badge bg-orange"><a href="ord.php?cid='.$upd_ord.'">Volver</a></span>
          </div>'; ?>              
<?php }else{
        echo '<div class="alert alert-danger">
                <b>Error al eliminar los datos!</b>
              </div>';
           }
}

    $laid = isset($_GET['cid']) ? $_GET['cid'] : 0;
    $laid = $_REQUEST['cid'];

    $sql = $db->prepare("SELECT vd.cantidad, vd.codigo, m.nombreproducto, m.existencia, vd.idventa, vd.precio, vd.num_orden, m.codproducto
                                            FROM c_venta_detalle vd INNER JOIN c_mercaderia m ON m.codproducto = vd.codigo
                                            WHERE idventa = '$laid'");
    $sql->execute();
    $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $key => $value) {
      $cid_idv        = $value['idventa'];
      $cid_nom        = $value['nombreproducto'];
      $cid_can        = $value['cantidad'];
      //$cid_sto        = $value['existencia'];
      $cid_pre        = $value['precio'];
      $cid_ord        = $value['num_orden'];
      $cid_pro        = $value['codproducto'];
    }

?>
  </div>
    <div class="col-md-6">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Eliminar datos del producto</h3>
            </div>
            <form method="POST" class="form-horizontal">
                <div class="box-body">
                    <input type="hidden" name="pid" value="<?php echo $cid_idv ?>" />
                    <input type="hidden" name="p_precio" value="<?php echo $cid_pre ?>" />
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
                  <label for="inputEmail3" class="col-sm-4 control-label">Cantidad </label>

                  <div class="col-sm-8">
                    <input type="text" name="p_nuevo" value="<?php echo $cid_can ?>" class="form-control" readonly="" />
                  </div>
                </div>
                
            </div>
                <!-- /.box-body -->
              <div class="box-footer">
                <a href="ord.php?cid=<?php echo $cid_ord ?>" class="btn bg-navy">Volver</a>
                <button type="reset" class="btn btn-default">Cancelar</button>
                <button type="submit" class="btn btn-danger pull-right" value="ACTUALIZAR DATOS AHORA" name="update">Eliminar Datos</button>
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