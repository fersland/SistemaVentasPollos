<?php
 session_start();
 if(isset($_SESSION["acceso"])) {   
	require_once ("../head_unico.php");
?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Ventas /
        <b>Historial por Fechas</b>
      </h1>
      <ol class="breadcrumb">
        <li><a href="../in.php?cid=dashboard/init"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Ventas</a></li>
        <li class="active"><a href="../in.php?cid=devolucion/dev">Anular Venta</a></li>
      </ol>
    </section>

<!-- Main content -->
<section class="content">
<div class="row"><br />
<!--<div class="col-lg-12">
            <div class="alert alert-danger" style="margin-top: 10px; height: 100px">
              <h4><i class="fa fa-info"></i> Precaución:</h4>
              
              <p>Al confirmar la eliminación de la venta, los pagos realizados de la cuenta por cobrar de esta venta 
              seran eliminados.</p>
            </div>
        </div>-->
  <div class="col-md-12">
<?php

    $desde = isset($_GET['desde']) ? $_GET['desde'] : 0;
    $hasta = isset($_GET['hasta']) ? $_GET['hasta'] : 0;
    $sucursal = isset($_GET['sucursal']) ? $_GET['sucursal'] : 0;

    $registro = $db->prepare("select * from c_venta v left join c_clientes c on c.cedula = v.cliente 
                                                where v.fecha_origen between '$desde' AND '$hasta' AND v.estado = 'I' AND v.sucursal = '$sucursal'");
    $registro->execute();
    $all = $registro->fetchAll(PDO::FETCH_ASSOC);
    $rulz = $registro->rowCount();
?>
  </div>
    <div class="col-md-12">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Numero de resultados para esta busqueda (<?php echo $rulz; ?>)</h3>
            </div>
<div class="box">
    <div class="box-body">
        <table id="example1" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Factura</th>
                    <th>Cliente</th>
                    <th>Forma de Pago</th>
                    <th>Total</th>
                    <th>Fecha</th>
                    <th>Ver Factura</th>
                    <th>Anular Factura</th>
                </tr>
            </thead>
            
            <tbody>
            <?php foreach($all as $registro2){ ?>
                <tr>
                    <td><?php echo $registro2['nventa'] ?></td>
                    <?php if ($registro2['cliente'] == 0){ ?>
                        <td>CONSUMIDOR FINAL</td>
                        <td><?php echo strtoupper($registro2['forma_pago']) ?></td>
                    <?php }else{ ?>
                        <td><?php echo strtoupper($registro2['nombres']) ?></td>
                        <td><?php echo strtoupper($registro2['forma_pago']) ?></td>
                    <?php } ?>
                    <td><?php echo $registro2['total'] ?></td>
                    <td><?php echo $registro2['fecharegistro'] ?></td>

                    
                    <!--<td><a href="../app/ventas/frm_ventas_facturadas_act.php?cid=<?php //echo $registro2['norden']?> ">
                      <span class="btn btn-info"><i class="glyphicon glyphicon-pencil"></i></span></a></td>-->
                      <td><a target="_blank" href="../../../datos/clases/pdf/informe_ventas/venta.php?factura=<?php echo $registro2['norden']?> " >
  <span class="btn btn-success"><i class="glyphicon glyphicon-print"></i></span></a></td>
                      <td><a href="../app/ventas/ventas_del.php?cid=<?php echo $registro2['norden'] ?> ">
                      <span class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></span></a></td>
 
                </tr>
        <?php } ?>  
      </tbody>                      
    </table>
  </div><!-- /.box-body -->
</div><!-- /.box -->
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
} 
?>