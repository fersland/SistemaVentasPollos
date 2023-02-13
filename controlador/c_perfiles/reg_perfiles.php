<?php
	require_once ('./'."../../datos/db/connect.php");
	$env = new DBSTART;
	$db = $env->abrirDB();

	if (isset($_POST['register'])) {
		$perfil   = strtoupper(htmlspecialchars($_POST['perfil']));
		$obs      = htmlspecialchars($_POST['obs']);
		$est      = 'A';

		$insert = DBSTART::abrirDB()->prepare("INSERT INTO c_roles (nombrerol, observacion, estado) VALUES (?,?,?)");
		$insert->bindParam(1, $perfil,    PDO::PARAM_STR);
        $insert->bindParam(2, $obs,       PDO::PARAM_STR);
        $insert->bindParam(3, $est,       PDO::PARAM_STR);

        // Nuevo Parámetro
	    if ($insert->execute() ) {
            $last = DBSTART::abrirDB()->prepare("SELECT MAX(idrol) el_ultimo_rol FROM c_roles");
            $last->execute();
            $fetch = $last->fetchAll(PDO::FETCH_ASSOC);

            foreach((array) $fetch as $all_fetch) {
                $perfil = $all_fetch['el_ultimo_rol'];
            }
            // Crear accesos a modulos
          	$modules = DBSTART::abrirDB()->prepare("INSERT INTO access (a_perfil, a_modulo, a_item, cs,sav,edi,del,pri,estado) VALUES
                                                                      ('$perfil', 1, 		1,    'I','I', 'I', 'I', 'I', 'A'),
                                                                      ('$perfil', 1, 		2,  	'I','I', 'I', 'I', 'I', 'A'),
                                                                      ('$perfil', 1, 		3,  	'I','I', 'I', 'I', 'I', 'A'),
                                                                      
                                                                      ('$perfil', 2, 		4,  	'I','I', 'I', 'I', 'I', 'A'),
                                                                      ('$perfil', 2, 		5,  	'I','I', 'I', 'I', 'I', 'A'),
                                                                      ('$perfil', 2, 		6,  	'I','I', 'I', 'I', 'I', 'A'),
                                                                      ('$perfil', 2, 		7,  	'I','I', 'I', 'I', 'I', 'A'),
                                                                      ('$perfil', 2, 		8,  	'I','I', 'I', 'I', 'I', 'A'),
                                                                      ('$perfil', 2, 		9, 	  'I','I', 'I', 'I', 'I', 'A'),
                                                                      ('$perfil', 2, 		22, 	'I','I', 'I', 'I', 'I', 'A'),
                                                                      ('$perfil', 2, 		23, 	'I','I', 'I', 'I', 'I', 'A'),
                                                                      ('$perfil', 2, 		29, 	'I','I', 'I', 'I', 'I', 'A'),
                                                                      ('$perfil', 2,    30,   'I','I', 'I', 'I', 'I', 'A'),
                                                                      ('$perfil', 2,    32,   'I','I', 'I', 'I', 'I', 'A'),
                                                                      ('$perfil', 2,    33,   'I','I', 'I', 'I', 'I', 'A'),
                                                                      ('$perfil', 2,    34,   'I','I', 'I', 'I', 'I', 'A'),
                                                                      
                                                                      ('$perfil', 3, 		10, 	'I','I', 'I', 'I', 'I', 'A'),
                                                                      ('$perfil', 3, 		11, 	'I','I', 'I', 'I', 'I', 'A'),
                                                                      ('$perfil', 3, 		12, 	'I','I', 'I', 'I', 'I', 'A'),
                                                                      
                                                                      ('$perfil', 4, 		13, 	'I','I', 'I', 'I', 'I', 'A'),
                                                                      ('$perfil', 4, 		14, 	'I','I', 'I', 'I', 'I', 'A'),
                                                                      ('$perfil', 4, 		15, 	'I','I', 'I', 'I', 'I', 'A'),
                                                                      ('$perfil', 4, 		16, 	'I','I', 'I', 'I', 'I', 'A'),
                                                                      
                                                                      ('$perfil', 5, 		17, 	'I','I', 'I', 'I', 'I', 'A'),
                                                                      
                                                                      ('$perfil', 6, 		20, 	'I','I', 'I', 'I', 'I', 'A'),
                                                                      ('$perfil', 6, 		21, 	'I','I', 'I', 'I', 'I', 'A'),
                                                                      ('$perfil', 6, 		27, 	'I','I', 'I', 'I', 'I', 'A'),

                                                                      ('$perfil', 7, 		24, 	'I','I', 'I', 'I', 'I', 'A'),
                                                                      
                                                                      ('$perfil', 8, 		28, 	'I','I', 'I', 'I', 'I', 'A'),

                                                                      ('$perfil', 4,    31,   'I','I', 'I', 'I', 'I', 'A')
                                                                      ");
            $modules->execute();
            
            echo '<script>
                    window.location.href = "../../init/app/seguridad/permisos.php?cid='.$perfil.'";
                  </script>';
            
	    }
	}
?>