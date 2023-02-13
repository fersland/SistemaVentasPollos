<?php
 session_start();
 if(isset($_SESSION["acceso"])) {
	require_once ('./'."../head_unico.php");
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Moneda / <b>Eliminar Datos</b></h1>

    </section>
<section class="content">
<div class="row"><br />
  <div class="col-md-12">
<?php
 if (isset($_POST['update'])) { // Actualizar datos

    $upd_id        = htmlspecialchars($_POST['p_id']);
    $upd_abrv       = htmlspecialchars(strtoupper($_POST['p_abrv']));
    $upd_nombre      = htmlspecialchars(strtoupper($_POST['p_nombre']));

    $stmt = $db->prepare("UPDATE c_moneda SET estado=2 WHERE id= :id");
                        
                        $stmt->bindParam(':id',         $upd_id,  PDO::PARAM_INT);
   if ($stmt->execute() ) {
     echo '<div class="alert alert-success">
                <b>Cambios guardados! </b>
            </div>'; 
   }else{
     echo '<div class="alert alert-danger">
                <b>Error al cambiar datos!</b>
            </div>';
   }
}

   $laid = isset($_GET['cid']) ? $_GET['cid'] : 0;

    $sql = $db->prepare("SELECT * FROM c_moneda WHERE id = ?");
    $sql->execute(array($laid));
    $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $key => $value) {
      $cid_id         = $value['id'];
      $cid_abrv        = $value['abrv'];
      $cid_nombre        = $value['nombre'];
    }
?>
  </div>
    <div class="col-md-6">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Eliminar datos</h3>
            </div>
            <form method="POST" class="form-horizontal">
                <div class="box-body">
                    <input type="hidden" name="p_id" value="<?php echo $cid_id ?>" />
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Nombre (*)</label>
                  <div class="col-sm-8">
                    <input type="text" name="p_nombre" value="<?php echo $cid_nombre ?>" class="form-control" onkeypress="return caracteres(event)" readonly="" />
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Abreviatura (*)</label>
                  <div class="col-sm-8">
                    <input type="text" name="p_abrv" value="<?php echo $cid_abrv ?>" class="form-control" onkeypress="return caracteres(event)" readonly="" />
                  </div>
                </div>
            </div>
              <div class="box-footer"> <!-- /.box-body -->
                <a href="../in.php?cid=moneda/frm_moneda" class="btn bg-navy">Volver</a>
                <button type="submit" class="btn btn-danger pull-right" name="update">Eliminar Datos</button>
              </div>
    </form>
</div>
</div>
</div>
</section>
</div>
<?php
require_once ('./'."../foot_unico.php");
}else{
    session_unset();
    session_destroy();
    header('Location:  ../../../index.php');
}?>