<?php
 session_start();
 if(isset($_SESSION["acceso"])) {
	require_once ("../head_unico.php");
?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1> SEGURIDAD <b> /CAMBIAR CLAVE DE USUARIO</b></h1>
    </section>

<section class="content">
<div class="row"><br />
  <div class="col-md-12">
<?php
 if (isset($_POST['update'])) {

  $user     = $_POST['pid'];
  $act      = sha1($_POST['actual']);
  $npassw   = $_POST['new_passw'];
  $rpassw   = $_POST['rep_passw'];
  $usuario  = $_POST['usuario'];
  
  $estado   = 'A';

   // Consultar si la clave actual coincide
    $actual = $db->prepare("SELECT * FROM c_usuarios WHERE id_usuario ='$user' AND passw='$act'");
    $actual->execute();
    $an = $actual->rowCount();

      if ($an == 0) {
          echo '<script>alert("La clave actual no coinciden");
            window.history.back();</script>';
      }else if ($an > 0){
        if ( $npassw == $rpassw ) { // Consultar si las claves coinciden
          $cambio = sha1($npassw);
          $sql = $db->prepare("UPDATE c_usuarios SET usuario='$usuario', passw='$cambio', cl='$rpassw' WHERE id_usuario='$user' AND estado='A'");
          if ($sql -> execute() ) {
               echo '<div class="alert alert-success">
                        <b>Nueva Clave Guardada!</b>
                    </div>';
          }else{
               echo '<div class="alert alert-danger">
                        <b>Error al cambiar la clave!</b>
                    </div>';
          } 
        }else{
          echo '<div class="alert alert-danger">
                    <b>Error, las claves nuevas no coinciden!</b>
                </div>';
        }
  }
}

if (isset($_REQUEST['cid'])){
    $laid = $_REQUEST['cid'];

    $sql = $db->prepare("SELECT u.cedula_user, u.id_usuario FROM c_usuarios u INNER JOIN c_empleados e ON u.cedula_user = e.cedula 
    							WHERE u.id_usuario = '$laid'");
    $sql->execute();
    $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $key => $value) {
      $cid_id = $value['id_usuario'];
      $cid_nombre = $value['cedula_user'];
    }
}
?>
  </div>
    <div class="col-md-6">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Actualizar clave del usuario</h3>
            </div>
            <form method="POST" class="form-horizontal">
                <div class="box-body">
                  <input type="hidden" name="pid" value="<?php echo $cid_id ?>" />
            
                <div class="form-group">
                  <label class="col-md-5">Usuario (*)</label>
                  <div class="col-md-7">
                  <input type="text" name="usuario" class="form-control" autocomplete="nope" value="<?php echo $cid_nombre ?>" />
                  </div>
              </div>
              
              <div class="form-group">
                  <label class="col-md-5">Contraseña Actual (*)</label>
                  <div class="col-md-7">
                  <input type="password" name="actual" class="form-control" required="" />
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-md-5">Nueva Clave (*)</label>
                  <div class="col-md-7">
                  <input type="password" name="new_passw" class="form-control" required="" />
                  </div>
              </div>        
              
              <div class="form-group">
                  <label class="col-md-5"> Repita su nueva clave (*)</label>
                  <div class="col-md-7">
                  <input type="password" name="rep_passw" class="form-control" required="" />
                  </div>
              </div>
            </div>

              <div class="box-footer">
                <a href="../in.php?cid=usuarios/users" class="btn bg-navy">Volver</a>
                <button type="reset" class="btn btn-default">Cancelar</button>
                <button type="submit" class="btn btn-warning pull-right" name="update">Cambiar Ahora</button>
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