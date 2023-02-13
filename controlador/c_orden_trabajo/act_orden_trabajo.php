<?php
	require_once ("../../datos/db/connect.php");
	require_once ("../../controlador/conf.php");

	$env = new DBSTART;
	$cc = $env->abrirDB();
    
    if (isset($_POST['facturar'])){
	    $empresa    = SEG::clean($_POST['empresa']);
        $ntrab      = SEG::clean($_POST['ntrabajo']);
        
        // Cliente
        $cedula     = SEG::clean($_POST['cedula']);
        $nombres    = SEG::clean(strtoupper($_POST['nombres']));
        $correo     = SEG::clean($_POST['correo']);
        $celular    = SEG::clean($_POST['cel']);
        $direcc     = SEG::clean($_POST['direccion']);
        
        // Vehiculo
        $placa      = SEG::clean($_POST['placa']);
        $serie_m    = SEG::clean($_POST['serie_motor']);
        $serie_c    = SEG::clean($_POST['serie_chasis']);
        $marca      = SEG::clean($_POST['marca']);
        $color      = SEG::clean($_POST['color']);
        $modelo     = SEG::clean($_POST['modelo']);
        $km         = SEG::clean($_POST['km']);
        $anio       = SEG::clean($_POST['anio']);
        $activ      = SEG::clean($_POST['actividad']);
        $observ     = SEG::clean($_POST['observ']);
        
        // Trabajos
        $motor      = $_POST['motor'];
        $frenos     = $_POST['frenos'];
        $caja       = $_POST['cajacambios'];
        $diferen    = $_POST['diferen'];
        $ladirecc   = $_POST['ladireccion'];
        $ruedas     = $_POST['ruedas'];
        $suspen     = $_POST['suspen'];
        $sistema    = $_POST['sistema'];
        $cardan     = $_POST['cardan'];
        $inactivo = 'I';
        
        $sql = $cc->prepare("UPDATE c_orden_trabajo SET
                                cedula='$cedula', placa='$placa', serie_m='$serie_m', serie_c='$serie_c', marca='$marca',
                                color='$color', modelo='$modelo', km='$km', anio='$anio', actividad='$activ', fecha_modificacion=now()
                                
                             WHERE id_empresa='$empresa' AND estado ='E' AND ntrabajo='$ntrab'");
                
        if ($sql -> execute()) {
            $ins = $cc->prepare("UPDATE c_orden_trabajo_items SET 
                    motor='$motor', frenos='$frenos',caja='$caja',diferenciales='$diferen',
                    direccion='$ladirecc',ruedas='$ruedas',suspension='$suspen',sistema='$sistema',cardan='$cardan'
                    WHERE id_empresa='$empresa' AND estado='E' AND norden='$ntrab'");
             $ins->execute();
             header('Location: ../../inicializador/vistas/app/ventas/frm_orden_trabajo_param.php?cid='.$ntrab);
                }else{
                        echo '<div class="alert alert-danger">
                                  <b>Error al Guardar!</b>
                              </div>';
                    }
        }