<?php
session_start();
    if ( $_SESSION['login'] == true)  {
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
            <div class="alert alert-danger" style="margin-top: 10px; height: 110px">
              <h4>Imagen</h4><hr />
              <p style="float: left;">Eliminar imagen del Producto</p>
              <p style="float: right;"><a href="../in.php?cid=imagen_producto/listar_productos">Volver</a></p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">

        	<form method="POST" enctype="multipart/form-data">
        		
        			<label>Imagen Actual</label><br />
                    <img src="../../../../inicializador/img/<?php echo $ruta ?>" style="border: 3px solid gray; padding: 5px; width: 60%" />
                    
        			<input type="hidden" name="_codigo" value="<?php echo $codigo ?>" />
        		

        		<br /><br />

        		<input type="submit" class="btn btn-danger" value="ELIMINAR AHORA" name="delete" />
        	</form><br />
 <?php 
     // Actualizar datos
     if (isset($_POST['delete'])) {
        require_once ('../../../../controlador/c_mercaderia_imagen/eli_imagen.php');
      }
 ?>

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