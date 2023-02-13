<?php
 session_start();
 if(isset($_SESSION["acceso"])) {
    require_once ("../head_unico.php");
?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>Contabilidad / <b>Eliminar Pago</b></h1>
      <ol class="breadcrumb">
        <li><a href="../in.php?cid=dashboard/init"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Contabilidad</a></li>
        <li><a href="#">Empleado</a></li>
        <li class="active"><a href="#"> Actualizar Pago</a></li>
      </ol>
    </section>
<section class="content">
<div class="row"><br>
  <div class="col-md-12">
<?php
 if (isset($_POST['update'])) { // Actualizar datos
    $idemp    = $_POST['_id'];

          $stmt = $db->prepare("UPDATE c_pagos SET id_estado=2, fecha_modificacion=now() WHERE id_pago='$idemp' AND id_estado = 1");
            if ( $stmt->execute() ){
              echo '<div class="alert alert-success">
                    <b>El pago se ha eliminado correctamente!  <a href="../in.php?cid=empleados/frm_pagos">Volver</a></b>
                </div>';
            }else{
                    echo '<div class="alert alert-warning">
                    <b>Error al guardar los cambios!</b>
                </div>';
                }
        
        
}

        $laid = isset($_GET['cid']) ? $_GET['cid'] : 0;
        $sql = $db->prepare("SELECT * FROM c_pagos WHERE id_pago = '$laid' and id_estado=1");
        $sql->execute();
        $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $key => $value) {
            $id          = $value['id_pago'];
            $valor      = $value['valor'];
        }

?>
  </div>
    <div class="col-md-6">
      <div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title">Eliminar el pago del Empleado</h3>
        </div>
        <form method="POST" class="form-horizontal">
          <div class="box-body">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-4 control-label">Valor (*)</label>
              <div class="col-sm-8">
                <input type="hidden" name="_id" value="<?php echo $id ?>" />
                <input type="text" name="valor" value="<?php echo @$valor ?>" class="form-control" readonly="" />
              </div>
            </div>

            </div>
              <div class="box-footer">
                <a href="../in.php?cid=empleados/frm_pagos" class="btn bg-navy">Volver</a>
                <button type="reset" class="btn btn-default">Cancelar</button>
                <button type="submit" class="btn btn-danger pull-right" name="update">Eliminar Pago</button>
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
}?>