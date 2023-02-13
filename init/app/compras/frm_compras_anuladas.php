<?php
  $ver = $db->prepare("SELECT * FROM access WHERE a_perfil='$session_acceso' AND a_modulo=3 AND a_item=19");
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
        Historial Compras Anualdas / 
        <b>Lista de compras anuladas</b>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?cid=dashboard/init"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Compras</a></li>
        <li><a href="?cid=compras/frm_ver_compras">Historial de compras</a></li>
        <li class="active"><a href="#">Historial de compras anuladas</a></li>
      </ol>
    </section>

<!-- Main content -->
<section class="content">
    <div class="row"><br>
        <div class="col-md-12">
                  <?php require_once ("../../controlador/c_compras/paginarComprasAnuladas.php"); ?>
        </div><!-- nav-tabs-custom -->
    </div><!-- /.col -->
  </section>
</div>