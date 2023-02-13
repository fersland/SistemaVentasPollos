<?php

    require_once ("../../datos/db/connect.php");



  	$registro = DBSTART::abrirDB()->prepare("select v.id, v.cedula, v.fecha_cxc, v.total,v.saldo, v.meses, v.cuotas_pagadas, v.cuotas_pendientes, v.diferido, v.estado, c.nombres from c_cxc v inner join c_clientes c on c.cedula = v.cedula ORDER BY v.id DESC");

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

                 <?php if (strlen($send['cedula'] >= 1 )){ ?>

                <tr>

                

                    <td><?php echo @$send['cedula'] ?></td>

                    <td><?php echo strtoupper(utf8_decode($send['nombres'])); ?></td>

                    <td><?php echo @$send['fecha_cxc'] ?></td>

                    <td><?php echo number_format($send['total'], 2) ?></td>

                    <!--<td><?php //echo number_format($send['saldo'],2) ?></td>-->

                    <td><?php echo $send['meses'] ?></td>

                    <!--<td><?php //echo $send['cuotas_pagadas'] ?></td>

                    <td><?php //echo $send['cuotas_pendientes'] ?></td>-->

                    <td><?php echo number_format($send['diferido'],2) ?></td>

                    

                    <?php if ($send['estado'] == 'DEBE'){ ?>

                    <td><small class="label label-danger"><i class="fa fa-bell"></i> <?php echo @$send['estado'] ?></small></td>

                    <td><a href="accounts/cxc_form.php?cid=<?php echo $send['id'] ?>">  <small class="label label-primary"> <i class="fa fa-money"></i>  PAGAR CUOTA</small></a></td>

                    <?php }else if ($send['estado'] == 'CANCELADO'){ ?>

                    <td><small class="label label-success"><i class="fa fa-check"></i> <?php echo @$send['estado'] ?></small></td>

                    <td></td>

                    <?php } ?>

                    <td><a href="accounts/cxc_history.php?cid=<?php echo $send['id'] ?>"><small class="label label-warning"><i class="fa fa-book"> VER HISTORIAL DE PAGOS</i></small></a></td>

                </tr>

            <?php } } ?>

            </tbody>

        </table>

          <!-- /.box -->