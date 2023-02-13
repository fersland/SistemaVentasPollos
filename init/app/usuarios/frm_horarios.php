<?php
 session_start();
 date_default_timezone_set('America/Guayaquil');
 
 if(isset($_SESSION["acceso"])) {
	require_once ("../head_unico.php");
?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1> SEGURIDAD <b> /CAMBIAR HORARIOS DE USUARIO EN EL SISTEMA</b></h1>
    </section>

<section class="content">
<div class="row"><br />
  <div class="col-md-12">
<?php
 if (isset($_POST['update'])) {

  $user     = $_POST['pid'];
  $lunes_desde      = htmlspecialchars($_POST['lunes_desde']);
  $lunes_hasta   = htmlspecialchars($_POST['lunes_hasta']);
  $martes_desde   = htmlspecialchars($_POST['martes_desde']);
  $martes_hasta  = htmlspecialchars($_POST['martes_hasta']);
  $miercoles_desde = htmlspecialchars($_POST['miercoles_desde']);
  $miercoles_hasta = htmlspecialchars($_POST['miercoles_hasta']);
  $jueves_desde = htmlspecialchars($_POST['jueves_desde']);
  $jueves_hasta = htmlspecialchars($_POST['jueves_hasta']);
  $viernes_desde = htmlspecialchars($_POST['viernes_desde']);
  $viernes_hasta = htmlspecialchars($_POST['viernes_hasta']);
  
  $sabado_desde = htmlspecialchars($_POST['sabado_desde']);
  $sabado_hasta = htmlspecialchars($_POST['sabado_hasta']);
  $domingo_desde = htmlspecialchars($_POST['domingo_desde']);
  $domingo_hasta = htmlspecialchars($_POST['domingo_hasta']);
  

    $sql = $db->prepare("UPDATE c_horarios SET 
                                lunes_desde='$lunes_desde', 
                                lunes_hasta='$lunes_hasta',
                                martes_desde='$martes_desde',
                                martes_hasta='$martes_hasta',
                                miercoles_desde='$miercoles_desde',
                                miercoles_hasta='$miercoles_hasta',
                                jueves_desde='$jueves_desde',
                                jueves_hasta='$jueves_hasta',
                                viernes_desde='$viernes_desde',
                                viernes_hasta='$viernes_hasta',
                                
                                sabado_desde='$sabado_desde',
                                sabado_hasta='$sabado_hasta',
                                domingo_desde='$domingo_desde',
                                domingo_hasta='$domingo_hasta'
                                
                        WHERE id_usuario='$user'");
                        
          if ($sql -> execute() ) {
               echo '<div class="alert alert-success">
                        <b>Nueva Horario Actualizado!</b>
                    </div>';
          }else{
               echo '<div class="alert alert-danger">
                        <b>Error al cambiar el horario!</b>
                    </div>';
          }
}

    $laid = isset($_REQUEST['cid']) ? $_REQUEST['cid'] : 0;

    $sql = $db->prepare("SELECT u.id_usuario, concat(e.nombres , ' ', e.apellidos) as epl,
    
                                h.lunes_desde, h.lunes_hasta,
                                h.martes_desde, h.martes_hasta,
                                h.miercoles_desde, h.miercoles_hasta,
                                h.jueves_desde, h.jueves_hasta,
                                h.viernes_desde, h.viernes_hasta,
                                h.sabado_desde, h.sabado_hasta,
                                h.domingo_desde, h.domingo_hasta
                                
                                FROM c_usuarios u 
                                    INNER JOIN c_empleados e ON u.cedula_user = e.cedula
                                    LEFT JOIN c_horarios h ON h.id_usuario = u.id_usuario 
                                WHERE u.id_usuario = '$laid'");
    $sql->execute();
    $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $key => $value) {
      $cid_id = $value['id_usuario'];
      $empleado = $value['epl'];
      $lunes_d = $value['lunes_desde'];
      $lunes_h = $value['lunes_hasta'];
      $martes_d = $value['martes_desde'];
      $martes_h = $value['martes_hasta'];
      $miercoles_d = $value['miercoles_desde'];
      $miercoles_h = $value['miercoles_hasta'];
      $jueves_d = $value['jueves_desde'];
      $jueves_h = $value['jueves_hasta'];
      $viernes_d = $value['viernes_desde'];
      $viernes_h = $value['viernes_hasta'];
      $sabado_d = $value['sabado_desde'];
      $sabado_h = $value['sabado_hasta'];
      $domingo_d = $value['domingo_desde'];
      $domingo_h = $value['domingo_hasta'];
    }
?>
  </div>
    <div class="col-md-8">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Cambiar el horario de utilización del sistema por parte de este usuario.</h3>
            </div>
            <form method="POST" class="form-horizontal">
                <div class="box-body">
                  <input type="hidden" name="pid" value="<?php echo $cid_id ?>" />
            
                <div class="form-group">
                  <label class="col-md-2">Usuario (*)</label>
                  <div class="col-md-7">
                  <input type="text" name="usuario" class="form-control" value="<?php echo $empleado ?>" required="" readonly="" />
                  </div>
              </div>
              
              <div class="form-group">
                  <label class="col-md-2">Lunes </label>
                  <div class="col-md-3">
                    <input type="time" name="lunes_desde" class="form-control" value="<?php echo $lunes_d ?>" />
                  </div>
                  
                  <label class="col-md-1"> a</label>
                  <div class="col-md-3">
                    <input type="time" name="lunes_hasta" class="form-control" value="<?php echo $lunes_h ?>" />
                  </div>
              </div>
              
              <div class="form-group">
                  <label class="col-md-2">Martes </label>
                  <div class="col-md-3">
                    <input type="time" name="martes_desde" class="form-control" value="<?php echo $martes_d; ?>" />
                  </div>
                  
                  <label class="col-md-1"> a</label>
                  <div class="col-md-3">
                    <input type="time" name="martes_hasta" class="form-control" value="<?php echo $martes_h; ?>" />
                  </div>
              </div>
              
              
              <div class="form-group">
                  <label class="col-md-2">Miercoles </label>
                  <div class="col-md-3">
                    <input type="time" name="miercoles_desde" class="form-control" value="<?php echo $miercoles_d; ?>" />
                  </div>
                  
                  <label class="col-md-1"> a</label>
                  <div class="col-md-3">
                    <input type="time" name="miercoles_hasta" class="form-control" value="<?php echo $miercoles_h; ?>"/>
                  </div>
              </div>
              
              
              <div class="form-group">
                  <label class="col-md-2">Jueves </label>
                  <div class="col-md-3">
                    <input type="time" name="jueves_desde" class="form-control" value="<?php echo $jueves_d; ?>" />
                  </div>
                  
                  <label class="col-md-1"> a</label>
                  <div class="col-md-3">
                    <input type="time" name="jueves_hasta" class="form-control" value="<?php echo $jueves_h; ?>" />
                  </div>
              </div>
              
              <div class="form-group">
                  <label class="col-md-2">Viernes </label>
                  <div class="col-md-3">
                    <input type="time" name="viernes_desde" class="form-control" value="<?php echo $viernes_d; ?>" />
                  </div>
                  
                  <label class="col-md-1"> a</label>
                  <div class="col-md-3">
                    <input type="time" name="viernes_hasta" class="form-control" value="<?php echo $viernes_h; ?>" />
                  </div>
              </div>
              
              <div class="form-group">
                  <label class="col-md-2">Sabado </label>
                  <div class="col-md-3">
                    <input type="time" name="sabado_desde" class="form-control" value="<?php echo $sabado_d; ?>" />
                  </div>
                  
                  <label class="col-md-1"> a</label>
                  <div class="col-md-3">
                    <input type="time" name="sabado_hasta" class="form-control" value="<?php echo $sabado_h; ?>" />
                  </div>
              </div>
              
              <div class="form-group">
                  <label class="col-md-2">Domingo </label>
                  <div class="col-md-3">
                    <input type="time" name="domingo_desde" class="form-control" value="<?php echo $domingo_d; ?>" />
                  </div>
                  
                  <label class="col-md-1"> a</label>
                  <div class="col-md-3">
                    <input type="time" name="domingo_hasta" class="form-control" value="<?php echo $domingo_h; ?>" />
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