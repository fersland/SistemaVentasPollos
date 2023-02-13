<?php
    $registro = $db->prepare("select * from c_venta v left join c_clientes c on c.cedula = v.cliente 
                                                where v.estado = 'I' OR v.estado = 'A'");
    $registro->execute();
    $all = $registro->fetchAll(PDO::FETCH_ASSOC);
?>
  <!--<img src="../../../inicializador/img/iva.png" class="img" width="100% " />-->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Ventas
        <small>Devolución</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?cid=dashboard/init"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="?cid=devolucion/dev">Ver listado</a></li>
        <li><a href="#">Devolución</a></li>
      </ol>
    </section>

<!-- Main content -->
<section class="content">
<div class="row"><br />
    <div class="col-md-12">
<div class="box">
    <div class="box-body">
        <table id="example" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Factura</th>
                    <th>Orden</th>
                    <th>Cliente</th>
                    <th>Forma</th>
                    <th>Total</th>
                    <th>Fecha</th>                    
                    <th>Ver Factura</th>
                    <th>Devolver</th>
                </tr>
            </thead>
            
            <tbody>
            <?php foreach($all as $registro2){ ?>
                <tr>
                    <td><?php echo $registro2['nventa'] ?></td>
                    <td><?php echo $registro2['norden'] ?></td>
                    <?php if ($registro2['cliente'] == 0){ ?>
                        <td>CONSUMIDOR FINAL</td>
                    <?php }else{ ?>
                        <td><?php echo $registro2['nombres'] ?></td>
                    <?php } ?>
                    <td><?php echo $registro2['forma_pago'] ?></td>
                    <td><?php echo $registro2['total'] ?></td>
                    <td><?php echo $registro2['fecharegistro'] ?></td>
                    
<td><a target="_blank" href="../../datos/clases/pdf/informe_ventas/venta.php?factura=<?php echo $registro2['norden']?> " >
  <span class="btn btn-success"><i class="glyphicon glyphicon-print"></i></span></a></td>
  <td><a href="devolucion/volt.php?arg=<?php echo $registro2['norden']?>&vn=<?php echo $registro2['nventa'] ?> " >
  <span class="btn btn-primary">Seleccionar <i class="fa fa-rotate-right"></i></span></a></td> 
                </tr>
        <?php } ?>  
      </tbody>                      
    </table>
  </div><!-- /.box-body -->
</div><!-- /.box -->
    </div>
        </div><!-- /.col -->
  </section>
</div>