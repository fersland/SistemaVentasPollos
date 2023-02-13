<?php
 session_start();
 if(isset($_SESSION["acceso"])) {   
	require_once ("../head_unico.php");
?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>Compras / <b>Historial por Fechas</b></h1>
      <ol class="breadcrumb">
        <li><a href="../in.php?cid=dashboard/init"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Compras</a></li>
        <li class="active"><a href="../in.php?cid=devolucion/dev">Historial</a></li>
      </ol>
    </section>

<section class="content">
<div class="row"><br />
  <div class="col-md-12">
<?php
    $desde = isset($_GET['desde']) ? $_GET['desde'] : 0;
    $hasta = isset($_GET['hasta']) ? $_GET['hasta'] : 0;
    $prove = isset($_GET['proveedor']) ? $_GET['proveedor'] : 0;

    $registro = $db->prepare("select v.ncompra, v.fechacompra, c.nombreproveedor, v.total
                                from c_compra v left join c_proveedor c on c.id_proveedor = v.id_proveedor 
                                                where v.fechacompra between '$desde' AND '$hasta' AND v.estado = 'A' AND v.id_proveedor='$prove'");
    $registro->execute();
    $contador = $registro->rowCount();
    $all = $registro->fetchAll(PDO::FETCH_ASSOC);
    
    $registro2 = $db->prepare("select v.ncompra, v.fechacompra, c.nombreproveedor, v.total, sum(v.total) as totaly
                                from c_compra v left join c_proveedor c on c.id_proveedor = v.id_proveedor 
                                                where v.fechacompra between '$desde' AND '$hasta' AND v.estado = 'A' AND v.id_proveedor='$prove'");
    $registro2->execute();
    $all2 = $registro2->fetchAll(PDO::FETCH_ASSOC);
    
    
    foreach((array) $all2 as $model) {
        $totally = $model['totaly'];
    }
?>
  </div>
    <div class="col-md-12">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Veces comprado a este proveedor (<?php echo $contador ?>) | El total es : (<?php echo number_format($totally, 2) ?>) </h3>
            </div>
<div class="box">
    <div class="box-body">
        <table id="example1" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Factura</th>
                    <th>Proveedor</th>
                    <th>Total</th>
                    <th>Fecha</th>
                    <th>Ver Factura</th>
                </tr>
            </thead>
            
            <tbody>
            <?php foreach($all as $registro2){ ?>
                <tr>
                    <td><?php echo $registro2['ncompra'] ?></td>
                        <td><?php echo strtoupper($registro2['nombreproveedor']) ?></td>
                        <td><?php echo strtoupper($registro2['total']) ?></td>
                        <td><?php echo $registro2['fechacompra'] ?></td>
                        <td><a target="_blank" href="../../../datos/clases/pdf/informe_compras/compra.php?factura=<?php echo $registro2['ncompra']?> " >
                        <span class="btn btn-success"><i class="glyphicon glyphicon-print"></i></span></a></td>
 
                </tr>
        <?php } ?>  
      </tbody>                      
    </table>
  </div><!-- /.box-body -->
</div><!-- /.box -->
    </div>
</div>
</div>
</section>
</div>

<?php 
require_once ("../foot_unico.php");

}else{
    session_unset();
    session_destroy();
    header('Location:  ../../../index.php');
} 
?>