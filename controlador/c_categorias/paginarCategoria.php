<?php
    require_once ("../../datos/db/connect.php");

    $registro = DBSTART::abrirDB()->prepare("select * from c_categoria e where e.estado = 'A' ORDER BY e.id_categoria DESC");
    $registro->execute();
    $all = $registro->fetchAll(PDO::FETCH_ASSOC);
   ?>
<div class="box">
    <div class="box-body">
        <table id="example" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>CODIGO_BARRAS</th>
                    <th>CATEGORIA</th>
                    <th>FECHA REGISTRO</th>
                    <th>DESCRIPCION</th>
                    <th>EDITAR</th>
                    <th>ELIMINAR</th>
                </tr>
            </thead>
            
            <tbody>
            <?php foreach($all as $registro2){ ?>
                <tr >
                    <td><img src="../../init/barcode/barcode.php?text=<?php echo @$registro2['nombre'] ?>"></td>
                    <td><?php echo @$registro2['nombre'] ?></td>
                    <td><?php echo @$registro2['fecha_registro'] ?></td>
                    <td><?php echo @$registro2['observacion'] ?></td>
                    <td><a class="<?php echo @$ee ?>" href="../app/categoria/frm_categoria_act.php?cid=<?php echo @$registro2['id_categoria'] ?> " >
                        <span class="btn btn-info"><i class="glyphicon glyphicon-pencil"></i></span></a></td>
                    <td><a class="<?php echo @$dd ?>" href="../app/categoria/frm_categoria_eli.php?cid=<?php echo @$registro2['id_categoria'] ?> " >
                        <span class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></span></a></td>    
                </tr>
                <?php } ?>  
            </tbody>                      
        </table>
    </div>
</div>