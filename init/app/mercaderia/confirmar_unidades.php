<?php
 session_start();
 if(isset($_SESSION["acceso"]))  {        
	require_once ("../head_unico.php");
    
    $tp = $db->prepare("SELECT * FROM c_tipo_unidad WHERE estado = 1");
    $tp->execute();
    $alltp = $tp->fetchAll(PDO::FETCH_ASSOC);
    
    $tpr = $db->prepare("SELECT * FROM c_proveedor WHERE estado = 'A'");
    $tpr->execute();
    $alltpr = $tpr->fetchAll(PDO::FETCH_ASSOC);
    
    // Categorias    
    $sql1 = $db->prepare("SELECT * FROM c_categoria WHERE estado = 'A'");
    $sql1->execute();
    $allt1 = $sql1->fetchAll(PDO::FETCH_ASSOC);
    
    // Proveedores
    $sql4 = $db->prepare("SELECT * FROM c_proveedor WHERE estado = 'A' ORDER BY nombreproveedor ASC");
    $sql4->execute();
    $all4 = $sql4->fetchAll(PDO::FETCH_ASSOC);
?>
  
  <div class="content-wrapper">
    <section class="content-header">
      <h1>Inventario /  <b>Cambiar informaci&oacute;n de producto</b></h1>
    </section>

<section class="content">
<div class="row"><br />
<div class="col-md-12">
    <?php if (isset($_POST['reload'])) { require_once ("../../../controlador/c_mercaderia/load_imagen.php"); } ?>
    </div>
  <div class="col-md-12">
<?php // Actualizar datos
 if (isset($_POST['delete'])) {
    $cantidad   = $_POST['_cant'];
    $codd       = $_POST['_codigo'];
    $nombrepr   = htmlspecialchars($_POST['nombrepro']);
    $id_form    = htmlspecialchars($_POST['upd_id']);
    
    $lprove     = htmlspecialchars($_POST['prove']);
    $lcate      = htmlspecialchars($_POST['cate']);
    
    $precio_venta = htmlspecialchars($_POST['precioventa']);
    $pgr = htmlspecialchars($_POST['precio_gr']);
    $plt = htmlspecialchars($_POST['precio_lt']);
    $pkg = htmlspecialchars($_POST['precio_kg']);
    $plb = htmlspecialchars($_POST['precio_lb']);
    

    $tunidad    = htmlspecialchars($_POST['tipo']);
        $cun = 0;
        $cgr = 0;
        $ckg = 0;
        $clb = 0;
        $clt = 0;
    
    if ($tunidad == 2) {
        $ckg = $cantidad;
        $clb = $cantidad * 2.20;
        $cgr = $cantidad * 1000;
        $clt = 0;
        $cun = 0;
    }elseif ($tunidad == 3) {
        $clb = $cantidad;
        $ckg = $cantidad * 0.45;
        $cgr = $cantidad * 453.592;    
        $clt = 0;
        $cun = 0;
    }elseif ($tunidad == 5) {
        $clt = $cantidad;
        $cgr = 0;
        $ckg = 0;
        $clb = 0;
        $cun = 0;
    }elseif ($tunidad == 4) {
        $cgr = $cantidad;
        $ckg = 0;
        $clb = 0;
        $clt = 0;
        $cun = 0;
    }elseif ($tunidad == 1){
        $cun = $cantidad;
        $cgr = 0;
        $ckg = 0;
        $clb = 0;
        $clt = 0;
    }
    
    if ($cantidad >= 0) {

     $stmt = $db->prepare("UPDATE c_mercaderia SET
                                            id_proveedor = '$lprove',
                                            categoria = '$lcate',
                                            nombreproducto='$nombrepr', 
                                            precio_venta='$precio_venta', 
                                            existencia='$cun',
                                            gramo = '$cgr',
                                            litro = '$clt',
                                            libra = '$clb',
                                            kilo = '$ckg',
                                            
                                            pre_gr = '$pgr',
                                            pre_lt = '$plt',
                                            pre_lb = '$plb',
                                            pre_kg = '$pkg',
                                            
                                            tunidad = '$tunidad',
                                            ok = 1
                                            
                                             
                            WHERE idp='$id_form' AND estado='A'");
     if ($stmt->execute()) {
            echo '<div class="alert alert-success">
                    <b><i class="fa fa-check"></i> Actualizado correctamente.</b>
                  </div>';
            }else{
                echo '<div class="alert alert-danger">
                        <b><i class="fa fa-remove"></i> Error al actualizar.</b>
                      </div>';
            }
     }else{
        echo '<div class="alert alert-danger">
                <b><i class="fa fa-remove"></i> Error, debe ingresar un valor mayor e igual a 0</b>
            </div>';
     }
}  // fin formulario


if (isset($_POST['del'])) {
    $id_form = htmlspecialchars($_POST['upd_id']);
    $stmt = $db->prepare("UPDATE c_mercaderia SET estado = 'X' WHERE idp='$id_form' AND estado='A'");
     if ($stmt->execute()) {
            echo '<div class="alert alert-success">
                    <b><i class="fa fa-check"></i> Eliminado correctamente.</b>
                  </div>';
            }else{
                echo '<div class="alert alert-danger">
                        <b><i class="fa fa-remove"></i> Error al Eliminar.</b>
                      </div>';
            }
    
    }

    $laid = isset($_GET['cid']) ? $_GET['cid'] : 0;

    $sql = $db->prepare("SELECT * FROM c_mercaderia WHERE idp = '$laid' AND estado='A'");
    $sql->execute();
    $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $key => $value) {
      $id          = $value['idp'];
      $codi        = $value['codproducto'];
      $nombrep     = $value['nombreproducto'];
      $exis        = $value['existencia'];
      
      $ruta        = $value['ruta'];
      
      $lacat = $value['categoria'];
      $latip = $value['tunidad'];
      $lapro = $value['id_proveedor'];
      
      $priceventa  = $value['precio_venta'];
      $lapkg = $value['pre_kg'];
      $laplt = $value['pre_lt'];
      $laplb = $value['pre_lb'];
      $lapgr = $value['pre_gr'];
      
      $lacgr = $value['gramo'];
      $laclt = $value['litro'];
      $laclb = $value['libra'];
      $lackg = $value['kilo'];
      
    }
 ?>
  </div>
  <div class="col-md-6">
    <div class="box box-danger">
      <div class="box-header with-border">
          <h3 class="box-title">Formulario de confirmación</h3>
      </div>
      <form method="POST" class="form-horizontal">
      <input type="hidden" name="upd_id" value="<?php echo $id ?>" />
        <div class="box-body">
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">CODIGO DE PRODUCTO</label>
            <div class="col-sm-8">
              <input type="text" name="_codigo" value="<?php echo @$codi?>" class="form-control" readonly="" />
            </div>
          </div>
          
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">TIPO DE UNIDAD</label>
            <div class="col-sm-8">
              <select class="form-control" name="tipo">
                <?php foreach((array) $alltp as $val) : 
                if ($val['id'] == $latip ): ?>
                    <option value="<?php echo $val['id']; ?>" selected="" style="background: antiquewhite;"><?php echo $val['nombre']; ?></option>
                    <?php else: ?>
                    <option value="<?php echo $val['id']; ?>" ><?php echo $val['nombre']; ?></option>
                <?php endif;
                    endforeach; ?>
              </select>
            </div>
          </div>
          
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">PROVEEDOR</label>
            <div class="col-sm-8">
              <select class="form-control" name="prove">
                <?php foreach((array) $all4 as $val4) :
                    if ($val4['id_proveedor'] == $lapro ): ?>
                    <option value="<?php echo $val4['id_proveedor']; ?>" selected="" style="background: antiquewhite;"><?php echo $val4['nombreproveedor']; ?></option>
                    <?php else: ?>
                    <option value="<?php echo $val4['id_proveedor']; ?>" ><?php echo $val4['nombreproveedor']; ?></option>
                <?php endif;
                    endforeach; ?>
              </select>
            </div>
          </div>
          
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">TIPO DE CATEGORIA</label>
            <div class="col-sm-8">
              <select class="form-control" name="cate">
                <?php foreach((array) $allt1 as $val1) : 
                if ($val1['id_categoria'] == $lacat ): ?>
                    <option value="<?php echo $val1['id_categoria']; ?>" selected="" style="background: antiquewhite;"><?php echo $val1['nombre']; ?></option>
                    <?php else: ?>
                    <option value="<?php echo $val1['id_categoria']; ?>"><?php echo $val1['nombre']; ?></option>
                <?php endif;
                    endforeach; ?>
              </select>
            </div>
          </div> 
          
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">NOMBRE DE PRODUCTO</label>
            <div class="col-sm-8">
              <input type="text" name="nombrepro" value="<?php echo @$nombrep?>" class="form-control"  />
            </div>
          </div>
          
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">PRECIO UNIDAD</label>
            <div class="col-sm-8">
              <input type="number" step="0.01" name="precioventa" value="<?php echo @$priceventa?>" class="form-control"  />
            </div>
          </div>
          
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">PRECIO KILO</label>
            <div class="col-sm-8">
              <input type="number" step="0.01" name="precio_kg" value="<?php echo @$lapkg?>" class="form-control"  />
            </div>
          </div>
          
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">PRECIO LIBRA</label>
            <div class="col-sm-8">
              <input type="number" step="0.01" name="precio_lb" value="<?php echo @$laplb ?>" class="form-control"  />
            </div>
          </div>
          
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">PRECIO LITRO</label>
            <div class="col-sm-8">
              <input type="number" step="0.01" name="precio_lt" value="<?php echo @$laplt?>" class="form-control"  />
            </div>
          </div>
          
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">PRECIO GRAMO</label>
            <div class="col-sm-8">
              <input type="number" step="0.01" name="precio_gr" value="<?php echo @$lapgr ?>" class="form-control"  />
            </div>
          </div>
          
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">CAMBIAR CANTIDAD</label>
            <div class="col-sm-8">
              <input type="text" name="_cant" value="<?php echo @$exis?>" class="form-control" />
            </div>
          </div>
          
          

        </div>
        <div class="box-footer">
          <a href="../in.php?cid=mercaderia/mercaderia" class="btn bg-navy"><i class="fa fa-reply"></i> Volver</a>
          <button type="submit" class="btn btn-warning pull-right" name="delete"><i class="fa fa-check-square-o"></i> Editar!</button>
          

                  </div>
      </form><br /><br />
</div>
</div><!-- FIN COL-MD-6 -->

<div class="col-md-6">



<div class="box box-success">
      <div class="box-header with-border">
          <h3 class="box-title">Ilustraci&oacute;n del Producto</h3>
      </div>
      <form method="POST" class="form-horizontal" enctype="multipart/form-data">
      <input type="hidden" name="upd_id" value="<?php echo $id ?>" />
      <center><img src="../../img/<?php echo $ruta ?>" width="200" /></center>
        <div class="box-body">
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">Subir o Cambiar Ilustraci&oacute;n</label>
            <div class="col-sm-8">
              <input type="file" name="img"  class="form-control"  />
            </div>
          </div>


        </div>
        <div class="box-footer">
          <a href="../in.php?cid=mercaderia/mercaderia" class="btn bg-navy"><i class="fa fa-reply"></i> Volver</a>
          <button type="submit" class="btn btn-success pull-right" name="reload"><i class="fa fa-check-square-o"></i> Confirmar Imag&eacute;n!</button>
                  </div>
      </form>
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