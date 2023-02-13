<?php
 session_start();
 if(isset($_SESSION["acceso"])) {
    require_once ("../head_unico.php");
?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>Administración / <b>Empleado Actualizar</b></h1>

    </section>
<section class="content">
<div class="row"><br>
  <div class="col-md-12">
<?php
 if (isset($_POST['update'])) { // Actualizar datos
    $idemp    = $_POST['_id'];
    $ci       = $_POST['_cedula'];
    $na       = $_POST['_nombres'];
    $ap       = $_POST['_apellidos'];
    $lu       = $_POST['_lug_nac'];
    $ed       = $_POST['_edad'];
    $co       = $_POST['_correo'];
    $dir      = $_POST['_dir'];
    $tel      = $_POST['_telf'];
    $cel      = $_POST['_cel'];
    $perf     = $_POST['acceso'];
    $susu_     = $_POST['sucursal'];
    
    $sueldo_ = htmlspecialchars($_POST['_sueldo']);
    $ingreso_ = htmlspecialchars($_POST['ingreso']);
    $carnet_ = htmlspecialchars($_POST['_carnet']);
    
    if ($perf == 0) {
        $user = 'I';
    }else{
        $user = 'A';
    }


         $stmt = $db->prepare("UPDATE c_empleados SET
                id_acceso='$perf',cedula = '$ci', nombres='$na', apellidos='$ap', lugar_nacimiento = '$lu',edad='$ed',correo='$co',
                direccion='$dir', telefono='$tel', celular='$cel', fechamodificacion=now(), sucursal='$susu_',
                
                carnet='$carnet_', mensualidad='$sueldo_', fecha_ingreso='$ingreso_'
                  WHERE id_empleado='$idemp'");
         if ( $stmt->execute() ){
            $val_passw = sha1($ci);
          // INSERTAR UN NUEVO PERFIL AL EMPLEADO CON USUARIO NUEVO
            $new = $db->prepare("UPDATE c_usuarios SET nivelacceso='$perf', correo='$co', cedula_user='$ci', estado='$user', sucursal='$susu_' WHERE idemp='$idemp'");
            $new->execute();

         echo '<div class="alert alert-success">
                    <b>Cambios guardados y nuevo perfil asignado con exito!  <a href="../in.php?cid=empleados/frm_empleados">Volver</a></b>
                </div>';
            }else{
                    echo '<div class="alert alert-warning">
                    <b>Error al guardar los cambios!</b>
                </div>';
                }
}

        $laid = isset($_GET['cid']) ? $_GET['cid'] : 0;
        $sql = $db->prepare("SELECT * FROM c_empleados WHERE id_empleado = '$laid' and estado='A'");
        $sql->execute();
        $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $key => $value) {
            $id          = $value['id_empleado'];
            $perfil      = $value['id_acceso'];
            $cedula      = $value['cedula'];
            $nombres     = $value['nombres'];
            $apellidos   = $value['apellidos'];
            $lug_nac     = $value['lugar_nacimiento'];
            $fec_nac     = $value['fecha_nacimiento'];
            $edad        = $value['edad'];
            $correo      = $value['correo'];
            $dir         = $value['direccion'];
            $telf        = $value['telefono'];
            $cel         = $value['celular'];
            $susu        = $value['sucursal'];
            $carnet      = $value['carnet'];
            $sueldo     = $value['mensualidad'];
            $fingreso    = $value['fecha_ingreso'];
        }
?>
  </div>
    <div class="col-md-6">
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">Actualizar datos del Empleado <?php //echo $susu ?></h3>
        </div>
        <form method="POST" class="form-horizontal">
          <div class="box-body">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-4 control-label">Fecha de Ingreso (*)</label>
              <div class="col-sm-8">
                <input type="hidden" name="_id" value="<?php echo $id ?>">
                <input type="date" name="ingreso" value="<?php echo $fingreso ?>" class="form-control" />
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-sm-4 control-label">Sucursal (*)</label>
              <div class="col-sm-8">
                <select class="form-control" name="sucursal" >
                  <?php 
                    $stmt3 = $db->prepare("SELECT * FROM c_sucursal WHERE id_estado=1");
                    $stmt3->execute();
                    $all3 = $stmt3->fetchAll();
                                  
                    foreach ($all3 as $value3) { ?>
                    <?php if ($value3['id_sucursal'] == $susu){ ?>
                      <option style="background: turquoise" value="<?php echo $value3['id_sucursal'] ?>" selected><?php echo strtoupper($value3['nombre']) ?></option>
                    <?php }else{ ?>
                    <option value="<?php echo $value3['id_sucursal'] ?>"><?php echo strtoupper($value3['nombre']) ?></option>
                  <?php } } ?>
                </select>
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-sm-4 control-label">Asignar Perfil de Usuario (*)</label>
              <div class="col-sm-8">
                <select class="form-control" name="acceso" >
                  <option value="0">SIN ACCESO AL SISTEMA</option>
                  <?php 
                    $stmt = $db->prepare("SELECT * FROM c_roles WHERE estado='A'");
                    $stmt->execute();
                    $all = $stmt->fetchAll();
                                  
                    foreach ($all as $value) { ?>
                    <?php if ($value['idrol'] == $perfil){ ?>
                      <option style="background: turquoise" value="<?php echo $value['idrol'] ?>" selected><?php echo strtoupper($value['nombrerol']) ?></option>
                    <?php }else{ ?>
                    <option value="<?php echo $value['idrol'] ?>"><?php echo strtoupper($value['nombrerol']) ?></option>
                  <?php } } ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-4 control-label">CI/NIT (*)</label>
              <div class="col-sm-8">
                <input type="hidden" name="_id" value="<?php echo $id ?>">
                <input type="text" name="_cedula" value="<?php echo $cedula ?>" onkeypress="return soloNumeros(event)" class="form-control" />
              </div>
            </div>
                
            <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Nombre (*)</label>
                  <div class="col-sm-8">
                    <input type="text" name="_nombres" value="<?php echo $nombres ?>" class="form-control" onkeypress="return caracteres(event)" />
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Apellidos (*)</label>
                  <div class="col-sm-8">
                    <input type="text" name="_apellidos" value="<?php echo $apellidos ?>" class="form-control" onkeypress="return caracteres(event)">
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Sueldo</label>
                  <div class="col-sm-8">
                    <input type="number" step="0.01" name="_sueldo" value="<?php echo $sueldo ?>" class="form-control" />
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Lugar Nacimiento</label>
                  <div class="col-sm-8">
                    <input type="text" name="_lug_nac" value="<?php echo $lug_nac ?>" class="form-control">
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Edad </label>
                  <div class="col-sm-8">
                    <input type="text" name="_edad" value="<?php echo $edad ?>" class="form-control" onkeypress="return soloNumeros(event)" />
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Correo Electrónico </label>
                  <div class="col-sm-8">
                    <input type="text" name="_correo" value="<?php echo $correo ?>" class="form-control">
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Dirección</label>
                  <div class="col-sm-8">
                    <input type="text" name="_dir" value="<?php echo $dir ?>" class="form-control">
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Teléfono</label>
                  <div class="col-sm-8">
                    <input type="text" name="_telf" value="<?php echo $telf?>" class="form-control" onkeypress="return soloNumeros(event)" />
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Celular</label>
                  <div class="col-sm-8">
                    <input type="text" name="_cel" value="<?php echo $cel ?>" class="form-control" onkeypress="return soloNumeros(event)" />
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Carnet</label>
                  <div class="col-sm-8">
                    <input type="text" name="_carnet" value="<?php echo $carnet ?>" class="form-control" />
                  </div>
                </div>
                
                
                
            </div>
              <div class="box-footer">
                <a href="../in.php?cid=empleados/frm_empleados" class="btn bg-navy">Volver</a>
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
require_once ("../foot_unico.php");
}else{
    session_unset();
    session_destroy();
    header('Location:  ../../../index.php');
}?>