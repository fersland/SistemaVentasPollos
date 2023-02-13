<?php
  
  $mysql = $db->prepare("UPDATE c_tokens SET modulo='2', item='5', active='A' WHERE id_usuario='$session_usuario' AND ntoken='$session_token'");
  $mysql->execute();
  
  $ver = $db->prepare("SELECT * FROM access WHERE a_perfil='$session_acceso' AND a_modulo=2 AND a_item=5");
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
?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        SEGURIDAD /
        <b>RESPALDO DE BASE DE DATOS</b>
      </h1>

    </section>

<!-- Main content -->
<section class="content">
<div class="row"><br />
    <div class="col-md-12">
<?php
    if (isset($_POST['update'])) {
     require_once ("../../controlador/c_seguridad/bd_access.php");
  }
  ?>
    </div>
    <div class="col-md-6">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Ingrese la clave de seguridad</h3>
            </div>
            <form id="formulario" method="post">
                <div class="box-body">
                
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label>Clave de Acceso (*) </label>
                        <input type="password" name="acceso" class="form-control" />
                    </div>
                </div>
                
            </div>
                <div class="box-footer">
                <a href="?cid=dashboard/init" class="btn bg-navy">Volver</a>
                <button type="reset" class="btn btn-default">Cancelar</button>
                <button type="submit" class="btn btn-danger pull-right" name="update" >Validar Datos</button>
              </div>
            </form>
              </div>
          </div>
        </div>
  </section>
</div>