
<?php
  $ver = $db->prepare("SELECT * FROM access WHERE a_perfil='$session_acceso' AND a_modulo=3 AND a_item=17");
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
    @$ee = '';
  }elseif (@$edit == 'I'){
    @$ee = 'disabled';
  }

  if (@$dele == 'A'){
    @$dd = '';
  }elseif (@$dele == 'I'){
    @$dd = 'disabled';
  }
  
  
  
  
  
?>
<script>
$(function () {
    $(".custom-close").on('click', function() {
        $('#myModal').modal('hide');
    });
});

</script>

<?php
    $empresa = 1;
    
    // Proveedores
    $sql4 = $db->prepare("SELECT * FROM c_proveedor WHERE estado = 'A' ORDER BY nombreproveedor ASC");
    $sql4->execute();
    $all4 = $sql4->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" >
    <section class="content-header">
      <h1><b>Compras</b> / Factura de Compra</small></h1>
      <ol class="breadcrumb">
        <li><a href="?cid=dashboard/init"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="?cid=compras/frm_ver_compras">Compras</a></li>
        <li class="active">Ingreso de mercaderia</li>
      </ol>
    </section>

<!-- Main content -->
<section class="content">
<div class="row">
    
<div class="col-md-12">
      <!--<div class="callout callout-info" >
        <h4><i class="fa fa-info"></i> Importante!:</h4>
        <p>Los productos que se listen aqu&iacute; no estar&aacute;n disponibles para la venta hasta que usted lo seleccione y lo ponga en stock en el m&oacute;dulo kardex.</p>
      </div>-->
</div>
   <div class="col-md-12">
    <?php
        if (isset($_POST['register']) ){ require_once ("../../controlador/c_compras/reg_compra_detalle.php"); }
    
        if (isset($_POST['comprar'])){ require_once ("../../controlador/c_compras/reg_compra.php"); } 
     ?>
   </div>
    <div class="col-md-5">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><b>Ingreso de Factura de Compra</b></h3>
            </div>

<form id="formulario" method="post" name="formulario" class="form-horizontal" enctype="multipart/form-data">
    <input type="hidden" required="required" readonly="readonly" id="pro" name="pro"/>
    <input type="hidden" name="idempresa" value="<?php echo $empresa ?>" />

    <div class="box-body">
        <div class="form-group">
            <label class="col-md-4">Factura </label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="ncompra" placeholder="Número de Compra" value="<?php echo @$datoncompra ?>" <?php echo $readonly ?> required="" >
            </div>
        </div>
        <div class="form-group">            
            <label class="col-md-4">Fecha </label>
            <div class="col-md-8">
                <input class="form-control" type="date" name="fechacompra" value="<?php echo @$fechaco ?>" <?php echo $readonly ?> required="" />
            </div>
        </div>
        <div class="form-group">                    
            
            <label class="col-md-4">Proveedor </label>
            <div class="col-md-8">
                <select id="id_prov" name="proveedor" class="form-control" <?php echo $readonly ?> required="" />
                    <?php foreach ($all4 as $key => $dd){ ?>
                    <?php if ($dd['id_proveedor'] == $datoprov) { ?>
                        <option style="background-color: turquoise" value="<?php echo $dd['id_proveedor'] ?>" selected><?php echo $dd['nombreproveedor'] ?></option>
                    <?php }else{ ?>
                        <option value="<?php echo $dd['id_proveedor'] ?>"><?php echo $dd['nombreproveedor'] ?></option>                    
                    <?php } } ?>
                </select>
            </div>
        </div>
        
        <div class="form-group">    
        
            <label class="col-md-4">IVA</label>
                    <div class="col-md-8">
                    <input class="form-control input-sm" type="text" name="iva" required="" onkeypress="return soloNumeros(event)" />
            </div>
        </div>
        <div class="form-group">        
            <label class="col-md-4">IVA Valor</label>
                    <div class="col-md-8">
                    <input class="form-control input-sm" type="number" step="0.01" name="dinero_iva" required="" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4">Descuento </label>
            <div class="col-md-8">
                <input type="number" step="0.01" class="form-control input-sm" name="desc" />
            </div>
        </div>            
        <div class="form-group">            
        
            <label class="col-md-4">Sub Total </label>
            <div class="col-md-8">
                <input type="number" step="0.01" class="form-control input-sm" name="importe" required="" />
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-4">Forma de Pago</label>
                <div class="col-md-8">
                <select id="selectpago" class="form-control input-sm" name="forma">
                    <option>Efectivo</option>
                    <option>Credito</option>
                </select>
            </div>
        </div>
        <div class="form-group">            
            <div id="Efectivo" class="vehicle">
                    <label class="col-md-4">Efectivo</label>
                    <div class="col-md-8">
                        <input type="number" step="0.01" class="form-control input-sm" name="efectivo" value="0" />
                    </div>
            </div>
                        
                        
            <div id="Credito" class="vehicle" style="display:none;">
                    <label class="col-md-4">Diferido</label>
                    <div class="col-md-8">
                        <select name="meses" id="meses" class="form-control input-sm" style="height: 35px">
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="18">18</option>
                            <option value="24">24</option>
                        </select>
                    </div>
            </div>
        </div>
        <div class="form-group">        
                <label class="col-md-4"> Total </label>
                    <div class="col-md-8">
                        <input type="number" step="0.01" class="form-control input-sm" name="total" required="" />
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <center><button type="submit" class="btn btn-success btn-small" name="comprar" <?php echo @$ss ?>><i class="fa fa-check"></i> FINALIZAR COMPRA</button></center>
            </div>
        </form>
</div><!-- FIN BOX-INFO-->
    </div> <!-- FIN COL-MD-6 -->

    
</div><!-- FIN ROW -->
<script type="text/javascript">

$(document).ready(function() {
    $('#search').DataTable( {
        
    } );
} );

</script>
</section>                    
<!-- ******** FIN DETALLE DE LA COMPRA ************** -->
</div>















