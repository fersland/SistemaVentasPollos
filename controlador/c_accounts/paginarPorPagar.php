<?php
    require_once ("../../datos/db/connect.php");

  	$registro = DBSTART::abrirDB()->prepare("select v.id_cxp, c.ruc, v.fecha_cxp, v.total,v.saldo, v.meses, v.cuotas_pagadas,
                                                 v.cuotas_pendientes, v.diferido, v.estado, c.nombreproveedor 
                                                 from c_cxp v inner join c_proveedor c on c.id_proveedor = v.id_proveedor 
                                                    ORDER BY v.id_cxp DESC");
    $registro->execute();
    $all = $registro->fetchAll(PDO::FETCH_ASSOC);
   ?>
    <table id="example" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                        <th>CI/NIT</th>
                        <th>Nombres</th>
                        <th>Fecha Venta</th>
                        <th>Total</th>
                        <!--<th>Saldo Pendiente</th>-->
                        <th>Cuotas Totales</th>
                        <!--<th>Cuotas Pagadas</th>
                        <th>Cuotas Pendientes</th>-->
                        <th>Diferido</th>
                        <th>ESTADO</th>
                        <th>PAGAR</th>
                        <th>Historial</th>
                </tr>
            </thead>
            <tbody>
                 <?php foreach ($all as $send) { ?>
                 <?php if (strlen($send['ruc'] >= 1 )){ ?>
                <tr>
                
                    <td><?php echo @$send['ruc'] ?></td>
                    <td><?php echo @$send['nombreproveedor'] ?></td>
                    <td><?php echo @$send['fecha_cxp'] ?></td>
                    <td><?php echo number_format($send['total'], 2) ?></td>
                    <!--<td><?php //echo number_format($send['saldo'],2) ?></td>-->
                    <td><?php echo $send['meses'] ?></td>
                    <!--<td><?php //echo $send['cuotas_pagadas'] ?></td>
                    <td><?php //echo $send['cuotas_pendientes'] ?></td>-->
                    <td><?php echo number_format($send['diferido'],2) ?></td>
                    
                    <?php if ($send['estado'] == 'DEBE'){ ?>
                    <td><small class="label label-danger"><i class="fa fa-bell"></i> <?php echo @$send['estado'] ?></small></td>
                    <td><a href="accounts/cxp_form.php?cid=<?php echo $send['id_cxp'] ?>"><small class="label label-primary"><i class="fa fa-money"></i> PAGAR</small></a></td>
                    <?php }else if ($send['estado'] == 'CANCELADO'){ ?>
                    <td><small class="label label-success"><i class="fa fa-check"></i> <?php echo @$send['estado'] ?></small></td>
                    <td></td>
                    <?php } ?>
                    <td><a href="accounts/cxp_history.php?cid=<?php echo $send['id_cxp'] ?>"><small class="label label-warning"><i class="fa fa-book"> VER PAGOS</i></small></a></td>
                </tr>
            <?php } } ?>
            </tbody>
        </table>
          <!-- /.box -->