
<script>
$(function() {
    $('#selectpago').change(function(){
        $('.vehicle').hide();
        $('#' + $(this).val()).show();
    });
});

</script>

<div id="page-wrapper"><br />
<nav aria-label="breadcrumb">
  <ol class="breadcrumb" style="float: right;">
    <li class="breadcrumb-item"> Ventas</li>
    <li class="breadcrumb-item active">Facturar Ventas</li>
  </ol>
</nav><br /><br />
<?php
    if (isset($_POST['facturar']) ){
        require_once ("../../../controlador/c_ventas/reg_facturar.php");
    } ?>
<?php
    require_once ("../../../datos/db/connect.php");

    $empresa = $_SESSION['id_empresa'];

    $env = new DBSTART;
    $db = $env->abrirDB();

    $cc = $db->prepare("SELECT MAX(nventa) AS ultimo FROM c_venta WHERE id_empresa = '$empresa'");
    $cc->execute();
    $rr = $cc->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rr as $key => $val) {
        $new = $val['ultimo'];
        if ($new == "") {
            $producto = 1;           

        }else{
            $producto = $new + 1;
        }
    }

    function generate_numbers($start, $count, $digits) {
       $result = array();
       for ($n = $start; $n < $start + $count; $n++) {
          $result[] = str_pad($n, $digits, "0", STR_PAD_LEFT);
       }
       return $result;
    }

    $numbers = generate_numbers($producto, 1, 7);
    	foreach ($numbers as $key => $value) {
    		$producto = $value; 
    	}
?>
<div class="row">
<div class="col-lg-8">

<fieldset class="field">
    <legend class="ley"><h3>Venta: <span class="badge badge-danger" style="background: lightseagreen; padding:8px"><?php echo $producto ?></span></h3></legend>

<form id="formulario" action="../../../controlador/c_ventas/reg_agregar.php" method="post" name="formulario">
    <input type="hidden" name="empresa" value="<?php echo $empresa ?>" />
    <input type="hidden" required="required" readonly="readonly" id="_venta" name="_venta" value="<?php echo $producto ?>" />

    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="inputPassword4">Código</label>
            <input class="form-control" type="text" name="code" id="code" />
        </div>
        <div class="form-group col-md-8">
              <label for="inputAddress">Descripción</label>
              <input type="text" name="nombre" id="_name" class="form-control" readonly="" />
      	</div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-3">
	      <label for="inputCity">Precio</label>
	      <input type="text" class="form-control" name="_precio" id="_price" readonly="" />
	    </div>
	  	<div class="form-group col-md-3">
	    	<label for="inputAddress2">Stock</label>
	    	<input class="form-control" type="text" name="_stock" id="_stock" readonly="" />
		</div>  	

        <div class="form-group col-md-3">
          <label for="inputCity">Bodega</label>
          <input type="text" class="form-control" id="_bodega" name="_bodega" readonly="" />
        </div>

        <div class="form-group col-md-2">
	      <label for="inputCity">Cantidad</label>
	      <input type="text" class="form-control" id="_cantidad" name="_cantidad" />
	    </div>
        
	 </div>
    <div class="modal-footer">
        <button type="submit" name="register" class="btn btn-success"><i class="fa fa-check"></i> Agregar</button> 
	    <button type="reset" class="btn btn-warning" > <i class="fa fa-times"></i> Cancelar</button>
    </div>
</form>

<?php
    $stmt = DBSTART::abrirDB()->prepare("SELECT * FROM c_venta_detalle WHERE nventa = '$producto' ORDER BY idventa DESC");
    $stmt->execute();
    $exec = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<table class="table table-striped table-hover">
    <thead>
        <th>Código</th>
        <th>Precio</th>
        <th>Cantidad</th>
        <th>Parcial</th>
        <th colspan="2">Opción</th>
    
    </thead>
    <?php foreach ($exec as $send) { ?>
    <tbody>
        <td><?php echo $send['codigo'] ?></td>
        <td><?php echo $send['precio'] ?></td>
        <td><?php echo $send['cantidad'] ?></td>
        <td><?php echo $send['importe'] ?></td>
        <td><a href="ventas/frm_ventas_act.php?cid=<?php echo $send['nventa'] ?>"><i class="fa fa-edit"></i></a>&nbsp;
        <a href=""><i class="fa fa-trash"></i></a></td>
    </tbody>
    <?php } ?>
