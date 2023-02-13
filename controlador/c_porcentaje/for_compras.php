<?php

	require_once ('./'."../../datos/db/connect.php");



	$env = new DBSTART;

	$cc = $env->abrirDB();

    

        $pata = htmlspecialchars($_POST['pata']);
        $molleja 	= htmlspecialchars($_POST['molleja']);
        $higado    = htmlspecialchars($_POST['higado']);
        $cinco  = htmlspecialchars($_POST['cinco']);
        $seis  = htmlspecialchars($_POST['seis']);

        $estado = 1;

        

        if ($pata == "") {

            echo '<div class="alert alert-warning">

                <b>Debe asignar un valor de Pata!</b>

            </div>';

        }else{

            $veces = 0;

			$sql = $cc->prepare("UPDATE tablero SET pata=:pata, molleja=:molleja, higado=:higado, de_cinco=:cinco, de_seis=:seis");

			$sql->bindParam(':pata', $pata,     PDO::PARAM_STR);
            $sql->bindParam(':molleja', $molleja,     PDO::PARAM_STR);
            $sql->bindParam(':higado', $higado,     PDO::PARAM_STR);
            $sql->bindParam(':cinco', $cinco,     PDO::PARAM_INT);
            $sql->bindParam(':seis', $seis, 	  PDO::PARAM_INT);

			if ($sql -> execute() ) {

			     echo '<div class="alert alert-success">

                <b>DATOS ACTUALIZADOS!!</b>

            </div>';

                

			}else{

			     echo '<div class="alert alert-danger">

                        <b>Error al registrar!</b>

                       </div>';

			}

    }