<?php
    date_default_timezone_set('America/Guayaquil');
    $solofecha = date('Y-m-d');
  $ver = $db->prepare("SELECT * FROM c_empleados WHERE estado='A'");
  $ver->execute();
  $fetch = $ver->fetchAll(PDO::FETCH_ASSOC);

  // Formas de pagos

  $trans = $db->prepare("SELECT * FROM c_tipo_gastos WHERE id_estado=1 AND id <> 4");
  $trans->execute();
  $fetchtrans = $trans->fetchAll(PDO::FETCH_ASSOC);

  // INGRESO O EGRESO
  $conta = $db->prepare("SELECT * FROM c_conta");
  $conta->execute();
  $fetchconta = $conta->fetchAll(PDO::FETCH_ASSOC);
  
  // Ganancia al dia de hoy
  
  $cajadb = $db->prepare("SELECT sum(total) as totales FROM c_venta 
                                WHERE fecha_origen='$solofecha' AND estado = 'I' AND contado='NO'");
  $cajadb->execute();
  $caja_args = $cajadb->fetchAll(PDO::FETCH_ASSOC);
  
  foreach((array) $caja_args as $datos_args) {
    $total_caja = $datos_args['totales'];
  }
  
  
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><b>Gastos & Ganancias</b> / 
      <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> NUEVO INGRESO O EGRESO</button> 
      
      <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-cierre"><i class="fa fa-minus-square-o"></i> CIERRE DE CAJA</button>
      
      
      / <a class="btn btn-info btn-sm" href="?cid=cgg/rep_cgg"><i class="fa fa-list"></i> VER REPORTES</a>
      / <a target="_blank" class="btn btn-warning btn-sm" href="../../datos/clases/pdf/pdfhoycaja.php"><i class="fa fa-list"></i> CAJA HOY</a> 
       
      <button class="btn btn-info btn-sm pull-right"><b>EN VENTAS HOY: <?php echo number_format($total_caja, 2); ?></b></button>
      
      </h1><br />
      
      

    </section>

<!-- Main content -->
<section class="content">
<div class="row">
    <div class="col-md-12">
<?php if (isset($_POST['register'])) { require_once ("../../controlador/c_gastos/reg_pagos.php"); } ?>
<?php if (isset($_POST['cerrar'])) { require_once ("../../controlador/c_gastos/reg_cerrar.php"); } ?>

<?php


// CONSULTAR SALDO INICIAL EN LA TABLA SALDO
  $sous = $db->prepare("SELECT * FROM c_saldo");
  $sous->execute();
  $allsous = $sous->fetchAll(PDO::FETCH_ASSOC);
        
  foreach((array) $allsous as $datasaldo) {
    $saldo = $datasaldo['saldo'];
  }
  
   ?>
 </div>
</div>

<div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nuevo Ingreso</h4>
              </div>
              <div class="modal-body">
                <form id="formulario" method="post" class="form-horizontal" >
      <input type="hidden" name="anio" class="form-control" value="<?php echo $year_zone ?>" />
      <input type="hidden" name="mes" class="form-control" value="<?php echo $month_zone ?>" />
      <input type="hidden" name="dia" class="form-control" value="<?php echo $day_zone ?>" />
        <div class="box-body">
        <div class="form-group">
            <label class="col-md-4">Empleado (*)</label>
            <div class="col-md-8">
	            <select class="form-control" name="empleado" >
                  <option value="0">-- Seleccione --</option>
                  <?php foreach((array) $fetch as $values) { ?>
                  <option value="<?php echo $values['id_empleado'] ?>"><?php echo strtoupper($values['nombres']). ' '.strtoupper($values['apellidos']) ?></option>
                  <?php } ?>
	            </select>
            </div>
        </div>

        <!--<div class="form-group">
            <label class="col-md-4">Tipo (*)</label>
            <div class="col-md-8">
                <select class="form-control" name="tipo" >
                  <?php //foreach((array) $fetchconta as $value_conta) { ?>
                  <option value="<?php// echo $value_conta['id'] ?>"><?php //echo strtoupper($value_conta['nombre']); ?></option>
                  <?php //} ?>
                </select>
            </div>
        </div>-->

        <div class="form-group">
            <label class="col-md-4">Detalle (*)</label>
            <div class="col-md-8">
                <select class="form-control" name="detalle" >
                  <?php foreach((array) $fetchtrans as $value) { ?>
                  <option value="<?php echo $value['id'] ?>"><?php echo strtoupper($value['nombre']); ?></option>
                  <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4">Valor (*)</label>
            <div class="col-md-8">
            <input type="number" step="0.01" name="valor" class="form-control" required="" />
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-4">Observaci&oacute;n (*)</label>
            <div class="col-md-8">
            <textarea name="obs" class="form-control" ></textarea>     
            </div>
        </div>
        
        


        <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-success pull-right" value="Registrar" name="register" >
              </div>

        </div>


    </form>
              </div>
              
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->



<!-- MODAL DE CIERRE DE CAJA -->
<div class="modal fade" id="modal-cierre">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">CIERRE DE CAJA</h4>
              </div>
              <div class="modal-body">
                <form id="formulario" method="post" class="form-horizontal" >
      <input type="hidden" name="anio" class="form-control" value="<?php echo $year_zone ?>" />
      <input type="hidden" name="mes" class="form-control" value="<?php echo $month_zone ?>" />
      <input type="hidden" name="dia" class="form-control" value="<?php echo $day_zone ?>" />
        <div class="box-body">

        <div class="form-group">
            <label class="col-md-4">Valor (*)</label>
            <div class="col-md-8">
            <input type="number" step="0.01" name="valor" class="form-control" value="<?php echo $saldo ?>" required="" />
            </div>
        </div>


        <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger pull-right" name="cerrar" ><i class="fa  fa-minus-square-o"></i> CERRAR CAJA AHORA</button>
              </div>

        </div>


    </form>
              </div>
              
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        
    <!-- FIN DEL MODAL DE CIERRE DE CAJA -->
       

        <div class="row"><div class="col-md-12">
            <?php require_once ("../../controlador/c_gastos/paginarPagos.php"); ?>
        </div></div>

        


          
        </div><!-- /.col -->
      </div><!-- /.row -->
  </section>
</div>