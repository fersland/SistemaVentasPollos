<?php

	require_once ("../../datos/db/connect.php");

	$env = new DBSTART;

	$db = $env->abrirDB();

    

	$clave = '1234';

    $cedula = '1234567890';

	$passw = sha1($clave);

    

    $action = $db->prepare("TRUNCATE TABLE access");

    $action->execute();

/*

    $action = $db->prepare("TRUNCATE TABLE c_empleados");

    $action->execute();



    $action = $db->prepare("TRUNCATE TABLE c_usuarios");

    $action->execute();



    $action = $db->prepare("TRUNCATE TABLE c_saldo");

    $action->execute();



    $action = $db->prepare("INSERT INTO c_saldo (saldo) VALUES (0)");

    $action->execute();

    

    

    

    $ad = $db->prepare("INSERT INTO c_empleados (id_acceso,cedula,nombres, apellidos, correo,estado) 

                                                        VALUES (1, '$cedula','Nelson', 'Machaca', 'admin@live.com', 'A')");

	$ad->execute();



	$users = $db->prepare("INSERT INTO c_usuarios (nivelacceso, correo, passw, cedula_user, estado, imagen) 

        VALUES (1, 'admin@outlook.es', '$passw', '$cedula', 'A', 'default.png')");

	$users->execute();

    */



	$modules = $db->prepare("INSERT INTO access (a_perfil, a_modulo, a_item, cs, sav, edi, del, pri, estado) VALUES

                                                   (1, 1, 		1,  	'A','A', 'A', 'A', 'A', 'A'),

                                                   (1, 1, 		2,  	'A','A', 'A', 'A', 'A', 'A'),

                                                   (1, 1, 		3,  	'A','A', 'A', 'A', 'A', 'A'),

                                                   

                                                   (1, 2, 		4,  	'A','A', 'A', 'A', 'A', 'A'),

                                                   (1, 2, 		5,  	'A','A', 'A', 'A', 'A', 'A'),

                                                   (1, 2, 		6,  	'A','A', 'A', 'A', 'A', 'A'),

                                                   (1, 2, 		7, 	    'A','A', 'A', 'A', 'A', 'A'),

                                                   (1, 2, 		8, 	    'A','A', 'A', 'A', 'A', 'A'),

                                                   (1, 2, 		9, 	    'A','A', 'A', 'A', 'A', 'A'),

                                                   (1, 2, 		22, 	'A','A', 'A', 'A', 'A', 'A'),

                                                   (1, 2, 		23, 	'A','A', 'A', 'A', 'A', 'A'),

                                                   (1, 2, 		29, 	'A','A', 'A', 'A', 'A', 'A'),
                                                   (1, 2, 		30, 	'A','A', 'A', 'A', 'A', 'A'),



                                                   (1, 3, 		10, 	'A','A', 'A', 'A', 'A', 'A'),

                                                   (1, 3, 		11, 	'A','A', 'A', 'A', 'A', 'A'),

                                                   (1, 3, 		12, 	'A','A', 'A', 'A', 'A', 'A'),

                                                   

                                                   (1, 4, 		13, 	'A','A', 'A', 'A', 'A', 'A'),

                                                   (1, 4, 		14, 	'A','A', 'A', 'A', 'A', 'I'),

                                                   (1, 4, 		15, 	'A','A', 'A', 'A', 'A', 'A'),

                                                   (1, 4, 		16, 	'A','A', 'A', 'A', 'A', 'I'),

                                                   

                                                   (1, 5, 		17, 	'A','A', 'A', 'A', 'A', 'A'),

                                                   

                                                   (1, 6, 		20, 	'A','A', 'A', 'A', 'A', 'A'),

                                                   (1, 6, 		21, 	'A','A', 'A', 'A', 'A', 'A'),

                                                   (1, 6, 		27, 	'A','A', 'A', 'A', 'A', 'A'),

                                                   

                                                   (1, 7, 		24, 	'A','A', 'A', 'A', 'A', 'A'),

                                                   

                                                   (1, 8, 		28, 	'A','A', 'A', 'A', 'A', 'A'),

                                                   (1, 4,     31,   'A','A', 'A', 'A', 'A', 'A'),
                                                   (1, 2,     32,   'A','A', 'A', 'A', 'A', 'A'),
                                                   (1, 2,     33,   'A','A', 'A', 'A', 'A', 'A'),
                                                   (1, 2,     34,   'A','A', 'A', 'A', 'A', 'A')");

    $modules->execute();



	@header('Location: ../../datos/db/close.php');