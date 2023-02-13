<?php
 session_start();
 if(isset($_SESSION["acceso"])) {
	require_once ('./'."../head_unico.php");
?>

<div class="content-wrapper">
  <section class="content-header">
    <h1>Contabilidad<small>Historial de pagos</small></h1>
      <ol class="breadcrumb">
        <li><a href="../in.php?cid=dashboard/init"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Contabilidad</a></li>
        <li class=""><a href="../in.php?cid=accounts/cxc">Cuentas por cobrar</a></li>
        <li class=""><a href="../in.php?cid=accounts/cxp">Cuentas por pagar</a></li>
        <li class="active">Cuentas por pagar historial</li>
      </ol>
    </section>
<section class="content">
<div class="row"><br />
  <div class="col-md-12">
<?php
    $laid = isset($_GET['cid']) ? $_GET['cid'] : 0;

    $sql = $db->prepare("SELECT c.ruc, c.nombreproveedor, cd.account,co.total, cd.num_cuotas, cd.valor_cuotas,cd.fecha_pago,cd.recibido, cd.cambio, cd.id  
                            FROM c_cxp_detalle cd
                                INNER JOIN c_cxp co ON co.id_cxp = cd.account
                                INNER JOIN c_proveedor c ON c.id_proveedor = co.id_proveedor WHERE cd.account = ?");
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
                        <th>Historial</th>
                    </tr>
                </thead>
            <tbody>
                 <?php foreach ($rows as $send) { ?>
                <tr>
                    <td><?php echo @$send['account'] ?></td>
                    <td><?php echo @$send['ruc'] ?></td>
                    <td><?php echo @$send['nombreproveedor'] ?></td>
                    <td><?php echo @$send['fecha_pago'] ?></td>
                    <td><?php echo number_format($send['total'], 2) ?></td>
                    <td><?php echo $send['num_cuotas'] ?></td>
                    <td><?php echo number_format($send['valor_cuotas'],2) ?></td>
                    <td><a target="_blank" href="../../../datos/clases/pdf/accounts_p.php?cid=<?php echo $send['id'] ?>"><small class="label label-primary"><i class="fa fa-book"> VER FACTURA</i></small></a></td>
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