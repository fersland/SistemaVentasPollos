<?php 
	require_once ("../../datos/db/connect.php");
	$env = new DBSTART;
	$db = $env->abrirDB();

		// SI
		$sql = $db->prepare("truncate table c_usuarios");
		$sql->execute();		
	
		$sql4 = $db->prepare("truncate table c_roles");
		$sql4->execute();

		$sql5 = $db->prepare("truncate table access");
		$sql5->execute();

		// INSERTS 

		$stmt = $db->prepare("insert into c_roles (id_empresa, nombrerol, fecharegistro, estado) values (1,'Admin',now(),'A')");
		$stmt->execute();

		$stmt2 = $db->prepare("insert into c_usuarios 
					(id_empresa, nivelacceso,correo, passw, fecha_registro, estado) values (1,1,'admin@outlook.es','1234',now(), 'A');");
		$stmt2->execute();


        // Accesos

        $insert = $db->prepare("INSERT INTO access (a_perfil, a_modulo, a_item, estado) VALUES                                                            
                                                            
                                                            (1, 1, 1, 'A'),
                                                            (1, 2, 3, 'A'),
                                                            (1, 2, 5, 'A'),
                                                            (1, 2, 6, 'A'),
                                                            (1, 2, 7, 'A'),
                                                            (1, 2, 8, 'A'),
                                                            (1, 2, 11, 'A'),
                                                            (1, 2, 14, 'A'),
                                                            
                                                            (1, 3, 17, 'A'),
                                                            (1, 3, 18, 'A'),
                                                            (1, 3, 19, 'A'),
                                                            
                                                            
                                                            (1, 4, 20, 'A'),
                                                            (1, 4, 21, 'A'),
                                                            (1, 4, 22, 'A'),
                                                            (1, 4, 23, 'A'),
                                                            (1, 4, 24, 'A'),
                                                            
                                                            
                                                            (1, 5, 25, 'A'),
                                                            (1, 5, 26, 'A'),
                                                            (1, 5, 27, 'A'),
                                                            (1, 5, 28, 'A'),
                                                            (1, 5, 29, 'A')");
		$insert->execute();

		session_start();
		session_unset();
		session_destroy();

		header("Location: ../../login.php");

	