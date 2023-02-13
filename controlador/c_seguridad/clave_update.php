<?php
    require_once ("../../datos/db/connect.php");
    require_once ("../../controlador/conf.php");
    

    if (isset($_POST['register'])) {
    	$id = SEG::clean($_POST['_iduser']);
        $nueva = $_POST["_nueva"];
        $rnueva = $_POST["_rnueva"];        
        $actual = $_POST["_actual"];

        // Verificar si la clave actual indicada es correcta
        $consulta = DBSTART::abrirDB()->prepare("SELECT * FROM c_usuarios WHERE id_usuario = '$id' AND passw = '$actual'");
        $consulta->execute();
        $cc = $consulta->rowCount();
        
        if ( $cc > 0 ) { 
            if ( $nueva == $rnueva ) {
                // Actualizar la clave actual
                $new = DBSTART::abrirDB()->prepare("UPDATE c_usuarios SET passw = '$rnueva' WHERE id_usuario = '$id' AND id_empresa='$empresa'");
                
                if ($new->execute()) {
                    echo '<script>
                            alert("Su clave a sido cambiada con exito!");
                            window.history.back();
                          </script>';
                }else{
                    echo '<script>
                        alert("Error al cambiar su clave!");
                        window.history.back();
                      </script>';
                }
            }else{
                    echo '<script>
                        alert("Las claves no coinciden, vuelva a intentarlo!");
                        window.history.back();
                      </script>';
                }
        }else{
            echo '<script>
                    alert("La clave que indico como actual, no coincide con la de nuestra base de datos!");
                    window.history.back();
                  </script>';
            }
}