<?php
    require_once ("../../datos/db/connect.php");

    $registro = DBSTART::abrirDB()->prepare("
                    SELECT p.id_pago, r.cedula, r.nombres, r.apellidos, p.valor, p.fecha_pago, pd.nombre as tipo
                        FROM c_pagos p
                            INNER JOIN c_empleados r ON p.id_empleado = r.id_empleado
                            INNER JOIN c_pagos_detalle pd ON pd.id = p.detalle 
                            WHERE p.id_estado = 1");
    $registro->execute();
    $all = $registro->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="box">
    <div class="box-header"><h4><b>Lista de pagos a empleados</b></h4></div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example" class="table table-bordered table-striped table-hover">
                <thead>
                <tr>
                    <th>TIPO</th>
                    <th>EMPLEADO</th>
                    <th>VALOR</th>
                    <th>FECHA</th>
                    
                    <?php if (isset($_SESSION["rol"]) == 'Administrador') { ?>
                    <th></th>
                    <th></th>
                    <?php } ?>
                </tr>
            </thead>
            
            <tbody>
            <?php foreach($all as $registro2){ ?>
                <tr>
                    <td><?php echo $registro2['tipo'] ?></td>
                    <td><?php echo $registro2['nombres'].' '.$registro2['apellidos'] ?></td>
                    <td><?php echo '$ '.$registro2['valor'] ?></td>
                    <td><?php echo $registro2['fecha_pago'] ?></td>
                    <?php if (isset($_SESSION["rol"]) == 'Administrador') { ?>
                    <td><a href="../app/empleados/frm_pagos_act.php?cid=<?php echo $registro2['id_pago'] ?> " >
                            <span class="btn btn-info"><i class="glyphicon glyphicon-pencil"></i></span></a></td>
                    <td><a href="../app/empleados/frm_pagos_eli.php?cid=<?php echo $registro2['id_pago']?> " >
                        <span class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></span></a></td>  
                        <?php } ?>  
                </tr>
                <?php } ?>  
                </tbody>                      
            </table>
            </div>
          </div>