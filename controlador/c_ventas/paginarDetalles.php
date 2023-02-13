<?php
    require_once ("../../datos/db/connect.php");

    $registro = DBSTART::abrirDB()->prepare("SELECT v.nventa, v.cliente, vd.codigo, vd.categoria, vd.lamerma, c.nombres, m.nombreproducto, vd.lacompra
                                                FROM c_venta v
                                                    LEFT JOIN c_venta_detalle vd ON vd.nventa = v.nventa
                                                    LEFT JOIN c_clientes c on c.cedula = v.cliente 
                                                    INNER JOIN c_mercaderia m ON m.codproducto = vd.codigo
                                                WHERE v.estado = 'I' OR v.estado = 'A'
                                                ORDER BY v.nventa DESC");
    $registro->execute();
    $all = $registro->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="box">
    <div class="box-body">
        <table id="example" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>FACTURA_VENTA</th>
                    <th>FACTURA_COMPRA</th>
                    <th>CLIENTE</th>
                    <th>CODIGO</th>
                    <th>DESCRIPCION</th>
                    <th>CATEGORIA</th>
                    <th>MERMA</th>
                    <th></th>
                </tr>
            </thead>
            
            <tbody>
            <?php foreach($all as $registro2){ ?>
                <tr>
                    
                    <?php if ($registro2['cliente'] == 0){ ?>
                        <td><?php echo $registro2['nventa'] ?></td>
                        <td><?php echo $registro2['lacompra'] ?></td>
                        <td>CONSUMIDOR FINAL</td>
                        <td><?php echo strtoupper($registro2['codigo']) ?></td>
                        <td><?php echo strtoupper($registro2['nombreproducto']) ?></td>
                        <td><?php echo strtoupper($registro2['categoria']) ?></td>
                        <td><?php echo strtoupper($registro2['lamerma']) ?></td>
                    <?php }else{ ?>
                        <td><?php echo $registro2['nventa'] ?></td>
                        <td><?php echo $registro2['lacompra'] ?></td>
                        <td><?php echo strtoupper($registro2['nombres']) ?></td>
                        <td><?php echo strtoupper($registro2['codigo']) ?></td>    
                        <td><?php echo strtoupper($registro2['nombreproducto']) ?></td>                    
                        <td><?php echo strtoupper($registro2['categoria']) ?></td>
                        <td><?php echo strtoupper($registro2['lamerma']) ?></td>
                    <?php } ?>

                
                      <td><a href="../../init/app/ventas/details.php?codigo=<?php echo $registro2['codigo']?>&factura=<?php echo $registro2['lacompra']; ?>">
                                                <span class="btn btn-success"><i class="glyphicon glyphicon-print"></i> VER RESULTADOS</span> </a></td>
 
                </tr>
        <?php } ?>  
      </tbody>                      
    </table>
  </div><!-- /.box-body -->
</div><!-- /.box -->