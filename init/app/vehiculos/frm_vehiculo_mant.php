<?php
 session_start();
 if(isset($_SESSION["acceso"])) {
    require_once ("../head_unico.php");
?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>Veh&iacute;culos / <b>Movimiento</b> /  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-default">
                <i class="fa fa-plus"></i> Nuevo
              </button></h1>
      <ol class="breadcrumb">
        <li><a href="../in.php?cid=dashboard/init"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Veh&iacute;culos</a></li>
        <li class="active"><a href="#">Movimiento</a></li>
      </ol>
    </section>
<section class="content">
<div class="row"><br />
  <div class="col-md-12">
<?php
 if (isset($_POST['update'])) { // Actualizar datos
    $idemp    = $_POST['_id'];
    $tipo    = $_POST['tipo'];
    $eply    = $_POST['eply'];
    $valor    = $_POST['valor'];
    $anio    = $_POST['anio'];
    $mes    = $_POST['mes'];
    $dia    = $_POST['dia'];
    $detalle    = $_POST['detalle'];
    $fecha    = $_POST['fecha'];
    $hora    = $_POST['hora'];


    /*****************************************************************
         SALDO INICIAL SUMATORIA AL INGRESO POR VENTAS
        ******************************************************************/
        // CONSULTAR SALDO INICIAL EN LA TABLA SALDO
        $sous = $db->prepare("SELECT * FROM c_saldo");
        $sous->execute();
        $allsous = $sous->fetchAll(PDO::FETCH_ASSOC);
        
        foreach((array) $allsous as $datasaldo) {
            $saldo = $datasaldo['saldo'];
            $nuevo_saldo = $saldo - $valor;
        }
        
        // ACTUALIZAR EL SALDO EN LA TABLA SALDO
            $upd = DBSTART::abrirDB()->prepare("UPDATE c_saldo SET saldo=saldo - '$valor'");
            $upd->execute();
        
        // FIN SALDO INICIAL
        
          $stmt = $db->prepare("INSERT INTO c_vehiculo_movimiento (id_tipo, id_empleado, id_auto, detalle, valor, fecha, hora, id_estado)
                    VALUES ('$tipo', '$eply', '$idemp', '$detalle', '$valor', '$fecha', '$hora', 1)");
            if ( $stmt->execute() ){
                // Ingresar a caja chica
                    
                $sqlsaldo = $db->prepare("INSERT INTO c_resumen_gasto (param, tipo, id_empleado, valor, anio, mes, dia, entrada, salida, saldo, id_estado) 
                                  VALUES (2, '$tipo', '$eply', '$valor', '$anio', '$mes', '$dia', 0, '$valor', '$nuevo_saldo' ,1)");
                $sqlsaldo->execute();

                // AUMENTAR LAS VECES DEL VEHICULO
                $veces = $db->prepare("UPDATE c_vehiculo SET veces=veces+1 WHERE id='$idemp'");
                $veces->execute();

              echo '<div class="alert alert-success">
                    <b>Cambios guardados!  </b>
                </div>';
            }else{
                    echo '<div class="alert alert-warning">
                    <b>Error al guardar los cambios!</b>
                </div>';
                }
        
        
}

        $laid = isset($_GET['cid']) ? $_GET['cid'] : 0;
        $sql = $db->prepare("SELECT * FROM c_vehiculo WHERE id = '$laid'");
        $sql->execute();
        $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $key => $value) {
            $id          = $value['id'];
            $marca      = $value['marca'];
            $modelo    = $value['modelo'];
            $placa      = $value['placa'];
            $color      = $value['color'];
            $propietario      = $value['propietario'];
            $anio      = $value['anio'];
        }

  $trans = $db->prepare("SELECT * FROM c_tipo_gastos WHERE mant = 1");
  $trans->execute();
  $fetchtrans = $trans->fetchAll(PDO::FETCH_ASSOC);
  
  $eply = $db->prepare("SELECT * FROM c_empleados WHERE estado = 'A'");
  $eply->execute();
  $fetchteply = $eply->fetchAll(PDO::FETCH_ASSOC);
  
  $mov = $db->prepare("SELECT concat(t4.marca, '-', t4.modelo) as veh, t1.detalle, t1.valor, t1.fecha, concat(t3.nombres, ' ', t3.apellidos) as eply, t2.nombre as eltipo  
                             FROM c_vehiculo_movimiento t1 INNER JOIN c_tipo_gastos t2 ON t1.id_tipo = t2.id
                                    INNER JOIN c_empleados t3 ON t1.id_empleado = t3.id_empleado 
                                    INNER JOIN c_vehiculo t4 ON t1.id_auto = t4.id
                                    
                                    WHERE t1.id_estado = 1");
  $mov->execute();
  $fetchtmov = $mov->fetchAll(PDO::FETCH_ASSOC);
?>
  </div>
  
  
  
  
  
  
  
  
  
  
  <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-plus"></i> Nuevo Movimiento</h4>
              </div>
              <div class="modal-body">
                <form method="POST" class="form-horizontal">
        <input type="hidden" name="anio" class="form-control" value="<?php echo $year_zone ?>" />
      <input type="hidden" name="mes" class="form-control" value="<?php echo abs($month_zone) ?>" />
      <input type="hidden" name="dia" class="form-control" value="<?php echo abs($day_zone) ?>" />
          <div class="box-body">
          <input type="hidden" name="_id" value="<?php echo $id ?>">
            
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-4 control-label">Tipo de Movimiento (*)</label>
              <div class="col-sm-8">
                <select class="form-control" name="tipo">
                    <?php foreach((array) $fetchtrans as $tipo) : ?>
                        <option value="<?php echo $tipo['id'] ?>"><?php echo strtoupper($tipo['nombre']); ?></option>
                    <?php endforeach; ?>
                </select>
              </div>
            </div>
            
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-4 control-label">Encargado (*)</label>
              <div class="col-sm-8">
                <select class="form-control" name="eply">
                    <?php foreach((array) $fetchteply as $tipop) : ?>
                        <option value="<?php echo $tipop['id_empleado'] ?>"><?php echo strtoupper($tipop['nombres']. ' '. $tipop['apellidos']); ?></option>
                    <?php endforeach; ?>
                </select>
              </div>
            </div>
            
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-4 control-label">Marca (*)</label>
              <div class="col-sm-8">
                <input type="text" name="_marca" value="<?php echo $marca ?>" class="form-control" readonly="" />
              </div>
            </div>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-4 control-label">Modelo (*)</label>
              <div class="col-sm-8">
                <input type="text" name="_modelo" value="<?php echo $modelo ?>" class="form-control" readonly="" />
              </div>
            </div>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-4 control-label">Placa (*)</label>
              <div class="col-sm-8">
                <input type="text" name="_placa" value="<?php echo $placa ?>" class="form-control" readonly="" />
              </div>
            </div>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-4 control-label">Detalle (*)</label>
              <div class="col-sm-8">
                <textarea name="detalle" class="form-control" required="" ></textarea>
              </div>
            </div>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-4 control-label">Fecha (*)</label>
              <div class="col-sm-8">
                <input type="date" name="fecha" class="form-control" required="" />
              </div>
            </div>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-4 control-label">Hora (*)</label>
              <div class="col-sm-8">
                <input type="time" name="hora" class="form-control" />
              </div>
            </div>
            
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-4 control-label">Valor (*)</label>
              <div class="col-sm-8">
                <input type="number" name="valor" step="0.01" class="form-control" />
              </div>
            </div>
            </div>
            
              </div>
              <div class="modal-footer">
                <a href="../in.php?cid=vehiculos/frm_vehiculo" class="btn bg-navy pull-left">Volver</a>
                <button type="reset" class="btn btn-default">Cancelar</button>
                <button type="submit" class="btn btn-warning pull-right" name="update">Guardar Datos</button>
              </div>
            </div>
            
            </form>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

    
    
    <div class="col-md-12">
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">LIsta de Movimientos en Veh&iacute;culos</h3>
        </div>
                <table class="table table-striped table-hover" id="example1">
                    <thead>
                       <tr>
                            <th>TIPO</th>
                            <th>EMPLEADO</th>
                            <th>VEHICULO</th>
                            <th>DETALLE</th>
                            <th>VALOR</th>
                            <th>FECHA</th>
                        </tr> 
                    </thead>
                    
                    <tbody> 
                        <?php foreach((array) $fetchtmov as $ttl): ?>
                            <tr>
                                <td><?php echo $ttl['eltipo'] ?></td>
                                <td><?php echo $ttl['eply'] ?></td>
                                <td><?php echo $ttl['veh'] ?></td>
                                <td><?php echo $ttl['detalle'] ?></td>
                                <td><?php echo $ttl['valor'] ?></td>
                                <td><?php echo $ttl['fecha'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
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