<?php
 session_start();
 if(isset($_SESSION["acceso"])) {
	require_once ('./'."../head_unico.php");
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Clientes / <b>Actualizar Datos</b></h1>

    </section>
<section class="content">
<div class="row"><br />
  <div class="col-md-12">
<?php
 if (isset($_POST['update'])) { // Actualizar datos

    $upd_id        = htmlspecialchars($_POST['p_id']);
    $upd_ced       = htmlspecialchars($_POST['p_cedula']);
    $upd_nom       = htmlspecialchars($_POST['p_nombres']);
    $upd_cor       = htmlspecialchars($_POST['p_correo']);
    $upd_tel       = htmlspecialchars($_POST['p_telefono']);
    $upd_cel       = htmlspecialchars($_POST['p_celular']);    
    $upd_dir       = htmlspecialchars($_POST['p_direccion']);

    $stmt = $db->prepare("UPDATE c_clientes
                            SET 
                                cedula  = :cedula,
                                nombres = :nombres,
                                correo  = :correo,
                                telefono= :telefono,
                                celular = :celular,
                                direccion_cliente  = :direccion
                                
                                WHERE id_cliente= :id");
                                
                        $stmt->bindParam(':cedula',     $upd_ced, PDO::PARAM_STR);
                        $stmt->bindParam(':nombres',    $upd_nom, PDO::PARAM_STR);
                        $stmt->bindParam(':correo',     $upd_cor, PDO::PARAM_STR);
                        $stmt->bindParam(':telefono',   $upd_tel, PDO::PARAM_STR);
                        $stmt->bindParam(':celular',    $upd_cel, PDO::PARAM_STR);
                        $stmt->bindParam(':direccion',  $upd_dir, PDO::PARAM_STR);
                        
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

    $sql = $db->prepare("SELECT * FROM c_clientes WHERE id_cliente = ?");
    $sql->execute(array($laid));
    $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $key => $value) {
      $cid_id         = $value['id_cliente'];
      $cid_ced        = $value['cedula'];
      $cid_nom        = $value['nombres'];
      $cid_cor        = $value['correo'];
      $cid_tel        = $value['telefono'];
      $cid_cel        = $value['celular'];
      $cid_dir        = $value['direccion_cliente'];
    }
?>
  </div>
    <div class="col-md-6">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Actualizar datos del cliente</h3>
            </div>
            <form method="POST" class="form-horizontal">
                <div class="box-body">
                    <input type="hidden" name="p_id" value="<?php echo $cid_id ?>" />
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Identificación <span class="ast">(*)</span></label>
                  <div class="col-sm-8">
                    <input type="text" name="p_cedula" value="<?php echo $cid_ced ?>" class="form-control" onkeypress="return soloNumeros(event)" />
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Nombres y Apellidos <span class="ast">(*)</span></label>
                  <div class="col-sm-8">
                    <input type="text" name="p_nombres" value="<?php echo $cid_nom ?>" class="form-control" onkeypress="return caracteres(event)" />
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Correo Electrónico </label>
                  <div class="col-sm-8">
                    <input type="text" name="p_correo" value="<?php echo $cid_cor ?>" class="form-control" />
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Teléfono </label>
                  <div class="col-sm-8">
                    <input type="text" name="p_telefono" value="<?php echo $cid_tel ?>" onkeypress="return soloNumeros(event)"  class="form-control" />
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Celular </label>
                  <div class="col-sm-8">
                    <input type="text" name="p_celular" value="<?php echo $cid_cel ?>" onkeypress="return soloNumeros(event)"  class="form-control" />
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Dirección </label>
                  <div class="col-sm-8">
                    <input type="text" name="p_direccion" value="<?php echo $cid_dir ?>" class="form-control" />
                  </div>
                </div>
            </div>
              <div class="box-footer"> <!-- /.box-body -->
                <a href="../in.php?cid=clientes/frm_clientes" class="btn bg-navy">Volver</a>
                <button type="reset" class="btn btn-default">Cancelar</button>
                <button type="submit" class="btn btn-warning pull-right" name="update">Actualizar Datos</button>
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