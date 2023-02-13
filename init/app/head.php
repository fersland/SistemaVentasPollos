<?php

    $times = date_default_timezone_set('America/Guayaquil');
    $uss = $db->prepare("SELECT * FROM c_usuarios WHERE id_usuario = '$session_usuario'");
    $uss->execute();
    $img = $uss->fetchColumn(11);
    
    $names = $db->prepare("SELECT * FROM c_empresa");
    $names->execute();
    $nempresa = $names->fetchColumn(2); 

    $hoy = date('Y-m-d');
    
    // VERIFICAR QUE LOS PRODUCTOS NO ESTEN EN ALERTA DE POCO STOCK
    $verificar = $db->prepare("SELECT * FROM c_mercaderia WHERE 
                                                                existencia <= 5 AND estado = 'A'
                                                            OR
                                                                kilo < 31 AND estado = 'A'");
    $verificar->execute();
    $cant = $verificar->rowCount();
?>

<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title><?php echo COMPANY .' '. VERSION ?></title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo CSS_BOWS ?>bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo CSS_BOWS ?>font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo CSS_BOWS ?>Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo CSS_BOWS ?>datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo CSS_BOWS ?>jvectormap/jquery-jvectormap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo CSS_NAT ?>AdminLTE.min.css">
  <link rel="stylesheet" href="<?php echo CSS_NAT ?>skins/_all-skins.min.css">
   <link rel="stylesheet" href="<?php echo CSS_NAT ?>nativo.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <script src="../js/jquery-2.2.4.min.js"></script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <header class="main-header">
    <a href="?cid=dashboard/init" class="logo">
      <span class="logo-mini"><b><?php echo $nempresa ?></b></span>
      <span class="logo-lg"><b><?php echo $nempresa ?></b></span>
    </a>
    <nav class="navbar navbar-static-top">
    <a href="?cid=dashboard/init" >
      <span style="line-height: 50px;font-size: 16px;color: turquoise;"> <b><?php echo $_SESSION["sucursal"]; ?></b></span>
    </a>
    &nbsp;&nbsp;&nbsp;&nbsp;|
    <a href="../../datos/clases/pdf/pdf_bajo.php" target="_blank">
        <span style="line-height: 50px;font-size: 16px;color: gold;"><b>&nbsp;&nbsp;&nbsp;Ver Productos con bajo stock (<?php echo $cant; ?>)</b></a>
    
      <a class="sidebar-toggle" data-toggle="push-menu" role="button"><span class="sr-only">Toggle navigation</span></a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
          <li class="dropdown user user-menu"><a class="dropdown-toggle" data-toggle="dropdown">
          <?php if (isset($_SESSION["rol"]) == 'ADMINSTRADOR') { ?>
              <img src="../../init/img/<?php echo $img ?>" class="img-circle" style="width: 20px; height: 20px">
          <?php } ?>
              <span class="hidden-xs"><b><?php echo $_SESSION["rol"]; ?> - </b><?php echo $_SESSION["persona"]; ?></span></a>            
            
            <ul class="dropdown-menu"><!-- User image -->
              <li class="user-header">
              <?php if (isset($_SESSION["rol"]) == 'Administrador') { ?>
                <img src="../../init/img/<?php echo $img ?>" class="img-circle" alt="User Image" style="width: 100px; height: 100px">
              <?php } ?>
                <p><?php echo $_SESSION["rol"]; ?> - <b><?php echo $_SESSION["persona"];  ?></b></p>
              </li>
              <li class="user-footer">
                <div class="pull-left">
                </div>
                <div class="pull-right">
                  <a href="../../datos/db/close.php" class="btn btn-default btn-flat">Cerrar Sesión</a>
                </div>
              </li>
            </ul>
          </li>
          <li><a data-toggle="control-sidebar"><i class="fa fa-gears"></i></a></li>
        </ul>
      </div>
    </nav>
  </header>
  <aside class="main-sidebar"> <!-- Left side column. contains the logo and sidebar -->
    <section class="sidebar">
      <div class="user-panel">
        <div class="pull-left image">
        <?php if (isset($_SESSION["rol"]) == 'Administrador') { ?>
          <img src="../../init/img/<?php echo $img ?>" class="img-circle" alt="User Image" />
          <?php } ?>
          <br />
        </div>
        <div class="pull-left info">
          <p style="color: #333;"><?php echo $_SESSION["rol"];  ?></p>
          <a style="color: #333;"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <ul class="sidebar-menu" data-widget="tree">        
        <li><a href="?cid=dashboard/init">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">Inicio</small>
            </span></a></li>
            <?php require_once ('./'."permisos/seguridad.php"); ?>
            <?php require_once ('./'."permisos/config.php"); ?>
            <?php require_once ('./'."permisos/compras.php"); ?>
            <?php require_once ('./'."permisos/ventas.php"); ?>
            <?php require_once ('./'."permisos/inventario.php"); ?>
            <?php require_once ('./'."permisos/contabilidad.php"); ?>
            <?php require_once ('./'."permisos/vehiculos.php"); ?>
            <?php require_once ('./'."permisos/convenios.php"); ?>

      </ul>
    </section>
  </aside>