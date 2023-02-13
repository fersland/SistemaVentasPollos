<?php
    session_start();
    if(isset($_SESSION["correo"]))  {
	require_once ("../../../../datos/db/connect.php");
	require_once ("../head_unico.php");
	
	if (isset($_REQUEST['cid'])) {
		$url = $_REQUEST['cid'];

		$sql = DBSTART::abrirDB()->prepare("SELECT * FROM c_mercaderia WHERE codproducto = '$url' LIMIT 1");
		$sql->execute();
		$rows = $sql->fetchAll(PDO::FETCH_ASSOC);
	}

?>

<div id="page-wrapper">
	<div class="row">
        <div class="col-lg-12">
            <div class="alert alert-warning" style="margin-top: 10px; height: 50px">
              <p style="float:left"><strong>Detalle de Mercaderia</strong></p>
              <p style="float: right"><strong><a href="galeria.php">Volver</a></strong></p>
            </div>
        </div>
    </div>
<div class="card">
	<div class="container-fliud">
		<div class="wrapper row">
			<?php foreach ($rows as $key => $value): ?>
			<div class="preview col-md-6">
				<div class="preview-pic tab-content">
					<div class="tab-pane active" id="pic-1">
						<img src="../../../img/<?php echo $value['ruta'] ?>" style="border: 3px solid gray; padding: 5px; width: 80%" />
					</div>
				</div>
					<!-- DESACTIVADO EL THUMBNAIL DE LA PORTADA -->
						
				</div>
				<div class="details col-md-6"><br><br>
					<strong><h3 class="product-title"><?php echo strtoupper($value['nombreproducto']) ?></h3><br></strong>
					<div class="rating"></div>
						<p class="product-description"><strong>Código : </strong><?php echo $value['codproducto']; ?></p>
						<p class="product-description"><strong>Precio : </strong><?php echo $value['precio_venta']; ?></p>
						<p class="product-description"><strong>Cantidad : </strong><?php echo $value['existencia']; ?></p>
						<p class="product-description"><strong>Descripción : </strong><?php echo $value['nombreproducto']; ?></p>
						<p class="product-description"><strong>Observación : </strong><?php echo $value['observacion']; ?></p>
						<p class="product-description"><strong>Fecha : </strong><?php echo $value['fecharegistro']; ?></p>


<?php if ( $value['existencia'] > 5  ): ?>
    <h4 class="price"><strong>Estado</strong>: <span style="color: green"><strong> SUFICIENTES </strong></span></h4>
    

      
        
        
      <?php elseif ( $value['existencia'] >1 && $value['existencia'] <= 5  ): ?>
        <h4 class="price"><strong>Estado</strong>: <span style="color: orange"><strong> INSUFICIENTES </strong></span></h4>
    
        
      
        
      <?php elseif ( $value['existencia'] == 0 ): ?>
      <h4 class="price"><strong>Estado:</strong> <span style="color: red"> <strong> SIN PRODUCTOS </strong></span></h4>
        
      <?php endif ?>
    
    <br /><br />

			</div>
			</div>
			<?php endforeach ?>
		</div>
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