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
        Usuarios
        <small>Actualizar</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="../in.php?cid=dashboard/init"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Administración</a></li>
        <li><a href="#">Empresa</a></li>
        <li><a href="#">IVA</a></li>
        <li><a href="#">Empleados</a></li>
        <li><a href="#">Proveedor</a></li>
        <li><a href="#">Categoría</a></li>
        <li class="active"><a href="../in.php?cid=clientes/frm_clientes">Usuarios</a></li>
        <li class="active">Actualizar Usuarios</li>
      </ol>
    </section>

<!-- Main content -->
<section class="content">
<div class="row"><br>
  <div class="col-md-12">
<?php
 if (isset($_POST['update'])) {

    $updid        = $_POST['pid'];
    $updrol       = strtoupper($_POST['prol']);
    $updcor       = $_POST['pcorreo'];

   $stmt = $db->prepare(
                                     "UPDATE c_usuarios SET nivelacceso = '$updrol',correo='$updcor', fecha_modificacion=now()
                                            WHERE id_usuario='$updid'");
   if ($stmt->execute() ) {
     echo '<div class="alert alert-success">
                <b>Cambios guardados! <a href="../in.php?cid=usuarios/users">Volver</a></b>
            </div>'; 
   }else{
     echo '<div class="alert alert-danger">
                <b>Error al cambiar datos!</b>
            </div>';
   }
}

// ROLES
	$roles = $db->prepare("SELECT * FROM c_roles WHERE estado= 'A'");
    $roles->execute();
    $rows_roles = $roles->fetchAll(PDO::FETCH_ASSOC);


if (isset($_REQUEST['cid'])){
    $laid = $_REQUEST['cid'];

    $sql = $db->prepare("SELECT * FROM c_usuarios u INNER JOIN c_roles r ON r.idrol = u.nivelacceso WHERE u.id_usuario = '$laid'");
    $sql->execute();
    $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $key => $value) {
      $cid_id         = $value['id_usuario'];
      $cid_cor        = $value['correo'];
      $cid_rol  	  = $value['nivelacceso'];
    }
}
?>
  </div>
    <div class="col-md-6">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Actualizar datos del usuario</h3>
            </div>
            <form method="POST" class="form-horizontal">
                <div class="box-body">
                    <input type="hidden" name="pid" value="<?php echo $cid_id ?>" />

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-5 control-label">PERFIL (*)</label>

                  <div class="col-sm-7">
                    <select class="form-control" name="prol">
                    	<?php foreach ((array) $rows_roles as $key => $value_roles) { ?>
                    		<?php if ($value_roles['idrol'] == $cid_rol){ ?>
                    			<option style="background: lightgreen" value="<?php echo $value_roles['idrol'] ?>" selected><?php echo $value_roles['nombrerol'] ?></option>	
                    		<?php }else{ ?>
                    		<option value="<?php echo $value_roles['idrol'] ?>"><?php echo $value_roles['nombrerol'] ?></option>
                    	<?php } } ?>
                    </select>
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-5 control-label">CORREO ELECTRÓNICO (*)</label>

                  <div class="col-sm-7">
                    <input type="text" name="pcorreo" value="<?php echo $cid_cor ?>" class="form-control" />
                  </div>
                </div>
            </div>
                <!-- /.box-body -->
              <div class="box-footer">
                <a href="../in.php?cid=usuarios/users" class="btn bg-navy">Volver</a>
                <button type="reset" class="btn btn-default">Cancelar</button>
                <button type="submit" class="btn btn-warning pull-right" value="ACTUALIZAR DATOS AHORA" name="update">Actualizar Datos</button>
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