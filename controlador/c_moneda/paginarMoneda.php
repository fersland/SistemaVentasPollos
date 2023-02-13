<?php
    require_once ("../../datos/db/connect.php");

  	$registro = DBSTART::abrirDB()->prepare("select * from c_moneda where estado = 1 ORDER BY id DESC");
    $registro->execute();
    $all = $registro->fetchAll(PDO::FETCH_ASSOC);
   ?>
    <table id="example" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>NOMBRE</th>
                    <th>ABREVIATURA</th>
                    <th>DECIMALES</th>
                    <th>SIGNO</th>
                    <th></th>
                    <th></th>
                </tr> 
            </thead>
            <tbody>
                 <?php foreach ($all as $send) { ?>
                <tr>
                
                    <td><?php echo @$send['nombre'] ?></td>
                    <td><?php echo @$send['abrv'] ?></td>
                    <td><?php echo @$send['decimales'] ?></td>
                    <td><?php echo @$send['signo'] ?></td>
                <td><a class="<?php echo @$ee ?>" style="color:white" href="../app/moneda/frm_moneda_act.php?cid=<?php echo $send['id'] ?>"><span class="btn btn-info">
                    <i class="glyphicon glyphicon-pencil" style="padding: 2px;"> </i></span> </a></td>
                <td><a class="<?php echo @$dd ?>" style="color:white" href="../app/moneda/frm_moneda_eli.php?cid=<?php echo $send['id'] ?>">
                    <span class="btn btn-danger"><i class="glyphicon glyphicon-remove" style="padding: 2px;"> </i></span></a></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
          <!-- /.box -->