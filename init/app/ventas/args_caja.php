<?php
  date_default_timezone_set('America/Guayaquil');
  $solofecha = date('Y-m-d');

    
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
  if ($save == 'A') {
    $ss = '';
  }elseif ($save == 'I'){
    $ss = "disabled";
  }

  if ($prin == 'A'){
    $pp = '';
  }elseif ($prin == 'I'){
    $pp = 'disabled';
  }

  if ($edit == 'A'){
    $ee = '';
  }elseif ($edit == 'I'){
    $ee = 'disabled';
  }

  if ($dele == 'A'){
    $dd = '';
  }elseif ($dele == 'I'){
    $dd = 'disabled';
  }
  
  $cajadb = $db->prepare("SELECT sum(total) as totales FROM c_venta WHERE fecha_origen='$solofecha' AND estado = 'I' AND contado='NO'");
  $cajadb->execute();
  $caja_args = $cajadb->fetchAll(PDO::FETCH_ASSOC);
  
  foreach((array) $caja_args as $datos_args) {
    $total_caja = $datos_args['totales'];
  }
?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>VENTAS / <strong>CAJA</strong></h1>
      <ol class="breadcrumb">
        <li><a href="?cid=dashboard/init"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Caja</li>
      </ol>
    </section>

<!-- Main content -->
<section class="content">
<div class="row"><br />
    <div class="col-md-12">
<?php
    
  ?>
    </div>
    <div class="col-md-4">
          <div class="box box-info">
          
          <?php 
            
            if (isset($_POST['update'])) {
                 require_once ("../../controlador/c_ventas/reg_caja.php");
              }
              
            if (isset($_POST['abrircaja'])) {
                 require_once ("../../controlador/c_ventas/reg_cajabrir.php");
              }
              
            // VERIFICAR ESTADO DE CAJA
  
  $stddb = $db->prepare("SELECT * FROM c_caja WHERE fecha='$solofecha'");
  $stddb->execute();
  $std_args = $stddb->fetchAll(PDO::FETCH_ASSOC);
  
  foreach((array) $std_args as $std_args_datos) {
    $disp = $std_args_datos['disponibilidad'];
    $util = $std_args_datos['utilidad'];
  }
  
  $abir = $db->prepare("SELECT * FROM c_empresa");
    $abir->execute();
    $count_abir = $abir->fetchAll(PDO::FETCH_BOTH);
    
    foreach((array) $count_abir as $aver) {
        $cajaabierta = $aver['caja_abierta'];
    }
    
  ?>
            <div class="box-header with-border">
              <h3 class="box-title">Cuidado al cerrar caja</h3>
            </div>
            <form id="formulario" method="post">
                <div class="box-body">
                    <input type="hidden" required="required" readonly="readonly" id="pro" name="pro"/>
                    <input type="hidden" step="0.01" name="valor" class="form-control" value="<?php echo number_format($total_caja,2,'.',''); ?>" readonly="" />
                    <input type="hidden" step="0.01" name="pago" class="form-control" />
                </div>
                
                <div class="box-footer">
              <?php if ($cajaabierta  == 'NO' ) { ?>
                <button type="submit" class="btn btn-info btn-block pull-right" name="abrircaja" <?php echo @$ee ?>>Abrir Caja</button>
                
              <?php }
              if($cajaabierta  == 'SI' ){ ?>
              
              <button type="submit" class="btn btn-success btn-block pull-right" name="update" <?php echo @$ee ?>>Cerrar Caja</button>
              
              <?php } ?>
              </div>
            </form>
            
                <h3>Ganancia del d&iacute;a de hoy: <b><?php  echo number_format($total_caja,2,'.',''); ?></b></h3><br />
            
              </div>
          </div>
          
          
          <div class="col-md-8">
          <div class="box box-info">
          <div class="box-header with-border">
              <h3 class="box-title">Resumen de caja</h3>
            </div>
            <?php

  	$registro = $db->prepare("select * from c_caja c where c.estado = 1 ORDER BY c.id_caja DESC");
    $registro->execute();
    $all = $registro->fetchAll(PDO::FETCH_ASSOC);
   ?>
    <table id="example" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                        <th>Fecha</th>
                        <th>Veces Cerrado</th>
                        <th>Valor</th>
                        <th>Utilidad</th>
                </tr> 
            </thead>
            <tbody>
                 <?php foreach ($all as $send) { ?>
                 
                <?php if ($solofecha == $send['fecha']) { ?>
                <tr style="background: lightgreen;"> 
                 <td><?php echo @$send['fecha'] ?><p style="float: right; color: red;">Hoy</p></td>
                 <td><?php echo @$send['veces'] ?></td>
                 <td><?php echo @$send['valor'] ?></td>
                 <td><?php echo @$send['utilidad'] ?></td>
                 <?php }else{ ?>
                </tr>
                <tr>
                    <td><?php echo @$send['fecha'] ?></td>
                    <td><?php echo @$send['veces'] ?></td>
                    <td><?php echo @$send['valor'] ?></td>
                    <td><?php echo @$send['utilidad'] ?></td>
                </tr>
            <?php } } ?>
            </tbody>
        </table>
          <!-- /.box -->
          </div>
          </div>
        </div>
  </section>
</div>