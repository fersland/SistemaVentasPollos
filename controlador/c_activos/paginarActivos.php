<?php
    require_once ("../../datos/db/connect.php");

    $registro = DBSTART::abrirDB()->prepare("select * from c_activos where estado = 'A'");
    $registro->execute();
    $all = $registro->fetchAll(PDO::FETCH_ASSOC);
   ?>
<div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example" class="table table-bordered table-striped table-hover table-responsive">
                <thead>
                <tr>
                    <th>DESCRIPCION</th>
                    <th>VALOR</th>
                    <th>ESTADO F&Iacute;SICO</th>
                    <th>C&Oacute;DIGO</th>
                    <th>RESPONSABLE</th>
                    <th>CANTIDAD</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            
            <tbody>
            <?php foreach($all as $registro2){ ?>            
                <tr>
                    <td><?php echo $registro2['descripcion'] ?></td>
                    <td><?php echo $registro2['valor'] ?></td>
                    <td><?php echo $registro2['estado_fisico'] ?></td>
                    <td><?php echo $registro2['codigo'] ?></td>
                    <td><?php echo $registro2['persona_resp'] ?></td>
                    <td><?php echo $registro2['cantidad'] ?></td>
                    <td><a class="<?php echo $ee ?>" href="../app/activos/frm_activos_act.php?cid=<?php echo $registro2['id_activos'] ?> " >
                        <span class="btn btn-info"><i class="glyphicon glyphicon-pencil"></i></span></a></td>
                    <td><a class="<?php echo $dd ?>" href="../app/activos/frm_activos_eli.php?cid=<?php echo $registro2['id_activos']?>">
                        <span class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></span></a></td> 
                </tr>
                <?php } ?>  
                </tbody>                      
            </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->