<?php
session_start();
 if(isset($_SESSION["acceso"])) {
    require_once ("../head_unico.php");
    
    if (isset($_REQUEST['cid'])){
        $laid = $_REQUEST['cid'];

        $sql = $db->prepare("SELECT * FROM c_activos WHERE id_activos = '$laid' AND estado='A'");
        $sql->execute();
        $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $key => $value) {
            $id          = $value['id_activos'];
            $empresa     = $value['id_empresa'];
            $nombres     = $value['descripcion'];
        }
}?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Inventario
        <small>Eliminar Activo</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="../in.php?cid=dashboard/init"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Inventario</a></li>
        <li class="active">Eliminar Activo</li>
      </ol>
    </section>


 <?php 
 // Actualizar datos
 if (isset($_POST['delete'])) {
    $id    = $_POST['_id'];
    $em    = $_POST['_empresa'];

     $stmt = $db->prepare("UPDATE c_activos SET estado= 'I', fecha_eliminacion=now() WHERE id_activos='$id'");
     
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
 ?>

<!-- Main content -->
<section class="content">
<div class="row"><br>
    <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Eliminar Activo</h3>
            </div>
            <form method="POST" class="form-horizontal">
                <input type="hidden" name="_id" value="<?php echo $id ?>" />
                <input type="hidden" name="_empresa" value="<?php echo $empresa?>" class="form-control" />

                <div class="box-body">
                    <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Nombre del Activo</label>

                  <div class="col-sm-8">
                    <input type="text" name="_nombres" value="<?php echo $nombres?>" class="form-control" readonly="" />
                  </div>
                </div>

                </div>

                <div class="box-footer">
                <a href="../in.php?cid=activos/frm_activos" class="btn bg-navy">Volver</a>
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