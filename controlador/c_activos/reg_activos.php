<?php
    require_once ('./'."../../datos/db/connect.php");
  
    $empleado       = htmlspecialchars($_POST['usuario']);
    $proveedor      = htmlspecialchars($_POST['proveedor']);
    $fecha          = htmlspecialchars($_POST['fecha']);
    $nfactura       = htmlspecialchars($_POST['nfactura']);
    $descripcion    = htmlspecialchars($_POST['descripcion']);    
    $valor          = htmlspecialchars($_POST['valor']);
    $estado_f       = htmlspecialchars($_POST['estado_f']);
    $ubicacion      = htmlspecialchars($_POST['ubicacion']);
    $codigo_e       = htmlspecialchars($_POST['codigo_e']);
    $persona        = htmlspecialchars($_POST['persona']);
    $stock          = htmlspecialchars($_POST['stock']);
    $obs            = htmlspecialchars($_POST['obs']);
    $estado         = "A";
    
    // BUSCAR COMPRA REPETIDA DE PROVEEDOR Y NUMERO DE COMPRA
    $stmt = DBSTART::abrirDB()->prepare("SELECT * FROM c_activos WHERE codigo ='$codigo_e' AND estado = 'A'");
    $stmt->execute();
    $cant_stmt = $stmt->rowCount();
    
    if ($cant_stmt != 0 ) {
        echo '<script>
                alert("ERROR, ESTE CODIGO YA LA INGRESO ANTERIORMENTE!!!");
                window.location.href="in.php?cid=activos/frm_activos";
              </script>';
    }else{
   
    $sql = DBSTART::abrirDB()->prepare(
        "INSERT INTO c_activos 
         (id_empresa, id_empleado,proveedor, fecha_adq,numero_factura, descripcion,valor,estado_fisico,ubicacion_fisica,
                codigo,persona_resp,cantidad,observacion, estado)
         VALUES (1,:emp,:pro,:fec,:nfa,:des,:val,:est,:ubi,:cod,:per,:can,:obs,:std)");

                                                      $sql->bindParam(':emp', $empleado,       PDO::PARAM_INT);
                                                      $sql->bindParam(':pro', $proveedor,      PDO::PARAM_STR);
                                                      $sql->bindParam(':fec', $fecha,          PDO::PARAM_STR);                                                      
                                                      $sql->bindParam(':nfa', $nfactura,       PDO::PARAM_STR);
                                                      $sql->bindParam(':des', $descripcion,    PDO::PARAM_STR);
                                                      $sql->bindParam(':val', $valor,          PDO::PARAM_STR);
                                                      $sql->bindParam(':est', $estado_f,       PDO::PARAM_STR);                                                      
                                                      $sql->bindParam(':ubi', $ubicacion,      PDO::PARAM_STR);                                                      
                                                      $sql->bindParam(':cod', $codigo_e,       PDO::PARAM_STR);
                                                      $sql->bindParam(':per', $persona,        PDO::PARAM_STR);
                                                      $sql->bindParam(':can', $stock,          PDO::PARAM_STR);
                                                      $sql->bindParam(':obs', $obs,            PDO::PARAM_STR);
                                                      $sql->bindParam(':std', $estado,         PDO::PARAM_STR);
        if ( $sql->execute() ){
    	       echo '<div class="alert alert-success">
                    <b>Activo Guardado!</b>
                </div>';
                }else{
                    echo '<div class="alert alert-warning">
                    <b>Error al guardar el activo!</b>
                </div>';
                }
    }
?>