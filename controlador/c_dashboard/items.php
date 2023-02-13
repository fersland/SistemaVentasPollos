<?php
	require_once ("../../datos/db/connect.php");
	$db = new DBSTART();
	$cc = $db::abrirDB();
    
    // CONTADOR DE VENTAS
    $countv = $cc->prepare("SELECT * FROM c_venta WHERE estado = 'I'");
    $countv->execute();
    $cc1 = $countv->rowCount();
    
    // CONTADOR DE COMPRAS
    $countc = $cc->prepare("SELECT * FROM c_compra WHERE estado = 'A'");
    $countc->execute();
    $cc2 = $countc->rowCount();
    
    // CONTADOR DE CLIENTES
    $countcc = $cc->prepare("select * from c_clientes where length(cedula) > 7");
    $countcc->execute();
    $cc3 = $countcc->rowCount();
    
    // CONTADOR DE PRODUCTOS DEL INVENTARIO
    $countm = $cc->prepare("SELECT * FROM c_mercaderia WHERE estado = 'A'");
    $countm->execute();
    $cc4 = $countm->rowCount();
?>
<div class="row">
        <div class="col-lg-12 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>Ventas</h3>
            </div>
            <div class="icon">
              &nbsp;<?php echo $cc1 ?>&nbsp;<i class="ion ion-bag"></i>
            </div>
            <br />
            <a href="?cid=ventas/frm_ver_ventas" class="small-box-footer">M&aacute;s informaci&oacute;n <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-12 col-xs-6">
          <div class="small-box bg-green">
            <div class="inner">
              <h3>Compras</h3>
              <p></p>
            </div>
            <div class="icon">
              &nbsp;<?php echo $cc2 ?>&nbsp;<i class="ion ion-stats-bars"></i>
            </div>
            <br />
            <a href="?cid=compras/frm_ver_compras" class="small-box-footer">M&aacute;s informaci&oacute;n <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-12 col-xs-6">
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>Clientes</h3>
              <p></p>
            </div>
            <div class="icon">
              &nbsp;<?php echo $cc3 ?>&nbsp;<i class="ion ion-person-add"></i>
            </div>
            <br />
            <a href="?cid=clientes/frm_clientes" class="small-box-footer">M&aacute;s informaci&oacute;n <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-12 col-xs-6">
          <div class="small-box bg-red">
            <div class="inner">
              <h3>Productos</h3>
              <p></p>
            </div>
            <div class="icon">
              &nbsp;<?php echo $cc4 ?>&nbsp;<i class="ion ion-pie-graph"></i>
            </div>
            <br />
            <a href="?cid=mercaderia/mercaderia" class="small-box-footer">M&aacute;s informaci&oacute;n <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>