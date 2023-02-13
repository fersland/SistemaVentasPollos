 <?php 
 // Actualizar datos
    require_once ("../../../../datos/db/connect.php"); 
    
    $nombrearchivo = 'sinfoto.png';  
    
 	$idemp    = $_POST['_codigo'];
    
	 $stmt = DBSTART::abrirDB()->prepare(
	 	"UPDATE c_mercaderia SET ruta = '$nombrearchivo', fechaeliminacion=now() WHERE id_empresa = 1 AND codproducto='$idemp'");
	 $stmt->execute();

	 if ( $stmt->execute() ){

	 echo '<div class="alert alert-success">
                <b>Imagen Eliminada!</b>
            </div>';
            }else{
                echo '<div class="alert alert-warning">
                <b>Error al eliminar!</b>
            </div>';
            }
    