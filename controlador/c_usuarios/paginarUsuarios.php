<?php
    require_once ("../../datos/db/connect.php");

  	$registro = DBSTART::abrirDB()->prepare("select c.id_usuario, r.nombrerol, c.correo, c.fecha_registro, c.estado, concat(e.nombres, ' ', e.apellidos) as empl
                                        from c_usuarios c left join c_roles r on r.idrol = c.nivelacceso 
                                                          left join c_empleados e on e.id_empleado = c.idemp
                                        ORDER BY c.id_usuario DESC");
    $registro->execute();
    $all = $registro->fetchAll(PDO::FETCH_ASSOC);
   ?>
<div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example" class="table table-bordered table-striped table-hover">
                <thead>
                <tr>
                    <th>PERFIL</th>
                    <th>EMPLEADO</th>
                    <th>CORREO ELECTRÓNICO</th>
                    <th>FECHA REGISTRO</th>
                    <th>ESTADO</th>
                    <th>SEGURIDAD</th>
                    <th>HORARIOS</th>
                    <th>ELIMINAR</th>
                </tr>
            </thead>  
            
            <tbody>
            <?php foreach($all as $registro2){ ?>
                <tr>
                    <td><?php echo $registro2['nombrerol'] ?></td>
                    <td><?php echo $registro2['empl'] ?></td>
                    <td><?php echo $registro2['correo'] ?></td>
                    <td><?php echo $registro2['fecha_registro'] ?></td>
                    <?php if ($registro2['estado'] == 'A') { ?>
                        <td><span class="badge bg-green" style="padding: 4px">ACTIVO</span></td>
                        <td><a href="../app/usuarios/frm_cl.php?cid=<?php echo $registro2['id_usuario'] ?> " >
                        <span class="badge bg-red" style="padding: 4px">CAMBIAR CLAVE</span></a></td>
                        
                        <td><a href="../app/usuarios/frm_horarios.php?cid=<?php echo $registro2['id_usuario'] ?> " >
                        <span class="badge bg-blue" style="padding: 4px">CAMBIAR HORARIOS</span></a></td>
                        
                        <td><a href="../app/usuarios/frm_usuarios_eli.php?cid=<?php echo $registro2['id_usuario'] ?> " >
                        <span class="badge bg-red" style="padding: 4px">ELIMINAR</span></a></td>
                    <?php }elseif ($registro2['estado'] == 'I'){ ?>
                    
                    <td><span class="badge bg-red">INACTIVO</span></td>
                    <td></td>
                    <td></td>
                    <?php } ?>

                    
                </tr>
                <?php } ?>  
                </tbody>                      
            </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->