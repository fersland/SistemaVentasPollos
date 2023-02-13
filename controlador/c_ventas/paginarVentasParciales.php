<?php
    require_once ("../../datos/db/connect.php");

    $registro = DBSTART::abrirDB()->prepare("select v.nventa, v.cliente, v.forma_pago, c.nombres, v.total, v.fecharegistro, v.norden, 
                                                concat(t3.nombres, ' ', t3.apellidos) as eply, t4.nombre as nsucursal, v.parcial
                                                from c_venta v left join c_clientes c on c.cedula = v.cliente
                                                    left join c_empleados t3 on t3.id_empleado = v.idr
                                                    left join c_sucursal t4 on t4.id_sucursal = v.sucursal
                                                where v.estado = 'I' AND v.forma_pago='Parcial'");
    $registro->execute();
    $all = $registro->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="box">
    <div class="box-body">
        <table id="example" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Sucursal</th>
                    <th>Factura</th>
                    <th>Cliente</th>
                    <th>Responsable</th>
                    <th>Pago Parcial</th>
                    <th>Total</th>
                    <th>Fecha</th>
                    <th>Ver Factura</th>
                    <th>Ver Recibo</th>
                    <th>Anular Factura</th>
                </tr>
            </thead>
            
            <tbody>
            <?php foreach($all as $registro2){ ?>
                <tr>
                <td><?php echo $registro2['nsucursal'] ?></td>
                    <td><?php echo $registro2['nventa'] ?></td>
                    <?php if ($registro2['cliente'] == 0){ ?>
                        <td>CONSUMIDOR FINAL</td>
                        <td><?php echo strtoupper($registro2['eply']) ?></td>
                        

                    <?php }else{ ?>
                        <td><?php echo strtoupper($registro2['nombres']) ?></td>
                        <td><?php echo strtoupper($registro2['eply']) ?></td>
                        
                    <?php } ?>
                    <td><?php echo $registro2['parcial'] ?></td>
                    <td><?php echo $registro2['total'] ?></td>
                    <td><?php echo $registro2['fecharegistro'] ?></td>

                    
                    <!--<td><a href="../app/ventas/frm_ventas_facturadas_act.php?cid=<?php //echo $registro2['norden']?> ">
                      <span class="btn btn-info"><i class="glyphicon glyphicon-pencil"></i></span></a></td>-->
                      <td><a target="_blank" href="../../datos/clases/pdf/informe_ventas/venta.php?factura=<?php echo $registro2['norden']?> " >
                                <span class="btn btn-success"><i class="glyphicon glyphicon-print"></i></span></a></td>
                        <td><a target="_blank" href="../../datos/clases/pdf/informe_ventas/infparcial.php?factura=<?php echo $registro2['norden']?> " >
                                <span class="btn btn-info"><i class="glyphicon glyphicon-print"></i></span></a></td>
                      <td><a href="../app/ventas/ventas_del.php?cid=<?php echo $registro2['norden'] ?> ">
                      <span class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></span></a></td>
 
                </tr>
        <?php } ?>  
      </tbody>                      
    </table>
  </div><!-- /.box-body -->
</div><!-- /.box -->