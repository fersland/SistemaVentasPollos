<?php



    session_start();

    date_default_timezone_set('America/La_Paz');

 require_once ('./'."datos/db/connect.php");

 $message = "";

try {

      if(isset($_POST["login"])){

           if(empty($_POST["username"]) || empty($_POST["password"])){

                $message = '<label>Los datos son requeridos</label>';  

           }else{

                $query = DBSTART::abrirDB()->prepare(

                        "SELECT

                                u.id_usuario,

                                u.correo,

                                u.passw,

                                u.estado,

                                u.nivelacceso,

                                r.nombrerol,

                                e.id_empleado,

                                concat(e.nombres, ' ', e.apellidos) as pp,

                                s.nombre as susus,

                                s.id_sucursal

                            FROM c_usuarios u

                                INNER JOIN c_roles r ON r.idrol = u.nivelacceso

                                INNER JOIN c_empleados e ON e.cedula = u.cedula_user

                                INNER JOIN c_sucursal s ON u.sucursal = s.id_sucursal

                                    WHERE u.usuario=:correo AND u.passw=:passw AND u.estado = 'A'");



                $query->execute(

                     array(



                          'correo'     =>     htmlspecialchars($_POST["username"]),

                          'passw'      =>     sha1(htmlspecialchars($_POST["password"]))

                     )

                );



                $count = $query->rowCount();

                $empresa = $query->fetch();



                if($count > 0){

                    $us = $empresa["id_usuario"];

                    // Generar token de sesi�n



                    $select = DBSTART::abrirDB()->prepare("SELECT * FROM c_tokens WHERE id_usuario = '$us'");

                    $select->execute();

                    $rowstokens = $select->fetchAll();

                    

                    foreach((array) $rowstokens as $alls) {

                        $n_tokens = $alls['ntoken'];

                        

                    }

                    

                    $ip = $_SERVER['SERVER_ADDR']; // IP Direcci�n

                    $ip_rem = $_SERVER['REMOTE_ADDR']; // Esto contendr� la ip de la solicitud.

                    if ($_SERVER['REMOTE_ADDR']=='::1') $ipuser= ''; else $ipuser= $_SERVER['REMOTE_ADDR'];



                    $geoPlugin_array = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ipuser));

                    

                    //Obtener el continente

                    //echo 'Continente: '.$geoPlugin_array['geoplugin_continentCode'];

                    

                    $conti = $geoPlugin_array['geoplugin_continentCode'];

                    $pais = $geoPlugin_array['geoplugin_countryName'];

                    $divisa = $geoPlugin_array['geoplugin_currencyCode'];

                    $plus_tokens = $n_tokens + 1;

                    

                    $token = DBSTART::abrirDB()->prepare("INSERT INTO c_tokens (id_usuario, ntoken, dir_ip, rem_ip, pais, divisa) 

                                                        VALUES ('$us', '$plus_tokens', '$ip', '$ip_rem', '$pais', '$divisa')");

                    $token->execute();

                    

                    $sumatoken = 0;

                    $sumatoken = $empresa["ntoken"] + 1;

                    

                    // SECUENCIA DE HORARIOS

                    $hora_actual = date('H:i:s', time()); // HORA ACTUAL

                    $dia = date('l'); // DIA EN INGLES

                    

                    

                    if ($dia == 'Saturday') {

                        $horarios = DBSTART::abrirDB()->prepare("SELECT * FROM c_horarios WHERE '$hora_actual' BETWEEN sabado_desde AND sabado_hasta AND id_usuario='$us'");

                        $horarios->execute();

                        $cant_horarios = $horarios->rowCount();

                        

                        if ($cant_horarios > 0) {

                            $exito = 1;        

                        }else{

                            $exito = 0;

                        }

                    }elseif($dia == 'Monday') {

                        $horarios = DBSTART::abrirDB()->prepare("SELECT * FROM c_horarios WHERE '$hora_actual' BETWEEN lunes_desde AND lunes_hasta AND id_usuario='$us'");

                        $horarios->execute();

                        $cant_horarios = $horarios->rowCount();

                        

                        if ($cant_horarios > 0) {

                            $exito = 1;        

                        }else{

                            $exito = 0;

                        }

                    }elseif($dia == 'Tuesday') {

                        $horarios = DBSTART::abrirDB()->prepare("SELECT * FROM c_horarios WHERE '$hora_actual' BETWEEN martes_desde AND martes_hasta AND id_usuario='$us'");

                        $horarios->execute();

                        $cant_horarios = $horarios->rowCount();

                        

                        if ($cant_horarios > 0) {

                            $exito = 1;        

                        }else{

                            $exito = 0;

                        }

                    }elseif($dia == 'Wednesday') {

                        $horarios = DBSTART::abrirDB()->prepare("SELECT * FROM c_horarios WHERE '$hora_actual' BETWEEN miercoles_desde AND miercoles_hasta AND id_usuario='$us'");

                        $horarios->execute();

                        $cant_horarios = $horarios->rowCount();

                        

                        if ($cant_horarios > 0) {

                            $exito = 1;        

                        }else{

                            $exito = 0;

                        }

                    }elseif($dia == 'Thursday') {

                        $horarios = DBSTART::abrirDB()->prepare("SELECT * FROM c_horarios WHERE '$hora_actual' BETWEEN jueves_desde AND jueves_hasta AND id_usuario='$us'");

                        $horarios->execute();

                        $cant_horarios = $horarios->rowCount();

                        

                        if ($cant_horarios > 0) {

                            $exito = 1;        

                        }else{

                            $exito = 0;

                        }

                    }elseif($dia == 'Friday') {

                        $horarios = DBSTART::abrirDB()->prepare("SELECT * FROM c_horarios WHERE '$hora_actual' BETWEEN viernes_desde AND viernes_hasta AND id_usuario='$us'");

                        $horarios->execute();

                        $cant_horarios = $horarios->rowCount();

                        

                        if ($cant_horarios > 0) {

                            $exito = 1;

                                    

                        }else{

                            $exito = 0;

                        }

                    }elseif($dia == 'Sunday') {

                        $horarios = DBSTART::abrirDB()->prepare("SELECT * FROM c_horarios WHERE '$hora_actual' BETWEEN domingo_desde AND domingo_hasta AND id_usuario='$us'");

                        $horarios->execute();

                        $cant_horarios = $horarios->rowCount();

                        

                        if ($cant_horarios > 0) {

                            $exito = 1;

                                    

                        }else{

                            $exito = 0;

                        }

                    }

                    

                    

                    if ($exito == 1) {

                        $_SESSION["acceso"]      = $empresa["nivelacceso"];

                        $_SESSION["usuario"]     = $empresa["id_usuario"];

                        $_SESSION["rol"]         = $empresa["nombrerol"];

                        $_SESSION["persona"]     = $empresa["pp"];

                        $_SESSION["empleado"]    = $empresa["id_empleado"];

                        $_SESSION["sucursal"]    = $empresa["susus"];

                        $_SESSION["idsucursal"]  = $empresa["id_sucursal"];

                        $_SESSION["token"]       = $sumatoken;

                        header("location:init/app/in.php");

                    }elseif($exito == 0) {

                        $message = '<div class="alert alert-danger">Error, esta fuera de horario.</div>';

                    }

                    

                    //header("location:init/app/in.php"); PARA PRUEBAS

                     

                }else {

                     $message = '<div class="alert alert-danger">Error, revise los datos ingresados.</div>';

                }

           }

      }

 }

 catch(PDOException $error){

      $message = $error->getMessage();  

 }



 ?>  