</table>

<?php
    // Mostrar el listado de ultimas facturas
    $cs = $db->prepare("SELECT * FROM c_venta_detalle WHERE nventa = '$producto'");
    $cs->execute();
    $cant = $cs->rowCount();

    if ( $cant == 0 ){
        $cs2 = $db->prepare("SELECT max(nventa) as laste FROM c_venta");
        $cs2->execute();
        $fetch = $cs2->fetchAll(PDO::FETCH_ASSOC);

        foreach ( (array)  $fetch as $del ){
            $thenum = $del['laste'];
        }
    ?>
    
    <?php }else{ ?>    

    <?php
        $sql = $db->prepare("SELECT sum(importe) as imp FROM c_venta_detalle WHERE nventa = '$producto' AND id_empresa = '$empresa'");
        $sql->execute();
        $rows = $sql->fetchAll(PDO::FETCH_ASSOC);        

        foreach ($rows as $values) { ?>       
<h3 style="background: #333; color: lightgreen;padding: 8px;border-radius: 2px;">Importe: $./ <strong><?php echo $values['imp'] ?></strong> </h3>
    <?php } } ?>
</fieldset>
</div>

<div class="col-lg-4"><br>
<?php
    // Mostrar el listado de ultimas facturas
    $cs = $db->prepare("SELECT * FROM c_venta WHERE nventa = '$producto'");
    $cs->execute();

        $cs2 = $db->prepare("SELECT max(nventa) as laste FROM c_venta");
        $cs2->execute();
        $fetch = $cs2->fetchAll(PDO::FETCH_ASSOC);

        foreach ( (array)  $fetch as $del ){
            $thenum = $del['laste'];
        }
    ?>

    <?php
        $n = 1;
        $nn = $producto - $n;
        $sql = $db->prepare("SELECT importe, forma_pago, efectivo, cambio,meses, diferido FROM c_venta WHERE nventa = '$producto' -1 AND id_empresa = '$empresa'");
        $sql->execute();
        $rows = $sql->fetchAll(PDO::FETCH_ASSOC);        

        foreach ($rows as $values) { ?>       
<div style="background: #333333d6; color: lightgreen;padding: 8px;border-radius: 2px;">
    <p>Forma de pago: <strong><?php echo $values['forma_pago'] ?></strong> </p>
    <p>Importe: $./ <strong><?php echo $values['importe'] ?></strong> </p>
    <p>Efectivo: $./ <strong><?php echo $values['efectivo'] ?></strong> </p>
    <p>cambio: $./ <strong><?php echo $values['cambio'] ?></strong> </p>
    <p>Meses Dif: <strong><?php echo $values['meses'] ?></strong> </p>
    <p>Valor Dif: $./ <strong><?php echo $values['diferido'] ?></strong> </p>
</div><br>
    <?php }  ?>

    <i class="fa fa-check"></i> <a target="_blank" href="../../../datos/clases/pdf/informe_ventas/venta.php?factura=<?php echo $thenum ?>">Imprimir Factura</a>

</div>
    </div>

    <div class="row">

