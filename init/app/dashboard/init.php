<?php
    require_once ('./'."../../datos/db/connect.php");
    
    $emp = DBSTART::abrirDB()->prepare("SELECT * FROM c_empresa");
    $emp->execute();
    $fetch = $emp->fetchAll(PDO::FETCH_ASSOC);

    foreach ((array) $fetch as $key => $value) {
      $wall = $value['img_wall'];
      $pdf = $value['img_pdf'];
    }
    
    /* RESUMEN DE VENTAS*/
    
    $ventas = DBSTART::abrirDB()->prepare("SELECT SUM(total) AS resumen_ventas FROM c_venta WHERE estado='I'");
    $ventas->execute();
    $row_ventas = $ventas->fetchAll();
    
    foreach((array) $row_ventas as $res1) {
        $resumen_ventas = $res1["resumen_ventas"];
    }
    
    
    /****  RESUMEN DE INVENTARIO DISPONIBLE EN DOLARES ****/
    $inv = DBSTART::abrirDB()->prepare("SELECT SUM(precio_venta * existencia) AS resumen_inve FROM c_mercaderia WHERE estado='A'");
    $inv->execute();
    $row_inv = $inv->fetchAll();
    
    foreach((array) $row_inv as $res2) {
        $resumen_inv = $res2["resumen_inve"];
    }
    
    /****  RESUMEN DE COMPRAS EFECTUADAS ****/
    $com = DBSTART::abrirDB()->prepare("SELECT SUM(total) AS resumen_compras FROM c_compra WHERE estado='A'");
    $com->execute();
    $row_com = $com->fetchAll();
    
    foreach((array) $row_com as $res3) {
        $resumen_com = $res3["resumen_compras"];
    }
    
    // RECIENTES PRODUCTOS VENDIDOS: TOP 5
    
    $args = DBSTART::abrirDB()->prepare("SELECT m.codproducto, m.nombreproducto, sum(vd.cantidad) as totales, m.ruta
                                            FROM c_venta_detalle vd 
                                                INNER JOIN c_mercaderia m ON m.codproducto = vd.codigo
                                            WHERE vd.estado = 'F'
                                                GROUP BY m.nombreproducto
                                                ORDER BY totales DESC");
    $args->execute();
    $all_args = $args->fetchAll(PDO::FETCH_ASSOC);
    
?>

 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small><?php echo VERSION ?></small>  <?php // echo $session_sucursal; PARA PRUEBAS ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    
    <!-- Main content -->
    <section class="content">
      
        

      <!--<div class="row">
        <div class="col-md-12">
        <div class="alert mt-3" style="background: #71366dd4; color:#ffffff">
           <h4><i class="fa fa-info"></i> Si desea adquirir el sistema o necesita m&aacute;s informaci&oacute;n, envie mensaje al desarrollador 
                    <a target="_blank" href="https://api.whatsapp.com/send?phone=[593][967956736]&text=Hola"> 
                    <span class="btn btn-warning">Aqu&iacute;</span></a></h4>
            <p>Algunas funciones no est&aacute;n disponibles en el modo prueba.</p>
        </div>
        </div>
      </div>-->
        
        
        <div class="row">
            <div class="col-md-7">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <center><img src="../../init/img/presentacion/<?php echo $wall ?>" class="img" style="width: 70%"></center>
                    </div>    
                </div>
                
                <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Recientes Productos Vendidos</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <ul class="products-list product-list-in-box">
                <?php foreach((array) $all_args as $values_args) { ?>
                <li class="item">
                  <div class="product-img">
                    <img src="../../../init/img/<?php echo $values_args['ruta'] ?>" alt="Product Image" />
                  </div>
                  <div class="product-info">
                    <a href="javascript:void(0)" class="product-title"><?php echo $values_args['nombreproducto']; ?>
                      <span class="label label-warning pull-right"><?php echo $values_args['totales']; ?></span></a>
                    <span class="product-description">
                          C&oacute;digo: <?php echo $values_args['codproducto'] ?>
                        </span>
                  </div>
                </li>
                <?php } ?>
              </ul>
            </div>
          </div>
                
            </div>
            
            <div class="col-md-5">

                <?php if (isset($_SESSION["rol"]) == 'Administrador') { require_once ("../../controlador/c_dashboard/items.php"); } ?>        
            </div>
        </div>
        
        
        
      <div class="row">
        <div class="col-md-6">
          
        </div>
        
        <?php //if (isset($_SESSION["rol"]) == 'Administrador') { ?>
        <!--<div class="col-md-4">
          <div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Inventario</span>
              <span class="info-box-number">$ <?php //echo number_format($resumen_inv, 2) ?></span>

              <div class="progress">
                <div class="progress-bar" style="width: 50%"></div>
              </div>
              <span class="progress-description">
                    100% Registrado hasta hoy
                  </span>
            </div>
          </div>
          <div class="info-box bg-green">
            <span class="info-box-icon"><i class="fa fa-cart-plus"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Ventas</span>
              <span class="info-box-number">$ <?php //echo number_format($resumen_ventas,2) ?></span>

              <div class="progress">
                <div class="progress-bar" style="width: 20%"></div>
              </div>
              <span class="progress-description">
                    Procesado a fecha de hoy
                  </span>
            </div>
          </div>
          <div class="info-box bg-red">
            <span class="info-box-icon"><i class="ion ion-ios-cloud-download-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Compras</span>
              <span class="info-box-number">$ <?php //echo number_format($resumen_com, 2) ?></span>

              <div class="progress">
                <div class="progress-bar" style="width: 70%"></div>
              </div>
              <span class="progress-description">
                    Compras este mes
                  </span>
            </div>
          </div>
        </div>-->
        <?php // } ?>
        
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->