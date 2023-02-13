<?php
    require_once ("../../datos/db/connect.php");

    $registro = DBSTART::abrirDB()->prepare("
                    SELECT p.id, r.cedula, r.nombres, r.apellidos, p.valor, p.fecha, pd.nombre as tipo, c.nombre as contable,
                            p.entrada, p.salida, p.saldo, p.obs
                        FROM c_resumen_gasto p
                            LEFT JOIN c_empleados r ON p.id_empleado = r.id_empleado
                            LEFT JOIN c_conta c ON c.id = p.param
                            INNER JOIN c_tipo_gastos pd ON pd.id = p.tipo WHERE p.id_estado = 1 ORDER BY p.fecha ASC");
    $registro->execute();
    $all = $registro->fetchAll(PDO::FETCH_ASSOC);
?>
    <div class="box">
        <div class="box-body">
            <table id="exampleargs" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>DETALLE</th>
                        <th>EMPLEADO</th>
                        <th>ENTRADA</th>
                        <th>SALIDA</th>
                        <th>SALDO</th>
                        <th>FECHA_HORA</th>
                        <th>OBSERVACION</th>
                        <th></th>
                    </tr>
                </thead>
            <tbody>
            <?php foreach($all as $registro2){
                
                if ($registro2['tipo'] == 'Cierre de Caja') {
                    $back = 'coral';
                }else{
                    $back = 'lightgreen';
                }?>
                <tr style="background: <?php echo $back ?>;">
                    <td><?php echo utf8_decode($registro2['tipo']) ?></td>
                    <td><?php echo utf8_decode($registro2['nombres'].' '.$registro2['apellidos']) ?></td>
                    <td><?php echo $registro2['entrada'] ?></td>
                    <td><?php echo $registro2['salida'] ?></td>
                    <td><?php echo $registro2['saldo'] ?></td>
                    <td><?php echo $registro2['fecha'] ?></td>
                    <td><?php echo $registro2['obs'] ?></td>
                    <td><a href="../app/cgg/cgg_del.php?cid=<?php echo $registro2['id']; ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Eliminar</a></td>
                </tr>
                <?php } ?>  
                </tbody>                      
            </table>
            </div>
          </div>