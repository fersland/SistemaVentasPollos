<?php 
	require_once ('./'."../../datos/db/connect.php");

	$env = new DBSTART;
	$cc = $env->abrirDB();
    $fecha = date('Y-m-d');

        $valor 	= htmlspecialchars($_POST['valor']);
        $pago   = htmlspecialchars($_POST['pago']);
        $estado = 'A';
        
        if ( $pago > $valor ){
            echo '<div class="alert alert-danger">
                    <b>El pago no debe ser mayor a lo recaudado durante el d&iacute;a!</b>
                  </div>';
        }else{
            
            $utilidad = 0;
            $utilidad = $valor - $pago;
            
            $select = $cc->prepare("SELECT * FROM c_caja WHERE fecha='$fecha' ");
            $select->execute();
            $rowcount = $select->rowCount();
            $fechall = $select->fetchAll(PDO::FETCH_ASSOC);
            foreach((array) $fechall as $asing){
                $n = $asing['veces'];
            }
            
            if ($rowcount == 0 || $rowcount == '') {
                $nn = 1;
            }else{
                $nn = $n + 1;
            }
            
            $ins = $cc->prepare("INSERT INTO c_caja (fecha, valor, empleado, utilidad, estado, disponibilidad, veces) 
                                             VALUES ('$fecha', '$valor', '$pago', '$utilidad', 1, 'CERRADA', '$nn') ");			
                    if ( $ins -> execute() ){
                        
                        $cerrar = $cc->prepare("UPDATE c_empresa SET fcaja='$fecha', scaja='NO', caja_abierta='NO'");
                        $cerrar->execute();
                        
                        $contado = $cc->prepare("UPDATE c_venta SET contado='SI'");
                        $contado->execute();
                        
                        echo '<script> 
                                alert("La caja ha sido cerrada");
                                window.location.href = "../../init/app/in.php?cid=dashboard/init";
                              </script>';
                    }else{
                        echo '<div class="alert alert-danger">
                                <b>Error al cerrar la caja!</b>
                              </div>';
                    } 
        }