 <?php 
 // Actualizar datos
    require_once ("../../../../datos/db/connect.php");
 
    
    $formato = array('.jpg', '.png');    
    
 	$idemp    = $_POST['_codigo'];
    
    $nombrearchivo = $_FILES['img']['name'];
    $nombretmparchivo = $_FILES['img']['tmp_name'];

    $ext = substr($nombrearchivo, strrpos($nombrearchivo, '.'));
    
    if (in_array($ext, $formato)) {
      if (move_uploaded_file($nombretmparchivo, "../../../../inicializador/img/$nombrearchivo")) {
	 $stmt = DBSTART::abrirDB()->prepare(
	 	"UPDATE c_mercaderia SET ruta = '$nombrearchivo', fechamodificacion=now() WHERE codproducto='$idemp'");
	 $stmt->execute();

	 if ( $stmt->execute() ){

	 echo '<div class="alert alert-success">
                <b>Imagen cambiada!</b>
            </div>';
            }else{
                echo '<div class="alert alert-warning">
                <b>Error al guardar los cambios!</b>
            </div>';
            }
    }
    } else{
          echo '<div class="alert alert-warning">
                <b>Formato o archivo no admitido.!</b>
            </div>';
    }
  
 ?>