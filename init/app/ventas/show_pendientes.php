<?php

  $ver = $db->prepare("SELECT * FROM c_modul WHERE a_perfil='$session_acceso' AND a_modulo=4 AND a_item=21");
  $ver->execute();
  $fetch = $ver->fetchAll(PDO::FETCH_ASSOC);

  foreach ($fetch as $key => $value) {
    $save = $value['sav'];
    $edit = $value['edi'];
    $dele = $value['del'];
    $prin = $value['pri'];
  }
  if ($save == 'A') {
    $ss = '';
  }elseif ($save == 'I'){
    $ss = "disabled";
  }

  if ($prin == 'A'){
    $pp = '';
  }elseif ($prin == 'I'){
    $pp = 'disabled';
  }

  if ($edit == 'A'){
    $ee = '';
  }elseif ($edit == 'I'){
    $ee = 'disabled';
  }

  if ($dele == 'A'){
    $dd = '';
  }elseif ($dele == 'I'){
    $dd = 'disabled';
  }

    $s = $db->prepare("SELECT MAX(num_secuencial_orden) as dato FROM c_secuencial");
    $s->execute();
    $all = $s->fetchAll(PDO::FETCH_ASSOC);

    foreach ($all as $key => $value) {
        $secuencial = $value['dato'];

        if($secuencial == 0 || $secuencial == ''){
            $nn = 1;
        }else{
            $nn = $secuencial + 1;
        }
    }
?>
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Ventas y Facturación
        <small>Elija una opción</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?cid=dashboard/init"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Ventas</a></li>
        <li class="active"><a href="#">Seleccionar</a></li>
        
      </ol>
    </section>

<!-- Main content -->
<section class="content">
    <div class="row"><br>
        <div class="col-md-12">
            <div class="callout callout-success">
                <h4><b>* Importante: </b></h4>

                <p>1. <b>Ventas sin finalizar: </b>Se visualizan las ventas sin finalizar unicamente de esta caja.</p>
                <p>2. <b>Nueva Venta: </b> Realiza una nueva factura con datos nuevos.</p>
        </div>
        </div>
        <div class="col-md-8">
              <!-- Horizontal Form -->
            <div class="box box-danger">
                <h3 class="box-title">&nbsp;Lista de ventas no finalizadas.</h3>
                <?php
        // Mostrar el listado de ultimas facturas
        $cs = $db->prepare("SELECT * FROM c_venta_detalle WHERE estado = 'A' AND empleado='$session_usuario'");
        $cs->execute();
        $cant_fetch = $cs->rowCount();

        if ($cant_fetch == 0) {
            echo '<div class="btn bg-maroon btn-block">No hay Facturas pendientes.</div>';
        }else{

        $cs = $db->prepare("SELECT distinct(vd.num_orden), vd.fecharegistro, vd.num_orden, vd.cliente, c.nombres
                                FROM c_venta_detalle vd LEFT JOIN c_clientes c ON c.id_cliente = vd.cliente 
                                WHERE vd.estado = 'A' AND vd.empleado ='$session_usuario' GROUP BY vd.num_orden ORDER BY vd.idventa DESC");
        $cs->execute();
        $fetch = $cs->fetchAll(PDO::FETCH_ASSOC); ?>    
        
        <table class="table table-hover" style="background: none;">
          <thead>
              <th>N°</th>
              <th>Cliente</th>
              <th>Fecha</th>
              <th colspan="2"></th>
          </thead>
          <?php            
          foreach ( (array) $fetch as $del ){ ?>
          <tbody>
              <td><li style="list-style:none"><?php echo $thenum = $del['num_orden']; ?></li></td>
              <?php if ($del['cliente'] == 0) { ?>
                  <td><li style="list-style:none">CONSUMIDOR FINAL</li></td>
              <?php }else{ ?>
                  <td><li style="list-style:none"><?php echo $del['nombres'] ?></li></td>
                    <?php } ?>
                    <td><li style="list-style:none"><?php echo $thenum = $del['fecharegistro']; ?></li></td>
                    <td><li style="list-style:none"><a class="<?php echo $ee ?>" href="ventas/ord.php?cid=<?php  echo $del['num_orden'] ?>"> 
                        <i class="fa fa-check"></i></a></li></td>
                    <td><li style="list-style:none"><a class="<?php echo $dd ?>" href="ventas/del_orden.php?cid=<?php  echo $del['num_orden'] ?>"> <i class="fa fa-trash"></i></a></li></td>
                </tbody>
        <?php } ?> 
            </table>
        <?php } ?>
            </div><!-- /.tab-pane -->
        </div>

        <div class="col-md-4">
              <!-- Horizontal Form -->
            <div class="box box-success">
                <h3 class="box-title">&nbsp;Realizar una nueva venta</h3>
              <br /><center><a class="btn bg-olive <?php echo $ss ?>" href="ventas/ord.php?cid=<?php echo $nn ?>"><h4><i class="fa fa-cart-plus"></i> Ir a Facturaci&oacute;n</h4></a></center><br /><br />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h3>Historial General de Ventas Facturadas</h3>
            <?php require_once ("../../../controlador/c_ventas/paginarVentas.php"); ?>
        </div>
    </div>
  </section>
</div>