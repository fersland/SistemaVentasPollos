<?php
  
  $ver = $db->prepare("SELECT * FROM access WHERE a_perfil='$session_usuario' AND a_modulo=2 AND a_item=7");
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
      <h1>ADMINISTRACI&Oacute;N / <b>CLIENTES</b></h1>

    </section>
<section class="content" style="margin-top: -40px;">
<div class="row">
        <div class="col-md-12">
<?php if (isset($_POST['register'])) {
        require_once ("../../controlador/c_clientes/reg_clientes.php");
} ?>
       <div class="alert alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
       </div>
    
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs pull-right">
              <li><a href="#tab_2-2" data-toggle="tab"><i class="fa fa-check-square-o"></i> Nuevo Cliente</a></li>
              <li class="active"><a href="#tab_1-1" data-toggle="tab"><i class="fa fa-server"></i> Listado Clientes</a></li>
              <!--<li><a href="../../../datos/clases/excel/ex_clientes.php"><img src="../../img/excel.png" width="30" /></a></li>-->
              <li><a class="<?php echo @$pp ?>" href="../../datos/clases/pdf/pdfclientes.php" target="_blank"><img src="../img/pdf.png" width="30" /></a></li>
              <li class="pull-left header"><i class="fa fa-th"></i> </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1-1">
                <div class="box">
                    <div class="box-body">
                        <?php require_once ('./'."../../controlador/c_clientes/paginarClientes.php"); ?>
                    </div>
                </div>
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
            <label class="col-md-5">Identificación <span class="ast">(*)</span></label>
            <div class="col-md-7">
            <input type="text" minlength="8" maxlength="13" id="_cedula" name="cedula" class="form-control" onkeypress="return soloNumeros(event)" required="" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-5">Nombres y Apellidos <span class="ast">(*)</span></label>
            <div class="col-md-7">
            <input type="text" id="_nombres" name="nombres" class="form-control" onkeypress="return caracteres(event)" />
            </div>
        </div>   
        
        <div class="form-group">
            <label class="col-md-5"> Correo Electrónico</label>
            <div class="col-md-7">
            <input type="text" id="_correo" name="correo" class="form-control" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-5"> Teléfono</label>
            <div class="col-md-7">
            <input type="text" id="_telefono" name="telefono" class="form-control" onkeypress="return soloNumeros(event)"  />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-5"> Celular</label>
            <div class="col-md-7">
            <input type="text" id="_celular" name="celular" class="form-control" onkeypress="return soloNumeros(event)"  />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-5">Dirección</label>
            <div class="col-md-7">
            <input type="text" id="_direccion" name="direccion" class="form-control" />
            </div> 
        </div>
        <div class="form-group">
            <label class="col-md-5"> Observacion</label>
            <div class="col-md-7">
            <input type="text" name="observacion" class="form-control" />
            </div>
        </div>
        </div>

    <div class="box-footer">
        <a href="#tab_1-1" class="btn bg-navy" data-toggle="tab"><i class="fa fa-reply"></i> Volver</a>
        <button type="reset" class="btn btn-default"><i class="fa fa-refresh"></i> Cancelar</button>
        <button type="submit" class="btn btn-success pull-right" value="Registrar" name="register" <?php echo @$ss ?>><i class="fa fa-check-square-o"></i> Guardar Datos</button>
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