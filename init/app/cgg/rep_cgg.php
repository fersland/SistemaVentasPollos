<?php
  $ver = $db->prepare("SELECT * FROM c_empleados WHERE estado='A'");
  $ver->execute();
  $fetch = $ver->fetchAll(PDO::FETCH_ASSOC);

  // Formas de pagos

  $trans = $db->prepare("SELECT * FROM c_tipo_gastos WHERE id_estado=1");
  $trans->execute();
  $fetchtrans = $trans->fetchAll(PDO::FETCH_ASSOC);

  // INGRESO O EGRESO
  $conta = $db->prepare("SELECT * FROM c_conta");
  $conta->execute();
  $fetchconta = $conta->fetchAll(PDO::FETCH_ASSOC);
  
  // SUCURSALES
  $sqlsucursal = $db->prepare("SELECT * FROM c_sucursal WHERE id_estado = 1");
  $sqlsucursal->execute();
  $allsucursal = $sqlsucursal->fetchAll();
?>
<div class="content-wrapper">
    <section class="content-header">
      <h1><b>Gastos & Ganancias</b> 
      <!-- <a target="_blank" href="../../datos/clases/pdf/NEW/general_diario.php" class="btn btn-warning btn-sm"><i class="fa fa-list"></i> GENERAL DIARIO</a>
      / <a target="_blank" href="../../datos/clases/pdf/NEW/general_semanal.php" class="btn btn-warning btn-sm"><i class="fa fa-list"></i> GENERAL SEMANAL</a>
      / <a target="_blank" href="../../datos/clases/pdf/NEW/general_mensual.php?mes=<?php //echo abs($month_zone) ?>" class="btn btn-warning btn-sm"><i class="fa fa-list"></i> GENERAL MENSUAL</a>
      / <a target="_blank" href="../../datos/clases/pdf/NEW/general_anual.php?anio=<?php //echo $year_zone ?>" class="btn btn-warning btn-sm"><i class="fa fa-list"></i> GENERAL ANUAL</a>-->
      
       <a class="btn btn-danger btn-sm pull-right" href="?cid=cgg/cgg_view"><i class="fa fa-reply"></i> Volver</a> </h1><br>
      

      <?php // require_once ("../../controlador/ol.php") ?>
    </section>

<!-- Main content -->
<section class="content">
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box box-body">
                <div class="col-xs-1"><label>General Diario</label></div>
                <div class="col-xs-2">
                    <form action="../../datos/clases/pdf/NEW/general_diario.php" method="request" target="_blank" class="form-horizontal">
                        <div class="row">
                            
                            <select onchange='this.form.submit()' name="sucursal" class="form-control">
                            <option>- Seleccione -</option>           
                                        <?php foreach((array) $allsucursal as $modelcase) : ?>
                                            <option value="<?php echo $modelcase['id_sucursal']; ?>"><?php echo $modelcase['nombre']; ?></option>
                                        <?php endforeach; ?>
                            </select>                            
                        </div>
                    </form>
                </div>
                <!--<a target="_blank" href="../../datos/clases/pdf/NEW/gastos_empresa_anio.php?anio=<?php // echo $year_zone ?>" class="btn btn-info btn-sm"><i class="fa fa-list"></i> GASTOS DE EMPRESA ANUAL</a>-->

    <div class="col-xs-1"><label>Gastos Semanal</label></div>
    <div class="col-xs-2">
	   <form class="form-horizontal" action="../../datos/clases/pdf/NEW/general_semanal.php" target="_blank" method="request">
      		<div class="row">
                    <select name="sucursal" onchange='this.form.submit()' class="form-control">
                        <option>- Seleccione -</option>
                            <?php foreach((array) $allsucursal as $modelcase) : ?>
                                <option value="<?php echo $modelcase['id_sucursal']; ?>"><?php echo $modelcase['nombre']; ?></option>
                            <?php endforeach; ?>
                    </select>      	 
            </div>
        </form>
            </div>
            
        <div class="col-xs-1"><label>Gastos Mensual</label></div>
    <div class="col-xs-2">
	   <form class="form-horizontal" action="../../datos/clases/pdf/NEW/general_mensual.php" target="_blank" method="request">
       <input type="hidden" name="mes" value="<?php echo abs(date('m')); ?>" />
      		<div class="row">
                    <select name="sucursal" onchange='this.form.submit()' class="form-control">
                        <option>- Seleccione -</option>
                            <?php foreach((array) $allsucursal as $modelcase) : ?>
                                <option value="<?php echo $modelcase['id_sucursal']; ?>"><?php echo $modelcase['nombre']; ?></option>
                            <?php endforeach; ?>
                    </select>      	 
            </div>
        </form>
     </div>
     
     
     <div class="col-xs-1"><label>Gastos Anual</label></div>
    <div class="col-xs-2">
	   <form class="form-horizontal" action="../../datos/clases/pdf/NEW/general_anual.php" target="_blank" method="request">
       <input type="hidden" name="anio" value="<?php echo abs(date('Y')); ?>" />
      		<div class="row">
                    <select name="sucursal" onchange='this.form.submit()' class="form-control">
                        <option>- Seleccione -</option>
                            <?php foreach((array) $allsucursal as $modelcase) : ?>
                                <option value="<?php echo $modelcase['id_sucursal']; ?>"><?php echo $modelcase['nombre']; ?></option>
                            <?php endforeach; ?>
                    </select>      	 
            </div>
        </form>
     </div>
        
        </div><!-- FIN BOX BODY -->
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box box-body">
                <div class="col-xs-2"><label>Gastos Empresa Anual</label></div>
                <div class="col-xs-2">
                    <form action="../../datos/clases/pdf/NEW/gastos_empresa_anio.php" method="request" target="_blank" class="form-horizontal">
                        <div class="row">
                            
                            <select onchange='this.form.submit()' name="sucursal" class="form-control">
                            <option>- Seleccione -</option>           
                                        <?php foreach((array) $allsucursal as $modelcase) : ?>
                                            <option value="<?php echo $modelcase['id_sucursal']; ?>"><?php echo $modelcase['nombre']; ?></option>
                                        <?php endforeach; ?>
                            </select>                            
                        </div>
                    </form>
                </div>
                <!--<a target="_blank" href="../../datos/clases/pdf/NEW/gastos_empresa_anio.php?anio=<?php // echo $year_zone ?>" class="btn btn-info btn-sm"><i class="fa fa-list"></i> GASTOS DE EMPRESA ANUAL</a>-->

    <div class="col-xs-1"><label>Gastos Mes</label></div>
    <div class="col-xs-7">
	   <form class="form-horizontal" action="../../datos/clases/pdf/NEW/gastos_empresa_mes.php" target="_blank" method="post">
      		<div class="row">
                <div class="col-xs-2">
                <select name="sucursal" class="form-control">
                            
                            <?php foreach((array) $allsucursal as $modelcase) : ?>
                                <option value="<?php echo $modelcase['id_sucursal']; ?>"><?php echo $modelcase['nombre']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        </div>
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
</div>

