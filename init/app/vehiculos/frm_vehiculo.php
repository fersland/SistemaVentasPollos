<?php

  @$user = $_SESSION["correo"];
  
  
  $ver = $db->prepare("SELECT * FROM access WHERE a_perfil='$user' AND a_modulo=7 AND a_item=24");
  $ver->execute();
  $fetch = $ver->fetchAll(PDO::FETCH_ASSOC);

  foreach ($fetch as $key => $value) {
    $save = $value['sav'];
    $edit = $value['edi'];
    $dele = $value['del'];
    $prin = $value['pri'];
  }
  if (@$save == 'A') {
    @$ss = '';
  }elseif (@$save == 'I'){
    @$ss = "disabled";
  }

  if (@$prin == 'A'){
    @$pp = '';
  }elseif (@$prin == 'I'){
    @$pp = 'disabled';
  }

  if (@$edit == 'A'){
    @$ee = '';
  }elseif (@$edit == 'I'){
    @$ee = 'disabled';
  }

  if (@$dele == 'A'){
    @$dd = '';
  }elseif (@$dele == 'I'){
    @$dd = 'disabled';
  }
  
  
  $ver_empleados = $db->prepare("SELECT * FROM c_empleados WHERE estado='A'");
  $ver_empleados->execute();
  $fetch_empleados = $ver_empleados->fetchAll(PDO::FETCH_ASSOC);
?>

  <div class="content-wrapper">
    <section class="content-header">
      <h1>VEH&Iacute;CULOS /  <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-default">
                <i class="fa fa-plus"></i> Nuevo
              </button> /  <!--<a class="<?php // echo @$pp ?>" href="../../datos/clases/pdf/pdfempleados.php" target="_blank"><img src="../img/pdf.png" width="30" /> Ver Informe</a></h1>-->
    </section>

<section class="content">
<div class="row">
    <div class="col-md-12">
      <?php if (isset($_POST['register'])) { require_once ("../../controlador/c_vehiculos/reg_vehiculos.php"); } ?>

<div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Registro Nuevo Veh&iacute;culo</h4>
              </div>
              <div class="modal-body">
              <div class="box box-success">
    <div class="box-body">
    <div class="col-md-12">
            <div class="box-header with-border">
              <h3 class="box-title"><b>Importante:</b>  Los campos con (*) son obligatorios</h3>
            </div>
    
    <form id="formulario" method="post" class="form-horizontal" >

        <div class="box-body">
        
        <div class="form-group">
            <label class="col-md-5">Marca (*)</label>
            <div class="col-md-7">
            <input type="text" name="marca" class="form-control" required="" />
            </div>
        </div>   

        <div class="form-group">
            <label class="col-md-5">Modelo  (*)</label>
            <div class="col-md-7">
            <input type="text" name="modelo" class="form-control" required="" />
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-5">Placa (*)</label>
            <div class="col-md-7">
            <input type="text" name="placa" class="form-control" required="" />
            </div>
        </div>  

        <div class="form-group">
            <label class="col-md-5"> Color (*)</label>
            <div class="col-md-7">
            <input type="text" name="color" class="form-control" />
            </div>
        </div> 
        
        <div class="form-group">
            <label class="col-md-5">Propietario </label>
            <div class="col-md-7">
            <input type="text" name="propietario" class="form-control" />
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-5"> Año</label>
            <div class="col-md-7">
            <input type="text" name="anio" class="form-control" />
            </div>
        </div>
              

        </div>


    
            </div>
            </div>
            </div><!-- /.tab-pane -->
              </div>
              <div class="modal-footer">
              <button type="reset" class="btn btn-default"><i class="fa fa-refresh"></i> Cancelar</button>
              <button type="submit" class="btn btn-success pull-right" name="register" <?php echo @$ss ?> ><i class="fa fa-check-square-o"></i> Guardar Datos</button>
              </div>
            </div>
            </form>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
<!-- /.modal -->

<div class="box box-success">
            <div class="box-body">
                <?php require_once ("../../controlador/c_vehiculos/paginarVehiculos.php"); ?>
              </div>
            </div>
      </div><!-- /.row -->
  </section>
</div>


<script>
    function calcularEdad() {
        var fecha =document.getElementById('fecnac').value;
        var hoy = new Date();
        var cumpleanos = new Date(fecha);
        var edad = hoy.getFullYear() - cumpleanos.getFullYear();
        var m = hoy.getMonth() - cumpleanos.getMonth();

    if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
        edad--;
    }
         document.getElementById('edad').value= edad;
        //return edad;
        //alert(edad);
}
</script>
