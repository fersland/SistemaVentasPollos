<?php

    session_start();  
 if(isset($_SESSION["correo"]))  { 
        
	require_once ("../head_unico.php");
	require_once ("../../../../datos/db/connect.php");
	
	if (isset($_REQUEST['cid'])){
		$laid = $_REQUEST['cid'];

		$sql = DBSTART::abrirDB()->prepare("SELECT * FROM c_mercaderia WHERE idp = '$laid'");
		$sql->execute();
		$rows = $sql->fetchAll(PDO::FETCH_ASSOC);

		foreach ($rows as $key => $value) {
			$id          = $value['idp'];
			$empresa      = $value['id_empresa'];
			$nombres     = $value['nombreproducto'];
		}
} ?>
<div id="page-wrapper">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb" style="float: right; margin-top:15px">
    <li class="breadcrumb-item active">Mercaderia</li>
    <li class="breadcrumb-item">Eliminar</li>
  </ol>
</nav>
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-danger" style="margin-top: 10px; height: 110px">
              <h4>Mercaderia</h4><hr />
              <p style="float: left;">Eliminar producto</p>
              <p style="float: right;"><a href="../in.php?cid=mercaderia/frm_mercaderia">Volver</a></p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
        	<form method="POST">
        		<div class="form-group">
        			<input type="hidden" name="_empresa" value="<?php echo $empresa?>" class="form-control" />
        		</div>

        		<div class="form-group">
        			<label>Código</label>
        			<input type="text" name="_codigo" value="<?php echo $id?>" class="form-control" />
        		</div>
                
                <div class="form-group">
        			<label>Nombre producto</label>
        			<input type="text" name="_nombres" value="<?php echo $nombres?>" class="form-control" />
        		</div>

        		<input type="submit" class="btn btn-info" value="ELIMINAR DATO AHORA" name="delete" />
        	</form>
<br />
 <?php 
 // Actualizar datos
 if (isset($_POST['delete'])) {
 	//require_once ("../../../../controlador/c_categorias/act_categoria.php");

     $em       = $_POST['_empresa'];
     $cod       = $_POST['_codigo'];
     $na       = $_POST['_nombres'];

	 $stmt = DBSTART::abrirDB()->prepare(
	 	"UPDATE c_mercaderia SET fechaeliminacion = now(), estado = 'I' WHERE idp='$cod'");
	 
     
     if ( $stmt->execute() ){

	 echo '<div class="alert alert-success">
                <b>Dato eliminado con exito!</b>
            </div>';
            }else{
                echo '<div class="alert alert-warning">
                <b>Error al eliminar el dato!</b>
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