<div class="row">
    <div class="col-md-12"><?php if (isset($_POST['register'])) { require_once ("../../controlador/c_gastos/reg_pagos.php"); } ?></div>
</div>

    <div class="row">
   	    <div class="col-md-6">
            <div class="box box-success">
                <div class="box-body">
                <div class="box-header with-border">
                    <h3 class="box-title"><b>Informes:</b>  Seleccione el año para ver el informe</h3>
                </div>
        		<form id="formulario" method="post" class="form-horizontal" action="../../datos/clases/pdf/NEW/gastos_param_anio.php" target="_blank">
      <input type="hidden" name="anio" class="form-control" value="<?php echo $year_zone ?>" />
        <div class="box-body">
        <div class="form-group">
            <label class="col-md-4">Sucursal (*)</label>
            <div class="col-md-8">
	            <select name="sucursal" class="form-control">
                            
                            
                            <?php foreach((array) $allsucursal as $modelcase) : ?>
                                <option value="<?php echo $modelcase['id_sucursal']; ?>"><?php echo $modelcase['nombre']; ?></option>
                            <?php endforeach; ?>
                        </select>
            </div>
        </div>
        
        
        
        <div class="form-group">
            <label class="col-md-4">Empleado (*)</label>
            <div class="col-md-8">
	            <select class="form-control" name="empleado" >
                  <?php foreach((array) $fetch as $values) { ?>
                  <option value="<?php echo $values['id_empleado'] ?>"><?php echo strtoupper($values['nombres']). ' '.strtoupper($values['apellidos']) ?></option>
                  <?php } ?>
	            </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4">Año (*)</label>
            <div class="col-md-8">
                <select class="form-control" name="anio" >
                  <option>2021</option>
                </select>
            </div>
        </div>

        <div class="modal-footer">
                <button type="submit" class="btn btn-success pull-right btn-block" name="register" ><i class="fa fa-list"></i> Ver Reporte Anual</button>
              </div>

        </div>


    </form>
        	</div>
        </div>
    </div> <!-- FIN COL-MD-4 -->

    <!-- INICIO POR MES -->

    <div class="col-md-6">
        		<div class="box box-warning">
            <div class="box-body">
            
                <div class="box-header with-border">
                    <h3 class="box-title"><b>Informes:</b>  Seleccione los año y el mes para ver el informe</h3>
                </div>
        		<form id="formulario" method="post" class="form-horizontal" action="../../datos/clases/pdf/NEW/gastos_param_mes.php" target="_blank">
      <input type="hidden" name="anio" class="form-control" value="<?php echo $year_zone ?>" />
      <input type="hidden" name="mes" class="form-control" value="<?php echo $month_zone ?>" />
      <input type="hidden" name="dia" class="form-control" value="<?php echo $day_zone ?>" />
        <div class="box-body">
        <div class="form-group">
            <label class="col-md-4">Sucursal (*)</label>
            <div class="col-md-8">
	            <select name="sucursal" class="form-control">
                            
                            
                            <?php foreach((array) $allsucursal as $modelcase) : ?>
                                <option value="<?php echo $modelcase['id_sucursal']; ?>"><?php echo $modelcase['nombre']; ?></option>
                            <?php endforeach; ?>
                        </select>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-4">Empleado (*)</label>
            <div class="col-md-8">
	            <select class="form-control" name="empleado" >
                  <?php foreach((array) $fetch as $values) { ?>
                  <option value="<?php echo $values['id_empleado'] ?>"><?php echo strtoupper($values['nombres']). ' '.strtoupper($values['apellidos']) ?></option>
                  <?php } ?>
	            </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4">Año (*)</label>
            <div class="col-md-8">
                <select class="form-control" name="anio" >
                  <option>2021</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4">MES (*)</label>
            <div class="col-md-8">
                <select class="form-control" name="mes" >
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
                  <option value="12">Diciembre</option>
                </select>
            </div>
        </div>

        <div class="modal-footer">
                <button type="submit" class="btn btn-warning pull-right btn-block" name="register" ><i class="fa fa-list"></i> Ver Reporte del Mes</button>
              </div>

        </div>


    </form>
        	</div>
        </div>
    </div> <!-- FIN POR MES -->

    
