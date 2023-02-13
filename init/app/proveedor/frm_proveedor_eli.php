<?php
  session_start();
  if(isset($_SESSION["acceso"])) {
    require_once ("../head_unico.php");
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Administraci&oacute;n / Proveedor <small>Eliminar</small></h1>
    </section>

<!-- Main content -->
<section class="content">
<div class="row"><br />
  <div class="col-md-12">
    
 <?php 
 // Actualizar datos
 if (isset($_POST['delete'])) {
    $idemp    = $_POST['_id'];
    $ru       = $_POST['_ruc'];
    $na       = strtoupper($_POST['_nombres']);

     $stmt = $db->prepare(
        "UPDATE c_proveedor SET estado='I', fecha_modificacion=now() WHERE id_proveedor='$idemp'");
     $stmt->execute();

     if ( $stmt->execute() ){

     echo '<div class="alert alert-success">
                <b><i class="fa fa-check"></i> El proveedor ha sido eliminado!</b>
            </div>';
            }else{
                echo '<div class="alert alert-warning">
                <b><i class="fa fa-remove"></i> Error al eliminar el proveedor!</b>
            </div>';
            }
}


    if (isset($_REQUEST['cid'])){
        $laid = $_REQUEST['cid'];

        $sql = $db->prepare("SELECT * FROM c_proveedor WHERE id_proveedor = '$laid' AND estado='A'");
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
        }
}
?>
  </div>
    <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Eliminar datos del proveedor</h3>
            </div>
            <form method="POST" class="form-horizontal">
                <div class="box-body">
                    <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">CI/NIT</label>

                  <div class="col-sm-8">
                    <input type="hidden" name="_id" value="<?php echo @$id ?>">
                    <input type="text" name="_ruc" value="<?php echo @$ruc ?>" class="form-control"  readonly="" />
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Nombre Proveedor</label>

                  <div class="col-sm-8">
                    <input type="text" name="_nombres" value="<?php echo @$nombres ?>" class="form-control"  readonly="" />
                  </div>
                </div>
                </div>

                <div class="box-footer">
                <a href="../in.php?cid=proveedor/frm_proveedor" class="btn bg-navy"><i class="fa fa-reply"></i> Volver</a>
                <button type="submit" class="btn btn-danger pull-right" name="delete"><i class="fa fa-check-square-o"></i> Eliminar Datos</button>
              </div>
            </form>
<br /><br />

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