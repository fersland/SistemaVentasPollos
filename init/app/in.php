<?php
    session_start();
    require_once ('./'."../../controlador/conf.php");
    require_once ('./'."../../controlador/func.php");
    require_once ('./'."../../datos/db/connect.php");
    $cc = new DBSTART;
    $db = $cc->abrirDB();
    
    $session_acceso     = $_SESSION["acceso"];
    $session_token      = $_SESSION["token"];
    $session_usuario    = $_SESSION["usuario"];
    $session_eply       = $_SESSION["empleado"];
    $session_sucursal   = $_SESSION["idsucursal"];

    date_default_timezone_set('America/La_Paz');
    $year_zone = date('Y');
    $month_zone = date('m');
    $day_zone = date('d');
    
    if(isset($_SESSION["acceso"])) {
        require_once ("head.php");
    
        if( isset($_GET['cid']) ) {
            $fflush = $_GET['cid'];
        }else{
            $fflush = "dashboard/init";
        }
            require_once $fflush .".php";
            require_once ("foot.php");
     }else{
        session_unset();
        session_destroy();
        header('Location:  ../../index.php');
    }
?>
    
<script>
	var url = window.location;
	var children = $('ul.sidebar-menu a').filter(function(){ return this.href == url; });
	children.parent().addClass('active');
	children.parent().parent().parent().addClass('active menu-open');
	children.parent().parent().parent().parent().parent().addClass('active menu-open');
</script>