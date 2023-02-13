<?php
session_start();
 if(isset($_SESSION["acceso"])) {
    require_once ("../head_unico.php");
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Adminstración
        <small>Eliminar Categoria</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="../in.php?cid=dashboard/init"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Administración</a></li>
        <li>Categorias</li>
        <li class="active">Categorias Eliminar</li>
      </ol>
    </section>


<!-- Main content -->
<section class="content">
<div class="row"><br>
<div class="col-md-12">
<?php
 // Actualizar datos
 if (isset($_POST['delete'])) {

    $id    = $_POST['_id'];
    $na    = strtoupper($_POST['_nombres']);
    $ob    = strtoupper($_POST['_obs']);

     $stmt = $db->prepare(
        "UPDATE c_categoria SET estado= 'I', fecha_eliminacion=now() WHERE id_categoria='$id'");
     
     if ( $stmt->execute() ){

     echo '<div class="alert alert-danger">
                <b>Datos eliminados correctamente!</b>
            </div>';
            }else{
                echo '<div class="alert alert-warning">
                <b>Error al guardar los cambios!</b>
            </div>';
            }
}

if (isset($_REQUEST['cid'])){
        $laid = $_REQUEST['cid'];

        $sql = $db->prepare("SELECT * FROM c_categoria WHERE id_categoria = '$laid' AND estado='A'");
        $sql->execute();
        $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $key => $value) {
            $id          = $value['id_categoria'];
            $nombres     = $value['nombre'];
            $obs     = $value['observacion'];
        }
}
 ?>
</div>
    <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Eliminar Categoria</h3>
            </div>
            <form method="POST" class="form-horizontal">
                <input type="hidden" name="_id" value="<?php echo @$id ?>" />

                <div class="box-body">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-4 control-label">C&oacute;digo / Categoria</label>

                      <div class="col-sm-8">
                        <input type="text" readonly="" name="_nombres" value="<?php echo @$nombres?>" class="form-control" />
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-4 control-label">Descripci&oacute;n</label>
                      <div class="col-sm-8">
                        <input type="text" readonly="" name="_obs" value="<?php echo @$obs?>" class="form-control" />
                      </div>
                    </div>
                
                </div>

                <div class="box-footer">
                <a href="../in.php?cid=categoria/frm_categoria_producto" class="btn bg-navy">Volver</a>
                <button type="submit" class="btn btn-danger pull-right" value="ELIMINAR DATOS AHORA" name="delete">Eliminar Datos</button>
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