<?php
session_start();
 if(isset($_SESSION["acceso"]))  { 
        
    require_once ("../head_unico.php");
    require_once ("../../../datos/db/connect.php");
?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Inventario
        <small>Eliminar Herramienta</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="../in.php?cid=dashboard/init"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="../in.php?cid=mercaderia/mercaderia">Inventario</a></li>
        <li><a href="../in.php?cid=activos/frm_activos">Activos</a></li>
        <li><a href="../in.php?cid=herramientas/frm_herramientas">Herramientas</a></li>
        <li class="active"><a href="#">Eliminar Herramienta</a></li>
      </ol>
    </section>

<!-- Main content -->
<section class="content">
<div class="row"><br />
    <div class="col-md-12">
<?php
 // Actualizar datos
 if (isset($_POST['delete'])) {
    $id    = $_POST['_id'];

     $stmt = $db->prepare("UPDATE c_herramientas SET estado= 'I', fecha_eliminacion=now() WHERE id_herramientas='$id'");
     
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

        $sql = $db->prepare("SELECT * FROM c_herramientas WHERE id_herramientas = '$laid' AND estado='A'");
        $sql->execute();
        $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $key => $value) {
            $ids          = $value['id_herramientas'];
            $nombres     = $value['descripcion'];
        }
}
 ?>
    </div>
    <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Eliminar Herramienta</h3>
            </div>
            <form method="POST" class="form-horizontal">
                <input type="hidden" name="_id" value="<?php echo $ids ?>" />

                <div class="box-body">
                    <div class="form-group">
                  <label for="inputEmail3" class="col-sm-5 control-label">Nombre de la Herramienta</label>

                  <div class="col-sm-7">
                    <input type="text" name="_nombres" value="<?php echo $nombres?>" class="form-control" readonly="" />
                  </div>
                </div>

                </div>

                <div class="box-footer">
                <a href="../in.php?cid=herramientas/frm_herramientas" class="btn bg-navy">Volver</a>
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