<?php
    session_start();  
 if(isset($_SESSION["correo"]))  {
        
	require_once ("../head_unico.php");
	require_once ("../../../../datos/db/connect.php");
	
	if (isset($_REQUEST['cid'])){
		$laid = $_REQUEST['cid'];

		$sql = DBSTART::abrirDB()->prepare("SELECT * FROM c_venta_detalle WHERE nventa = '$laid'");
		$sql->execute();
		$rows = $sql->fetchAll(PDO::FETCH_ASSOC);

		foreach ($rows as $key => $value) {
			$id          = $value['nventa'];
			$empresa     = $value['id_empresa'];
            $cod         = $value['codigo'];
            $cant         = $value['cantidad'];
            $bod = $value['bodega'];
            $fechaor = $value['fecha_origen'];
		}
} ?>

<script>
function muestra_oculta(id){
if (document.getElementById){ //se obtiene el id
var el = document.getElementById(id); //se define la variable "el" igual a nuestro div
el.style.display = (el.style.display == 'none') ? 'block' : 'none'; //damos un atributo display:none que oculta el div
}
}
window.onload = function(){/*hace que se cargue la función lo que predetermina que div estará oculto hasta llamar a la función nuevamente*/
muestra_oculta('contenido');/* "contenido_a_mostrar" es el nombre que le dimos al DIV */
}
</script>
<style type="text/css">
    .back-list:hover{background: turquoise;cursor: pointer;}
    #fapro{cursor:pointer}
</style>

<script type="text/javascript" src="../../../js/consulta_venta_codigo_act.js"></script>
<div id="page-wrapper">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb" style="float: right; margin-top:15px">
    <li class="breadcrumb-item">Config. y Administración</li>
    <li class="breadcrumb-item active">Ventas</li>
    <li class="breadcrumb-item active">Actualizar</li>
  </ol>
</nav>

    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-danger" style="margin-top: 10px; height: 110px">
              <h4>Ventas</h4><hr />
              <p style="float: left;">Actualizar datos de la factura</p>
              <p style="float: right;"><a href="../in.php?cid=ventas/frm_ver_ventas">Volver</a></p>
            </div>
        </div>
    </div>
    <div class="row">
    <?php
    if (isset($_POST['updates'])) {
        require_once ("../../../../controlador/c_ventas/act_ventas.php");
    }
?>
        <div class="col-lg-6">
        <fieldset class="field">
    <legend class="ley"><h3>Facturero </h3></legend>        
        	<form method="POST">
        		<input type="hidden" name="empresa" value="<?php echo $empresa ?>" />

    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="inputPassword4">Factura</label>
            <input class="form-control" type="text" name="_venta" id="_venta" value="<?php echo $id ?>" required="" />
        </div>

        <div class="form-group col-md-4">
            <label for="inputPassword4">Código <span><i id="fapro" class="fa fa-search" onClick="muestra_oculta('contenido')"></i></span></label>
            <input class="form-control" type="text" id="code" name="code" />
        </div>
        <div class="form-group col-md-5">
              <label for="inputAddress">Descripción</label>
              <input type="text" name="nombre" id="_name" class="form-control" readonly="" />
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-12">
        <div id="countryList"></div>
    </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-3">
	      <label for="inputCity">Precio</label>
	      <input type="text" class="form-control" name="_precio" id="_price" />
	    </div>
	  	<div class="form-group col-md-3">
	    	<label for="inputAddress2">Stock</label>
	    	<input class="form-control" type="text" name="_stock" id="_stock" />
		</div>

        <div class="form-group col-md-3">
          <label for="inputCity">Bodega</label>
          <select name="_bodega" id="_bodega" class="form-control">
              <option>1</option>
              <option>2</option>
          </select>
        </div>

        <div class="form-group col-md-3">
	      <label for="inputCity">Cantidad</label>
	      <input type="text" class="form-control" id="_cantidad" name="_cantidad" />
	    </div>
        
	 </div>
    <div class="modal-footer">
        <button type="submit" name="register" class="btn btn-success"><i class="fa fa-check"></i> Agregar Producto</button> 
	    <button type="reset" class="btn btn-warning" > <i class="fa fa-times"></i> Cancelar</button>
    </div>
        </form>
        
        
<table class="table table-striped table-hover">
    <thead>
        <th>Factura</th>
        <th>Código</th>
        <th>Precio</th>
        <th>Cantidad</th>
        <th>Parcial</th>
        <th>Eliminar</th>
    </thead>
    <?php foreach ($rows as $send) { ?>
    <tbody>
        <td><?php echo $send['nventa'] ?></td>
        <td><?php echo $send['codigo'] ?></td>
        <td><?php echo $send['precio'] ?></td>
        <td><?php echo $send['cantidad'] ?></td>
        <td><?php echo $send['importe'] ?></td>
        <td><a href="ventas/frm_ventas_eli.php?cid=<?php echo $send['nventa'] ?>"><i class="fa fa-trash"></i></a></td>
    </tbody>
    <?php } ?>
</table>

<?php 
    $im = DBSTART::abrirDB()->prepare("SELECT sum(importe) as lasuma FROM c_venta_detalle WHERE nventa = '$id' ");
    $im->execute();
    $row_imp = $im->fetchAll(PDO::FETCH_ASSOC);
    foreach ($row_imp as $key => $value_imp) {
        $el_importe = $value_imp['lasuma'];
    }
 ?>
 <div class="alert alert-success">
    <h3>Importe Total: <strong><?php echo $el_importe ?></strong></h3>
 </div>
    
    
        </fieldset>
   	</div>
    
    
    
 
 
 <div id="contenido">
<div class="col-lg-6">
	<div class="form-group">
    <div class="col-lg-9"><br />
        <input class="form-control" type="text" placeholder="Busca por código, categoria, nombre.." id="bs-prod"/><br />
    </div>            
    </div><br /><br />
    
    <div class="registros" id="agrega-registros"></div>
        <center>
            <ul class="pagination" id="pagination"></ul>
        </center>
</div>
</div>




    
	</div>
    
    
    
    
    
    
    
    <div class="row">
<?php
    $sql = DBSTART::abrirDB()->prepare("SELECT * FROM c_venta v INNER JOIN c_clientes c ON c.cedula = v.cliente 
                                                WHERE v.nventa = '$id'");
    $sql->execute();
    $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $key => $value) {
        $id         = $value['nventa'];
        $empresa    = $value['id_empresa'];
        
        // Cliente
        $get_cedula    = $value['cedula'];
        $get_nombres   = $value['nombres'];
        $get_correo    = $value['correo'];
        $get_celular   = $value['celular'];
        $get_direccion = $value['direccion'];
        $get_placa     = $value['placa'];
        
        // Factura
        $get_descuento = $value['descuento'];
        $get_iva       = $value['iva'];
        $get_importe   = $value['importe'];
        $get_total     = $value['total'];
        $get_origenf   = $value['fecha_origen'];
        $get_forma     = $value['forma_pago'];
        $get_efectivo  = $value['efectivo'];
        $get_cambio    = $value['cambio'];
        $get_meses     = $value['meses'];
    }
?>
    <div class="col-lg-12">
        <fieldset class="field">
    <legend class="ley">Facturar Venta</legend>
    <form id="formulario" method="post" name="formulario" enctype="multipart/form-data">
    <input type="hidden" name="p_empresa" value="<?php echo $empresa ?>" />
    

    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="inputPassword4">Fecha en que se facturó</label>
            <input class="form-control" type="date" name="p_fecha" id="lafecha" value="<?php echo $get_origenf ?>" />
        </div>
        <div class="form-group col-md-2">
            <label for="inputPassword4">Factura  </label>
            <input class="form-control" type="text" id="venta" name="p_factura" required="" value="<?php echo $id ?>" />
        </div>
        <div class="form-group col-md-2">
            <label for="inputPassword4">Cédula  </label>
            <input class="form-control" min="10" type="text" id="cedula" name="p_cedula" required="" value="<?php echo $get_cedula ?>" />
        </div>
        <div class="form-group col-md-3">
            <label for="inputPassword4">Nombres</label>
            <input class="form-control" type="text" id="nombres" name="p_nombres" required="" value="<?php echo $get_nombres ?>" />
        </div>
        <div class="form-group col-md-2">
            <label for="inputPassword4">Correo Electrónico</label>
            <input class="form-control" type="text" id="correo" name="p_correo" value="<?php echo $get_correo ?>" />
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-2">
            <label for="inputPassword4">Celular</label>
            <input class="form-control" type="text" id="celular" name="p_cel" value="<?php echo $get_celular ?>" />
        </div>
        <div class="form-group col-md-4">
            <label for="inputPassword4">Dirección</label>
            <input class="form-control" type="text" id="direccion" name="p_direccion" value="<?php echo $get_direccion ?>" />
        </div>
    
        <div class="form-group col-md-2">
            <label for="inputPassword4">Placa</label>
            <input class="form-control" type="text" id="placa" name="p_placa" value="<?php echo $get_placa ?>" />
        </div>
        <div class="form-group col-md-2">
            <label for="inputAddress">Desc</label>
            <input type="text" id="desc" name="p_desc" class="form-control" value="<?php echo $get_descuento ?>" />
        </div>
        <div class="form-group col-md-2">
            <label> IVA </label>
            <input type="text" id="importe" name="p_iva" class="form-control" value="<?php echo $get_iva ?>" />
        </div>
    </div>
        
    <div class="form-row">
    <div class="form-group col-md-2">
            <label> Importe Parcial</label>
            <input type="text" id="importe" name="p_importe" class="form-control" value="<?php echo $get_importe ?>" />
        </div>
        <div class="form-group col-md-2">
            <label> Total</label>
            <input type="text" id="total" name="p_total" class="form-control" value="<?php echo $get_total ?>" />
        </div>
        <div class="form-group col-md-2">
            <label> Tipo Pago:</label>
            <div class="controls">
                <td> <select id="selectpago" name="p_selectpago" class="form-control">
                        <option><?php echo $get_forma ?></option>
                        <option value="Efectivo">Efectivo</option>
                        <option value="Diferido">Diferido</option>
                    </select>
                </td>
            </div>
        </div>
        
        <div id="Efectivo" class="vehicle">
            <div class="form-group col-md-2">
                <label>Efectivo:</label>
                <input type="text" placeholder="$" name="p_efectivo" id="efectivo" class="form-control" value="<?php echo $get_efectivo ?>" />
            </div>
        </div>
        <div id="Efectivo" class="vehicle">
            <div class="form-group col-md-2">
                <label>Cambio:</label>
                <input type="text" placeholder="$" name="p_cambio" id="efectivo" class="form-control" value="<?php echo $get_cambio ?>" />
            </div>
        </div>
                    
        <div id="Diferido" class="vehicle" >
            <div class="form-group col-md-2">
                <label>Diferido:</label>
                <select name="meses" id="p_meses" class="form-control">
                    <option><?php echo $get_meses ?></option>
                    <option value="3">3</option>
                    <option value="6">6</option>
                    <option value="6">9</option>
                    <option value="6">12</option>
                </select>
            </div>
        </div>
        <div class="form-group col-md-4">
            <label for="inputAddress">Observación</label>
            <textarea id="obs" name="p_obs" class="form-control" placeholder="Dato adicional.." ></textarea>
        </div>
     </div>

<div class="form-row">
  <div class="modal-footer">
        <button type="submit" name="updates" class="btn btn-success"><i class="fa fa-check"></i> Guardar Actualización</button> 
        <button type="reset" class="btn btn-warning" > <i class="fa fa-times"></i> Cancelar</button>
   </div><br /></div>
</form>

</fieldset>
</div>
</div>
    
</div>




<?php 
require_once ("../foot_unico.php");

}else{
    session_unset();
    session_destroy();
    header('Location:  ../../../../login.php');
} 

 ?>