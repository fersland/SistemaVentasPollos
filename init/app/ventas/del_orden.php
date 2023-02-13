<?php
/*************************************************/
    /* Ultima actualización: 18-Oct-2019*/
    /* Por: Fernando Reyes N */
    /*************************************************/
 session_start();
 if(isset($_SESSION["correo"])) {   
	require_once ('./'."../head_unico.php");
	require_once ('./'."../../../../datos/db/connect.php");
    require_once ('./'."../../../../controlador/filter/class.inputfilter.php");
	$fflush = new InputFilter();
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Facturación<small>Eliminar Orden</small></h1>
      <ol class="breadcrumb">
        <li><a href="../in.php?cid=dashboard/init"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Ventas</a></li>
        <li><a href="../in.php?cid=clientes/frm_clientes">Facturación</a></li>
        <li class="active"><a href="../in.php?cid=ventas/show_pendientes">Eliminar Orden</a></li>
      </ol>

    </section>

<!-- Main content -->
<section class="content">
<div class="row"><br />

  <div class="col-md-12">

<?php
 // Actualizar datos

 if (isset($_POST['update'])) {
    $upd_ord       = $fflush->process($_POST['p_orden']);                

    // Actualizar el stock en inventario

    // Incrementar el inventario
    $cs = DBSTART::abrirDB()->prepare("SELECT * FROM c_venta_detalle WHERE num_orden = '$upd_ord' AND estado='A'");
    $cs->execute();
    $send = $cs->fetchAll(PDO::FETCH_ASSOC);


    foreach ((array) $send as $value_key) {
      $codp = $value_key['codigo'];
      $cani = $value_key['cantidad'];
      //$laord = $value_key['num_orden'];

      $inc = DBSTART::abrirDB()->prepare("UPDATE c_mercaderia SET existencia = existencia + '$cani' 
                                            WHERE codproducto = '$codp'");
      $inc->execute();

    }
    // Desactivar la orden en show pendientes
    $x = DBSTART::abrirDB()->prepare("UPDATE c_venta_detalle SET estado='X' WHERE num_orden = '$upd_ord'");
    $x->execute();

    echo '<div class="alert alert-success">
              <b>Cambios guardados!</b> <span class="badge bg-orange"><a href="../in.php?cid=ventas/show_pendientes">Volver</a></span>
            </div>';
}

    $laid = isset($_GET['cid']) ? $_GET['cid'] : 0;

    $sql = DBSTART::abrirDB()->prepare("SELECT * FROM c_venta_detalle WHERE num_orden = '$laid' AND estado='A'");

    $sql->execute();
    $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $key => $value) {
      $cid_ord        = $value['num_orden'];
    }
?>

  </div>
    <div class="col-md-6">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Eliminar la Orden</h3>
            </div>
            <form method="POST" class="form-horizontal">
                <div class="box-body">

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Número Orden </label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="p_orden" value="<?php echo $cid_ord ?>" />
                  </div>
                </div>
            </div>

                <!-- /.box-body -->

              <div class="box-footer">

                <a href="../in.php?cid=ventas/show_pendientes" class="btn bg-navy">Volver</a>

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
    header('Location:  ../../../../index.php');
}
 ?>