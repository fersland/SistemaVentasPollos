<?php
    require_once ("../../datos/db/connect.php");

    $registro = DBSTART::abrirDB()->prepare("select cd.ncompra, PR.nombreproveedor, cd.cantidad, cd.descripcion, cd.precio_venta, cd.precio_compra, cd.fecha_registro, cd.codigo
                        FROM c_compra_detalle cd
                            INNER JOIN c_proveedor PR ON PR.id_proveedor = cd.id_prov_cd
                                 WHERE cd.estado = 'I'");
    $registro->execute();
    $all = $registro->fetchAll(PDO::FETCH_ASSOC);
   ?>
<div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="entrada" class="table table-bordered table-striped table-hover table-responsive">
                <thead>
                    <tr>
                        <th>N° Factura</th>
                        <th>FECHA COMPRA</th>
                        <th>PROVEEDOR</th>
                        <th>CODIGO</th>
                        <th>DESCRIPCION</th>
                        <th>CANTIDAD</th>
                    </tr>
                </thead>
            
            <tbody style="background:aquamarine">
            <?php foreach($all as $registro2){ ?>            
                <tr>
                    <td><?php echo $registro2['ncompra'] ?></td>
                    <td><?php echo $registro2['fecha_registro'] ?></td>
                    <td><?php echo $registro2['nombreproveedor'] ?></td>
                    <td><?php echo $registro2['codigo'] ?></td>
                    <td><?php echo $registro2['descripcion'] ?></td>
                    <td><?php echo $registro2['cantidad'] ?></td>
                </tr>
                <?php } ?>  
                </tbody>                      
            </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->