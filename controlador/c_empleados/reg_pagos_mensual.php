<?php
	require_once ("../../../datos/db/connect.php");

	$env = new DBSTART;
	$cc = $env->abrirDB();
    
    $fecha_hoy = date('Y-m-d');

    $emply   	= htmlspecialchars($_POST['empleado']);
    $multa   	= htmlspecialchars($_POST['multa']);
    $ingreso       = htmlspecialchars($_POST['ingreso']);
    $final       = htmlspecialchars($_POST['final']);
    $fecha      = date('Y-m-d');
    $estado     = 1;
    $empresa     = 1;
    $ndias = htmlspecialchars($_POST['ndias']);
    $ndesc = htmlspecialchars($_POST['ndesc']);

    $anio = htmlspecialchars($_POST['anio']);
    $mes = htmlspecialchars($_POST['mes']);
    $dia = htmlspecialchars($_POST['dia']);
    $obs = htmlspecialchars($_POST['obs']);
    
    // NUEVAS
    $anticipo = htmlspecialchars($_POST['anticipo']);
    $bolimar = htmlspecialchars($_POST['bolimar']);
    $retraso = htmlspecialchars($_POST['retraso']);
    
    $cobro_ruta = htmlspecialchars($_POST['cobro_ruta']);
    $cobro_dia = htmlspecialchars($_POST['cobro_dia']);
    $boligrafo = htmlspecialchars($_POST['boligrafo']);
    $marcador = htmlspecialchars($_POST['marcador']);
    $deuda = htmlspecialchars($_POST['deuda']);
    $estados = htmlspecialchars($_POST['estados']);
    
    $vp = htmlspecialchars($_POST['valor_pagado']);
    
    if ($ndias == "" || $ndias <= 0 ){
                        echo '<div class="alert alert-danger">
                            <b>Los campos con (*) son obligatorios!</b>
                        </div>';
    }else{
        
            // Consultar pago repetido
            $stmt = $cc->prepare("SELECT * FROM c_pagos_mensual WHERE id_empleado = '$emply' AND fecha_pago= '$fecha_hoy' AND id_estado = 1");
            $stmt->execute();
            $cant = $stmt->rowCount();
   
            if ( $cant == 0 ) {
                    $sql = $cc->prepare("INSERT INTO c_pagos_mensual (id_empresa, id_empleado, ingreso, final, ndias, ndesc, multa, dia, mes, anio, obs, id_estado, anticipo, bolimar, retraso,
                    aux_multa_ruta, aux_multa_dia, boligrafo, marcador, deuda_anterior_mes, estados, valor_pagado, fecha_pago) 
                                                             VALUES (:empresa, :empleado, :ingreso, :final, :ndias, :ndesc, :multa, :dia, :mes, :anio, :obs, :estado, :anticipo, :bolimar, :retraso,
                                                             :multa_ruta, :multa_dia, :boligrafo, :marcador, :deuda, :estados, :vp, :fpago)");
                    $sql->bindParam(':empresa', $empresa,        PDO::PARAM_INT);
                    $sql->bindParam(':empleado', $emply,        PDO::PARAM_INT);
                    $sql->bindParam(':ingreso', $ingreso,       PDO::PARAM_STR);
                    $sql->bindParam(':final', $fecha,       PDO::PARAM_STR);
                    $sql->bindParam(':ndias', $ndias,     PDO::PARAM_INT);
                    $sql->bindParam(':ndesc', $ndesc,     PDO::PARAM_INT);
                    
                    $sql->bindParam(':multa', $multa,     PDO::PARAM_STR);
                    $sql->bindParam(':dia', $dia,     PDO::PARAM_INT);
                    $sql->bindParam(':mes', $mes,     PDO::PARAM_INT);
                    $sql->bindParam(':anio', $anio,     PDO::PARAM_INT);
                    $sql->bindParam(':obs', $obs,     PDO::PARAM_STR);
                    $sql->bindParam(':estado', $estado,     PDO::PARAM_INT);
                    
                    $sql->bindParam(':anticipo', $anticipo,     PDO::PARAM_STR);
                    $sql->bindParam(':bolimar', $bolimar,     PDO::PARAM_STR);
                    $sql->bindParam(':retraso', $retraso,     PDO::PARAM_STR);
                    
                    $sql->bindParam(':multa_ruta', $cobro_ruta, PDO::PARAM_STR);
                    $sql->bindParam(':multa_dia', $cobro_dia, PDO::PARAM_STR);
                    $sql->bindParam(':boligrafo', $boligrafo, PDO::PARAM_STR);
                    $sql->bindParam(':marcador', $marcador, PDO::PARAM_STR);
                    $sql->bindParam(':deuda', $deuda, PDO::PARAM_STR);
                    $sql->bindParam(':estados', $estados, PDO::PARAM_STR);
                    
                    $sql->bindParam(':vp', $vp, PDO::PARAM_STR);
                    $sql->bindParam(':fpago', $fecha_hoy, PDO::PARAM_STR);
            
                    if ($sql -> execute() ){
                        // GENERAR INGRESOS 
                       /* $ing = $cc->prepare("INSERT INTO c_resumen_gasto (tipo, id_empleado, valor, anio, mes, dia) VALUES
                                                                         ('$tipo', '$emply', '$valor', '$anio', '$mes', '$dia')");
                        $ing->execute();*/

                        echo '<div class="alert alert-success">
                                <b>Se han guardado los datos!</b>
                            </div>';
                    }else{
                        echo '<div class="alert alert-danger">
                                <b>Error al realizar el pago al empleado!</b>
                            </div>';
                    }
            }else{
                echo '<div class="alert alert-danger">
                                        <b>Error, usted ya realiz&oacute; este movimiento para el empleado seleccionado!</b>
                                    </div>';
            }
  
		
  }