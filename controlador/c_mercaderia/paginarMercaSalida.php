<?php
    require_once ("../../datos/db/connect.php");

    $registro = DBSTART::abrirDB()->prepare("select cd.nventa, cd.cantidad, m.nombreproducto, cd.fecharegistro, cd.codigo
                        FROM c_venta_detalle cd
                            LEFT JOIN c_mercaderia m ON m.codproducto = cd.codigo
                                 WHERE cd.estado = 'F'");
    $registro->execute();
    $all = $registro->fetchAll(PDO::FETCH_ASSOC);
   ?>
<div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="salida" class="table table-bordered table-striped table-hover table-responsive">
                <thead>
                <tr>
                    <th>N° Factura</th>
                    <th>FECHA VENTA</th>
                    <th>CODIGO</th>
                    <th>DESCRIPCION</th>
                    <th>CANTIDAD</th>
                </tr>
            </thead>
            
            <tbody style="background:antiquewhite">
            <?php foreach($all as $registro2){ ?>            
                <tr>
                    <td><?php echo $registro2['nventa'] ?></td>
                    <td><?php echo $registro2['fecharegistro'] ?></td>
                    <td><?php echo $registro2['codigo'] ?></td>
                    <td><?php echo $registro2['nombreproducto'] ?></td>
                    <td><?php echo $registro2['cantidad'] ?></td>
                </tr>
                <?php } ?>  
                </tbody>                      
            </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->