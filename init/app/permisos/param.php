<?php
    require_once ('./'."../../../../datos/db/connect.php");
    
    $cc = new DBSTART;
    $db = $cc->abrirDB();
    $usuario = $_SESSION["usuario"];
    
    $cid = isset($_GET["cid"]) ? $_GET["cid"] : 0;
    
    $sql = $db->prepare("UPDATE c_tokens SET active='A' WHERE id_usuario = '$usuario' AND modulo='$cid'");
    $sql->execute();
    
    echo '<script>window.history.back();</script>';