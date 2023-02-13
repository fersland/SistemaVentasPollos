<?php
session_start();
    if(isset($_SESSION["correo"]))  {
	require_once ("../head_unico.php");
	require_once ("../../../../datos/db/connect.php");
	
	if (isset($_REQUEST['cid'])){
		$laid = $_REQUEST['cid'];

		$sql = DBSTART::abrirDB()->prepare("SELECT * FROM c_mercaderia WHERE codproducto = '$laid'");
		$sql->execute();
		$rows = $sql->fetchAll(PDO::FETCH_ASSOC);

		foreach ($rows as $key => $value) {
			$codigo      = $value['codproducto'];
            $emp         = $value['id_empresa'];
            $ruta        = $value['ruta'];
		}
} ?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-warning" style="margin-top: 10px; height: 110px">
              <h4>Imagen</h4><hr />
              <p style="float: left;">Actualizar imagen del Producto</p>
              <p style="float: right;"><a href="../in.php?cid=imagen_producto/listar_productos">Volver</a></p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">

        	<form method="POST" enctype="multipart/form-data">
        		<div class="form-group">
        			<label>Nueva Imagen</label>
        			<input type="hidden" name="_codigo" value="<?php echo $codigo ?>" />
        		</div>

        		<input type="file" name="img" class="form-control" /><br />

        		<input type="submit" class="btn btn-info" value="ACTUALIZAR IMAGEN AHORA" name="update" />
        	</form>
 <?php 
     // Actualizar datos
     if (isset($_POST['update'])) {
        require_once ('../../../../controlador/c_mercaderia_imagen/act_imagen.php');
      }
 ?>

     	</div>
        
        <div class="col-lg-6">
            <label>Imagen Actual</label><br />
            <img src="../../../../inicializador/img/<?php echo $ruta ?>" style="border: 3px solid gray; padding: 5px; width: 60%" />
        </div>
	</div>
</div>
<br /><br /><br />
<?php 

require_once ("../foot_unico.php");

}else{
    session_unset();
    session_destroy();
    header('Location:  ../../../../index.php');
} 

 ?>