<?php
    require_once ("../../datos/db/connect.php");

    $registro = DBSTART::abrirDB()->prepare("select * from c_sucursal e where e.id_estado = 1 ORDER BY e.id_sucursal DESC");
    $registro->execute();
    $all = $registro->fetchAll(PDO::FETCH_ASSOC);
   ?>
<div class="box">
    <div class="box-body">
        <table id="example" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>SUCURSAL</th>
                    <th>DIRECCION</th>
                    <th>FECHA</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            
            <tbody>
            <?php foreach($all as $registro2){ ?>
                <tr >
                    <td><?php echo @$registro2['nombre'] ?></td>
                    <td><?php echo @$registro2['direccion'] ?></td>
                    <td><?php echo @$registro2['fecha_creacion'] ?></td>
                    <td><a class="<?php echo @$ee ?>" href="../app/sucursales/frm_sucursal_act.php?cid=<?php echo @$registro2['id_sucursal'] ?> " >
                        <span class="btn btn-info"><i class="glyphicon glyphicon-pencil"></i></span></a></td>
                    <td><a class="<?php echo @$dd ?>" href="../app/sucursales/frm_sucursal_eli.php?cid=<?php echo @$registro2['id_sucursal'] ?> " >
                        <span class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></span></a></td>    
                </tr>
                <?php } ?>  
            </tbody>                      
        </table>
    </div>
</div>