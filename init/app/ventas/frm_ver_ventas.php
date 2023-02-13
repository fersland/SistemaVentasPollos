<?php

// SUCURSALES
  $sqlsucursal = $db->prepare("SELECT * FROM c_sucursal WHERE id_estado = 1");
  $sqlsucursal->execute();
  $allsucursal = $sqlsucursal->fetchAll();
  
?>

<div class="content-wrapper">
    <section class="content-header">
      <h1><b>Ventas</b> / Historial Ventas </h1>
      <ol class="breadcrumb">
        <li><a href="?cid=dashboard/init"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Ventas</a></li>
        <li class="active"><a href="#">Historial de ventas</a></li>
        
      </ol>
    </section>


<section class="content">
    <div class="row"><br />
        <div class="card">
            <div class="col-md-12">
          <form target="_blank" method="get" action="ventas/frm_ver_ventas_param.php">
            <div class="form-group">
                <label class="col-md-1">Sucursal</label>
                <div class="col-md-2">
                    <select name="sucursal" class="form-control">              
                        <?php foreach((array) $allsucursal as $modelcase) : ?>
                            <option value="<?php echo $modelcase['id_sucursal']; ?>"><?php echo $modelcase['nombre']; ?></option>
                        <?php endforeach; ?>
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
          <?php require_once ("../../controlador/c_ventas/paginarVentas.php"); ?>
        </div><!-- nav-tabs-custom -->
    </div><!-- /.col -->

    <div class="row"><br />
        <div class="col-md-12">
            <strong><h3>HISTORIAL DE VENTAS CON PAGO PARCIAL</h3></strong>
          <?php require_once ("../../controlador/c_ventas/paginarVentasParciales.php"); ?>
        </div><!-- nav-tabs-custom -->
    </div><!-- /.col -->
  </section>
</div>