<?php 
	require_once ('./'."../../datos/db/connect.php");
    $visit = $_SESSION["rol"];
    
        $ruc   	        = htmlspecialchars($_POST['ruc']);
        $nombres   	    = htmlspecialchars($_POST['nombres']);
        $press          = htmlspecialchars($_POST['press']);
        $dir            = htmlspecialchars($_POST['dir']);
        $tel            = htmlspecialchars($_POST['tel']);
        $correo   	    = htmlspecialchars($_POST['correo']);
        
        $pais   	    = htmlspecialchars($_POST['pais']);
        $ciudad   	    = htmlspecialchars($_POST['ciudad']);
        $currency 	    = htmlspecialchars($_POST['moneda']);
        $estado         = 'A';
        
        if ($visit == 'Visitante') {
            echo  '<script>window.location.href = "in.php?cid=empresa/frm_empresa"</script>';
        }else{
        
            $statement = DBSTART::abrirDB()->prepare("UPDATE c_empresa SET
                                                                            ruc_empresa='$ruc', 
                                                                            nom_empresa='$nombres', 
                                                                            nom_empresa_presenta='$press', 
                                                                            direcc_empresa='$dir', 
                                                                            telf_empresa='$tel', 
                                                                            mail_empresa='$correo',
                                                                            pais = '$pais',
                                                                            ciudad = '$ciudad',
                                                                            money = '$currency'
                                                                            
                                                                            WHERE id_empresa = 1");
            
            $statement->execute();
            echo  '<script>
                            alert("Los datos han sido actualizado con exito!");
                            window.location.href = "in.php?cid=empresa/frm_empresa"</script>';
        }