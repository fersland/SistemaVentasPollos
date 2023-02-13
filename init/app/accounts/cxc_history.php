<?php

 session_start();

 if(isset($_SESSION["acceso"])) {

	require_once ('./'."../head_unico.php");

?>



<div class="content-wrapper">

  <section class="content-header">

    <h1>Contabilidad / <b>Historial de pagos</b></h1>

      <ol class="breadcrumb">

        <li><a href="../in.php?cid=dashboard/init"><i class="fa fa-dashboard"></i> Inicio</a></li>

        <li><a href="#">Contabilidad</a></li>

        <li class=""><a href="../in.php?cid=accounts/cxp">Cuentas por pagar</a></li>

        <li class=""><a href="../in.php?cid=accounts/cxc">Cuentas por cobrar</a></li>

        <li class="active">Cuentas por cobrar</li>

      </ol>

    </section>

<section class="content">

<div class="row"><br />



  <div class="col-md-12">
    <a class="btn btn-warning" href="../in.php?cid=accounts/cxc" style="float: right;">Volver</a>

<?php

    $laid = isset($_GET['cid']) ? $_GET['cid'] : 0;



    $sql = $db->prepare("SELECT co.cedula, c.nombres, cd.account,co.total, cd.num_cuotas, cd.valor_cuotas,

                            cd.fecha_pago,cd.recibido, cd.cambio, cd.id, concat(eply.nombres,  ' ', eply.apellidos) eleply  

                            FROM c_cxc_detalle cd

                                INNER JOIN c_cxc co ON co.id = cd.account

                                INNER JOIN c_empleados eply ON cd.empleado = eply.id_empleado

                                INNER JOIN c_clientes c ON c.cedula = co.cedula WHERE cd.account = ?");

    $sql->execute(array($laid));

    $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

?>

  </div>

    <div class="col-md-12">

          <div class="box box-warning">

            <div class="box-header with-border">

              <h3 class="box-title">Historial de pagos de esta cuenta</h3>

            </div>

            <table id="example" class="table table-bordered table-striped table-hover">

                <thead>

                    <tr>

                        <th>Cuenta</th>

                        <th>CI/NIT</th>

                        <th>Nombres</th>

                        <th>Fecha Pago</th>

                        <th>Total</th>

                        <th>Cuotas Pagadas</th>

                        <th>Valor Pagado</th>

                        <th>Cobrado_Por</th>

                        <th>Historial</th>

                    </tr>

                </thead>

            <tbody>

                 <?php foreach ($rows as $send) { ?>

                <tr>

                    <td><?php echo @$send['account'] ?></td>

                    <td><?php echo @$send['cedula'] ?></td>

                    <td><?php echo @$send['nombres'] ?></td>

                    <td><?php echo @$send['fecha_pago'] ?></td>

                    <td><?php echo number_format($send['total'], 2) ?></td>

                    <td><?php echo $send['num_cuotas'] ?></td>

                    <td><?php echo number_format($send['valor_cuotas'],2) ?></td>

                    

                    <td><?php echo @$send['eleply'] ?></td>

                    

                    <td><a target="_blank" href="../../../datos/clases/pdf/accounts.php?cid=<?php echo $send['id'] ?>"><small class="label label-primary"><i class="fa fa-book"> VER FACTURA</i></small></a></td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

          </div>

    </div>

</div>

</section>

</div>

<?php

require_once ('./'."../foot_unico.php");

}else{

    session_unset();

    session_destroy();

    header('Location:  ../../../index.php');

}?>



<script type="text/javascript">

    $(document).ready(function() {

    $('#example').DataTable( {

        "scrollY":        "250px",

        "scrollCollapse": true,

        "paging":         false

    } );

} );

</script>