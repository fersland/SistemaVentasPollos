<?php 
	require_once ('./'."../../datos/db/connect.php");

	$env = new DBSTART;
	$cc = $env->abrirDB();

        $iva 	= htmlspecialchars($_POST['iva']);
        $imp	= htmlspecialchars($_POST['imp']);
        $estado = 'A';
        $actual = htmlspecialchars($_POST['actual']);

        if (isset($_POST['inc'])) {
            $incluye = 'SI';
        }else{
            $incluye = 'NO';
        }

        if ($iva == '' || $iva == 0) { // SI EL IVA ESTA VACIO
            $iva = $actual;
        }else{ // SINO 
            $iva = $iva;
        }
        
        //Consultar el valor de iva actual
        $sql = $cc->prepare("SELECT * FROM c_iva WHERE id_iva = 1");
        $sql->execute();
        $extract = $sql->fetchAll(PDO::FETCH_ASSOC);
        $cant = $sql->rowCount();
        foreach ( (array) $extract as $items ) {
            $val = $items['valor'];
        }
        
        if ( $cant == 0 ){
               if ($iva == "") {
                    echo '<div class="alert alert-danger">
                                <b>Debe asignar el nuevo valor!</b>
                            </div>';
               }else{
                    $ins = $cc->prepare("INSERT INTO c_iva (valor, impuesto, estado) VALUES ('$iva', 2.5, '$estado') ");			
                    if ( $ins -> execute() ){
                        echo '<div class="alert alert-success">
                                <b><i class="fa fa-check"></i> Los valores agregados han sido registrados!</b>
                              </div>';
                    }else{
                        echo '<div class="alert alert-danger">
                                <b>Error al registrar el valor del I.V.A!</b>
                              </div>';
                    }
            }
        }else{
            $sqli = $cc->prepare("UPDATE c_iva SET valor='$iva', impuesto='$imp', incluido='$incluye', fecha_modificacion=now() WHERE estado = 'A' ");			
            if ( $sqli -> execute() ){
                echo '<div class="alert alert-success">
                        <b><i class="fa fa-check"></i> Los valores agregados han sido actualizados!</b>
                    </div>';
            }else{
                echo '<div class="alert alert-danger">
                        <b>Error al actualizar el valor!</b>
                    </div>';
            }   
        }