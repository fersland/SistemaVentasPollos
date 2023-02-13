<?php

    session_start();  
 if(isset($_SESSION["correo"]))  { 
        
	require_once ("../head_unico.php");
	require_once ("../../../../datos/db/connect.php");
	
	if (isset($_REQUEST['cid'])){
		$laid = $_REQUEST['cid'];

		$sql = DBSTART::abrirDB()->prepare("SELECT * FROM c_servicios WHERE id_servicios = '$laid'");
		$sql->execute();
		$rows = $sql->fetchAll(PDO::FETCH_ASSOC);

		foreach ($rows as $key => $value) {
			$id          = $value['id_servicios'];
			$empresa      = $value['id_empresa'];
			$nombres     = $value['nombre_servicio'];
		}
} ?>
<div id="page-wrapper">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb" style="float: right; margin-top:15px">
    <li class="breadcrumb-item">Config. y Administración</li>
    <li class="breadcrumb-item active">Servicios</li>
    <li class="breadcrumb-item active">Eliminar</li>

  </ol>
</nav>
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-danger" style="margin-top: 10px; height: 110px">
              <h4>Servicios</h4><hr />
              <p style="float: left;">Eliminar Servicio</p>
              <p style="float: right;"><a href="../in.php?cid=servicios/frm_servicios">Volver</a></p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
        	<form method="POST">
        		<div class="form-group">
        			<input type="hidden" name="_id" value="<?php echo $id ?>" />
        			<input type="hidden" name="_empresa" value="<?php echo $empresa?>" class="form-control" />
        		</div>

        		<div class="form-group">
        			<label>Nombre</label>
        			<input type="text" name="_nombres" value="<?php echo $nombres?>" class="form-control" readonly="" />
        		</div>

        		<input type="submit" class="btn btn-danger" value="ELIMINAR DATOS AHORA" name="delete" />
        	</form>
<br /><br />
 <?php 
 // Actualizar datos
 if (isset($_POST['delete'])) {
	require_once ("../../../../controlador/conf.php");

    $p_id    = $_POST['_id'];
 	$em       = $_POST['_empresa'];
 	$na       = strtoupper($_POST['_nombres']);

	 $stmt = DBSTART::abrirDB()->prepare(
	 	"UPDATE c_servicios SET estado= 'I', fecha_eliminacion=now() WHERE id_servicios='$p_id' and id_empresa = '$em' and estado = 'A'");
	 
     if ( $stmt->execute() ){

	 echo '<div class="alert alert-danger">
                <b>Datos eliminados correctamente!</b>
            </div>';
            }else{
                echo '<div class="alert alert-warning">
                <b>Error al guardar los cambios!</b>
            </div>';
            }
}
 ?>
     	</div>
	</div>
</div>




<?php 
require_once ("../foot_unico.php");

}else{
    session_unset();
    session_destroy();
    header('Location:  ../../../../index.php');
} 

 ?>