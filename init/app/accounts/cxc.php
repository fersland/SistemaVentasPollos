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
  
  $select = $db->prepare("SELECT distinct(t1.cedula), t1.id, t1.cedula, t2.nombres FROM c_cxc t1 INNER JOIN c_clientes t2 ON t1.cedula = t2.cedula WHERE t1.estado = 'DEBE'
  GROUP BY t1.cedula, t2.nombres");
  $select->execute();
  $allselect = $select->fetchAll();
?>

<div class="content-wrapper">
    <section class="content-header">
      <h1>Contabilidad / <b>Cuentas por cobrar / 
      <a class="btn btn-success btn-sm" href="../../datos/clases/pdf/pdf_cxc_general.php" target="_blank">Ver General Cuentas x Cobrar</a></b>
      
      <form target="_blank" action="../../datos/clases/pdf/pdf_cxc_individual.php" method="post" style="display:inline">
          
          <select name="cliente" style="font-size:16px">
          <?php foreach((array) $allselect as $key => $model) { ?>
            <option value="<?php echo $model['cedula']; ?>"><?php echo $model['nombres']; ?></option>
          <?php } ?>
      </select>
      
      <button class="btn btn-success btn-sm">Ver Reporte Individual</button>
      </form>
      
      </h1>

    </section>

<section class="content">
<div class="row"><br />
        <div class="col-md-12">
        <div class="alert alert-info">
                    <p>Aqu&iacute; se listan las cuentas por cobrar, es decir las ventas que hayan sido en diferido.</p>
        </div>
          <div class="nav-tabs-custom">

            <div class="tab-content">
                <div class="box">
                    <div class="box-header">
                      <h3 class="box-title">Lista de Cuentas por Cobrar</h3>
                    </div>
                    <div class="box-body">
                        <?php require_once ('./'."../../controlador/c_accounts/paginarPorCobrar.php"); ?>
                    </div>
                </div>
              </div>
          </div><!-- nav-tabs-custom -->
        </div><!-- /.col -->
      </div><!-- /.row -->
  </section>
</div>