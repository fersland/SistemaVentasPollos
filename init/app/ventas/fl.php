<?php
    /*************************************************/
    /* Ultima actualización: 18-Oct-2019*/
    /* Por: Fernando Reyes N */
    /*************************************************/
    
    session_start();
    if(isset($_SESSION["acceso"]))  {
    
    if (isset($_REQUEST['cid'])){
        $laid = $_REQUEST['cid'];

        require_once ("../head_unico.php");
        $sql = $db->prepare("SELECT * FROM c_venta vd LEFT JOIN c_clientes c ON c.cedula = vd.cliente 
                                WHERE vd.nventa = '$laid'");
        $sql->execute();
        $rows = $sql->fetchAll(PDO::FETCH_ASSOC);
        $cant_suprema = $sql->rowCount();

        foreach ($rows as $key => $value) {
            $cliente_id   = $value['id_cliente'];
            $c_cliente = $value['cedula'];
            $n_cliente = $value['nombres'];
            @$n_orden = $value['num_orden'];
            $n_correo = $value['correo'];
            $n_celular = $value['celular'];
        }
        
        // SI NO HAY CEDULA ENVIA VACIO
        
        if ($c_cliente == 0 || $c_cliente == '') {
            $c_cliente = '';
        }else{
            $c_cliente = $c_cliente;
        }

        if (@$cliente_id == 0) {
            $checked = 'checked';
        }else{
            $checked = 'unchecked';
        }

        if ($n_cliente == '') {
            $nncliente = 'CONSUMIDOR FINAL';
        }else{
            $nncliente = strtoupper($n_cliente);
        }

    $ventas = $db->prepare("SELECT * FROM c_venta WHERE nventa='$laid'");
    $ventas->execute();
    $fetch = $ventas->fetchAll(PDO::FETCH_ASSOC);

    foreach ($fetch as $key => $values) {
        $nfactura = $values['nventa'];
        $pago = $values['forma_pago'];
        $orden = $values['norden'];
        $total_pagar = $values['total'];
    }

    $empresa = $db->prepare("SELECT * FROM c_empresa");
    $empresa->execute();
    $fetchs = $empresa->fetchAll(PDO::FETCH_ASSOC);

    foreach ($fetchs as $key => $val) {
        $nombre_emp = $val['nom_empresa'];
        $dire = $val['direcc_empresa'];
        $telf= $val['telf_empresa'];
        $mail = $val['mail_empresa'];
        $ruc = $val['ruc_empresa'];
    }

    // Nueva Venta

    $s = $db->prepare("SELECT MAX(num_secuencial_orden) as dato FROM c_secuencial");
    $s->execute();
    $all = $s->fetchAll(PDO::FETCH_ASSOC);

    foreach ($all as $key => $v2) {
        $secuencial = $v2['dato'];

        if($secuencial == 0 || $secuencial == ''){
            $nn = 1;
        }else{
            $nn = $secuencial +1;
        }
    }
} ?>

<?php setlocale(LC_MONETARY, 'en_US');?>

<div class="content-wrapper">
    <section class="content-header">
      <h1>Facturación<small>Ventas</small></h1>
      <ol class="breadcrumb">
        <li><a href="?cid=dashboard/init"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="../in.php?cid=ventas/frm_ver_ventas">Historial Ventas</a></li>
        <li><a href="../in.php?cid=ventas/frm_ventas_anuladas">Historial Ventas Anuladas</a></li>
        <li class="active"><a href="#">Facturación</a></li>
      </ol>
    </section>
<!-- Main content -->
<!-- Content Wrapper. Contains page content -->

    <!--<div class="pad margin no-print">
      <div class="callout callout-info" style="margin-bottom: 0!important;">
        <h4><i class="fa fa-info"></i> Note:</h4>
        This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
      </div>
    </div>-->

    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> RESUMEN #<?php echo $nfactura ?>
            <small class="pull-right"><b>Fecha:</b> <?php echo date('Y-m-d') ?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          De
          <address>
            <strong><?php echo $nombre_emp ?>.</strong><br>
            <?php echo $ruc ?><br>
            Dirección: <?php echo $dire ?><br>
            
            Teléfono: <?php echo $telf ?><br>
            Email: <?php echo $mail ?>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          A
          <address>
            <strong>Cliente: </strong> <?php echo $nncliente ?><br />
            
            <?php echo $c_cliente ?><br>
            <?php echo $n_correo ?><br>
            <?php echo $n_celular ?><br>
            
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>Factura #<?php echo $nfactura ?></b><br>
          <br>
          <b>Orden:</b> <?php echo $orden ?><br>
          <b>Total: </b> <?php echo $total_pagar ?> <br />
          <b>Pago:</b> <?php echo $pago ?><br>
        </div>
      </div>
      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
        <!--  <p class="lead">Payment Methods:</p>
          <img src="../../dist/img/credit/visa.png" alt="Visa">
          <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
          <img src="../../dist/img/credit/american-express.png" alt="American Express">
          <img src="../../dist/img/credit/paypal2.png" alt="Paypal">

          <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg
            dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
          </p>-->
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
          
             <div class="row no-print">
        <div class="col-xs-12">
          <!--<a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>-->
          <a href="../../../init/app/ventas/ord.php?cid=<?php echo $nn ?>" class="btn btn-success pull-left"><i class="fa fa-credit-card"></i> Nueva Venta</a>
          
          <a target="_blank" href="../../../datos/clases/pdf/informe_ventas/infparcial.php?factura=<?php echo $orden ?>" class="btn btn-info pull-right" style="margin-right: 5px;">
            <i class="fa fa-download"></i> Imprimir Recibo
          </a>
          
          <a target="_blank" href="../../../datos/clases/pdf/informe_ventas/venta.php?factura=<?php echo $orden ?>" class="btn btn-primary pull-right" style="margin-right: 5px;">
            <i class="fa fa-download"></i> Imprimir Factura
          </a>
        </div>
      </div>
          
        </div>
      </div>
    </section>
    <div class="clearfix"></div>
  </div>

<?php 
require_once ("../foot_unico.php");
}else{
    session_unset();
    session_destroy();
    header('Location:  ../../../index.php');
}?>


<script type="text/javascript">
    $(document).ready(function() {
    $('#example').DataTable( {
        "scrollY":        "160px",
        "scrollCollapse": true,
        "paging":         false
    } );
} );
</script>