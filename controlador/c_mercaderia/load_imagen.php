<?php
    require_once ('./'."../../../datos/db/connect.php");
    $formato = array('.jpg', '.png');
  
    //$imgs = addslashes(file_get_contents($_FILES['img']['tmp_name'])); LAS IMAGENES VAN A DIRECTORIO
    
    $idp      = htmlspecialchars($_POST['upd_id']);

    // BUSCAR COMPRA REPETIDA DE PROVEEDOR Y NUMERO DE COMPRA
    
        // INGRESO DE MERCADERIA CON FOTO DE PRODUCTO
        $nombrearchivo = $_FILES['img']['name'];
        $nombretmparchivo = $_FILES['img']['tmp_name'];
        $ext = substr($nombrearchivo, strrpos($nombrearchivo, '.'));

    if (in_array($ext, $formato)) { // CON FOTO
        
        $importe = 0;
        $importe = $stock * $pc;
        if ($desc == 0 ) {
            $importe = $importe;
        }else{
            $importe = $importe - $desc;
        }
      if (move_uploaded_file($nombretmparchivo, "../../../init/img/$nombrearchivo")) {
        // Realizar la compra        
        $env = DBSTART::abrirDB()->prepare("UPDATE c_mercaderia SET ruta='$nombrearchivo' WHERE idp='$idp'");
        if ($env->execute()){
        
	   echo '<div class="alert alert-success">
                <b><i class="fa fa-check"></i> Ilustraci&oacute;n añadida correctamente!</b>
            </div>';
            }else{
                echo '<div class="alert alert-warning">
                <b>Error al guardar los cambios!</b>
            </div>';
            }
    }
  }
?>