<?php
 session_start();
 if(isset($_SESSION["acceso"]))  {        
	require_once ("../head_unico.php");
?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Inventario
        <small>Confirme subida de compra</small>
      </h1>

    </section>

<section class="content">
<div class="row"><br>
  <div class="col-md-12">
<?php // Actualizar datos
 if (isset($_POST['delete'])) {
    $arg    = $_POST['_compra'];

     $stmt = $db->prepare("SELECT * FROM c_compra_detalle WHERE ncompra='$arg' and estado= 'I'");
     $stmt->execute();
     $all_stmt = $stmt->fetchAll();   
     
     foreach((array) $all_stmt as $trend) {
        $la_compra      = $trend['ncompra'];
        $el_proveedor   = $trend['id_prov_cd'];
        $la_categoria   = $trend['idcat'];
        $el_codigo      = $trend['codigo'];
        $el_nombre      = $trend['descripcion'];
        $la_cantidad    = $trend['cantidad']; 
        $el_pc          = $trend['precio_compra'];
        $el_pv          = $trend['precio_venta'];
        
        $la_fecha       = $trend['fechac'];
        $la_ruta        = $trend['ruta'];        
        
        // BUSCAR
         $buscar = $db->prepare("SELECT * FROM c_mercaderia WHERE codproducto='$el_codigo' AND estado='A'");
         $buscar->execute();
         $cant_buscar = $buscar->rowCount();
         
         if($cant_buscar == 0) {
            $ins = $db->prepare("INSERT INTO c_mercaderia (ncompra, id_proveedor, categoria, codproducto, nombreproducto, precio_compra, 
            precio_venta, existencia, ruta, fechacompra, estado, existe, entrada) VALUES 
            ('$la_compra', '$el_proveedor', '$la_categoria','$el_codigo', '$el_nombre', '$el_pc', '$el_pv','$la_cantidad','$la_ruta','$la_fecha', 'A','$la_cantidad','$la_cantidad')");
            $ins->execute();
            
            
         }else{
            $act = $db->prepare("UPDATE c_mercaderia SET existencia=existencia+'$la_cantidad' WHERE codproducto='$el_codigo'");
            $act->execute();
         }
         
         $subido = $db->prepare("UPDATE c_compra SET subido='SI' WHERE ncompra='$la_compra'");
         $subido->execute();
        
    } // fin foreach
    
    echo '<div class="alert alert-success">
                <b><i class="fa fa-check"></i> La compra se ha ingresado correctamente.</b>
          </div>';
}  // fin formulario

    $laid = isset($_GET['cid']) ? $_GET['cid'] : 0;

    $sql = $db->prepare("SELECT * FROM c_compra WHERE idc_compra = ? AND subido='NO'");
    $sql->execute(array($laid));
    $rows = $sql->fetchAll(PDO::FETCH_ASSOC);
    $cant = $sql->rowCount();

    foreach ($rows as $key => $value) {
      $id         = $value['idc_compra'];
      $compra     = $value['ncompra'];
    }
 ?>
  </div>
  <div class="col-md-6">
    <div class="box box-danger">
      <div class="box-header with-border">
          <h3 class="box-title"><b>Formulario de confirmación</b></h3>
          <p>Todos los productos de esta compra, estaran disponibles en el inventario luego de Confirmar la subida.</p>
      </div>
      <form method="POST" class="form-horizontal">
      <input type="hidden" name="upd_id" value="<?php echo $id ?>" />
        <div class="box-body">
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">FACTURA DE COMPRA</label>
            <div class="col-sm-8">
              <input type="text" name="_compra" value="<?php echo @$compra?>" class="form-control" readonly="" />
            </div>
          </div>

        </div>
        <div class="box-footer">
          <a href="../in.php?cid=mercaderia/mercaderia" class="btn bg-navy"><i class="fa fa-reply"></i> Volver</a>
          
          <?php if ($cant > 0) { ?>
          <button type="submit" class="btn btn-danger pull-right" name="delete"><i class="fa fa-check-square-o"></i> Confirmar subida de compra al stock!</button>
          <?php } ?>
                  </div>
      </form><br /><br />
</div>
</div>
</div>
</section>
</div>
<?php require_once ("../foot_unico.php");
}else{
    session_unset();
    session_destroy();
    header('Location:  ../../../../index.php');
}?>