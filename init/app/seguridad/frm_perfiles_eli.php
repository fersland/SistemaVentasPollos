<?php
 session_start();
 if(isset($_SESSION["acceso"]))  {
	require_once ("../head_unico.php");
?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Seguridad
        <small>Perfil Eliminar</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="../in.php?cid=dashboard/init"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Seguridad</a></li>
        <li><a href="#">Perfil</a></li>
        <li class="active"><a href="#">Perfil Eliminar</a></li>
      </ol>
    </section>

<!-- Main content -->
<section class="content">
<div class="row"><br>
     <div class="col-md-12">
<?php
 // Actualizar datos
 if (isset($_POST['update'])) {

    $upd_id        = $_POST['p_id'];
    $upd_nom       = strtoupper($_POST['nombre']);
 	$upd_obs       = strtoupper($_POST['obs']);
 	
 	if ($upd_id == $session_acceso) {
 	    echo '<div class="alert alert-danger">
                <b>No puede eliminar el perfil de usuario que est&aacute; activo!</b>
            </div>';
 	    
 	}else{
    	 $stmt = $db->prepare(
                        	 	             "UPDATE c_roles 
                                                SET 
                                                	estado = 'I',
                                                    fechaeliminacion = now()
                                                WHERE idrol='$upd_id' ");
    	 if ($stmt->execute() ) {
    	   echo '<div class="alert alert-success">
                    <b>Perfil eliminado!</b>
                </div>';
    	 }else{
    	   echo '<div class="alert alert-danger">
                    <b>Error al eliminar perfil!</b>
                </div>';
    	 }
 	}
           
}

if (isset($_REQUEST['cid'])){
		$laid = $_REQUEST['cid'];

		$sql = $db->prepare("SELECT * FROM c_roles WHERE idrol = '$laid'");
		$sql->execute();
		$rows = $sql->fetchAll(PDO::FETCH_ASSOC);

		foreach ($rows as $key => $value) {
			$cid_id         = $value['idrol'];
			$cid_nom        = $value['nombrerol'];
            $cid_obs        = $value['observacion'];
		}
}
 ?>
     </div>
 
    <div class="col-md-6">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Eliminar datos del Perfil</h3>
            </div>

            <form method="POST" class="form-horizontal">
                <div class="box-body">
                    <input type="hidden" name="p_id" value="<?php echo $cid_id ?>" />
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Nombre Perfil (*)</label>

                  <div class="col-sm-8">
                    <input type="text" name="nombre" value="<?php echo $cid_nom ?>" class="form-control" readonly />
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Observación</label>

                  <div class="col-sm-8">
                    <input type="text" name="obs" value="<?php echo $cid_obs ?>" class="form-control" readonly />
                  </div>
                </div>
            </div>
              <div class="box-footer">
                <a href="../in.php?cid=seguridad/profile" class="btn bg-navy">Volver</a>
                <button type="reset" class="btn btn-default">Cancelar</button>
                <button type="submit" class="btn btn-danger pull-right" name="update">Eliminar Datos</button>
              </div>
            </form>
		</div>
	</div>
</div>
</section>
</div>

<?php 
require_once ("../foot_unico.php");

}else{
    session_unset();
    session_destroy();
    header('Location:  ../../../index.php');
} 

 ?>