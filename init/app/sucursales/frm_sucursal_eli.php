<?php
 session_start();
 if(isset($_SESSION["acceso"])) {
    require_once ("../head_unico.php");
?>

  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Administración / 
        <b>Eliminar Sucursal</b>
      </h1>
      <ol class="breadcrumb">
        <li><a href="../in.php?cid=dashboard/init"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Sucursal</a></li>
        <li class="active"><a href="#">Eliminar Sucursal</a></li>
      </ol>
    </section>

<!-- Main content -->
<section class="content">
<div class="row">
  <div class="col-md-12">
   <?php 
 // Actualizar datos
 if (isset($_POST['update'])) {

    $id       = $_POST['_id'];
    $na       = htmlspecialchars(strtoupper($_POST['_nombres']));

    if ($na == "") {
        echo '<div class="alert alert-warning">
                <b>Debe asignar un nombre a la Categoria!</b>
            </div>';
    }else{
     $stmt = $db->prepare("UPDATE c_sucursal SET id_estado = 2 WHERE id_sucursal=:id");
     
     $stmt->bindParam(':id', $id, PDO::PARAM_INT);
          
     if ( $stmt->execute() ){

     echo '<div class="alert alert-success">
                <b>Cambios guardados!</b>
            </div>';
            }else{
                echo '<div class="alert alert-warning">
                <b>Error al guardar los cambios!</b>
            </div>';
            }    
    }
}

        $laid = isset($_GET['cid']) ? $_GET['cid'] : 0;

        $sql = $db->prepare("SELECT * FROM c_sucursal WHERE id_sucursal = '$laid' AND id_estado=1");
        $sql->execute();
        $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $key => $value) {
            $id          = $value['id_sucursal'];
            $nombres     = $value['nombre'];
            $direccion   = $value['direccion'];
        }
 ?>
  </div>
    <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Eliminar Sucursal</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" class="form-horizontal">
                <div class="box-body">
                    <input type="hidden" name="_id" value="<?php echo $id ?>" />
            
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Nombre Sucursal (*)</label>
                  <div class="col-sm-8">
                    <input type="text" name="_nombres" value="<?php echo @$nombres?>" class="form-control" required="" readonly="" />
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Direcci&oacute;n</label>
                  <div class="col-sm-8">
                    <input type="text" name="_direccion" value="<?php echo @$direccion?>" class="form-control" readonly="" />
                  </div>
                </div>

                
                </div>
                <!-- /.box-body -->
              <div class="box-footer">
                <a href="../in.php?cid=sucursales/frm_sucursales" class="btn bg-navy">Volver</a>
                <button type="reset" class="btn btn-default">Cancelar</button>
                <button type="submit" class="btn btn-danger pull-right" name="update">Eliminar Datos</button>
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