<?php
	require_once ("../../datos/db/connect.php");

	$env = new DBSTART;
	$cc = $env->abrirDB();

    $acceso   	= htmlspecialchars($_POST['acceso']);
    $cedula 	= htmlspecialchars($_POST['cedula']);
	$nombres 	= htmlspecialchars($_POST['nombres']);
	$apellidos 	= htmlspecialchars($_POST['apellidos']);
    $lugnac 	= htmlspecialchars($_POST['lugnac']);
    $fecnac 	= htmlspecialchars($_POST['fecnac']);
	$edad 		= htmlspecialchars($_POST['edad']);
	$correo 	= htmlspecialchars($_POST['correo']);
    $direccion 	= htmlspecialchars($_POST['direccion']);
    $telefono 	= htmlspecialchars($_POST['telefono']);
    $celular 	= htmlspecialchars($_POST['celular']);
    $sucursal 	= htmlspecialchars($_POST['sucursal']);
    $fingreso   = htmlspecialchars($_POST['ingreso']);
    $carnet     = htmlspecialchars($_POST['carnet']);
    $sueldo     = htmlspecialchars($_POST['sueldo']);
    
    
    $imagen = 'default.png';
    $estado = 'A';

    if ($cedula == "" || $nombres == "" || $apellidos == "" ){
                        echo '<div class="alert alert-danger">
                            <b><i class="fa fa-remove"></i> Los campos con (*) son obligatorios!</b>
                        </div>';
    }else{
		// Consultar cédula repetida
		$stmt = $cc->prepare("SELECT * FROM c_empleados WHERE cedula = '$cedula' and estado = 'A'");
		$stmt->execute();
		$cant = $stmt->rowCount();
   
		if ( $cant == 0 ) {
              $sql = $cc->prepare("INSERT INTO c_empleados
                (id_acceso,cedula, nombres, apellidos, lugar_nacimiento, fecha_nacimiento, edad, correo, direccion, telefono, celular, estado, sucursal, carnet, mensualidad, fecha_ingreso)
                            VALUES (?,?,?,?,?,?, ?,?,?,?,?,?, ?,?,?,?)");
                $sql->bindParam(1, $acceso,        PDO::PARAM_INT);
                $sql->bindParam(2, $cedula,        PDO::PARAM_STR);
                $sql->bindParam(3, $nombres,       PDO::PARAM_STR);
                $sql->bindParam(4, $apellidos,     PDO::PARAM_STR);
                $sql->bindParam(5, $lugnac,        PDO::PARAM_STR);
                $sql->bindParam(6, $fecnac,        PDO::PARAM_STR);
                $sql->bindParam(7, $edad,          PDO::PARAM_INT);
                $sql->bindParam(8, $correo,        PDO::PARAM_STR);
                $sql->bindParam(9, $direccion,     PDO::PARAM_STR);
                $sql->bindParam(10, $telefono,     PDO::PARAM_STR);
                $sql->bindParam(11, $celular,      PDO::PARAM_STR);
                $sql->bindParam(12, $estado,       PDO::PARAM_STR);
                $sql->bindParam(13, $sucursal,     PDO::PARAM_INT);
                
                $sql->bindParam(14, $carnet, PDO::PARAM_STR);
                $sql->bindParam(15, $sueldo, PDO::PARAM_STR);
                $sql->bindParam(16, $fingreso, PDO::PARAM_STR);
                
                if ($sql -> execute() ){
                    
                    $lastid = $cc->prepare("SELECT MAX(id_empleado) as ultimo FROM c_empleados");
                    $lastid->execute();
                    $args = $lastid->fetchAll();
                    
                    foreach ((array) $args as $fff) {
                        $nn = $fff['ultimo']; }
                    
                    $shock = sha1($cedula);
                    // Agregar Usuario con nivel de acceso
                    
                    if ($acceso != '0') {
                        $statement = $cc->prepare("INSERT INTO c_usuarios (nivelacceso, usuario, correo, passw, cedula_user, estado, imagen, cl, idemp, sucursal)
                                                               VALUES (:niv, :usu, :cor, :pas, :ced, :est, :img, :cla, :ide, :suc)");
                        $statement->bindParam(':niv', $acceso, PDO::PARAM_INT);
                        $statement->bindParam(':usu', $cedula, PDO::PARAM_STR);
                        $statement->bindParam(':cor', $correo, PDO::PARAM_STR);
                        $statement->bindParam(':pas', $shock,  PDO::PARAM_STR);
                        $statement->bindParam(':ced', $cedula, PDO::PARAM_STR);
                        $statement->bindParam(':est', $estado, PDO::PARAM_STR);
                        $statement->bindParam(':img', $imagen, PDO::PARAM_STR);
                        $statement->bindParam(':cla', $cedula, PDO::PARAM_STR);
                        $statement->bindParam(':ide', $nn,     PDO::PARAM_INT);
                        $statement->bindParam(':suc', $sucursal,     PDO::PARAM_INT);
                        $statement->execute();
                        
                        $horario_inicial = '07:00:00';
                        $horario_final = '20:00:00';
                        
                        
                        // AGREGAR PERMISOS DE HORARIO PARA EL USUARIO
                        $lastuser = $cc->prepare("SELECT MAX(id_usuario) as ultimo_u FROM c_usuarios");
                        $lastuser->execute();
                        $args_user = $lastuser->fetchAll();
                        
                        foreach ((array) $args_user as $ffu) {
                            $nnu = $ffu['ultimo_u']; }
                            
                        $zone = $cc->prepare("INSERT INTO c_horarios (id_usuario, lunes_desde, lunes_hasta, martes_desde, martes_hasta, miercoles_desde, miercoles_hasta,
                                                                jueves_desde, jueves_hasta, viernes_desde, viernes_hasta, sabado_desde, sabado_hasta, domingo_desde, domingo_hasta) 
                                VALUES ('$nnu', '$horario_inicial', '$horario_final', '$horario_inicial', '$horario_final', '$horario_inicial', '$horario_final',
                                            '$horario_inicial', '$horario_final', '$horario_inicial', '$horario_final', '$horario_inicial', '$horario_final', '$horario_inicial', '$horario_final')");
                        $zone->execute();
                    }

                    echo '<div class="alert alert-success">
                            <b><i class="fa fa-check"></i> Empleado guardado!</b>
                          </div>';
                    
                }else{
                    echo '<div class="alert alert-danger">
                            <b><i class="fa fa-remove"></i> Error al guardar al empleado!</b>
                        </div>';
                }
		}else{
			echo '<div class="alert alert-danger">
                        <b><i class="fa fa-remove"></i> Esta cédula ya existe en otro empleado!</b>
                    </div>';
		}
    }