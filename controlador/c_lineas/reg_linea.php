e<?php
    require_once ("../../../controlador/conf.php");
    require_once ("../../../datos/db/connect.php");
    
      $empresa = $_POST['empresa'];
      $nombre = strtoupper(SEG::clean($_POST['_nombres']));
      $desc = SEG::clean($_POST['_desc']);
    
	  $sql = DBSTART::abrirDB()->prepare("SELECT * FROM c_mercaderia_lineas WHERE nombrelinea = '$nombre' AND estado = 'A'");
	  $sql->execute();
	  $cant = $sql->rowCount();

	  if ( $cant == 0 ) {
	  	$insert = DBSTART::abrirDB()->prepare("INSERT INTO c_mercaderia_lineas (id_empresa, nombrelinea, observacion, estado) VALUES (?,?,?,'A')");
	  	$insert->bindParam(1, $empresa,  PDO::PARAM_INT);
        $insert->bindParam(2, $nombre,  PDO::PARAM_STR);
	  	$insert->bindParam(3, $desc,    PDO::PARAM_STR);
	  	
        if ( $insert->execute() ){
    	 echo '<div class="alert alert-success">
                    <b>Linea registrada!</b>
               </div>';
        }else{
                echo '<div class="alert alert-danger">
                <b>Error al guardar la línea!</b>
                </div>';
                }
    }else{
        echo '<div class="alert alert-danger">
                <b>Error, la linea ingresada ya fue registrada anteriormente!</b>
                </div>';
    }