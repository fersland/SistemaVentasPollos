<?php
 session_start();
 if(isset($_SESSION["acceso"])) {
    require_once ("../head_unico.php");
    
        $laid = isset($_GET['cid']) ? $_GET['cid'] : 0;

        $sql = $db->prepare("SELECT sum(cantidad) as lacantidad, sum(cantidad_litros) as loslitros,ncompra,id_empresa,codigo,bodega_compra 
                                                FROM c_compra_detalle WHERE ncompra = '$laid'");
        $sql->execute();
        $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $key => $value) {
            $idv         = $value['ncompra'];
            $empresa     = $value['id_empresa'];
            $cod         = $value['codigo'];
            $cant_s      = $value['lacantidad'];
            $cant_l      = $value['loslitros'];
            $bod         = $value['bodega_compra'];
        }

    // La lista de compras
    $list = $db->prepare("SELECT * FROM c_compra_detalle WHERE ncompra = '$laid' AND id_empresa = '$empresa' AND estado = 'I'");
    $list->execute();
    $all_list = $list->fetchAll(PDO::FETCH_ASSOC);
    $nuevonum = $list->rowCount();

    // Verificar si hay una compra pendiente de finalizar o actualizacion sin finalizar
    $cs = $db->prepare("SELECT * FROM c_compra_detalle WHERE estado = 'A'");
    $cs->execute();
    $cantidad = $cs->rowCount();
 ?>

  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Compras
        <small>Actualizar Compra</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="../in.php?cid=dashboard/init"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Administración</a></li>
        <li><a href="#">Empresa</a></li>
        <li><a href="#">IVA</a></li>
        <li><a href="#">Empleados</a></li>
        <li><a href="#">Proveedor</a></li>
        <li><a href="#">Categoría</a></li>
        <li class="active"><a href="../in.php?cid=clientes/frm_clientes">Clientes</a></li>
        <li class="active">Actualizar Clientes</li>
      </ol>
    </section>


<?php
 // Actualizar datos
 if (isset($_POST['realizar'])) {
    $id         = $_POST['factura'];

    // Actualizar el stock en mercaderia
    $stmt = $db->prepare("DELETE FROM c_compra WHERE ncompra='$id'");
    if ( $stmt->execute() ){
        // Eliminar la cuenta por pagar de esta compra
        $cxp = $db->prepare("DELETE FROM c_cxp WHERE ncompra='$id'");
        $cxp->execute();
        
        $cxpd = $db->prepare("DELETE FROM c_cxp_detalle WHERE ncompra='$id'");
        $cxpd->execute();        
        
        // Devolver el stock original
        $stmt = $db->prepare("UPDATE c_compra_detalle SET estado = 'A' WHERE ncompra='$id' and estado = 'I' ");
        $stmt->execute();

        echo '<script type="text/javascript">
                    window.location.href = "../in.php?cid=compras/frm_compras_ingreso";
              </script>';
    }else{
        echo '<div class="alert alert-warning">
                  <b>Error al eliminar!</b></div>';
    }
}
?>
<section class="content">
<?php if ($cantidad == 0) { ?>

<div class="row">
        <div class="col-lg-12">
            <div class="alert alert-danger" style="margin-top: 10px; height: 110px">
              <h4><i class="fa fa-info"></i> Precaución:</h4>
              
              <p>
                Al confirmar la edición de la compra será redireccionado al formulario de compra, donde
                podrá realizar la edición.</p>
                <p>Los pagos realizados de la cuenta por pagar de esta compra, seran eliminados, al realizar cambios en los valores en la edición de esta compra.</p>
            </div>
        </div>
    </div>

<div class="row">
    <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Actualizar datos de la Compra</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" class="form-horizontal">
                <div class="box-body">

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Número de Compra <span class="ast">(*)</span></label>

                  <div class="col-sm-8">
                    <input type="text" name="factura" value="<?php echo $idv ?>" class="form-control" readonly="" />
                  </div>
                </div>
                
            </div>
                <!-- /.box-body -->
              <div class="box-footer">
                <a href="../in.php?cid=compras/frm_ver_compras" class="btn bg-navy">Volver</a>
                <button type="reset" class="btn btn-default">Cancelar</button>
                <button type="submit" class="btn btn-danger pull-right" name="realizar">Ir a Actualización</button>
              </div>
              <!-- /.box-footer -->
            </form>
</div>
</div>
</div>

<?php }else { ?>

<div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning" style="margin-top: 10px; height: 110px">
                <h4><i class="fa fa-info"></i> Nota:</h4>
              <h4>NO PUEDE REALIZAR UNA ACTUALIZACIÓN HASTA QUE NO FINALICE UNA COMPRA EXISTENTE SIN FINALIZAR</h4>
              <p>
                <strong>Precaución</strong> Si desea finalizar la compra ahora, haga click <a href="../in.php?cid=compras/frm_compras_ingreso">Aquí</a></p>
            </div>
        </div>
    </div>
 <?php }?>

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