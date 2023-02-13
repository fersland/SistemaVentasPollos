<?php require_once ("../../datos/db/connect.php");
  	$registro = DBSTART::abrirDB()->prepare("SELECT * FROM c_roles");
    $registro->execute();
    $all = $registro->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="box">
    <div class="box-body">
        <table id="example" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>NOMBRE PERFIL</th>
                    <th>OBSERVACIÓN</th>
                    <th>FECHA REGISTRO</th>
                    <th>PERMISOS</th>
                    <th>ESTADO</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($all as $registro2){ ?>            
                <tr>
                    <td><?php echo $registro2['idrol'] ?></td>
                    <td><?php echo $registro2['nombrerol'] ?></td>
                    <td><?php echo $registro2['observacion'] ?></td>
                    <td><?php echo $registro2['fecharegistro'] ?></td>
                    <td><a class="" href="seguridad/permisos.php?cid=<?php echo $registro2['idrol'] ?>"><span class="badge bg-orange">Ver Permisos</span></a></td>
                    <?php if ($registro2['estado'] == 'A') { ?>
                            <td><span class="badge bg-green">ACTIVO</span></td>
                    <?php }elseif ($registro2['estado'] == 'I') { ?>
                        <td><span class="badge bg-red">INACTIVO</span></td>
                    <?php } ?>
                    <td><a class="<?php echo $ee ?>" href="../app/seguridad/frm_perfiles_act.php?cid=<?php echo $registro2['idrol'] ?> " >
                        <span class="btn btn-info"><i class="glyphicon glyphicon-pencil"></i></span></a></td>
                    <td><a class="<?php echo $dd ?>" href="../app/seguridad/frm_perfiles_eli.php?cid=<?php echo $registro2['idrol']?> " >
                        <span class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></span></a></td>
                </tr>
                <?php } ?>  
                </tbody>                      
        </table>
    </div>
</div>