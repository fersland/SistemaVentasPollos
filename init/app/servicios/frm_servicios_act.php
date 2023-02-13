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
			$get_id          = $value['id_servicios'];
			$get_empresa      = $value['id_empresa'];
			$get_nombres     = $value['nombre_servicio'];
            $get_obs     = $value['observacion'];
		}
} ?>
<div id="page-wrapper">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb" style="float: right; margin-top:15px">
    <li class="breadcrumb-item">Config. y Administración</li>
    <li class="breadcrumb-item active">Servicios</li>
    <li class="breadcrumb-item active">Actualizar</li>

  </ol>
</nav>
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-warning" style="margin-top: 10px; height: 110px">
              <h4>Servicios</h4><hr />
              <p style="float: left;">Actualizar datos de servicios</p>
              <p style="float: right;"><a href="../in.php?cid=servicios/frm_servicios">Volver</a></p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
        	<form method="POST">
        		<div class="form-group">
        			<input type="hidden" name="_id" value="<?php echo $get_id ?>" />
        			<input type="hidden" name="_empresa" value="<?php echo $get_empresa?>" class="form-control" />
        		</div>

        		<div class="form-group">
        			<label>Nombre</label>
        			<input type="text" name="_nombres" value="<?php echo $get_nombres?>" class="form-control" />
        		</div>
                
                <div class="form-group">
        			<label>Observación</label>
        			<input type="text" name="_obs" value="<?php echo $get_obs?>" class="form-control" />
        		</div>

        		<input type="submit" class="btn btn-info" value="ACTUALIZAR DATOS AHORA" name="update" />
        	</form>
<br />
 <?php 
 // Actualizar datos
 if (isset($_POST['update'])) {
 	//require_once ("../../../../controlador/c_categorias/act_categoria.php");
	require_once ("../../../../controlador/conf.php");

    $p_id    = $_POST['_id'];
 	$p_em       = $_POST['_empresa'];
 	$p_na       = strtoupper($_POST['_nombres']);
    $p_ob       = strtoupper($_POST['_obs']);

	 $stmt = DBSTART::abrirDB()->prepare(
	 	"UPDATE c_servicios
            SET nombre_servicio= '$p_na', observacion='$p_ob', fecha_modificacion=now() WHERE id_servicios='$p_id' and id_empresa = '$p_em'");
	 $stmt->execute();
     //header('Location: categoria/frm_categoria_act.php?cid='.$id);
     

	 echo '<div class="alert alert-success">
                <b>Cambios guardados!</b>
            </div>';
           
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