<?php if ( $cant > 0 ){ ?>

<?php
    
    $sq = $db->prepare("SELECT sum(importe) as imp FROM c_venta_detalle WHERE nventa = '$producto' AND id_empresa = '$empresa'");
    $sq->execute();
    $ali = $sq->fetchAll(PDO::FETCH_ASSOC);
    foreach ($ali as $key => $v) {
        $v1 = $v['imp'];
    }

?>
    <div class="col-lg-12">
        <fieldset class="field">
    <legend class="ley">Facturar Venta</legend>
    <form id="formulario" method="post" name="formulario" enctype="multipart/form-data">
    <input type="hidden" name="empresa" value="<?php echo $empresa ?>" />
    <input type="hidden" required="required" id="venta" name="venta" value="<?php echo $producto; ?>" />
    <input type="hidden" id="importe" name="importe" value="<?php echo $v1 ?>" />

    <div class="form-row">
        <div class="form-group col-md-2">
            <label for="inputPassword4">Cédula  </label>
            <input class="form-control" min="10" type="text" id="cedula" name="cedula" required="" />
        </div>
        <div class="form-group col-md-3">
            <label for="inputPassword4">Nombres</label>
            <input class="form-control" type="text" id="nombres" name="nombres" />
        </div>
        <div class="form-group col-md-2">
            <label for="inputPassword4">Correo Electrónico</label>
            <input class="form-control" type="text" id="correo" name="correo" />
        </div>
        <div class="form-group col-md-2">
            <label for="inputPassword4">Celular</label>
            <input class="form-control" type="text" id="celular" name="cel" />
        </div>
        <div class="form-group col-md-3">
            <label for="inputPassword4">Dirección</label>
            <input class="form-control" type="text" id="direccion" name="direccion" />
        </div>
    </div>
        
    <div class="form-row">
        <div class="form-group col-md-2">
            <label for="inputPassword4">Placa</label>
            <input class="form-control" type="text" id="placa" name="placa" />
        </div>
        <div class="form-group col-md-2">
            <label for="inputAddress">Descuento</label>
            <input type="text" id="desc" name="desc" class="form-control" placeholder="%" />
        </div>

        <div class="form-group col-md-2">
            <label> Tipo Pago:</label>
            <div class="controls">
                <td> <select id="selectpago" name="selectpago" class="form-control">
                        <option value="Efectivo">Efectivo</option>
                        <option value="Diferido">Diferido</option>
                    </select>
                </td>
            </div>
        </div>
        
        <div id="Efectivo" class="vehicle">
            <div class="form-group col-md-2">
                <label>Efectivo Recibido:</label>
                <input type="text" placeholder="$" onkeypress="return soloNumeros(event)" name="efectivo" id="efectivo" class="form-control" />
            </div>
        </div>        
                    
        <div id="Diferido" class="vehicle" style="display:none;">
            <div class="form-group col-md-2">
                <label>Meses Diferido:</label>
                <select name="meses" id="meses" class="form-control">
                    <option value=""></option>
                    <option value="3">3</option>
                    <option value="6">6</option>
                    <option value="6">9</option>
                    <option value="6">12</option>
                </select>
            </div>
        </div>
        <div class="form-group col-md-4">
            <label for="inputAddress">Observación</label>
            <input type="text" id="obs" name="obs" class="form-control" placeholder="Dato adicional.." />
        </div>
     </div>

<div class="form-row">
  <div class="modal-footer">
        <button type="submit" name="facturar" class="btn btn-success"><i class="fa fa-check"></i> Facturar</button> 
        <button type="reset" class="btn btn-warning" > <i class="fa fa-times"></i> Cancelar</button>
   </div><br /></div>
</form>
</fieldset>
    </div>
    <br /><br />

<?php } ?>
</div>
</div>
</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('#code').blur(function(){
			$.ajax({
				type:"POST",
				data:"idpro=" + $('#code').val(),
				url:"../../../controlador/c_ventas/llenar.php",
				success:function(r){
					dato=jQuery.parseJSON(r);
					$('#_name').val(dato['nombreproducto']);
					$('#_price').val(dato['precio_venta']);
					$('#_stock').val(dato['existencia']);
                    $('#_bodega').val(dato['bodega']);
				}
			});
		});
	});
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#cedula').blur(function(){
            $.ajax({
                type:"POST",
                data:"idcliente=" + $('#cedula').val(),
                url:"../../../controlador/c_ventas/llenar_clientes.php",
                success:function(r){
                    dato=jQuery.parseJSON(r);
                    $('#nombres').val(dato['nombres']);
                    $('#correo').val(dato['correo']);
                    $('#celular').val(dato['celular']);
                    $('#direccion').val(dato['direccion']);
                    $('#placa').val(dato['placa']);
                }
            });
        });
    });
</script>