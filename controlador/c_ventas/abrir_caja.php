<?php
    date_default_timezone_set('America/Guayaquil');
        require_once ('./'."../../datos/db/connect.php");

        $env = new DBSTART;
        $cc = $env->abrirDB();
        $lafecha = date('Y-m-d');
        

        /*if ($codigo == "") { // Si no se ha especificado el código de producto retornará error
            echo '<script>
                        alert("Debe escoger el producto!");
                        window.location.href = "../../init/app/ventas/ord.php?cid='.$numorden.'";
                  </script>';
        }else{ // Si ha especificado el código.. continua
        if ($cantidad > $stock) {
            echo '<script>
                        alert("No puede llevar mas del Stock del producto!");
                        window.location.href = "../../init/app/ventas/ord.php?cid='.$numorden.'";
                  </script>';
        }else{ // SI LA CANTIDAD ES CORRECTA*/

            /*************************************************************/
            /*******  P R O C E S O    I N G R E S O    D E    C A R R I T O  *************/
            /*************************************************************/
            
            $s = $cc->prepare("SELECT MAX(num_secuencial_orden) as dato FROM c_secuencial");
            $s->execute();
            $all = $s->fetchAll(PDO::FETCH_ASSOC);
        
            foreach ($all as $key => $value) {
                $secuencial = $value['dato'];
        
                if($secuencial == 0 || $secuencial == ''){
                    $nn = 1;
                }else{
                    $nn = $secuencial + 1;
                }
            }

            $sql = $cc->prepare("UPDATE c_empresa SET fcaja='$lafecha', scaja='SI', caja_abierta='SI'");
            $sql->execute();
            header('Location: ../../init/app/ventas/ord.php?cid='.$nn);

        //} // HASTA AQUI TODO CORRECTO 