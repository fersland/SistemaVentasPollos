<?php 
  $mysql = $db->prepare("UPDATE c_tokens SET modulo='2', item='3', active='A' WHERE id_usuario='$session_usuario' AND ntoken='$session_token'");
  $mysql->execute();
  
  $ver = $db->prepare("SELECT * FROM access WHERE a_perfil='$session_acceso' AND a_modulo=2 AND a_item=3");
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

    $money = $db->prepare("SELECT * FROM c_moneda WHERE estado = 1");
    $money->execute();
    $allmoney = $money->fetchAll();
        
        
  $stmt = $db->prepare("SELECT * FROM c_roles");
    $stmt->execute();
    $all = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $emp = $db->prepare("SELECT * FROM c_empresa");
    $emp->execute();;
    $fetch_empresa = $emp->fetchAll(PDO::FETCH_ASSOC);

    foreach ((array) $fetch_empresa as $key => $value) {
      $wall = $value['img_wall'];
      $pdf = $value['img_pdf'];
      $ruc = $value['ruc_empresa'];
      $nom = $value['nom_empresa'];
      $nomp = $value['nom_empresa_presenta'];
      $dir = $value['direcc_empresa'];
      $tel = $value['telf_empresa'];
      $mail = $value['mail_empresa'];
      $pai = $value['pais'];
      $ciu = $value['ciudad'];
      $currency = $value['money'];
    }
?>

  <!--<img src="../../../inicializador/img/iva.png" class="img" width="100% " />-->
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        ADMINISTRACI&Oacute;N / <b>DATOS DE LA EMPRESA</b>
      </h1>

    </section>

<!-- Main content -->
<section class="content">
<div class="row"><br />
  <?php
    if (isset($_POST['update'])) {
        require_once ("../../controlador/c_empresa/reg_empresa.php");
    }
?>
    <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Actualizar datos de la empresa</h3>
            </div>
            <form action="#" id="formulario" method="post" class="form-horizontal">
                <div class="box-body">
               
              <div class="form-group">
                  <label class="col-md-5">CI/NIT (*)</label>
                  <div class="col-md-7">
                  <input type="text" name="ruc" class="form-control" required="" value="<?php echo $ruc ?>" onkeypress="return soloNumeros(event)" />
                  </div>
              </div> 
                
              <div class="form-group">
                  <label class="col-md-5">PAIS (*)</label>
                  <div class="col-md-7">
                  <input type="text" name="pais" class="form-control" value="<?php echo $pai ?>" required="" />
                  </div>
              </div>
              
              <div class="form-group">
                  <label class="col-md-5">CIUDAD (*)</label>
                  <div class="col-md-7">
                  <input type="text" name="ciudad" class="form-control" value="<?php echo $ciu ?>" required="" />
                  </div>
              </div>
              
              <div class="form-group">
                  <label class="col-md-5">NOMBRE EMPRESA (*)</label>
                  <div class="col-md-7">
                  <input type="text" name="nombres" class="form-control" value="<?php echo $nom ?>" required="" />
                  </div>
              </div>

              <div class="form-group">
                  <label class="col-md-5">PRESENTACIÓN</label>
                  <div class="col-md-7">
                  <textarea name="press" class="form-control" required="" ><?php echo $nomp ?></textarea>
                  </div>
              </div> 

              <div class="form-group">
                  <label class="col-md-5">DIRECCIÓN EMPRESA <span class="ast">(*)</span></label>
                  <div class="col-md-7">
                  <input type="text" value="<?php echo $dir ?>" name="dir" class="form-control" required="" />
                  </div>
              </div> 

              <div class="form-group">
                  <label class="col-md-5">TELÉFONO (*)</label>
                  <div class="col-md-7">
                  <input type="text" value="<?php echo $tel ?>" maxlength="13" name="tel" class="form-control" required="" onkeypress="return soloNumeros(event)">
                  </div>
              </div> 

              <div class="form-group">
                  <label class="col-md-5">CORREO ELECTRÓNICO (*)</label>
                  <div class="col-md-7">
                  <input type="email" value="<?php echo $mail ?>" name="correo" class="form-control" required="" />
                  </div>
              </div>
              
              <div class="form-group">
                  <label class="col-md-5">MONEDA (*)</label>
                  <div class="col-md-7">
                  <select class="form-control" name="moneda">
                    <?php foreach((array) $allmoney as $val_currencys) : 
                    
                        if ($val_currencys['id'] == $currency) : ?>
                        <option value="<?php echo $val_currencys['id']; ?>" selected="" style="background: coral;"><?php echo strtoupper($val_currencys['nombre']); ?></option>
                        
                    <?php else: ?>
                        <option value="<?php echo $val_currencys['id']; ?>"><?php echo strtoupper($val_currencys['nombre']); ?></option>
                    <?php endif;
                         endforeach; ?>
                  </select>
                  </div>
              </div>
                
            </div>
                <div class="box-footer">
                <a href="?cid=dashboard/init" class="btn bg-navy">Volver</a>
                <button type="reset" class="btn btn-default">Cancelar</button>
                <button type="submit" class="btn btn-warning pull-right" value="Guardar Datos" name="update" <?php echo @$ee ?>>Actualizar Datos</button>
              </div>
            </form>
              </div>
        </div>

          <div class="col-md-6">
            <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Cambiar imagen de presentación:</h3>
            </div>
              <center><img src="../../init/img/presentacion/<?php echo $wall ?>" class="img" width="60% " /></center>
              <br />

              <form action="../../controlador/c_empresa/empresa_edit_wall.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label class="col-md-4 control-label" for="name">Cambiar Imagen Presentación: </label>
                  <div class="col-md-8">
                    <div class="input-group">
                <input type="file" name="img" class="form-control input-sm" required="" />
               <span class="input-group-btn">
                    <input name="upd" class="btn btn-info btn-small" type="submit" <?php echo $ee ?> style="height:27px; line-height:10px" value="Guardar" />  
               </span>
            </div>
                  </div>
                </div>
                  
          </form>
        </div>
          </div>
        </div><!-- /.col -->

        <div class="row">
          <div class="col-md-6">
            <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Cambiar imagen del logo:</h3>
            </div>
            
              <center><img src="../../init/img/logo/<?php echo $pdf ?>" class="img" width="30% " /></center>
              <br />
              <form action="../../controlador/c_empresa/empresa_edit_logo.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label class="col-md-4 control-label" for="name">Cambiar Logo: </label>
                  <div class="col-md-8">
                  
                    <div class="input-group">
                        <input type="file" name="img" class="form-control input-sm" required="" />
                        <span class="input-group-btn">
                            <input type="submit" name="upd" class="btn btn-success" value="Cambiar Logo" style="height:27px; line-height:10px" <?php echo $ee ?> />  
                       </span>
                    </div>
                  </div>
                </div>  
                </form>
          </div>
        </div>
        </div>
  </section>
</div>