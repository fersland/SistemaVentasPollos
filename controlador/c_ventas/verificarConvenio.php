<?php
    require_once ("../../datos/db/connect.php");
    
    $cedula = $_POST["cedula"];
    $producto = $_POST["producto"];
    
    $stmt = DBSTART::abrirDB()->prepare("SELECT * FROM c_convenios WHERE cod='$cedula' AND codigo='$producto' AND id_estado = 1");
    $stmt->execute();
    $count = $stmt->rowCount();
        
    if ($count > 0) {
        echo '<span class="text-success">Esta codigo existe.</span>';
        echo '<script>document.getElementById("boton").disabled = false;</script>';
        echo '<script>validarEply();</script>';
    }else{
        echo '<span class="text-danger">Esta codigo NO existe.</span>';
        //echo '<script>document.getElementById("boton").disabled = true;</script>';
        echo '<script>document.getElementById("promo").value = "";</script>';
        //echo '<span class="text-success">- Esta cédula no existe, revise la siguiente restricción.</span>';
    }