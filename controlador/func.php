<?php
	//require ("../../../datos/db/connect.php");

        function contadorCliente($cc, $tabla) {
			$sql = $cc->prepare("SELECT * FROM $tabla WHERE estado = 'A'");
			$sql->execute();
			$all = $sql->rowCount();
			
            echo $all;
		}
        
		function contador($cc, $tabla) {
			$sql = $cc->prepare("SELECT * FROM $tabla WHERE estado = 'A'");
			$sql->execute();
			$all = $sql->rowCount();
			
            echo $all;
		}
        
        function contadorI($cc, $tabla) {
			$sql = $cc->prepare("SELECT * FROM $tabla WHERE estado = 'I'");
			$sql->execute();
			$all = $sql->rowCount();
			
            echo $all;
		}

        function contadorA($cc, $tabla,$empresa) {
			$sql = $cc->prepare("SELECT * FROM $tabla WHERE id_empresa = '$empresa' AND estado = 'A'");
			$sql->execute();
			$all = $sql->rowCount();
			
            echo $all;
		}
        
		function contadorMasUno($cc, $tabla, $empresa) {
			$sql = $cc->prepare("SELECT * FROM $tabla WHERE id_empresa = '$empresa' AND estado = 'A'");
			$sql->execute();
			$all = $sql->rowCount();
			
            echo $all += 1;
		}
        
        // Verificar si la empresa existe y esta activa
        function estadoEmpresa($cc, $param) {
            $sql = $cc->prepare("SELECT * FROM c_empresa WHERE id_empresa = '$param' AND est_empresa = 'A'");
            $sql->execute();
            $count = $sql->rowCount();
            
            echo $count;
        }

		function selectDato($cc, $tabla) {
			$sql = $cc->prepare("SELECT * FROM $tabla");
			$sql->execute();
			$all = $sql->fetchAll(PDO::FETCH_ASSOC);
			foreach ($all as $key => $value) { ?>
			 <option value="<?php echo $value['idclientes'] ?>"><?php echo $value['nombres']. " ". $value['apellidos'] ?></option>
    <?php } }