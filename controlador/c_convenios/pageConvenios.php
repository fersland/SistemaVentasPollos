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
                
                <td><a class="<?php echo @$ee ?>" style="color:white" href="../app/convenios/newconvenios.php?cid=<?php echo $send['id_cliente']; ?>&ci=<?php echo $send['cedula']; ?>"><span class="btn btn-success">
                    <i class="fa fa-money" style="padding: 2px;"> </i>Convenios</span> </a></td>
            <?php } } ?>
            </tbody>
        </table>
          <!-- /.box -->