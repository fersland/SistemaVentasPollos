<?php
 session_start();
 if(isset($_SESSION["acceso"])) {
	require_once ('./'."../head_unico.php");
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Clientes / <b>Ingreso de Saldo a Favor del Cliente</b></h1>

    </section>
<section class="content">
<div class="row"><br />
  <div class="col-md-12">
<?php
 if (isset($_POST['update'])) { // Actualizar datos

    $upd_id        = htmlspecialchars($_POST['p_id']);
    $upd_ced       = htmlspecialchars($_POST['p_cedula']);
    $upd_nom       = htmlspecialchars($_POST['p_nombres']);
    $upd_saldo     = htmlspecialchars($_POST['saldo']);
    

    $stmt = $db->prepare("UPDATE c_clientes
                            SET 
                                excedente=:ex
                                
                                WHERE cedula= :id");
                                
                        $stmt->bindParam(':ex',     $upd_saldo, PDO::PARAM_STR);
                        $stmt->bindParam(':id',         $upd_ced,  PDO::PARAM_STR);
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

    $sql = $db->prepare("SELECT * FROM c_clientes WHERE cedula = ?");
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
      $cid_saldo        = $value['excedente'];
    }
?>
  </div>
    <div class="col-md-6">
          <div class="box box-warning">
            <form method="POST" class="form-horizontal">
                <div class="box-body">
                    <input type="hidden" name="p_id" value="<?php echo $cid_id ?>" />
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Identificación <span class="ast">(*)</span></label>
                  <div class="col-sm-8">
                    <input type="text" name="p_cedula" value="<?php echo $cid_ced ?>" class="form-control" readonly="" onkeypress="return soloNumeros(event)" />
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Nombres y Apellidos <span class="ast">(*)</span></label>
                  <div class="col-sm-8">
                    <input type="text" name="p_nombres" value="<?php echo $cid_nom ?>" class="form-control" readonly="" onkeypress="return caracteres(event)" />
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Saldo a Favor del Cliente <span class="ast">(*)</span></label>
                  <div class="col-sm-8">
                    <input type="number" step="0.01" name="saldo" value="<?php echo $cid_saldo ?>" class="form-control"  />
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