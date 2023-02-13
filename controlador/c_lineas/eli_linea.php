<?php
	require_once ('../../../../datos/db/connect.php');

    
            $ids      = $_POST['_id'];
        
        	 $stmt = DBSTART::abrirDB()->prepare(
        	 	"UPDATE c_mercaderia_lineas SET fechaeliminacion=now(), estado = 'I' 
                    WHERE id_linea='$ids'");
        	 if ( $stmt->execute() ){
        	   
               header('Location: ../../inicializador/vistas/app/lineas/frm_lineas_act.php');
                   echo '<div class="alert alert-success" id="message">
                            <b>Cambios guardados!</b> <a href="../in.php?cid=lineas/frm_lineas">regresar</a>
                        </div>';
            }else{
                    echo '<div class="alert alert-warning">
                            <b>Error al guardar los cambios!</b>
                          </div>';
                  }
          
          