<?php
  $ver = $db->prepare("SELECT * FROM access WHERE a_perfil='$session_acceso' AND a_modulo=1 AND a_item=1");
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
    ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>Seguridad / Perfiles de Usuarios</h1>

    </section>

<!-- Main content -->
<section class="content">
<div class="row"><br>
  <div class="col-md-12">
    <?php
    if (isset($_POST['register'])) {
       require_once ("../../controlador/c_perfiles/reg_perfiles.php");
    }
 ?>
  </div>
        <div class="col-md-12">
          <!-- Custom Tabs (Pulled to the right) -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs pull-right">
              <li><a href="#tab_2-2" data-toggle="tab"><i class="fa fa-check-square-o"></i> Crear Nuevo Perfil</a></li>
              <li class="active"><a href="#tab_1-1" data-toggle="tab"><i class="fa fa-server"></i> Listado Perfiles</a></li>
              <!--<li><a href="../../../datos/clases/excel/ex_clientes.php"><img src="../../img/excel.png" width="30" /></a></li>-->
              <!--<li><a href="../../../datos/clases/pdf/clientes.php" target="_blank"><img src="../../img/pdf.png" width="30" /></a></li>-->
              <li class="pull-left header"><i class="fa fa-th"></i> </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1-1">
                <?php require_once ("../../controlador/c_perfiles/paginarPerfiles.php"); ?>
              </div>

<div class="tab-pane" id="tab_2-2">
<div class="box box-success">
    <div class="box-body">
    <div class="col-md-6">
        <div class="box-header with-border">
          <h3 class="box-title"><b>Importante:</b>  Los campos con (*) son obligatorios</h3>
        </div>
    
    <form id="formulario" method="post" class="form-horizontal" >

        <div class="box-body">
        <div class="form-group">
            <label class="col-md-5">Nombre de Perfil (*)</label>
            <div class="col-md-7">
            <input type="text" name="perfil" class="form-control" required="" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-5">Observación</label>
            <div class="col-md-7">
            <input type="text" name="obs" class="form-control"/>
            </div>
        </div>
        </div>

    <div class="box-footer">
        <a href="#tab_1-1" class="btn bg-navy" data-toggle="tab"><i class="fa fa-reply"></i> Volver</a>
        <button type="reset" class="btn btn-default"><i class="fa fa-refresh"></i> Cancelar</button>
        <button type="submit" class="btn btn-success pull-right" value="Registrar" name="register" <?php echo @$ss ?> ><i class="fa fa-check-square-o"></i> Guardar Datos</button>
    </div>
    </form>
            </div>
            </div>
            </div><!-- /.tab-pane -->
            </div><!-- /.tab-content -->
          </div><!-- nav-tabs-custom -->
        </div><!-- /.col -->
      </div><!-- /.row -->
  </section>
</div>