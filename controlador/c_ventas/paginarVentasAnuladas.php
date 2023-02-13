<?php
    require_once ("../../datos/db/connect.php");

    $registro = DBSTART::abrirDB()->prepare("select * from c_venta v left join c_clientes c on c.id_cliente = v.cliente 
                                                where v.estado = 'X' OR v.estado = 'A'");
    $registro->execute();
    $all = $registro->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="box box-danger">
    <div class="box-body">
        <table id="example" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Factura</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Fecha</th>
                    <!--<th>Editar Factura</th>
                    <th>Anular Factura</th>-->
                    
                    <th>Ver Factura</th>
                </tr>
            </thead>
            
            <tbody>
            <?php foreach($all as $registro2){ ?>
                <tr>
                    <td><?php echo $registro2['nventa'] ?></td>
                    <?php if ($registro2['cliente'] == 0){ ?>
                        <td>CONSUMIDOR FINAL</td>
                    <?php }else{ ?>
                        <td><?php echo $registro2['nombres'] ?></td>
                    <?php } ?>
                    <td><?php echo $registro2['total'] ?></td>
                    <td><?php echo $registro2['fecharegistro'] ?></td>

                    
                    <!--<td><a href="../app/ventas/frm_ventas_facturadas_act.php?cid=<?php //echo $registro2['norden']?> ">
                      <span class="btn btn-info"><i class="glyphicon glyphicon-pencil"></i></span></a></td>
                      <td><a href="../app/ventas/frm_ventas_eli.php?cid=<?php //echo $registro2['norden'] ?> ">
                      <span class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></span></a></td>-->
<td><a target="_blank" href="../../datos/clases/pdf/informe_ventas/venta.php?factura=<?php echo $registro2['norden']?> " >
  <span class="btn btn-success"><i class="glyphicon glyphicon-print

"></i></span></a></td> 
                </tr>
        <?php } ?>  
      </tbody>                      
    </table>
  </div><!-- /.box-body -->
</div><!-- /.box -->