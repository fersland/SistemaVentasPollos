<?php
 session_start();
 if(isset($_SESSION["acceso"])) {
    require_once ("../head_unico.php");
?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>Veh&iacute;culos / <b>Actualizar Datos del Veh&iacute;culo</b></h1>
      <ol class="breadcrumb">
        <li><a href="../in.php?cid=dashboard/init"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Veh&iacute;culos</a></li>
        <li class="active"><a href="#"> Actualizar Datos</a></li>
      </ol>
    </section>
<section class="content">
<div class="row"><br>
  <div class="col-md-12">
<?php
 if (isset($_POST['update'])) { // Actualizar datos
    $idemp    = $_POST['_id'];
    $marca_    = $_POST['_marca'];
    $modelo_    = $_POST['_modelo'];
    $placa_    = $_POST['_placa'];
    $color_    = $_POST['_color'];
    $propietario_    = $_POST['_propietario'];
    $anio_    = $_POST['_anio'];

          $stmt = $db->prepare("UPDATE c_vehiculo SET marca='$marca_', modelo='$modelo_', placa='$placa_', color='$color_', propietario='$propietario_', anio='$anio_'
                                    WHERE id ='$idemp'");
            if ( $stmt->execute() ){
              echo '<div class="alert alert-success">
                    <b>Cambios guardados!  </b>
                </div>';
            }else{
                    echo '<div class="alert alert-warning">
                    <b>Error al guardar los cambios!</b>
                </div>';
                }
        
        
}

        $laid = isset($_GET['cid']) ? $_GET['cid'] : 0;
        $sql = $db->prepare("SELECT * FROM c_vehiculo WHERE id = '$laid'");
        $sql->execute();
        $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $key => $value) {
            $id          = $value['id'];
            $marca      = $value['marca'];
            $modelo    = $value['modelo'];
            $placa      = $value['placa'];
            $color      = $value['color'];
            $propietario      = $value['propietario'];
            $anio      = $value['anio'];
        }

?>
  </div>
    <div class="col-md-6">
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">Actualizar Datos</h3>
        </div>
        <form method="POST" class="form-horizontal">
          <div class="box-body">
          <input type="hidden" name="_id" value="<?php echo $id ?>">

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-4 control-label">Marca (*)</label>
              <div class="col-sm-8">
                <input type="text" name="_marca" value="<?php echo $marca ?>" class="form-control" />
              </div>
            </div>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-4 control-label">Modelo (*)</label>
              <div class="col-sm-8">
                <input type="text" name="_modelo" value="<?php echo $modelo ?>" class="form-control" />
              </div>
            </div>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-4 control-label">Placa (*)</label>
              <div class="col-sm-8">
                <input type="text" name="_placa" value="<?php echo $placa ?>" class="form-control" />
              </div>
            </div>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-4 control-label">Color (*)</label>
              <div class="col-sm-8">
                <input type="text" name="_color" value="<?php echo $color ?>" class="form-control" />
              </div>
            </div>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-4 control-label">Propietario (*)</label>
              <div class="col-sm-8">
                <input type="text" name="_propietario" value="<?php echo $propietario ?>" class="form-control" />
              </div>
            </div>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-4 control-label">Año (*)</label>
              <div class="col-sm-8">
                <input type="text" name="_anio" value="<?php echo $anio ?>" class="form-control" />
              </div>
            </div>

            </div>
              <div class="box-footer">
                <a href="../in.php?cid=vehiculos/frm_vehiculo" class="btn bg-navy">Volver</a>
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