<?php
 session_start();
 if(isset($_SESSION["acceso"]))  {        
	require_once ("../head_unico.php");
?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Inventario / 
        <b>Confirmar eliminaci&oacute;n del producto</b>
      </h1>

    </section>

<section class="content">
<div class="row"><br />
<div class="col-md-12">
    <?php if (isset($_POST['reload'])) { require_once ("../../../controlador/c_mercaderia/load_imagen.php"); } ?>
    </div>
  <div class="col-md-12">
<?php // Eliminar datos

if (isset($_POST['del'])) {
    $id_form = htmlspecialchars($_POST['upd_id']);
    $stmt = $db->prepare("UPDATE c_mercaderia SET estado = 'X' WHERE idp='$id_form'");
     if ($stmt->execute()) {
            echo '<div class="alert alert-success">
                    <b><i class="fa fa-check"></i> Eliminado correctamente.</b>
                  </div>';
            }else{
                echo '<div class="alert alert-danger">
                        <b><i class="fa fa-remove"></i> Error al Eliminar.</b>
                      </div>';
            }
    
    }

    $laid = isset($_GET['cid']) ? $_GET['cid'] : 0;

    $sql = $db->prepare("SELECT * FROM c_mercaderia WHERE idp = '$laid' AND estado='A'");
    $sql->execute();
    $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $key => $value) {
      $id   = $value['idp'];
      $codi          = $value['codproducto'];
      $nombrep     = $value['nombreproducto'];
      $exis = $value['existencia'];
      $priceventa = $value['precio_venta'];
      $ruta = $value['ruta'];
    }
 ?>
  </div>
  <div class="col-md-6">
    <div class="box box-danger">
      <div class="box-header with-border">
          <h3 class="box-title">Formulario de confirmación</h3>
      </div>
      <form method="POST" class="form-horizontal">
      <input type="hidden" name="upd_id" value="<?php echo $id ?>" />
        <div class="box-body">
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">CODIGO DE PRODUCTO</label>
            <div class="col-sm-8">
              <input type="text" name="_codigo" value="<?php echo @$codi?>" class="form-control" readonly="" />
            </div>
          </div>
          
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">NOMBRE DE PRODUCTO</label>
            <div class="col-sm-8">
              <input type="text" name="nombrepro" value="<?php echo @$nombrep?>" class="form-control" readonly="" />
            </div>
          </div>

        </div>
        <div class="box-footer">
          <a href="../in.php?cid=mercaderia/mercaderia" class="btn bg-navy"><i class="fa fa-reply"></i> Volver</a>
          
          <button type="submit" class="btn btn-danger pull-right" name="del"><i class="fa fa-remove"></i> Eliminar!</button>
                  </div>
      </form><br /><br />
</div>
</div><!-- FIN COL-MD-6 -->

</section>
</div>
<?php require_once ("../foot_unico.php");
}else{
    session_unset();
    session_destroy();
    header('Location:  ../../../../index.php');
}?>