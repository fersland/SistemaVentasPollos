<?php
	require_once ("../../datos/db/connect.php");

	$env = new DBSTART;
	$cc = $env->abrirDB();

    $emply   	= htmlspecialchars($_POST['empleado']);
    $valor   	= htmlspecialchars($_POST['valor']);
    $detalle    = htmlspecialchars($_POST['detalle']);
    $fecha      = date('Y-m-d');
    $estado     = 1;
    
    if ($detalle == 3 || $detalle == 6) {
        $tipo = 1;
    }else{
        $tipo = 2;
    }

    $anio = htmlspecialchars($_POST['anio']);
    $mes = htmlspecialchars($_POST['mes']);
    $dia = htmlspecialchars($_POST['dia']);
    
    $obs = htmlspecialchars($_POST['obs']);

    if ($valor == "" || $valor < 0 ){
                        echo '<div class="alert alert-danger">
                            <b>Los campos con (*) son obligatorios!</b>
                        </div>';
    }else{
        $entrada = 0;
        $salida = 0;
        
        // CONSULTAR SALDO INICIAL EN LA TABLA SALDO
        $sous = $cc->prepare("SELECT * FROM c_saldo");
        $sous->execute();
        $allsous = $sous->fetchAll(PDO::FETCH_ASSOC);
        
        foreach((array) $allsous as $datasaldo) {
            @$saldo = $datasaldo['saldo'];
        }
        
        if ( $tipo == 1 ) {
                    $entrada = $valor;
                    $new = @$saldo + $entrada;
                    $salida = 0;
                    // ACTUALIZAR EL SALDO EN LA TABLA SALDO
                    $upd = $cc->prepare("UPDATE c_saldo SET saldo=saldo + '$entrada'");
                    $upd->execute();
                }elseif ($tipo == 2) {
                    $entrada = 0;
                    $salida = $valor;
                    $new = $saldo - $salida;
                    
                    // ACTUALIZAR EL SALDO EN LA TABLA SALDO
                    $upd = $cc->prepare("UPDATE c_saldo SET saldo=saldo - '$salida'");
                    $upd->execute();
                }
        
            $sql = $cc->prepare("INSERT INTO c_resumen_gasto (param, tipo, id_empleado, valor, anio, mes, dia, entrada, salida, saldo, id_estado, obs) 
                                                    VALUES (:par, :tip, :ide, :val, :ani, :mes, :dia, :ent, :sal, :sou, :ies, :obs)");
            
            $sql->bindParam(':par', $tipo,        PDO::PARAM_INT);
            $sql->bindParam(':tip', $detalle,     PDO::PARAM_INT);
            $sql->bindParam(':ide', $emply,       PDO::PARAM_INT);
            $sql->bindParam(':val', $valor,       PDO::PARAM_STR);
            $sql->bindParam(':ani', $anio,        PDO::PARAM_INT);
            $sql->bindParam(':mes', $mes,         PDO::PARAM_INT);
            $sql->bindParam(':dia', $dia,         PDO::PARAM_INT);
            
            $sql->bindParam(':ent', $entrada,     PDO::PARAM_STR);
            $sql->bindParam(':sal', $salida,      PDO::PARAM_STR);
            $sql->bindParam(':sou', $new,         PDO::PARAM_STR);
            $sql->bindParam(':ies', $estado,      PDO::PARAM_INT);
            
            $sql->bindParam(':obs', $obs,         PDO::PARAM_STR);
            
            if ($sql -> execute() ){
                
                if ($detalle == 3) {
                    $abrir = $cc->prepare("UPDATE c_empresa SET fcaja='$fecha', scaja='SI', caja_abierta='SI'");
                    $abrir->execute();
                }
                
                
                
                echo '<script>
                    window.location.href = "../app/in.php?cid=cgg/cgg_view";
                </script>';
                    //echo '<div class="alert alert-success"><b>Registro Ingresado!</b></div>';
            }else{
                echo '<div class="alert alert-danger"><b>Error al realizar el ingreso!</b></div>';
                    }
        } // FIN ELSE DEF
        
        
        
        