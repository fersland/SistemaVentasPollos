<?php
 session_start();
 if(isset($_SESSION["acceso"]))  { 
    require_once ("../head_unico.php");
?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>Administraci&oacute;n / Proveedor <small>Actualizar</small></h1>
    </section>

<!-- Main content -->
<section class="content">
<div class="row"><br />
  <div class="col-md-12">
<?php

 // Actualizar datos
 if (isset($_POST['update'])) {
    $idemp    = $_POST['_id'];
    $ru       = $_POST['_ruc'];
    $na       = strtoupper($_POST['_nombres']);
    $di       = strtoupper($_POST['_direccion']);
    $te       = $_POST['_telefono'];
    $ce       = $_POST['_celular'];
    $co       = $_POST['_correo'];
    $obs       = $_POST['_obs'];

     $stmt = $db->prepare(
        "UPDATE c_proveedor SET ruc = '$ru', nombreproveedor='$na', direccion='$di', telefono='$te', celular='$ce' ,correo='$co',observacion='$obs',
         fecha_modificacion=now()
         WHERE id_proveedor='$idemp'");
     $stmt->execute();

     if ( $stmt->execute() ){

     echo '<div class="alert alert-success">
                <b><i class="fa fa-check"></i> Cambios guardados! </b>
            </div>';
            }else{
                echo '<div class="alert alert-warning">
                <b><i class="fa fa-remove"></i> Error al guardar los cambios!</b>
            </div>';
            }
}


    $laid = isset($_GET['cid']) ? $_GET['cid'] : 0;

        $sql = $db->prepare("SELECT * FROM c_proveedor WHERE id_proveedor = '$laid'");
        $sql->execute();
        $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $key => $value) {
            $id          = $value['id_proveedor'];
            $ruc         = $value['ruc'];
            $nombres     = $value['nombreproveedor'];
            $direccion   = $value['direccion'];
            $telefono    = $value['telefono'];
            $celular     = $value['celular'];
            $correo      = $value['correo'];
            $observ      = $value['observacion'];
        }

 ?>
  </div>
    <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Actualizar datos del proveedor</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" class="form-horizontal">
                <div class="box-body">

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">CI/NIT <span class="ast">(*)</span></label>

                  <div class="col-sm-8">
                    <input type="hidden" name="_id" value="<?php echo $id ?>">
                    <input type="text" maxlength="13" name="_ruc" value="<?php echo $ruc ?>" class="form-control" onkeypress="return soloNumeros(event)">
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Nombres Empresa <span class="ast">(*)</span></label>

                  <div class="col-sm-8">
                    <input type="text" name="_nombres" value="<?php echo $nombres ?>" class="form-control">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Dirección </label>

                  <div class="col-sm-8">
                    <input type="text"  name="_direccion" value="<?php echo $direccion ?>" class="form-control">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Teléfono </label>

                  <div class="col-sm-8">
                    <input type="text" name="_telefono" value="<?php echo $telefono ?>" class="form-control" onkeypress="return soloNumeros(event)">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Celular </label>

                  <div class="col-sm-8">
                    <input type="text" name="_celular" value="<?php echo $celular ?>" class="form-control" onkeypress="return soloNumeros(event)">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Correo Electrónico </label>

                  <div class="col-sm-8">
                    <input type="text" name="_correo" value="<?php echo $correo ?>" class="form-control">
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Observación </label>

                  <div class="col-sm-8">
                    <input type="text" name="_obs" value="<?php echo $observ ?>" class="form-control">
                  </div>
                </div>
            </div>
                <!-- /.box-body -->
              <div class="box-footer">
                <a href="../in.php?cid=proveedor/frm_proveedor" class="btn bg-navy"><i class="fa fa-reply"></i> Volver</a>
                <button type="reset" class="btn btn-default"><i class="fa fa-refresh"></i> Cancelar</button>
                <button type="submit" class="btn btn-warning pull-right" name="update"><i class="fa fa-check-square-o"></i> Actualizar Datos</button>
              </div>
              <!-- /.box-footer -->
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