<?php
    require_once ("../../datos/db/connect.php");

  	$registro = DBSTART::abrirDB()->prepare("select * from c_vehiculo where id_estado = 1 ORDER BY id DESC");
    $registro->execute();
    $all = $registro->fetchAll(PDO::FETCH_ASSOC);
   ?>
    <table id="example" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                        <th>MARCA</th>
                        <th>MODELO</th>
                        <th>PLACA</th>
                        <th>COLOR</th>
                        <th>PROPIETARIO</th>
                        <th>AÑO</th>
                        <th>VECES_USADO</th>
                        <th></th>
                        <th></th>
                        <th></th>
                </tr> 
            </thead>
            <tbody>
                 <?php foreach ($all as $send) { ?>
                <tr>
                
                    <td><?php echo @$send['marca'] ?></td>
                    <td><?php echo @$send['modelo'] ?></td>
                    <td><?php echo @$send['placa'] ?></td>
                    <td><?php echo @$send['color'] ?></td>
                    <td><?php echo @$send['propietario'] ?></td>
                    <td><?php echo @$send['anio'] ?></td>
                    <td><?php echo @$send['veces'] ?></td>
                    <td><a class="<?php echo @$ee ?>" style="color:white" href="../app/vehiculos/frm_vehiculo_mant.php?cid=<?php echo $send['id'] ?>"><span class="btn btn-warning">
                    <i class="fa fa-flash" style="padding: 2px;"> </i></span> </a></td>
                    
                    <td><a class="<?php echo @$ee ?>" style="color:white" href="../app/vehiculos/frm_vehiculo_act.php?cid=<?php echo $send['id'] ?>"><span class="btn btn-info">
                    <i class="glyphicon glyphicon-pencil" style="padding: 2px;"> </i></span> </a></td>
                    <td><a class="<?php echo @$dd ?>" style="color:white" href="../app/vehiculos/frm_vehiculo_eli.php?cid=<?php echo $send['id'] ?>">
                    <span class="btn btn-danger"><i class="glyphicon glyphicon-remove" style="padding: 2px;"> </i></span></a></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
          <!-- /.box -->