<?php
  
  $ver = $db->prepare("SELECT * FROM access WHERE a_perfil='$session_acceso' AND a_modulo=2 AND a_item=22");
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
    $ee = '';
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
      <h1>Administración / <b>Sucursales</b></h1>

    </section>


<section class="content">
<div class="row">
<div class="col-md-12">
    <?php if (isset($_POST['register'])) { require_once ("../../controlador/c_sucursal/reg_sucursal.php"); } ?>
</div>
<br />
      <div class="col-md-5">
        <div class="box box-success"> 
            <div class="box-body">
            <div class="col-md-12">
                <div class="box-header with-border">
                    <h3 class="box-title"><b>Importante:</b>  Los campos con (*) son obligatorios</h3>
                </div>
            
            <form method="post" class="form-horizontal" >        
              <div class="box-body">
                <div class="form-group">
                <label class="col-md-5">Nombres de Sede <span class="ast">(*)</span></label>
                <div class="col-md-7">
                    <input type="text" name="nombres" class="form-control" />
                </div>
            </div>        
            
            <div class="form-group">
                <label class="col-md-5"> Dirección <span class="ast">(*)</span></label>
                <div class="col-md-7">
                    <input type="text" name="direccion" class="form-control" />
                </div>
            </div>                    
            <div class="form-group">
                <label class="col-md-5"> Fecha de Creaci&oacute;n <span class="ast">(*)</span></label>
                <div class="col-md-7">
                    <input type="date" name="creacion" class="form-control"  />
                </div>
            </div>       
                <div class="box-footer">
                        <a href="?cid=dashboard/init" class="btn bg-navy"><i class="fa fa-reply"></i> Volver</a>

                        <button type="submit" class="btn btn-success pull-right" value="Guardar Datos" name="register" <?php echo @$ss ?>><i class="fa fa-check-square-o"></i> Guardar Datos</button>
                </div>
                    </form>
                    </div>
                    </div>
                    </div><!-- /.tab-pane -->
            </div><!-- /.tab-content -->
            </div>
            
            
        <div class="col-md-7">

        <div class="box box-success">
            <div class="box-body">
                <div class="col-md-12">
                    <div class="box-header with-border">
                    </div>
                    
                    <?php require_once ("../../controlador/c_sucursal/paginarSucursal.php"); ?>
                </div>
                </div>
            </div>
        </div>
        
        
  </section>
</div>
