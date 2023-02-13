<?php
	require_once ("../../datos/db/connect.php");

	$env = new DBSTART;
	$cc = $env->abrirDB();

    $emply   	= htmlspecialchars($_POST['empleado']);
    $valor   	= htmlspecialchars($_POST['valor']);
    $tipo       = htmlspecialchars($_POST['tipo']);
    $fecha      = date('Y-m-d');
    $estado     = 1;

    $anio = htmlspecialchars($_POST['anio']);
    $mes = htmlspecialchars($_POST['mes']);
    $dia = htmlspecialchars($_POST['dia']);

    if ($valor == "" || $valor <= 0 ){
                        echo '<div class="alert alert-danger">
                            <b>Los campos con (*) son obligatorios!</b>
                        </div>';
    }else{


        if ($tipo == 1) {
            // Consultar pago repetido
            $stmt = $cc->prepare("SELECT * FROM c_pagos WHERE id_empleado = '$emply' AND fecha= '$fecha' AND id_estado = 1");
            $stmt->execute();
            $cant = $stmt->rowCount();
   
            if ( $cant == 0 ) {
                    $sql = $cc->prepare("INSERT INTO c_pagos (id_empleado, detalle, valor, fecha, id_estado, dia, mes, anio) 
                                            VALUES (?, ?, ?, ?, ?, ?,?,?)");
                    $sql->bindParam(1, $emply,        PDO::PARAM_INT);
                    $sql->bindParam(2, $tipo,        PDO::PARAM_INT);
                    $sql->bindParam(3, $valor,       PDO::PARAM_STR);
                    $sql->bindParam(4, $fecha,       PDO::PARAM_STR);
                    $sql->bindParam(5, $estado,     PDO::PARAM_INT);
                    
                    $sql->bindParam(6, $dia,     PDO::PARAM_INT);
                    $sql->bindParam(7, $mes,     PDO::PARAM_INT);
                    $sql->bindParam(8, $anio,     PDO::PARAM_INT);
            
                    if ($sql -> execute() ){
                        // GENERAR INGRESOS 
                        $ing = $cc->prepare("INSERT INTO c_resumen_gasto (tipo, id_empleado, valor, anio, mes, dia) VALUES
                                                                         ('$tipo', '$emply', '$valor', '$anio', '$mes', '$dia')");
                        $ing->execute();

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
        }elseif($tipo > 1){
            $sql = $cc->prepare("INSERT INTO c_pagos (id_empleado, detalle, valor, fecha, id_estado, dia, mes, anio) 
                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                    $sql->bindParam(1, $emply,       PDO::PARAM_INT);
                    $sql->bindParam(2, $tipo,        PDO::PARAM_INT);
                    $sql->bindParam(3, $valor,       PDO::PARAM_STR);
                    $sql->bindParam(4, $fecha,       PDO::PARAM_STR);
                    $sql->bindParam(5, $estado,      PDO::PARAM_INT);
                    $sql->bindParam(6, $dia,     PDO::PARAM_INT);
                    $sql->bindParam(7, $mes,     PDO::PARAM_INT);
                    $sql->bindParam(8, $anio,     PDO::PARAM_INT);
            
                    if ($sql -> execute() ){
                        // GENERAR INGRESOS 
                        $ing = $cc->prepare("INSERT INTO c_resumen_gasto (tipo, id_empleado, valor, anio, mes, dia) VALUES
                                                                         ('$tipo', '$emply', '$valor', '$anio', '$mes', '$dia')");
                        $ing->execute();


                        echo '<div class="alert alert-success">
                                <b>Se han guardado los datos!</b>
                            </div>';
                    }else{
                        echo '<div class="alert alert-danger">
                                <b>Error al realizar el pago al empleado!</b>
                            </div>';
                    }
        }
		
  }