<?php
  
  $ver = $db->prepare("SELECT * FROM access WHERE a_perfil='$session_acceso' AND a_modulo=2 AND a_item=11");
  $ver->execute();
  $fetch = $ver->fetchAll(PDO::FETCH_ASSOC);

  foreach ($fetch as $key => $value) {
    $save = $value['sav'];
    $edit = $value['edi'];
    $dele = $value['del'];
    $prin = $value['pri'];
  }
  if (@$save == 'A') {
    @$ss = '';
  }elseif (@$save == 'I'){
    @$ss = "disabled";
  }

  if (@$prin == 'A'){
    @$pp = '';
  }elseif (@$prin == 'I'){
    @$pp = 'disabled';
  }

  if (@$edit == 'A'){
    $ee = '';
  }elseif (@$edit == 'I'){
    @$ee = 'disabled';
  }

  if (@$dele == 'A'){
    @$dd = '';
  }elseif (@$dele == 'I'){
    @$dd = 'disabled';
  }
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Administración / <b>Categorias de Producto</b></h1>

        <ol class="breadcrumb">
        <li>  <a class="btn btn-warning btn-sm <?php echo @$pp ?>" href="categoria/barcode.php" target="_blank">Codigos de Barras <img src="../img/pdf.png" width="30" />  </a></li>    
        <li> Ver informe en <a class="<?php echo @$pp ?>" href="../../datos/clases/pdf/pdfcategoria.php" target="_blank"><img src="../img/pdf.png" width="30" />  </a></li>
        </ol>
    </section>

<!-- Main content -->
<section class="content">
<div class="row">
<div class="col-md-12">
    <?php
    if (isset($_POST['register'])) {
       require_once ("../../controlador/c_categorias/reg_categoria.php");
    }
 ?>
</div>
<br />
        <div class="col-md-4">
        
        <div class="box box-success">
            <div class="box-body">
            <div class="col-md-12">
                <div class="box-header with-border">
                    <h3 class="box-title"><b>Importante:</b>  Los campos con (*) son obligatorios</h3>
                </div>
            
            <form id="formulario" method="post" class="form-horizontal" >        
              <div class="box-body">
                <div class="form-group">
                    <label class="col-md-5">C&oacute;digo / Categoria (*)</label>
                    <div class="col-md-7">
                    <input type="text" id="nombre" name="nombre" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-5">Descripci&oacute;n </label>
                    <div class="col-md-7">
                    <input class="form-control" type="text" name="obs" placeholder=""/>
                    </div>
                </div>        
                <div class="box-footer">
                        <a href="?cid=dashboard/init" class="btn bg-navy"><i class="fa fa-reply"></i> Volver</a>

                        <button type="submit" class="btn btn-success pull-right" value="Guardar Datos" name="register" <?php echo @$ss ?>><i class="fa fa-check-square-o"></i> Guardar Datos</button>
                </div>
                    </form>
                    </div>
                    </div>
                    </div><!-- /.tab-pane -->
            </div><!-- /.tab-content -->
            </div>
            
            
        <div class="col-md-8">

        <div class="box box-success">
            <div class="box-body">
                <div class="col-md-12">
                    <div class="box-header with-border">
                        <h3 class="box-title"><b>Importante:</b>  Los campos con (*) son obligatorios</h3>
                    </div>
                    
                    	
                    	<?php require_once ("../../controlador/c_categorias/paginarCategoria.php"); ?>
                </div>
                </div>
            </div>
        </div>
        
        
  </section>
</div>

<script type="text/javascript">
	function imprimir() {
		$("#print").printArea();
	}
</script>