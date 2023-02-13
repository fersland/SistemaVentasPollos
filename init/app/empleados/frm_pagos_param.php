<?php
 session_start();
 if(isset($_SESSION["acceso"])) {
    require_once ("../head_unico.php");
    
    // EXTRAER LOS ANTICIPOS DEL EMPLEADOS
    
    $cid = isset($_GET['cid']) ? $_GET['cid'] : 0;
    
    $args = $db->prepare("SELECT concat(t2.nombres, ' ', t2.apellidos) as employee, t1.valor, t3.nombre as detalles 
    
                                FROM c_pagos t1
                                    INNER JOIN c_empleados t2 ON t1.id_empleado = t2.id_empleado 
                                    INNER JOIN c_pagos_detalle t3 ON t1.detalle = t3.id
                                WHERE t1.id_empleado = '$cid' AND t1.id_estado = 1 AND t1.fecha_pago BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()");
    $args->execute();
    $allargs = $args->fetchAll(PDO::FETCH_ASSOC);
    
    // TOTAL PAGADO ESTE MES AL EMPLEADO
    $argst = $db->prepare("SELECT SUM(t1.valor) as totales, t2.mensualidad
    
                                FROM c_pagos t1 
                                    INNER JOIN c_empleados t2 ON t1.id_empleado = t2.id_empleado 
                                    INNER JOIN c_pagos_detalle t3 ON t1.detalle = t3.id
                                WHERE t1.id_empleado = '$cid' AND t1.id_estado = 1 AND t1.fecha_pago BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()");
    $argst->execute();
    $allargst = $argst->fetchAll(PDO::FETCH_ASSOC);
    
    foreach((array) $allargst as $yan) {
        $los_totales = $yan['totales'];
        $mensualiad = $yan['mensualidad'];
    }
    
    $resta = ($mensualiad - $los_totales);
    
    // PARAMS EMPLEADOS
    $eply = $db->prepare("SELECT * FROM c_empleados WHERE estado = 'A' AND id_empleado = '$cid'");
    $eply->execute();
    $all_emply = $eply->fetch(PDO::FETCH_ASSOC);
?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>Pagos a: NIT:<strong><?php echo $all_emply['cedula']. ' | '. $all_emply['nombres']. ' '. $all_emply['apellidos']; ?></strong> / Sueldo: <strong><?php echo number_format($all_emply['mensualidad'], 2);; ?></strong></h1>
      <ol class="breadcrumb">
        <li><a href="../in.php?cid=dashboard/init"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Contabilidad</a></li>
        <li><a href="#">Empleado</a></li>
        <li class="active"><a href="#"> Actualizar Pago</a></li>
      </ol>
    </section>
<section class="content">

<div class="row"><br>
  <div class="col-md-12">
<?php
if (isset($_POST['mensualidad'])) { require_once ("../../../controlador/c_empleados/reg_pagos_mensual.php"); }

?>
  </div>
    <div class="col-md-6">
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">Actualizar el pago del Empleado</h3>
        </div>
        <form id="formulario" method="post" class="form-horizontal" >
      <input type="hidden" name="anio" class="form-control" value="<?php echo $year_zone; ?>" />
      <input type="hidden" name="mes" class="form-control" value="<?php echo abs($month_zone); ?>" />
      <input type="hidden" name="dia" class="form-control" value="<?php echo abs($day_zone); ?>" />
        <div class="box-body">
        

        <div class="form-group">
            <label class="col-md-4">FECHA INGRESO (*)</label>
            <div class="col-md-8">
                <input type="date" name="ingreso" class="form-control" value="<?php echo $all_emply['fecha_ingreso'] ?>" />
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-4">MES CUMPLIDO (*)</label>
            <div class="col-md-8">
                <input type="number" name="final" class="form-control" />
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-4">Dias Trabajados (*)</label>
            <div class="col-md-8">
            <input name="ndias" class="form-control" required="" />
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-4">Dias Descanso (*)</label>
            <div class="col-md-8">
            <input name="ndesc" class="form-control" required="" />
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-4">Anticipo</label>
            <div class="col-md-8">
            <input name="anticipo" class="form-control" value="<?php echo $los_totales ?>" />
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-4">Valor Multa </label>
            <div class="col-md-8">
            <input type="number" step="0.01" name="multa" class="form-control" />
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-4">Boli.Mar</label>
            <div class="col-md-8">
            <input type="number" step="0.01" name="bolimar" class="form-control" />
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-4">Retraso </label>
            <div class="col-md-8">
            <input type="number" step="0.01" name="retraso" class="form-control" />
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-4">Observaci&oacute;n</label>
            <div class="col-md-8">
            <textarea class="form-control" name="obs"></textarea>
            </div>
        </div>


        <div class="form-group">
            <label class="col-md-4">Cobro de Multa de Ruta </label>
            <div class="col-md-8">
            <input type="number" step="0.01" name="cobro_ruta" class="form-control" />
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-4">Cobro de Multa de Dia </label>
            <div class="col-md-8">
            <input type="number" step="0.01" name="cobro_dia" class="form-control" />
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-4">Retraso </label>
            <div class="col-md-8">
            <input type="number" step="0.01" name="retraso" class="form-control" />
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-4">Boligrafo </label>
            <div class="col-md-8">
            <input type="number" step="0.01" name="boligrafo" class="form-control"  />
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-4">Marcador </label>
            <div class="col-md-8">
            <input type="number" step="0.01" name="marcador" class="form-control" />
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-4">Deuda Anterior Mes </label>
            <div class="col-md-8">
            <input type="number" step="0.01" name="deuda_anterior" class="form-control" />
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-4">Valo a Pagar este Mes </label>
            <div class="col-md-8">
                <input name="valor_pagado" class="form-control"  value="<?php echo number_format($resta,2); ?>" />
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-4">Estado </label>
            <div class="col-md-8">
            <select class="form-control" name="estados">
                <option>NO PAGAR</option>
                <option>PAGAR</option>
            </select>
            </div>
        </div>
        
        
        </div>
    
              </div>
              <div class="modal-footer">
                    <button type="reset" class="btn btn-default">Cancelar</button>
                    <input type="submit" class="btn btn-success pull-right" value="Registrar" name="mensualidad" />
              </div>

              </form>
        </div><!-- FIN COL 1-->
        
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">PAGOS REALIZADOS AL EMPLEADO ESTE MES</h3>
            </div>
            
            
            <table class="table table-striped" id="example" style="background: cornflowerblue;">
                <thead>
                    <tr>
                        
                        <th>EMPLEADO</th>
                        <th>TIPO DE PAGO</th>
                        <th>VALOR</th>
                    </tr>
                </thead>
            
            
                
                <?php foreach((array) $allargs as $delos): ?>
                <tbody>
                    <tr>
                    <td><?php echo $delos['employee'] ?></td>
                    <td><?php echo $delos['detalles'] ?></td>
                    
                    <td><?php echo $delos['valor']; ?></td>
                    </tr>
                </tbody>  
                
                      
                <?php endforeach; ?>
                
                <div class="box box-body">
                    <h4>Sueldo del empleado: <strong><?php echo number_format($mensualiad, 2) ?></strong></h4>
                    <h4>Total valores del empleado en este mes: <strong><?php echo $los_totales; ?></strong></h4>
                    <h4>Valor total a pagar: <strong><?php echo number_format($resta, 2) ?></strong></h4>
                </div>
            </table>
            </div>
        </div>
    </div>
</div>
</section>
</div>
<?php
require_once ("../foot_unico.php");
}else{
    session_unset();
    session_destroy();
    header('Location:  ../../../index.php');
}?>