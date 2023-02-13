<?php
 session_start();
 if(isset($_SESSION["acceso"])) {   
	require_once ('./'."../head_unico.php");
?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>Compras / <b>Editar Productos de la Compra</b></h1>
      <ol class="breadcrumb">
        <li><a href="../in.php?cid=dashboard/init"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Compras</a></li>
        <li class="active"><a href="#">Editar Productos de la Compra</a></li>
      </ol>
    </section>
<section class="content">
<div class="row"><br />
  <div class="col-md-12">
<?php // Actualizar datos
 if (isset($_POST['update'])) {
    $idcompra    = htmlspecialchars($_POST['_idventa']);
    $nvent    	 = htmlspecialchars($_POST['_nventa']);
    $nexistencia = htmlspecialchars($_POST['cantidadstock']);
    $code    	 = htmlspecialchars($_POST['codi']);
    $desco = htmlspecialchars($_POST['_desc']);
    
    $elprecio_compra = htmlspecialchars($_POST['_pc']);
    $elprecio_venta = htmlspecialchars($_POST['_pv']);
 
    // Actualizar el stock en mercaderia
    $importe_final = $elprecio_compra * $nexistencia;
    $stmt = $db->prepare("UPDATE c_compra_detalle SET
                            codigo='$code',
                            descripcion='$desco',
                            cantidad='$nexistencia', 
                            precio_compra='$elprecio_compra',
                            precio_venta='$elprecio_venta', 
                            importe='$importe_final' 
                            
                          WHERE idcompra='$idcompra'");
    IF ($stmt->execute()){
                    
        echo '<script type="text/javascript">
                alert("Datos Actualizados!!");
                window.location.href = "../in.php?cid=compras/frm_compras_ingreso";
              </script>';
    }else{
                    echo '<div class="alert alert-warning">
    	                       <b>Error al editar la informacion!</b></div>';
    	            }
}

    $laid = isset($_GET['cid']) ? $_GET['cid'] : 0;

		$sql = $db->prepare("SELECT * FROM c_compra_detalle WHERE idcompra = '$laid'");
		$sql->execute();
		$rows = $sql->fetchAll(PDO::FETCH_ASSOC);

		foreach ($rows as $key => $value) {
			$idv         = $value['idcompra'];
            $nventa      = $value['ncompra'];
			$empresa     = $value['id_empresa'];
            $cod         = $value['codigo'];
            $cant        = $value['cantidad'];
            $descripci = $value['descripcion'];
            $pc = $value['precio_compra'];
            $pv = $value['precio_venta'];
		}
?>
  </div>
    <div class="col-md-6">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Precaución al cambiar los datos del Producto</h3>
            </div>
            <form method="POST" class="form-horizontal">
                
                
                <div class="box-body">
                <div class="form-group">
        			<input type="hidden" name="_idventa" value="<?php echo $idv ?>" />
                    <input type="hidden" name="_nventa" value="<?php echo $nventa ?>" />
        		</div>
                <div class="form-group">
        			<label class="col-sm-4">Código</label>
        			<div class="col-sm-8">
                        <input type="text" name="codi" value="<?php echo $cod; ?>" class="form-control" />
                    </div>
        		</div>
                
                <div class="form-group">
        			<label class="col-sm-4">Descripción</label>
        			<div class="col-sm-8">
                        <input type="text" name="_desc" value="<?php echo $descripci; ?>" class="form-control" />
                    </div>
        		</div>
                
                <div class="form-group">
        			<label class="col-sm-4">Precio Compra</label>
        			<div class="col-sm-8">
                        <input type="text" name="_pc" value="<?php echo $pc; ?>" class="form-control" />
                    </div>
        		</div>
                
                <div class="form-group">
        			<label class="col-sm-4">Precio Venta</label>
        			<div class="col-sm-8">
                        <input type="text" name="_pv" value="<?php echo $pv; ?>" class="form-control" />
                    </div>
        		</div>
                
                <div class="form-group">
        			<label class="col-sm-4">Cantidad</label>
        			<div class="col-sm-8">
                        <input type="number" step="0.01" name="cantidadstock" value="<?php echo $cant; ?>" class="form-control" />
                    </div>
        		</div>
                
                
            </div>
                <!-- /.box-body -->
              <div class="box-footer">
                <a href="../in.php?cid=compras/frm_compras_ingreso" class="btn bg-navy">Volver</a>
                <button type="reset" class="btn btn-default">Cancelar</button>
                <button type="submit" class="btn btn-warning pull-right" name="update">ACTUALIZAR DATOS AHORA</button>
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
}?>