</div>
<div class="row">
<div class="col-md-6">
        		<div class="box box-info">
            <div class="box-body">
            
                <div class="box-header with-border">
                    <h3 class="box-title"><b>Informes:</b> Haga click en la semana o dia para ver el informe</h3>
                </div>
        		<form id="formulario" method="post" class="form-horizontal" action="../../datos/clases/pdf/NEW/gastos_empleados.php" target="_blank">
      <input type="hidden" name="anio" class="form-control" value="<?php echo $year_zone ?>" />
      <input type="hidden" name="mes" class="form-control" value="<?php echo $month_zone ?>" />
      <input type="hidden" name="dia" class="form-control" value="<?php echo $day_zone ?>" />
        <div class="box-body">
        <div class="form-group">
            <label class="col-md-4">Sucursal (*)</label>
            <div class="col-md-8">
	            <select name="sucursal" class="form-control">
                            
                            
                            <?php foreach((array) $allsucursal as $modelcase) : ?>
                                <option value="<?php echo $modelcase['id_sucursal']; ?>"><?php echo $modelcase['nombre']; ?></option>
                            <?php endforeach; ?>
                        </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4">Empleado (*)</label>
            <div class="col-md-8">
	            <select class="form-control" name="empleado" >
                  <?php foreach((array) $fetch as $values) { ?>
                  <option value="<?php echo $values['id_empleado'] ?>"><?php echo strtoupper($values['nombres']). ' '.strtoupper($values['apellidos']) ?></option>
                  <?php } ?>
	            </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4">Seleccione (*)</label>
            <div class="col-md-8">
                <select class="form-control" name="mes" >
                  <option>Día</option>
                  <option>Semanal</option>
                </select>
            </div>
        </div>

        <div class="modal-footer">
                <button type="submit" class="btn btn-info pull-right btn-block" name="register" ><i class="fa fa-list"></i> Ver Reporte Del Día o de la Semana</button>
              </div>

        </div>


    </form>
        	</div>
        </div>
    </div> <!-- FIN POR SEMANA -->
<div class="col-md-6">
    <div class="box box-primary">
            <div class="box-body">
            
                <div class="box-header with-border">
                    <h3 class="box-title"><b>Informes:</b> De la semana actual</h3>
                </div>
        		<form id="formulario" method="request" class="form-horizontal" action="../../datos/clases/pdf/NEW/gastos_param_semanal.php" target="_blank">
      <input type="hidden" name="anio" class="form-control" value="<?php echo $year_zone ?>" />
      <input type="hidden" name="mes" class="form-control" value="<?php echo $month_zone ?>" />
      <input type="hidden" name="dia" class="form-control" value="<?php echo $day_zone ?>" />
        <div class="box-body">
        <div class="form-group">
            <label class="col-md-4">Sucursal (*)</label>
            <div class="col-md-8">
	            <select name="sucursal" class="form-control">
                            
                            
                            <?php foreach((array) $allsucursal as $modelcase) : ?>
                                <option value="<?php echo $modelcase['id_sucursal']; ?>"><?php echo $modelcase['nombre']; ?></option>
                            <?php endforeach; ?>
                        </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4">Empleado (*)</label>
            <div class="col-md-8">
	            <select class="form-control" name="empleado" >
                  <?php foreach((array) $fetch as $values) { ?>
                  <option value="<?php echo $values['id_empleado'] ?>"><?php echo strtoupper($values['nombres']). ' '.strtoupper($values['apellidos']) ?></option>
                  <?php } ?>
	            </select>
            </div>
        </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary pull-right btn-block" name="register" ><i class="fa fa-list"></i> Ver Reporte de esta Semana</button>
            </div>
        </div>
    </form>
        	</div>
        </div>
</div>

</div>
        </div>


        


          
        </div><!-- /.col -->
      </div><!-- /.row -->
  </section>
</div>