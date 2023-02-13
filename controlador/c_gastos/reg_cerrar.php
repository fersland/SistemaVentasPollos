<?php
	require_once ("../../datos/db/connect.php");

	$env = new DBSTART;
	$cc = $env->abrirDB();

    $valor   	= htmlspecialchars($_POST['valor']);
    $estado     = 1;

    $anio = htmlspecialchars($_POST['anio']);
    $mes = htmlspecialchars($_POST['mes']);
    $dia = htmlspecialchars($_POST['dia']);
    $detalle = 4;
    $entrada = 0;
    $salida = $valor;
    $new = 0;

    $fecha = date('Y-m-d');

    if ($valor == ""){
                        echo '<div class="alert alert-danger">
                            <b>Los campos con (*) son obligatorios!</b>
                        </div>';
    }else{
        
            $sql = $cc->prepare("INSERT INTO c_resumen_gasto (tipo, valor, anio, mes, dia, entrada, salida, saldo, id_estado) 
                                                    VALUES (:tip,   :val, :ani, :mes, :dia, :ent, :sal,     :sou,  :ies)");
            
            $sql->bindParam(':tip', $detalle,     PDO::PARAM_INT);
            $sql->bindParam(':val', $valor,       PDO::PARAM_STR);
            $sql->bindParam(':ani', $anio,        PDO::PARAM_INT);
            $sql->bindParam(':mes', $mes,         PDO::PARAM_INT);
            $sql->bindParam(':dia', $dia,         PDO::PARAM_INT);
            
            $sql->bindParam(':ent', $entrada,     PDO::PARAM_STR);
            $sql->bindParam(':sal', $salida,      PDO::PARAM_STR);
            $sql->bindParam(':sou', $new,         PDO::PARAM_STR);
            
            $sql->bindParam(':ies', $estado,         PDO::PARAM_INT);
            
            if ($sql -> execute() ){
                $history = $cc->prepare("INSERT INTO c_historial_caja (saldo, anio, mes, dia) VALUES ('$valor', '$anio', '$mes', '$dia')");
                $history->execute();
                
                // ACTUALIZAR EL SALDO EN LA TABLA SALDO
                $upd = $cc->prepare("UPDATE c_saldo SET saldo=0");
                $upd->execute();
                
                // CERRAR LA CAJA PARA NO FACTURAR EN VENTAS
                $cerrar = $cc->prepare("UPDATE c_empresa SET fcaja='$fecha', scaja='NO', caja_abierta='NO'");
                $cerrar->execute();
                
                    echo '<script>
                    alert("Caja Cerrada");
                    window.location.href = "../app/in.php?cid=cgg/cgg_view";
                </script>';
            }else{
                echo '<div class="alert alert-danger"><b>Error al realizar el ingreso!</b></div>';
                    }
        } // FIN ELSE DEF
        
        
        
        