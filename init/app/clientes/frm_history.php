<?php
 session_start();
 if(isset($_SESSION["acceso"])) {
	require_once ('./'."../head_unico.php");
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Clientes / <b>Historial de Compras</b>
    <a class="btn btn-warning" style="float: right;" href="../in.php?cid=clientes/frm_clientes"><i class="fa fa-reply"></i> Volver</a>
    </h1>

    
    </section>
<section class="content">
<div class="row"><br />
  <div class="col-md-12">
<?php
   $ci = isset($_GET['cid']) ? $_GET['cid'] : 0;

    

    $registro = $db->prepare("select * from c_venta v left join c_clientes c on c.cedula = v.cliente 
                                                where cliente='$ci'");
    $registro->execute();
    $all = $registro->fetchAll(PDO::FETCH_ASSOC);
    $veces = $registro->rowCount();
    
    $regi = $db->prepare("select sum(total) as totaly from c_venta v left join c_clientes c on c.cedula = v.cliente 
                                                where cliente='$ci'");
    $regi->execute();
    $alls = $regi->fetchAll(PDO::FETCH_ASSOC);
    
    foreach((array) $alls as $model) {
        $valorest = $model['totaly'];
    }
    
    // SUMATORIA DE TOTALES DE CLIENTE SPOR VENTAS 
?>
<div class="box">
    <div class="box-header">
        <h4>Este cliente compr&oacute; un total de (<?php echo $veces ?>) veces. | En dinero total: (<?php echo $valorest ?>)</h4>
       <h4>Para ver lo que compr&oacute; seleccione la factura en "Ver Factura"</h4> 
    </div>
    <div class="box-body">
        <table id="example1" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Factura</th>
                    <th>Cliente</th>
                    <th>Forma de Pago</th>
                    <th>Total</th>
                    <th>Fecha</th>
                    <th>Ver Factura</th>
                </tr>
            </thead>
            
            <tbody>
            <?php foreach($all as $registro2){ ?>
                <tr>
                    <td><?php echo $registro2['nventa'] ?></td>
                    <?php if ($registro2['cliente'] == 0){ ?>
                        <td>CONSUMIDOR FINAL</td>
                        <td><?php echo strtoupper($registro2['forma_pago']) ?></td>
                    <?php }else{ ?>
                        <td><span class="btn btn-primary"><?php echo strtoupper($registro2['nombres']) ?></span></td>
                        <td><?php echo strtoupper($registro2['forma_pago']) ?></td>
                    <?php } ?>
                    <td><?php echo $registro2['total'] ?></td>
                    <td><?php echo $registro2['fecharegistro'] ?></td>

                    
                    <!--<td><a href="../app/ventas/frm_ventas_facturadas_act.php?cid=<?php //echo $registro2['norden']?> ">
                      <span class="btn btn-info"><i class="glyphicon glyphicon-pencil"></i></span></a></td>-->
                      <td><a target="_blank" href="../../../datos/clases/pdf/informe_ventas/venta.php?factura=<?php echo $registro2['norden']?> " >
                            <span class="btn btn-success"><i class="glyphicon glyphicon-print"></i> Ver Factura</span></a></td> 
                </tr>
        <?php } ?>  
      </tbody>                      
    </table>
  </div><!-- /.box-body -->
</div><!-- /.box -->

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