<?php

 session_start();
 if(isset($_SESSION["acceso"])) {   
	require_once ("../head_unico.php");
?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>SEGURIDAD / <b>ELIMINAR USUARIOS</b></h1>
    </section>

<!-- Main content -->
<section class="content">
<div class="row"><br>
  <div class="col-md-12">
<?php
 if (isset($_POST['update'])) {
    $updid        = $_POST['pid'];
    $updstd       = $_POST['status'];

   $stmt = $db->prepare("UPDATE c_usuarios SET estado='$updstd' WHERE id_usuario='$updid'");
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

// ESTADO
	$roles = $db->prepare("SELECT * FROM c_estado");
    $roles->execute();
    $rows_roles = $roles->fetchAll(PDO::FETCH_ASSOC);


if (isset($_REQUEST['cid'])){
    $laid = $_REQUEST['cid'];

    $sql = $db->prepare("SELECT u.id_usuario, u.correo, u.nivelacceso, u.estado FROM c_usuarios u INNER JOIN c_roles r ON r.idrol = u.nivelacceso WHERE u.id_usuario = '$laid' AND u.estado='A'");
    $sql->execute();
    $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $key => $value) {
      $cid_id         = $value['id_usuario'];
      $cid_cor        = $value['correo'];
      $cid_rol  	  = $value['nivelacceso'];
      $cid_std        = $value['estado'];
    }
}
?>
  </div>
    <div class="col-md-6">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Eliminar datos del usuario</h3>
            </div>
            <form method="POST" class="form-horizontal">
                <div class="box-body">
                    <input type="hidden" name="pid" value="<?php echo $laid ?>" />

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-5 control-label">ESTADO (*)</label>

                  <div class="col-sm-7">
                    <select class="form-control" name="status">
                    	<?php foreach ((array) $rows_roles as $key => $value_roles) { ?>
                    		<?php if ($value_roles['estado'] == $cid_std){ ?>
                    			<option style="background: lightgreen" value="<?php echo $value_roles['estado'] ?>" selected><?php echo $value_roles['nombre'] ?></option>	
                    		<?php }else{ ?>
                    		<option value="<?php echo $value_roles['estado'] ?>"><?php echo $value_roles['nombre'] ?></option>
                    	<?php } } ?>
                    </select>
                  </div>
                </div>
                
            </div>
              <div class="box-footer">
                <a href="../in.php?cid=usuarios/users" class="btn bg-navy">Volver</a>
                <button type="submit" class="btn btn-danger pull-right" name="update">Eliminar o Activar Usuario</button>
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