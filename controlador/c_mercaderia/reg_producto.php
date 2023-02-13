<?php
    require_once ("../../datos/db/connect.php");
  
    $codigo   = htmlspecialchars($_POST['codigo']);
    $cant     = htmlspecialchars($_POST['cant']); // Percha
    $stock    = htmlspecialchars($_POST['stock']);
  
    $estado     = "A";
    
    if ($cant == 0 || $cant < 0 || $cant == '') {
        echo '<div class="alert alert-success">
                <b><i class="fa fa-check"></i> Error! Debe especificar la cantidad a abastecer.</b>
            </div>';
           } else{
               
               if ($cant > $stock){
                   echo '<div class="alert alert-danger">
                            <b><i class="fa fa-check"></i> Error! la cantidad no debe suprerar el stock.</b>
                         </div>';
               }else{

                $sql = DBSTART::abrirDB()->prepare("UPDATE c_mercaderia SET existencia = existencia + '$cant' WHERE codproducto='$codigo'");
                if ( $sql->execute() ){
                    // Reducir entradas disponibles del producto
                    $reducir = DBSTART::abrirDB()->prepare("UPDATE c_mercaderia SET entrada=entrada-'$cant' WHERE codproducto='$codigo'");
                    $reducir->execute();
                    
                    echo '<div class="alert alert-success">
                        <b><i class="fa fa-check"></i> Correcto! Inventario abastecido.</b>
                    </div>';
                }else{
                        echo '<div class="alert alert-warning">
                            <b>Error al guardar los cambios!</b>
                        </div>';
                    }            
               }
        }
?>