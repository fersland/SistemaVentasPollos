<?php
    require_once ("../../datos/db/connect.php");

    $registro = DBSTART::abrirDB()->prepare("select * from c_empleados e 
                                left join c_roles r on r.idrol = e.id_acceso
                                inner join c_sucursal s on e.sucursal = s.id_sucursal
                                where e.estado = 'A' ORDER BY e.id_empleado DESC");
    $registro->execute();
    $all = $registro->fetchAll(PDO::FETCH_ASSOC);
?>
        <div class="box">
            <div class="box-body">
              <table id="example" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>SUCURSAL</th>
                            <th>PERFIL</th>
                            <th>CI/NIT</th>
                            <th>NOMBRES Y APELLIDOS</th>
                            <th>CORREO</th>
                            <th>TELÉFONO</th>
                            <th>CELULAR</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>  
            
                    <tbody>
                    <?php foreach($all as $registro2){ ?>            
                    <tr>
                        <td><?php echo $registro2['nombre']; ?></td>
                        <td><?php echo $registro2['nombrerol']; ?></td>
                        <td><?php echo $registro2['cedula'] ?></td>
                        <td><?php echo $registro2['nombres'].' '.$registro2['apellidos'] ?></td>
                        <td><?php echo $registro2['correo'] ?></td>
                        <td><?php echo $registro2['telefono'] ?></td>
                        <td><?php echo $registro2['celular'] ?></td>
                           
                        <td><a class="<?php echo @$ee ?>" href="../app/empleados/frm_empleados_act.php?cid=<?php echo $registro2['id_empleado'] ?> " >
                            <span class="btn btn-info"><i class="glyphicon glyphicon-pencil"></i></span></a></td>
                        <td><a class="<?php echo @$dd ?>" href="../app/empleados/frm_empleados_eli.php?cid=<?php echo $registro2['id_empleado']?> " >
                            <span class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></span></a></td>
                    </tr>
                    <?php } ?>  
                    </tbody>                      
            </table>
            </div>
          </div>