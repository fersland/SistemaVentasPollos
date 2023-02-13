<?php
    require_once ("../../datos/db/connect.php");

    $registro = DBSTART::abrirDB()->prepare("select * FROM c_compra c inner join c_proveedor pv on
                                                pv.id_proveedor = c.id_proveedor where c.estado = 'A' and c.subido='NO'");
    $registro->execute();
    $all = $registro->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example" class="table table-bordered table-striped table-hover table-responsive">
                <thead>
                <tr>
                    <th>FACTURA</th>
                    <th>PROVEEDOR</th>
                    <th>FORMA PAGO</th>
                    <th>FECHA COMPRA</th>
                    <th>TOTAL</th>
                    <th></th>
                </tr>
            </thead>
            
            <tbody>
            <?php foreach($all as $registro2){ ?>            
                <tr>
                    <td><?php echo $registro2['ncompra'] ?></td>
                    <td><?php echo $registro2['nombreproveedor'] ?></td>
                    <td><?php echo $registro2['forma_pago'] ?></td>
                    <td><?php echo $registro2['fechacompra'] ?></td>
                    <td><?php echo $registro2['total'] ?></td>
                    <td><a href="../app/mercaderia/confirmar_subida_compra.php?cid=<?php echo $registro2['idc_compra'] ?>">
                        <span class="btn btn-info"><i class="fa fa-star"></i> Seleccionar Factura</span></a></td>
                    
                </tr>
                <?php } ?>  
                </tbody>                      
            </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->