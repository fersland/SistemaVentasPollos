<?php
	require_once ('../datos/db/connect.php');
    
    $error = array();
    
    if (!empty ($_POST)){
        $correo = htmlspecialchars($_POST['correo']);
        
    }    