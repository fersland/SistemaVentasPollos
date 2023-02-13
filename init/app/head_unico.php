<?php
    @session_start();
    if(isset($_SESSION["acceso"]))  {
    }else{
        session_unset();
        session_destroy();
        header("../index.php");
    }

    require_once ("../../../controlador/conf.php");
    require_once ("../../../datos/db/connect.php");
    
    $cc = new DBSTART;
    $db = $cc->abrirDB();
    
    $session_acceso     = $_SESSION["acceso"];
    $session_token      = $_SESSION["token"];
    $session_usuario    = $_SESSION["usuario"];
    $session_empleado   = $_SESSION["empleado"];
    //$session_sucursal = $_SESSION["sucursal"];
    
    date_default_timezone_set('America/Guayaquil');
    $year_zone = date('Y');
    $month_zone = date('m');
    $day_zone = date('d');
    
    $sql = $db->prepare("SELECT * FROM c_empresa WHERE est_empresa='A'");
    $sql->execute();
    $name = $sql->fetchAll(PDO::FETCH_ASSOC);
    
    foreach($name as $data) {
        $elname = $data['nom_empresa'];
    }

    // Usuario
    $uss = $db->prepare("SELECT * FROM c_usuarios WHERE id_usuario = '$session_usuario'");
    $uss->execute();
    $img = $uss->fetchColumn(11);
    
    $names = $db->prepare("SELECT * FROM c_empresa");
    $names->execute();
    $nempresa = $names->fetchColumn(2); 
    
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
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> <?php echo COMPANY .' '. VERSION ?> </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../../../init/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../../init/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../../../init/bower_components/Ionicons/css/ionicons.min.css">
   <link rel="stylesheet" href="../../../init/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="../../../init/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../../init/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../../../init/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <script src="../../js/jquery-2.2.4.min.js"></script>
  <script src="../../js/barcode.js"></script>
  
  
  <!--<script language="JavaScript" src="../../../../init/jquery/jquery-1.5.1.min.js"></script>
    <script src="../../../../init/jquery/jquery-1.12.1.min.js"></script>
    <script src="../../../../init/jquery/jquery-ui.js"></script>-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">

    <!-- Logo -->
    <a href="../in.php?cid=dashboard/init" class="logo">
      <span class="logo-mini"><b><?php echo $nempresa ?></b></span>
      <span class="logo-lg"><b><?php echo $nempresa ?></b></span>
    </a>

    <nav class="navbar navbar-static-top">
<span style="line-height: 50px;font-size: 16px;color: turquoise;"><b><?php echo COMPANY. ' ' // VERSION?></b></span>
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      &nbsp;&nbsp;&nbsp;&nbsp;|
    <a href="../../../datos/clases/pdf/pdf_bajo.php" target="_blank">
        <span style="line-height: 50px;font-size: 16px;color: gold;"><b>&nbsp;&nbsp;&nbsp;Ver Productos con bajo stock (<?php echo $cant; ?>)</b></a>
      
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="../../../init/img/<?php echo $img ?>" class="img-circle" style="width: 20px; height: 20px">
             <span class="hidden-xs"><?php echo $_SESSION["rol"];  ?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <img src="../../../init/img/<?php echo $img ?>" class="img-circle" alt="User Image" style="width: 100px; height: 100px">

                <p>
                  <?php echo $_SESSION["persona"]; ?> - <b><?php echo $_SESSION["rol"];  ?> </b>
                  <!--<small>Desde 2019</small>-->
                </p>
              </li>
              <!-- Menu Body -->
              <!--<li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
              </li>-->
              <li class="user-footer">
                <div class="pull-left">
                  <!--<a href="#" class="btn btn-default btn-flat">Profile</a>-->
                </div>
                <div class="pull-right">
                  <a href="../../../datos/db/close.php" class="btn btn-default btn-flat">Cerrar Sesión</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>

    </nav>
  </header>
  <aside class="main-sidebar">
    <section class="sidebar">
      <div class="user-panel">
        <div class="pull-left image">
          <img src="../../../init/img/<?php echo $img ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p style="color: #333;"><?php echo $_SESSION["rol"];  ?></p>
          <a style="color: #333;" href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <ul class="sidebar-menu" data-widget="tree">
        <li><a href="../in.php?cid=dashboard/init">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">Inicio</small>
            </span></a></li>
        <?php require_once ("permisos/seguridad_u.php"); ?>
        <?php require_once ("permisos/config_u.php"); ?>
        <?php require_once ("permisos/compras_u.php"); ?>
        <?php require_once ("permisos/ventas_u.php"); ?>
        <?php require_once ("permisos/inventario_u.php"); ?>
        <?php require_once ("permisos/contabilidad_u.php"); ?>
        <?php require_once ("permisos/vehiculos_u.php"); ?>
        <?php require_once ("permisos/convenios_u.php"); ?>
      </ul>
    </section>
  </aside>