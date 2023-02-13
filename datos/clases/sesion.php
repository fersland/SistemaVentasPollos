<?php

	class Sesion {
		public $email;
		public $password;
		public $mensaje;

		public function Sesions() {
            require_once ("datos/db/connect.php");
            $cc = new DBSTART;
            $db = $cc->abrirDB();
			$sql = $db->prepare("SELECT count(*) as limite FROM c_empleados e INNER JOIN c_empresa p ON p.id_empresa = e.id_empresa
                                                    WHERE correo=:correo AND cedula=:cedula");
			$sql->bindParam(':correo', $this->email, PDO::PARAM_STR);
			$sql->bindParam(':cedula', $this->password, PDO::PARAM_STR);
			$sql->execute(); // Ejecutar la consulta sin procesar

			$datosDevueltos = $sql->rowCount();

			if ($datosDevueltos == 0) {
				//echo datosDevueltos;
				$this->mensaje = 'Error al iniciar sesion';
			}else if ($datosDevueltos == 1){
				$filaDevuelta = $sql->fetch();
				session_start();
				$_SESSION['login'] 			= true;
				$_SESSION['id_empleado'] 	= $filaDevuelta['id_empleado'];
                $_SESSION['id_empresa']		= $filaDevuelta['id_empresa'];
				$_SESSION['nombres'] 		= $filaDevuelta['nombres'];
                $_SESSION['apellidos'] 		= $filaDevuelta['apellidos'];

				//$seguridad = $filaDevuelta['nomrole'];

				//switch($seguridad){
					//case 'Administrador';
				   	header('Location: inicializador/vistas/app/in.php');
				  //  break;
				//}
			}
		}
	}
