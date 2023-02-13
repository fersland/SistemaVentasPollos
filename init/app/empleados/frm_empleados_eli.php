<?php
 session_start();
 if(isset($_SESSION["acceso"])) {        
    require_once ("../head_unico.php");
?>

  <div class="content-wrapper">
    <section class="content-header">
      <h1>Empleados / <b>Eliminar Datos del Empleado</b></h1>
    </section>

<section class="content">
<div class="row"><br />
    <div class="col-md-12">
        <div class="alert alert-warning">
            <i class="fa fa-info"></i> <b>Precauci&oacute;n:</b> Si este empleado tiene un acceso de usuario, tambi&eacute;n se eliminar&aacute;.
        </div>
    </div>
    
    <div class="col-md-12">
<?php 
 // Actualizar datos
 if (isset($_POST['delete'])) {
    $idemp    = $_POST['_id'];
    $ci       = $_POST['_cedula'];
    $na       = $_POST['_nombres'];
    $ap       = $_POST['_apellidos'];

     $stmt = $db->prepare("DELETE FROM c_empleados WHERE id_empleado='$idemp'");
     
     if ($stmt->execute() ) {
        // Inactivar usuario
        $inactivar = $db->prepare("DELETE FROM c_usuarios WHERE cedula_user='$ci'");
        $inactivar->execute();
       echo '<div>
                <div class="alert alert-success">
                    <p> Empleado eliminado correctamente!</p>
                </div>
            </div>';
    }else{
       echo '<div>
                <div class="alert alert-warning">
                    <p> Error al eliminar!</p>
                </div>
            </div>'; 
    }
} 

if (isset($_REQUEST['cid'])){
        $laid = $_REQUEST['cid'];

        $sql = $db->prepare("SELECT * FROM c_empleados WHERE id_empleado = '$laid' AND estado ='A'");
        $sql->execute();
        $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $key => $value) {
            $id = $value['id_empleado'];
            $cedula = $value['cedula'];
            $nombres = $value['nombres'];
            $apellidos = $value['apellidos'];
            $edad = $value['edad'];
            $correo = $value['correo'];
        }
    }
?>
    </div>
    <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Eliminar datos del empleado</h3>
            </div>
            <form method="POST" class="form-horizontal">
                <div class="box-body">
                    <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">CI/NIT</label>

                  <div class="col-sm-8">
                    <input type="hidden" name="_id" value="<?php echo @$id ?>" />
                    <input type="text" name="_cedula" value="<?php echo @$cedula?>" class="form-control" readonly="" />
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Nombres</label>

                  <div class="col-sm-8">
                    <input type="text" name="_nombres" value="<?php echo @$nombres?>" class="form-control" readonly="" />
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Apellidos</label>

                  <div class="col-sm-8">
                    <input type="text" name="_apellidos" value="<?php echo @$apellidos?>" class="form-control" readonly="" />
                  </div>
                </div>

                
                </div>

                <div class="box-footer">
                <a href="../in.php?cid=empleados/frm_empleados" class="btn bg-navy">Volver</a>
                <button type="submit" class="btn btn-danger pull-right" name="delete">Eliminar Datos</button>
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