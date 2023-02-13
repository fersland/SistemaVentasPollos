<?php
    require_once ("../../datos/db/connect.php");

    $registro = DBSTART::abrirDB()->prepare("select * from c_proveedor where estado = 'A' ORDER BY id_proveedor DESC");
    $registro->execute();
    $all = $registro->fetchAll(PDO::FETCH_ASSOC);
   ?>
<div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example" class="table table-bordered table-striped table-hover">
                <thead>
                <tr>
                    <th>CI/NIT</th>
                    <th>Nombre Proveedor</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Celular</th>
                    <th>Direcci&oacute;n</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>  
            
            <tbody>
            <?php foreach($all as $registro2){ ?>            
                <tr>
                    <td><?php echo $registro2['ruc'] ?></td>
                    <td><?php echo $registro2['nombreproveedor'] ?></td>
                    <td><?php echo $registro2['correo'] ?></td>
                    <td><?php echo $registro2['telefono'] ?></td>
                    <td><?php echo $registro2['celular'] ?></td>
                    <td><?php echo $registro2['direccion'] ?></td>
                    <td><a class="<?php echo $ee ?>" href="../app/proveedor/frm_proveedor_act.php?cid=<?php echo $registro2['id_proveedor'] ?> " >
                            <span class="btn btn-info"><i class="glyphicon glyphicon-pencil"></i></span></a></td>
                    <td><a class="<?php echo $dd ?>" href="../app/proveedor/frm_proveedor_eli.php?cid=<?php echo $registro2['id_proveedor']?>">
                            <span class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></span></a></td>    
                </tr>
                <?php } ?>  
                </tbody>                      
            </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->



