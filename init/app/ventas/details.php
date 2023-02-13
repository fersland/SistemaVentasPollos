<?php
 session_start();
 if(isset($_SESSION["acceso"])) {
	require_once ("../head_unico.php");
?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Ventas /
        <b>Detalle de Merma</b>
      </h1>
      <ol class="breadcrumb">
        <li><a href="../in.php?cid=dashboard/init"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Ventas</a></li>
        <li class="active"><a href="../in.php?cid=clientes/frm_clientes">Facturación</a></li>
      </ol>
    </section>

<!-- Main content -->
<section class="content">
<div class="row"><br />
  <div class="col-md-12">
<?php


    $laid = isset($_GET['codigo']) ? $_GET['codigo'] : 0;
    $compra = isset($_GET['factura']) ? $_GET['factura'] : 0;

    $sql = $db->prepare("SELECT sum(vd.lamerma) as sum, vd.cantidad, vd.codigo, m.nombreproducto, vd.lamerma, c.nombres
                                            FROM c_venta_detalle vd
                                              INNER JOIN c_venta v ON v.nventa = vd.nventa
                                              INNER JOIN c_mercaderia m ON m.codproducto = vd.codigo
                                              INNER JOIN c_clientes c ON c.cedula =  v.cliente
                                            WHERE vd.codigo = '$laid' AND vd.lacompra = '$compra'

                                            GROUP BY vd.cantidad, vd.codigo, m.nombreproducto, c.nombres, vd.lamerma");
    $sql->execute();
    $rows = $sql->fetchAll(PDO::FETCH_ASSOC);



    $sqls = $db->prepare("SELECT sum(vd.lamerma) as sum
                                            FROM c_venta_detalle vd
                                            WHERE vd.codigo = '$laid'");
    $sqls->execute();
    $rowss = $sqls->fetch();

    $sqlc = $db->prepare("SELECT *
                                            FROM c_compra_detalle vd
                                            WHERE vd.codigo = '$laid' AND vd.ncompra ='$compra'");
    $sqlc->execute();
    $rowsc = $sqlc->fetch();




    
?>
  </div>
    <div class="col-md-6">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">RESUMEN DEL PRODUCTO</h3>
            </div>

            <table class="table table-striped">
              <thead>
                <tr>
                  <th>CODIGO</th>
                  <th>DESCRIPCION</th>
                  <th>CLIENTE</th>
                  <th>MERMA</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($rows as $key => $value) {

                $inv = $value['sum']; ?>
                  <tr>
                    <td><?php echo $value['codigo'] ?></td>
                    <td><?php echo $value['nombreproducto'] ?></td>
                    <td><?php echo $value['nombres'] ?></td>
                    <td><?php echo $value['lamerma'] ?></td>
                  </tr>
                <?php } ?>
              </tbody>

              <tfoot>
                <tr>
                  <td>
                      Total Merma Compra <strong><?php echo $rowsc['pmerma'] ?></strong>
                      <br>
                      Total Merma Vendido: <strong><?php echo $rowss['sum']; ?></strong>
                      <br>

                      Total Merma Restante: <strong><?php echo $rowsc['pmerma'] - $rowss['sum'];?></strong>
                  </td>
                </tr>
              </tfoot>

              
            </table>
            
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