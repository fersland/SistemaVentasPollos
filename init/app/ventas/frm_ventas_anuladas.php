<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Historial Ventas Anuladas
        <small>Lista de ventas anuladas</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?cid=dashboard/init"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Ventas</a></li>
        <li class="active"><a href="#">Historial de ventas</a></li>
        <li class="active"><a href="#">Historial de ventas anuladas</a></li>
        
      </ol>
    </section>

<!-- Main content -->
<section class="content">
    <div class="row"><br />
        <div class="col-md-12">
          <?php require_once ("../../controlador/c_ventas/paginarVentasAnuladas.php"); ?>
        </div><!-- nav-tabs-custom -->
    </div><!-- /.col -->
  </section>
</div>