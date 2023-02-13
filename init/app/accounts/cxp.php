<?php
  
  $ver = $db->prepare("SELECT * FROM access WHERE a_perfil='$session_usuario' AND a_modulo=6 AND a_item=7");
  $ver->execute();
  $fetch = $ver->fetchAll(PDO::FETCH_ASSOC);

  foreach ($fetch as $key => $value) {
    $save = $value['sav'];
    $edit = $value['edi'];
    $dele = $value['del'];
    $prin = $value['pri'];
  }
  if (@$save == 'A') {
    $ss = '';
  }elseif (@$save == 'I'){
    $ss = "disabled";
  }

  if (@$prin == 'A'){
    $pp = '';
  }elseif (@$prin == 'I'){
    $pp = 'disabled';
  }

  if (@$edit == 'A'){
    $ee = '';
  }elseif (@$edit == 'I'){
    $ee = 'disabled';
  }

  if (@$dele == 'A'){
    $dd = '';
  }elseif (@$dele == 'I'){
    $dd = 'disabled';
  }
  
  $select = $db->prepare("SELECT distinct(t2.ruc), t1.id_cxp, t2.ruc, t2.nombreproveedor FROM c_cxp t1 INNER JOIN c_proveedor t2 ON t1.id_proveedor = t2.id_proveedor 
                WHERE t1.estado = 'DEBE'
  GROUP BY t2.ruc, t2.nombreproveedor");
  $select->execute();
  $allselect = $select->fetchAll();
?>

<div class="content-wrapper">
    <section class="content-header">
      <h1>Contabilidad / <b>Cuentas por pagar / 
      <a class="btn btn-warning btn-sm" href="../../datos/clases/pdf/pdf_cxp_general.php" target="_blank">Ver General Cuentas x Pagar</a></b>
      
      <form target="_blank" action="../../datos/clases/pdf/pdf_cxp_individual.php" method="post" style="display:inline">
          
          <select name="cliente" style="font-size:18px">
          <?php foreach((array) $allselect as $key => $model) { ?>
            <option value="<?php echo $model['ruc']; ?>"><?php echo $model['nombreproveedor']; ?></option>
          <?php } ?>
      </select>
      
      <button class="btn btn-success btn-sm">Ver Reporte Individual</button>
      </form>
      
      </h1>
      
    </section>

<section class="content">
<div class="row"><br />
        <div class="col-md-12">
<?php if (isset($msg)) { ?>
       <div class="alert alert-<?php echo $type ?> alert-dismissible fade show" role="alert">
        <?php echo $msg; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
       </div>
    <?php } ?>
          <div class="nav-tabs-custom">
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1-1">
                <div class="box">
                    <div class="box-header">
                      <h3 class="box-title">Lista de Cuentas por Pagar</h3>
                    </div>
                    <div class="box-body">
                        <?php require_once ('./'."../../controlador/c_accounts/paginarPorPagar.php"); ?>
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
    
    <form action="../../controlador/c_clientes/reg_clientes.php" id="formulario" method="post" class="form-horizontal" >

        <div class="box-body">
        <div class="form-group">
            <label class="col-md-5">C�dula / RUC <span class="ast">(*)</span></label>
            <div class="col-md-7">
            <input type="text" id="_cedula" name="cedula" class="form-control" onkeypress="return soloNumeros(event)" required="" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-5">Nombres y Apellidos <span class="ast">(*)</span></label>
            <div class="col-md-7">
            <input type="text" id="_nombres" name="nombres" class="form-control" onkeypress="return caracteres(event)" />
            </div>
        </div>        
        
        <div class="form-group">
            <label class="col-md-5"> Correo Electr�nico</label>
            <div class="col-md-7">
            <input type="text" id="_correo" name="correo" class="form-control" />
            </div>
        </div>                    
        <div class="form-group">
            <label class="col-md-5"> Tel�fono</label>
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
            <label class="col-md-5">Direcci�n</label>
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
        <a href="#tab_1-1" class="btn bg-navy" data-toggle="tab">Volver</a>
        <button type="reset" class="btn btn-default">Cancelar</button>
        <button type="submit" class="btn btn-success pull-right" value="Registrar" name="register" <?php echo $ss ?>>Guardar Datos</button>
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