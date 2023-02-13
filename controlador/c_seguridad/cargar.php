<?php
    require_once ("../../datos/db/connect.php");
    require_once ("../../controlador/conf.php");

    if (isset($_POST['register'])) {
    	$rol 	= $_POST['_idrol'];	// El nivel de acceso
    	$modulo = $_POST['elmodulo']; // El numero de módulo
    	$item 	= implode(", ", $_POST['michek']); // El item que se marcó


    	// Consultar si el nivel de acceso ya tiene permiso sobre el modulo
    	$stmt = DBSTART::abrirDB()->prepare("SELECT COUNT(*) as cant FROM c_modulos_items 
    			WHERE nivelacceso = '$rol' and idmodulo = '$modulo' and nombreitem = '$item' and estado = 'ACTIVO'");
    	$stmt->execute();
    	$the = $stmt->fetchAll(PDO::FETCH_ASSOC);

    	foreach ($the as $key => $value) {
    		$cantidad = $value['cant'];
    	}

    	// Comprobar el checked
    	if ( isset($item)) {
    		$estado = "ACTIVO";
    	}else{
    		$estado = "INACTIVO";
    	}

    	// Si la consulta manda vacio, se hace una inserción, para dar el nuevo permiso al nivel de acceso
    	if ( $cantidad == 0 ) {
    		$sql = DBSTART::abrirDB()->prepare("INSERT INTO c_modulos_items (nivelacceso, idmodulo, nombreitem, estado) 
    												VALUES ('$rol', '$modulo', '$item', '$estado')");
    		$sql->execute();

    		echo '<script>
	    			alert("Cambios Guardados!");
	    			window.history.back();
	    		  </script>';
    	}else{ // Si la consulta es mayor a cero, se aplican los cambios marcados
    		$sql = DBSTART::abrirDB()->prepare("UPDATE c_modulos_items SET nivelacceso='$rol', estado = '$estado'
    													 WHERE nivelacceso = '$rol' and idmodulo = '$modulo'");
    		$sql->execute();

    		echo '<script>
	    			alert("Cambios Guardados!");
	    			window.history.back();
	    		  </script>';
    	}
    }