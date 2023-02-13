<?php
    require_once ("../../datos/db/connect.php");

    $registro = DBSTART::abrirDB()->prepare("select e.ncompra, pv.nombreproveedor, e.total, e.fechacompra, e.ruta from c_compra e 
                                                inner join c_proveedor pv on pv.id_proveedor = e.id_proveedor
                                                where e.estado = 'A' ORDER BY e.idc_compra");
    $registro->execute();
    $all = $registro->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="box box-success">
    <div class="box-body">
        <table id="example" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Factura</th>
                    <th>Proveedor</th>
                    <th>Total</th>
                    <th>Fecha</th>
                    <th>Escaneado</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                    <th>Ver Reporte</th>
                </tr>
            </thead>  
            
            <tbody>
            <?php foreach($all as $registro2){ 

                

            ?>            
                <tr>
                    <td><?php echo $registro2['ncompra'] ?></td>
                    <td><?php echo $registro2['nombreproveedor'] ?></td>
                    <td><?php echo $registro2['total'] ?></td>
                    <td><?php echo $registro2['fechacompra'] ?></td>

                 <?php if ($registro2['ruta'] == '') { ?>
                    <td></td>
                <?php }else{ ?>
                    <td><a href="../pdf/<?php echo $registro2['ruta']; ?>" class="btn btn-warning" target="_blank" >VER PDF</a></td>
               <?php } ?>
                    


                    <td><a class="<?php echo $ee ?>" href="../app/compras/frm_compras_act.php?cid=<?php echo $registro2['ncompra'] ?> ">
                      <span class="btn btn-info"><i class="glyphicon glyphicon-pencil"></i></span></a></td>

                    <td><a class="<?php echo $dd ?>" href="../app/compras/frm_compras_total_eli.php?cid=<?php echo $registro2['ncompra']?> ">
                      <span class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></span></a></td>

<td><a class="<?php echo $pp ?>" target="_blank" href="../../datos/clases/pdf/informe_compras/compra.php?factura=<?php echo $registro2['ncompra']?> " >
  <span class="btn btn-success"><i class="glyphicon glyphicon-print

"></i></span></a></td> 
                </tr>
        <?php } ?>  
      </tbody>                      
    </table>
  </div><!-- /.box-body -->
</div><!-- /.box -->