<?php
    require_once ("../../datos/db/connect.php");

  	$registro = DBSTART::abrirDB()->prepare("select * from c_clientes c where c.estado = 'A' ORDER BY c.id_cliente DESC");
    $registro->execute();
    $all = $registro->fetchAll(PDO::FETCH_ASSOC);
   ?>
    <table id="example" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                        <th>CI/NIT</th>
                        <th>Nombres</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Celular</th>
                        <th>Direcci&oacute;n</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                </tr> 
            </thead>
            <tbody>
                 <?php foreach ($all as $send) { ?>
                 <?php if (strlen($send['cedula'] >= 10 )){ ?>
                <tr>
                
                    <td><?php echo @$send['cedula'] ?></td>
                    <td><?php echo @$send['nombres'] ?></td>
                    <td><?php echo @$send['correo'] ?></td>
                    <td><?php echo @$send['telefono'] ?></td>
                    <td><?php echo @$send['celular'] ?></td>
                    <td><?php echo @$send['direccion_cliente'] ?></td>
                
                <td><a class="<?php echo @$ee ?>" style="color:white" href="../app/clientes/frm_ex.php?cid=<?php echo $send['cedula'] ?>"><span class="btn btn-success">
                    <i class="fa fa-money" style="padding: 2px;"> </i>Excedente</span> </a></td>
                <td><a class="<?php echo @$ee ?>" style="color:white" href="../app/clientes/frm_history.php?cid=<?php echo $send['cedula'] ?>"><span class="btn btn-warning">
                    <i class="fa fa-money" style="padding: 2px;"> </i>Historial</span> </a></td>
                
                <td><a class="<?php echo @$ee ?>" style="color:white" href="../app/clientes/frm_clientes_act.php?cid=<?php echo $send['id_cliente'] ?>"><span class="btn btn-info">
                    <i class="glyphicon glyphicon-pencil" style="padding: 2px;"> </i></span> </a></td>
                <td><a class="<?php echo @$dd ?>" style="color:white" href="../app/clientes/frm_clientes_eli.php?cid=<?php echo $send['id_cliente'] ?>">
                    <span class="btn btn-danger"><i class="glyphicon glyphicon-remove" style="padding: 2px;"> </i></span></a></td>
                </tr>
            <?php } } ?>
            </tbody>
        </table>
          <!-- /.box -->