<?php
	require_once ('../../../../datos/db/connect.php');

    
            $ids      = $_POST['_id'];
            $na       = $_POST['_nombres'];
            $des      = $_POST['_desc'];
            
            if ($na != "" && $des != "") {
        
        	 $stmt = DBSTART::abrirDB()->prepare(
        	 	"UPDATE c_mercaderia_lineas SET nombrelinea='$na', observacion='$des', fechamodificacion=now() 
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
          }else{
            echo '<div class="alert alert-warning">
                            <b>No puede dejar campos vacios!</b>
                          </div>';
          }