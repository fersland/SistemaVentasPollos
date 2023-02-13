<?php
    session_start();
 if(isset($_SESSION["correo"]))  {    
    $empresa = $_SESSION['id_empresa'];        
	require_once ("../head_unico.php");
	require_once ("../../../../datos/db/connect.php");
	
	if (isset($_REQUEST['cid'])){
		$laid = $_REQUEST['cid'];

		$sql = DBSTART::abrirDB()->prepare("SELECT * FROM c_empresa WHERE id_empresa = '$laid'");
		$sql->execute();
		$rows = $sql->fetchAll(PDO::FETCH_ASSOC); 

		foreach ($rows as $key => $value) {
			$id          = $value['id_empresa'];
			$nombres     = $value['nom_empresa'];            
		}
} ?>
<div id="page-wrapper">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb" style="float: right; margin-top:15px">
    <li class="breadcrumb-item">Config. y Administración</li>
    <li class="breadcrumb-item active">Empresa</li>
    <li class="breadcrumb-item active">Eliminar</li>

  </ol>
</nav>
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-danger" style="margin-top: 10px; height: 110px">
              <h4>Empresa</h4><hr />
              <p style="float: left;">Eliminar Empresa</p>
              <p style="float: right;"><a href="../in.php?cid=empresa/frm_empresa">Volver</a></p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
        	<form method="POST">
        		<div class="form-group">
        			<input type="hidden" name="_id" value="<?php echo $id ?>" />
        			<input type="hidden" name="empresa" value="<?php echo $empresa ?>" />
        		</div>

        		<div class="form-group">
        			<label>Nombre</label>
        			<input type="text" name="_nombres" value="<?php echo $nombres?>" class="form-control" readonly="" />
        		</div>
                
        		<input type="submit" class="btn btn-danger" value="ELIMINAR DATOS AHORA" name="delete" />
        	</form>
<br /><br />
 <?php
 if (isset($_POST['delete'])) {
	require_once ("../../../../controlador/conf.php");

    $id    = $_POST['_id'];
 	$na    = strtoupper($_POST['_nombres']);
    $emp   = $_POST['empresa'];
    
    if ($id == $empresa) {
        echo '<div class="alert alert-danger">
                <b>No puede eliminar esta empresa, la sesión actual corresponde a la que quiere eliminar!</b>
            </div>';
    }else{
    	 $stmt = DBSTART::abrirDB()->prepare("UPDATE c_empresa SET est_empresa= 'I' WHERE id_empresa='$id' AND est_empresa='A'");
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