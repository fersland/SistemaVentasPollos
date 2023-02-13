<?php
 session_start();
 if(isset($_SESSION["acceso"])) {
	require_once ('./'."../head_unico.php");
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Moneda / <b>Actualizar Datos</b></h1>

    </section>
<section class="content">
<div class="row"><br />
  <div class="col-md-12">
<?php
 if (isset($_POST['update'])) { // Actualizar datos

    $upd_id       = htmlspecialchars($_POST['p_id']);
    $upd_abrv     = htmlspecialchars($_POST['p_abrv']);
    $upd_nombre   = htmlspecialchars($_POST['p_nombre']);
    $upd_dec      = htmlspecialchars($_POST['p_dec']);
    $upd_signo    = htmlspecialchars($_POST['p_signo']);

    $stmt = $db->prepare("UPDATE c_moneda SET nombre  = :nombre, abrv = :abrv, decimales= :dec, signo=:sig WHERE id= :id AND estado = 1");
                                
                        $stmt->bindParam(':nombre',    $upd_nombre, PDO::PARAM_STR);
                        $stmt->bindParam(':abrv',     $upd_abrv, PDO::PARAM_STR);
                        $stmt->bindParam(':dec',     $upd_dec, PDO::PARAM_INT);
                        $stmt->bindParam(':sig',     $upd_signo, PDO::PARAM_STR);
                        
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

    $sql = $db->prepare("SELECT * FROM c_moneda WHERE id = ? AND estado = 1");
    $sql->execute(array($laid));
    $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $key => $value) {
      $cid_id         = $value['id'];
      $cid_abrv        = $value['abrv'];
      $cid_nombre        = $value['nombre'];
      $cid_dec        = $value['decimales'];
      $cid_sig        = $value['signo'];
    }
?>
  </div>
    <div class="col-md-6">
          <div class="box box-warning">
            <div class="box-header with-border">
            </div>
            <form method="POST" class="form-horizontal">
                <div class="box-body">
                    <input type="hidden" name="p_id" value="<?php echo $cid_id ?>" />
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Nombre (*)</label>
                  <div class="col-sm-8">
                    <input type="text" name="p_nombre" value="<?php echo $cid_nombre ?>" class="form-control" onkeypress="return caracteres(event)" />
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Abreviatura (*)</label>
                  <div class="col-sm-8">
                    <input type="text" name="p_abrv" value="<?php echo $cid_abrv ?>" class="form-control" onkeypress="return caracteres(event)" />
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Decimales (*)</label>
                  <div class="col-sm-8">
                    <input type="number" name="p_dec" value="<?php echo $cid_dec ?>" class="form-control" placeholder="Por ejemplo: 2" />
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Signo (*)</label>
                  <div class="col-sm-8">
                    <input type="text" name="p_signo" value="<?php echo $cid_sig ?>" class="form-control" placeholder="Por ejemplo: $" />
                  </div>
                </div>
            </div>
              <div class="box-footer"> <!-- /.box-body -->
                <a href="../in.php?cid=moneda/frm_moneda" class="btn bg-navy">Volver</a>
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