<!DOCTYPE html>



<html>



<head><meta charset="windows-1252">



  



  <meta http-equiv="X-UA-Compatible" content="IE=edge">



  <title>Sorymarth | Log in</title>



  <!-- Tell the browser to be responsive to screen width -->



  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">



  <!-- Bootstrap 3.3.7 -->



  <link rel="stylesheet" href="init/bower_components/bootstrap/dist/css/bootstrap.min.css">



  <!-- Font Awesome -->



  <link rel="stylesheet" href="init/bower_components/font-awesome/css/font-awesome.min.css">



  <!-- Ionicons -->



  <link rel="stylesheet" href="init/bower_components/Ionicons/css/ionicons.min.css">



  <!-- Theme style -->



  <link rel="stylesheet" href="init/dist/css/AdminLTE.min.css">

  <link rel="stylesheet" href="init/plugins/iCheck/square/blue.css">



  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">



</head>



<body class="hold-transition login-page" style="background-color: #FFFFCC;

   background-image: url(init/img/pop3.png);

   background-repeat: no-repeat;

   background-attachment: scroll;

   background-size: cover;">



<div class="login-box">

  <div class="login-logo">

    <a href="#" style="color: #333;"><b>COMPRAS & VENTAS</b> SORYMARTH 

    <?php

    //$hora_actual = date('H:i:s', time()); // HORA ACTUAL

    // echo $hora_actual ?>  </a>

  </div>

  <!-- /.login-logo -->



  <div class="login-box-body" style="background: #bfdde0;">

   

    <p class="login-box-msg">Inicie sesi&oacute;n para continuar</p>



    <?php if(isset($message)){ echo $message; } ?>



    <form method="post">

    

      <div class="form-group has-feedback">

        <input type="text" class="form-control" name="username" placeholder="Usuario" />

        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

      </div>



      <div class="form-group has-feedback">

        <input type="password" class="form-control" name="password" placeholder="Clave de usuario" value="Admin2404" />

        <span class="glyphicon glyphicon-lock form-control-feedback"></span>

      </div>



      <div class="row">

        <div class="col-xs-12">

          <button type="submit" name="login" class="btn btn-primary btn-block btn-flat">Continuar</button>

        </div>

      </div>



    </form><br />



    <!--<center>Desarrollado por  <a href="https://www.proyectosrender.com" class="text-center" target="_blank">proyectosrender.com</a></center>-->

  </div>

</div>

<!-- jQuery 3 -->



<script src="../../bower_components/jquery/dist/jquery.min.js"></script>

<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<script src="../../plugins/iCheck/icheck.min.js"></script>



<script>

  $(function () {

    $('input').iCheck({

      checkboxClass: 'icheckbox_square-blue',

      radioClass: 'iradio_square-blue',

      increaseArea: '20%' /* optional */

    });

  });

</script>

</body>

</html>