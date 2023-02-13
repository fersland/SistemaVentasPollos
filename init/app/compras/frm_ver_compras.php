<?php
  $ver = $db->prepare("SELECT * FROM access WHERE a_perfil='$session_acceso' AND a_modulo=3 AND a_item=18");
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
  
  $css = $db->prepare("SELECT * FROM c_proveedor WHERE estado = 'A'");
  $css->execute();
  $fetchcss = $css->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Historial Compras / 
        <b>Lista de compras realizadas</b>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?cid=dashboard/init"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Compras</a></li>
        <li class="active"><a href="#">Historial de compras</a></li>
      </ol>
    </section>

<!-- Main content -->
  <section class="content">
    <div class="row"><br />
        <div class="card">
            <div class="col-md-12">
          <form target="_blank" method="get" action="compras/frm_ver_compras_param.php">
            <div class="form-group">
                <label class="col-md-1">Proveedor</label>
                <div class="col-md-3">
                    <select class="form-control" name="proveedor">
                    <?php foreach((array) $fetchcss as $luxor) { ?>
                        <option value="<?php echo $luxor['id_proveedor']; ?>"><?php echo $luxor['nombreproveedor']; ?></option>
                    <?php } ?>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-1">Desde</label>
                <div class="col-md-2"><input class="form-control" type="date" name="desde" /></div> 
            </div>
            
            <div class="form-group">
                <label class="col-md-1">Hasta</label>
                <div class="col-md-2"><input class="form-control" type="date" name="hasta" /></div> 
            </div>
            
            <div class="form-group">
                <button class="btn btn-success col-md-2"><i class="fa fa-check-square"></i> Ver</button>
            </div>
          </form>
        </div>
        </div>
    </div>
    <div class="row"><br />
        <div class="col-md-12">
          <?php require_once ("../../controlador/c_compras/paginarCompras.php"); ?>
        </div><!-- nav-tabs-custom -->
    </div><!-- /.col -->
  </section>
</div>