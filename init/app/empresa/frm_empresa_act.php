<?php
session_start();  
 if(isset($_SESSION["correo"]))  { 
	require_once ("../head_unico.php");
	require_once ("../../../../datos/db/connect.php");
	
	if (isset($_REQUEST['cid'])){
		$laid = $_REQUEST['cid'];

		$sql = DBSTART::abrirDB()->prepare("SELECT * FROM c_empresa WHERE id_empresa = '$laid' and est_empresa='A'");
		$sql->execute();
		$rows = $sql->fetchAll(PDO::FETCH_ASSOC);

		foreach ($rows as $key => $value) {
			$id          = $value['id_empresa'];
            $ciudad      = $value['id_ciudad'];
            $provincia   = $value['id_provincia'];
            $ruc         = $value['ruc_empresa'];
			$nombres     = $value['nom_empresa'];
			$direccion   = $value['direcc_empresa'];
			$telefono    = $value['telf_empresa'];
            $correo      = $value['mail_empresa'];
		}
} ?>

<?php
    $prov = DBSTART::abrirDB()->prepare("SELECT * FROM c_provincia ORDER BY provincia");
    try {
        $prov->execute();
        $results_prov = $prov->fetchAll();
    } catch (Exception $ex) {
        echo($ex->getMessage());
    }
?>

<?php
    $prov2 = DBSTART::abrirDB()->prepare("SELECT * FROM c_provincia WHERE id_provincia = '$provincia' ORDER BY provincia");
    try {
        $prov2->execute();
        $results_prov2 = $prov2->fetchAll();
        
        foreach((array) $results_prov2 as $lapro) {
            $idpro = $lapro['id_provincia'];
            $npro = $lapro['provincia'];
        }
    } catch (Exception $ex) {
        echo($ex->getMessage());
    }
?>

<?php
    $ciu = DBSTART::abrirDB()->prepare("SELECT * FROM c_ciudad ORDER BY ciudad");
    try {
        $ciu->execute();
        $results_ciu = $ciu->fetchAll();
    } catch (Exception $ex) {
        echo($ex->getMessage());
    }
?>


<?php
    $ciu2 = DBSTART::abrirDB()->prepare("SELECT * FROM c_ciudad WHERE id_ciudad='$ciudad'");
    try {
        $ciu2->execute();
        $results_ciu2 = $ciu2->fetchAll();
        
        foreach((array) $results_ciu2 as $laciudad) {
            $idciu = $laciudad['id_ciudad'];
            $nciu = $laciudad['ciudad'];
        }
    } catch (Exception $ex) {
        echo($ex->getMessage());
    }
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-warning" style="margin-top: 10px; height: 110px">
              <h4>Empresa</h4><hr>
              <p style="float: left;">Actualizar datos de la Empresa</p>
              <p style="float: right;"><a href="../in.php?cid=empresa/frm_empresa">Volver</a></p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
        	<form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
            
        		<div class="form-group">
        			<label>Provincia</label>
                    <select name="miprovincia" id="miprovincia" class="form-control">                    
                        <option value="<?php echo $idpro ?>" style="background: lightgreen;"><?php echo $npro?></option>
                        <?php
	                       foreach ( (array) $results_prov as $content ) { ?>
                            <option value="<?php echo $content['id_provincia']?>"><?php echo $content['provincia']?></option>
                        <?php } ?>                    
                    </select>
        		</div>
                <div class="form-group">
        			<label>Ciudad</label>
                    <select name="miciudad" class="form-control">                    
                        <option value="<?php echo $idciu ?>" style="background: lightgreen;"><?php echo $nciu?></option>
                        <?php
	                       foreach ( (array) $results_ciu as $content2 ) { ?>
                            <option value="<?php echo $content2['id_ciudad']?>"><?php echo $content2['ciudad']?></option>
                        <?php } ?>                    
                    </select>
        		</div>
                <div class="form-group">
        			<label>Ruc</label>
        			<input type="hidden" name="_id" value="<?php echo $id ?>">
        			<input type="text" name="_ruc" value="<?php echo $ruc?>" class="form-control" onkeypress="return soloNumeros(event)">
        		</div>

        		<div class="form-group">
        			<label>Nombres Empresa</label>
        			<input type="text" onkeypress="return caracteres(event)" name="_nombres" value="<?php echo $nombres?>" class="form-control">
        		</div>

        		<div class="form-group">
        			<label>Dirección</label>
        			<input type="text"  name="_direccion" value="<?php echo $direccion?>" class="form-control">
        		</div>

        		<div class="form-group">
        			<label>Teléfono</label>
        			<input type="text" name="_telefono" value="<?php echo $telefono?>" class="form-control" onkeypress="return soloNumeros(event)">
        		</div>
                
                <div class="form-group">
        			<label>Correo Electrónico</label>
        			<input type="text" name="_correo" value="<?php echo $correo?>" class="form-control">
        		</div>

        		<input type="submit" class="btn btn-info" value="ACTUALIZAR DATOS AHORA" name="update">
        	</form>

 <?php 
 // Actualizar datos
 if (isset($_POST['update'])) {
 	$idemp    = $_POST['_id'];
    $prov       = $_POST['miprovincia'];
    $ciud       = $_POST['miciudad'];
 	$ru       = $_POST['_ruc'];
 	$na       = strtoupper($_POST['_nombres']);
 	$di       = strtoupper($_POST['_direccion']);
 	$te       = $_POST['_telefono'];
    $co       = $_POST['_correo'];

	 $stmt = DBSTART::abrirDB()->prepare(
	 	"UPDATE c_empresa SET id_provincia='$prov', id_ciudad= '$ciud', ruc_empresa = '$ru', nom_empresa='$na', direcc_empresa='$di', telf_empresa='$te', mail_empresa='$co' WHERE id_empresa='$idemp'");
	 $stmt->execute();

	 echo '<script>window.history.back();</script>';
}
 ?>
     	</div>
	</div>
</div><br /><br /><br />

<?php 

require_once ("../foot_unico.php");

}else{
    session_unset();
    session_destroy();
    header('Location:  ../../../../index.php');
} 

 ?>