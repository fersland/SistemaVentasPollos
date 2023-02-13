<?php
 session_start();
 if(isset($_SESSION["acceso"]))  {        
	require_once ("../head_unico.php");
?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>Clientes / <b>Eliminar Datos del Cliente</b></h1>

    </section>

<section class="content">
<div class="row"><br>
  <div class="col-md-12">
<?php // Actualizar datos
 if (isset($_POST['delete'])) {
    $ci    = $_POST['_cedula'];

     $stmt = $db->prepare("UPDATE c_clientes SET estado= 'I', fecha_eliminacion=now() WHERE cedula=?");
     if ( $stmt->execute(array($ci)) ){
       echo '<div class="alert alert-danger">
                <b>Datos eliminados correctamente! </b>
            </div>';
        }else{
                echo '<div class="alert alert-warning">
                        <b>Error al guardar los cambios!</b>
                      </div>';
        }
}

    $laid = isset($_GET['cid']) ? $_GET['cid'] : 0;

    $sql = $db->prepare("SELECT * FROM c_clientes WHERE id_cliente = ? AND estado='A'");
    $sql->execute(array($laid));
    $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $key => $value) {
      $id          = $value['id_cliente'];
      $empresa     = $value['id_empresa'];
      $nombres     = $value['nombres'];
      $cedula      = $value['cedula'];
    }
 ?>
  </div>
  <div class="col-md-6">
    <div class="box box-danger">
      <div class="box-header with-border">
          <h3 class="box-title">Eliminar datos del cliente</h3>
      </div>
      <form method="POST" class="form-horizontal">
        <div class="box-body">
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">Identificación</label>
            <div class="col-sm-8">
              <input type="text" name="_cedula" value="<?php echo @$cedula?>" class="form-control" readonly="" />
            </div>
          </div>
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">Nombres y Apellidos</label>
            <div class="col-sm-8">
              <input type="text" name="_nombres" value="<?php echo @$nombres?>" class="form-control" readonly="" />
            </div>
          </div>
        </div>
        <div class="box-footer">
          <a href="../in.php?cid=clientes/frm_clientes" class="btn bg-navy">Volver</a>
          <button type="submit" class="btn btn-danger pull-right" value="ELIMINAR DATOS AHORA" name="delete">Eliminar Datos</button>
        </div>
      </form><br /><br />
</div>
</div>
</div>
</section>
</div>
<?php require_once ("../foot_unico.php");
}else{
    session_unset();
    session_destroy();
    header('Location:  ../../../../index.php');
}?>