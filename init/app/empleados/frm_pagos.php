<?php
  $ver = $db->prepare("SELECT * FROM c_empleados WHERE estado='A'");
  $ver->execute();
  $fetch = $ver->fetchAll(PDO::FETCH_ASSOC);

  // Formas de pagos

  $trans = $db->prepare("SELECT * FROM c_pagos_detalle WHERE id_estado=1");
  $trans->execute();
  $fetchtrans = $trans->fetchAll(PDO::FETCH_ASSOC);
?>

  <div class="content-wrapper">
    <section class="content-header">
      <h1><b>Administraci&oacute;n</b> / Pagos a Empleados / <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-default">
                <i class="fa fa-plus"></i> PAGO PARCIAL
              </button>
              
              <div class="btn-group">
                  <button type="button" class="btn btn-info">Pago Mensual</button>
                  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Pago Mensual</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    
                    <?php foreach((array) $fetch as $results) : ?>
                        <li><a href="../app/empleados/frm_pagos_param.php?cid=<?php echo $results['id_empleado']; ?>"><?php echo strtoupper($results['nombres']. ' '. $results['apellidos']); ?></a></li>
                    <?php endforeach; ?>
                  </ul>
                </div></h1>

      <?php // require_once ("../../controlador/ol.php") ?>
      
      <div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
          <form class="form-horizontal" action="../../datos/clases/pdf/tipofflush.php" target="_blank" method="get">
            <div class="box box-body">
                <div class="col-xs-3">
                    <select name="eply" class="form-control">        
                        <?php foreach((array) $fetch as $modelcaseeply) : ?>
                            <option value="<?php echo $modelcaseeply['id_empleado']; ?>"><?php echo strtoupper($modelcaseeply['nombres']. ' '. $modelcaseeply['apellidos']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <!--<div class="col-xs-1"><label>Tipo</label></div>
               
                <!--<a target="_blank" href="../../datos/clases/pdf/NEW/gastos_empresa_anio.php?anio=<?php // echo $year_zone ?>" class="btn btn-info btn-sm"><i class="fa fa-list"></i> GASTOS DE EMPRESA ANUAL</a>-->

    
    <div class="col-xs-8">
	   
      		<div class="row">
                <!--<div class="col-xs-3">
                    <select name="tipo" class="form-control">        
                        <?php //foreach((array) $fetchtrans as $modelcase) : ?>
                            <option value="<?php // echo $modelcase['id']; ?>"><?php //echo $modelcase['nombre']; ?></option>
                        <?php //endforeach; ?>
                    </select>
                </div>-->
      			<div class="col-xs-3">
                    <select class="form-control" name="anio">
      			       <option>2021</option>
      		        </select>
                </div>

      		<div class="col-xs-3">
      			<select class="form-control" name="mes">
      			  <option value="1">Enero</option>
                  <option value="2">Febrero</option>
                  <option value="3">Marzo</option>
                  <option value="4">Abril</option>
                  <option value="5">Mayo</option>
                  <option value="6">Junio</option>
                  <option value="7">Julio</option>
                  <option value="8">Agosto</option>
                  <option value="9">Septiembre</option>
                  <option value="10">Octubre</option>
                  <option value="11">Noviembre</option>
                  <option value="12">Diciembre</option></select>
      		</div>
      		<div class="col-xs-2"><button type="submit" class="btn btn-success btn-sm">Ver reporte</button></div>
      		</div>

      	 </form>
        
            </div>
        
        </div>
    </div>
</div>
    </section>


<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nuevo Pago a Empleados</h4>
              </div>
              <div class="modal-body">
                <div class="box-body">
    
    <form id="formulario" method="post" class="form-horizontal" >
      <input type="hidden" name="anio" class="form-control" value="<?php echo $year_zone; ?>" />
      <input type="hidden" name="mes" class="form-control" value="<?php echo abs($month_zone); ?>" />
      <input type="hidden" name="dia" class="form-control" value="<?php echo abs($day_zone); ?>" />
        <div class="box-body">
        <div class="form-group">
            <label class="col-md-4">Empleado (*) </label>
            <div class="col-md-8">
                <select class="form-control" name="empleado" >
                  <?php foreach((array) $fetch as $values) { ?>
                  <option value="<?php echo $values['id_empleado'] ?>"><?php echo strtoupper($values['nombres']). ' '.strtoupper($values['apellidos']) ?></option>
                  <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4">Tipo de Pago (*)</label>
            <div class="col-md-8">
                <select class="form-control" name="tipo" >
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

        </div>
    
              </div>
              <div class="modal-footer">
                    <button type="reset" class="btn btn-default">Cancelar</button>
                    <input type="submit" class="btn btn-success pull-right" value="Registrar" name="register" >
              </div>

              </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
    </div>
        <!-- /.modal -->


<!-- Main content -->
<section class="content">
<div class="row">
    <div class="col-md-12"> <?php 
    
        if (isset($_POST['register'])) { require_once ("../../controlador/c_empleados/reg_pagos.php"); } 
        
        
        ?> </div>

    <div class="col-md-12">

                

                <?php require_once ("../../controlador/c_empleados/paginarPagos.php"); ?> 
                
                </div>

     

          
    </div><!-- /.col -->
  </section>
</div>