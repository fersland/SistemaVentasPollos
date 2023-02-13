<?php
    require_once ("../../datos/db/connect.php");

    $registro = DBSTART::abrirDB()->prepare("select * from c_compra e 
                                                inner join c_proveedor pv on pv.id_proveedor = e.id_proveedor
                                                where e.estado = 'X' ORDER BY e.idc_compra");
    $registro->execute();
    $all = $registro->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="box box-danger">
            <div class="box-body">
              <table id="example" class="table table-bordered table-striped table-hover">
                <thead>
                <tr>
                    <th>Factura</th>
                    <th>Proveedor</th>
                    <th>Total</th>
                    <th>Fecha</th>
                    <!--<th></th>-->
                </tr>
            </thead>  
            
            <tbody>
            <?php foreach($all as $registro2){ ?>            
                <tr>
                    <td><?php echo $registro2['ncompra'] ?></td>
                    <td><?php echo $registro2['nombreproveedor'] ?></td>
                    <td><?php echo $registro2['total'] ?></td>
                    <td><?php echo $registro2['fecha_registro'] ?></td>
<!--<td><a class="<?php //echo $pp ?>" target="_blank" href="../../../datos/clases/pdf/informe_compras/compra.php?factura=<?php //echo $registro2['ncompra']?> " >
  <span class="btn btn-success"><i class="glyphicon glyphicon-print

"></i></span></a></td> -->
                </tr>
        <?php } ?>  
      </tbody>
    </table>
  </div><!-- /.box-body -->
</div><!-- /.box -->