<?php
    require_once ("../../datos/db/connect.php");

    $registro = DBSTART::abrirDB()->prepare("select * FROM c_mercaderia where estado = 'A'");
    $registro->execute();
    $all = $registro->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example" class="table table-bordered table-striped table-hover table-responsive">
                <thead>
                <tr>
                    <th>CODIGO</th>
                    <th>DESCRIPCION</th>
                    <th>PRECIO VENTA</th>
                    <th>STOCK</th>
                    <th></th>
                </tr>
            </thead>
            
            <tbody>
            <?php foreach($all as $registro2){ ?>            
                <tr>
                    <td><?php echo $registro2['codproducto'] ?></td>
                    <td><?php echo $registro2['nombreproducto'] ?></td>
                    <td><?php echo $registro2['precio_venta'] ?></td>
                    <td><?php echo $registro2['existencia'] ?></td>
                    <td><a href="../app/mercaderia/confirmar.php?cid=<?php echo $registro2['codproducto'] ?>">
                        <span class="btn btn-warning"><i class="fa fa-refresh"></i></span></a></td>
                </tr>
                <?php } ?>  
                </tbody>                      
            </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->