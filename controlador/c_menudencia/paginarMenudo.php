<?php
    require_once ("../../datos/db/connect.php");

    $registro = DBSTART::abrirDB()->prepare("SELECT * FROM menu t1 LEFT JOIN c_proveedor t2 ON t1.proveedor = t2.id_proveedor ORDER BY t1.id DESC");
    $registro->execute();
    $all = $registro->fetchAll(PDO::FETCH_ASSOC);
?>
        <div class="box">
            <div class="box-body">
              <table id="example" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>FACTURA</th>
                            <th>PROVEEDOR</th>
                            <th>TOTAL_PATA</th>
                            <th>TOTAL_MOLLEJA</th>
                            <th>TOTAL_HIGADO</th>
                            <th>TOTAL_MENUDO</th>
                            <th>FECHA_REGISTRO</th>
                            <th></th>
                        </tr>
                    </thead>  
            
                    <tbody>
                    <?php foreach($all as $registro2){ ?>            
                    <tr>
                        <td><?php echo $registro2['nfactura']; ?></td>
                        <td><?php echo $registro2['nombreproveedor']; ?></td>
                        <td><?php echo $registro2['sumapata']; ?></td>
                        <td><?php echo $registro2['sumamolleja'] ?></td>
                        <td><?php echo $registro2['sumahigado'] ?></td>
                        <td><?php echo $registro2['sumakg'] ?></td>
                        <td><?php echo $registro2['fecha_registro'] ?></td>
                           
                        <td><a target="_blank" class="<?php echo @$ee ?>" href="../../datos/clases/pdf/menudencia.php?cid=<?php echo $registro2['nnum'] ?> " >
                            <span class="btn btn-info"><i class="fa fa-list"></i></span></a></td>
                        <!--<td><a class="<?php //echo @$dd ?>" href="../app/empleados/frm_empleados_eli.php?cid=<?php //echo $registro2['id']?> " >
                            <span class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></span></a></td>-->
                    </tr>
                    <?php } ?>  
                    </tbody>                      
            </table>
            </div>
          </div>