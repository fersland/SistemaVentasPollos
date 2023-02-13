<script type="text/javascript" src="../../js/consulta_mercaderia.js"></script>
<?php
    require_once ("../../../datos/db/connect.php");
    $empresa = $_SESSION['id_empresa'];
        
    // Categorias    
    $sql1 = DBSTART::abrirDB()->prepare("SELECT * FROM c_categoria WHERE id_empresa = '$empresa' AND estado = 'A'");
    $sql1->execute();
    $all1 = $sql1->fetchAll(PDO::FETCH_ASSOC);
    
    // Tipo de filtros
    $sql2 = DBSTART::abrirDB()->prepare("SELECT * FROM c_tipo_filtro WHERE id_empresa = '$empresa' AND estado = 'A'");
    $sql2->execute();
    $all2 = $sql2->fetchAll(PDO::FETCH_ASSOC);
    
    // Tipo de aceite
    $sql3 = DBSTART::abrirDB()->prepare("SELECT * FROM c_tipo_aceite WHERE id_empresa = '$empresa' AND estado = 'A'");
    $sql3->execute();
    $all3 = $sql3->fetchAll(PDO::FETCH_ASSOC);
    
    // Proveedores
    $sql4 = DBSTART::abrirDB()->prepare("SELECT * FROM c_proveedor WHERE id_empresa = '$empresa' AND estado = 'A' ORDER BY nombreproveedor ASC");
    $sql4->execute();
    $all4 = $sql4->fetchAll(PDO::FETCH_ASSOC);
    
    // Proveedores
    $sql5 = DBSTART::abrirDB()->prepare("SELECT * FROM c_tipo_presentacion WHERE id_empresa = '$empresa' AND estado = 'A'");
    $sql5->execute();
    $all5 = $sql5->fetchAll(PDO::FETCH_ASSOC);
    
    // Bodegas
    $bode = DBSTART::abrirDB()->prepare("SELECT * FROM c_bodega WHERE id_empresa = '$empresa' AND estado = 'A'");
    $bode->execute();
    $boderow = $bode->fetchAll(PDO::FETCH_ASSOC);
?>

<div id="page-wrapper">

    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-warning" style="margin-top: 10px">
              <strong> <i class="fa fa-cubes fa-fw"></i> Entrada de Mercaderia</strong><hr />
              <span style="float: right;">MAESTRO
                <a target="_blank" href="../../../datos/clases/pdf/maestro.php"><img src="../../img/pdf.png" width="40" /></a></span>
                <span style="float: right;">STOCK
                <a target="_blank" href="../../../datos/clases/pdf/existencia.php"><img src="../../img/pdf.png" width="40" /></a></span>
              <p>Alimentar de productos al Inventario</p><br />

                <a target="_blank" href="../../../datos/clases/pdf/maestro.php"></a></span></p>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-5">

<fieldset class="field">
    <legend class="ley">LLenar el formulario</legend>
<?php
    if (isset($_POST['register']) ){
        require_once ("../../../controlador/c_mercaderia/reg_producto.php");
    }
?>

<?php
    if (isset($_POST['comprar'])){
        require_once ("../../../controlador/c_compras/reg_agregar_compras.php");   
    }
?>

<?php 
    $com = DBSTART::abrirDB()->prepare("SELECT * FROM c_compra_detalle c WHERE c.estado = 'A' AND c.id_empresa = '$empresa'");
    $com->execute();
    $rowslista = $com->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($rowslista as $deures) { // extraer el número de compra
        $nco = $deures['ncompra'];
    }
    
    // Verificar si el numero de compra existe en la tabla c_compra
    $onlyncompra = DBSTART::abrirDB()->prepare("SELECT * FROM c_compra WHERE id_empresa = '$empresa' AND ncompra = '$nco' AND estado='A'");
    $onlyncompra->execute();
    $nonly = $onlyncompra->rowCount();
    
    $elproveedor = DBSTART::abrirDB()->prepare(
                        "SELECT * FROM c_mercaderia m 
                            INNER JOIN c_proveedor p ON p.id_proveedor = m.id_proveedor
                            WHERE m.id_empresa = '$empresa' AND m.ncompra='$nco' AND m.estado = 'A' LIMIT 1");
    $elproveedor->execute();
    $elnumprov = $elproveedor->rowCount();
    $nprov = $elproveedor->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ( (array) $nprov as $noo){
        $elidprov = $noo['id_proveedor'];
        $elnaprov = $noo['nombreproveedor'];
    }
    
    // Si existe es debe ser 1 sino es 0
    if ($nonly == 0) {
        $datoncompra = $nco;
    }else{
        $datoncompra = "";
    }
    
    if ( $elnumprov == 0 ) {
        $datoprov = "0";
    }else{
        $datoprov = $elidprov;
    }
?>
<form id="formulario" method="post" name="formulario" enctype="multipart/form-data">
    <input type="hidden" name="empresa" value="<?php echo $empresa ?>" />
    <input type="hidden" required="required" readonly="readonly" id="pro" name="pro"/>
    
    <div class="form-row">
    <div class="form-group col-md-12">
        <label>Proveedor</label>
        <select id="id_prov" name="proveedor" class="form-control">
            <option value="<?php echo $datoprov ?>" ><?php echo $elnaprov ?></option>
            <?php foreach ((array) $all4 as $data_prov) : ?>
            <option value="<?php echo $data_prov['id_proveedor'] ?>"><?php echo $data_prov['nombreproveedor'] ?></option>
            <?php endforeach ?>
        </select>
    </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="inputPassword4">Código</label>
            <input class="form-control" type="text" id="_codigo" name="codigo" required="" />
        </div>
    </div>
	 

    <div class="form-row">
        <div class="form-group col-md-12">
        <label for="inputPassword4">Categoria</label>
                    
          <select class="form-control" id="_categoria" name="categoria" onchange="ActDesactCampotipoFiltro(); ActDesactCampotipoAceite();">
          <option value="0"> Seleccione </option>\n";
                <?php foreach ( (array) $all1 as $res ) { ?>
                <option value="<?php echo $res['id_categoria'] ?>"> <?php echo $res['nombre'] ?></option>\n";
                <?php } ?>
          </select>
      </div>
      </div>
      
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="inputPassword4">Bodega</label>
          <select id="_bodega" name="bodega"  class="form-control">
            
            <?php foreach ( (array) $boderow as $rs_bod ) { ?>
                <option value="<?php echo $rs_bod['numero_bodega'] ?>"> <?php echo $rs_bod['numero_bodega'] ?></option>\n";
            <?php } ?>
          </select>
      </div>
      <div class="form-group col-md-6">
      <label for="inputAddress">Número de Percha</label>
      <input type="text" id="_percha" name="percha" class="form-control" onkeypress="return soloNumeros(event)" />
  	</div>            
    </div>

    <div class="form-row">
    <div class="form-group col-md-12">
      <label for="inputAddress">Descripción (Nombre producto)</label>
      <input type="text" id="_nombre" name="nombre" class="form-control" />
  	</div>
    </div>
    
    
    <div class="form-row">
        <div class="form-group col-md-6">
        <label for="inputPassword4">Tipo Presentación</label>
          <select class="form-control" id="_present" name="present" >
            <option value="0"> Seleccione... </option>\n";
            <?php foreach($all5 as $value5){ ?>
                    <option value="<?php echo $value5['id_tipo_presentacion'] ?>"><?php echo $value5['nombrepresentacion'] ?></option>
            <?php } ?>
          </select>
      </div>
        <div class="form-group col-md-6">
        <label for="inputPassword4">Cantidad litros o libra</label>
          <input class="form-control" type="text" id="_litros" name="litros" placeholder="" onkeypress="return soloNumeros(event)"  />
      </div>
      </div>
      
    <div class="form-row">
        <div class="form-group col-md-12">
        <label for="inputPassword4">Tipo Filtro</label>
          <select class="form-control" id="_filtro" name="filtro" >
          <option value="0"> Seleccione... </option>\n";
            <?php foreach($all2 as $value2){ ?>
                    <option value="<?php echo $value2['id_tipo_filtro'] ?>"><?php echo $value2['nombrefiltro'] ?></option>
            <?php } ?>
          </select>
      </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-12">
        <label for="inputPassword4">Tipo Aceite</label>
          <select class="form-control" id="_aceite" name="aceite" >
          <option value="0"> Seleccione... </option>\n";
            <?php foreach($all3 as $value3){ ?>
                    <option value="<?php echo $value3['id_tipo_aceite'] ?>"><?php echo $value3['nombreaceite'] ?></option>
            <?php } ?>
          </select>
      </div>
      </div>
      
      <div class="form-row">
        <div class="form-group col-md-6">
	    	<label for="inputAddress2">Cantidad Stock</label>
	    	<input class="form-control" type="text" id="_stock" name="stock" required="" onkeypress="return soloNumeros(event)" />
		</div>
        <div class="form-group col-md-6">
        <label for="inputPassword4">Viscosidad</label>
          <input class="form-control" type="text" id="_viscosidad" name="viscosidad"  placeholder=""  />
      </div>
      </div>
      
      <div class="form-row">
	  	<div class="form-group col-md-6">
	    	<label for="inputAddress2">Marca</label>
	    	<input class="form-control" type="text" id="_marca" name="marca" placeholder=""  />
		</div>
	  	<div class="form-group col-md-6">
	      <label for="inputCity">Unidad Medida</label>
	      <input type="text" class="form-control" id="_medida" name="medida" />
	    </div>
	 </div>
     
     <div class="form-row">
        <div class="form-group col-md-6">
	      <label for="inputCity">Precio Compra</label>
	      <input type="text" class="form-control" id="_precio_compra" name="precio_compra" />
	    </div>
        <div class="form-group col-md-6">
	      <label for="inputCity">Precio Litro</label>
	      <input type="text" class="form-control" id="_precio" name="precio_litro" />
	    </div>
      </div>
     
     <div class="form-row">
        <div class="form-group col-md-6">
          <label for="inputPassword4">Descuento</label>
          <input type="text" value="0" id="_desc" name="desc" class="form-control" />
        </div>
        <div class="form-group col-md-6">
	    	<label for="inputAddress2">Imagen</label>
            <input type="file" class="form-control" name="img" id="_ruta" />
        </div>
     </div>
    
    <div class="form-row">
        <div class="form-group col-md-12">
          <label for="inputPassword4">Observación</label>
          <input type="text" id="_obs" name="obs" class="form-control" />
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" name="register" class="btn btn-success"><i class="fa fa-check"></i> Grabar Producto</button> 
        <button type="reset" class="btn btn-warning" > <i class="fa fa-times"></i> Cancelar</button>
    </div>
</form>
</fieldset>
</div>

<div class="col-lg-6">
    <div class="form-group">
    <div class="col-md-8"><br />
        <input class="form-control" type="text" placeholder="Busca por código, categoria, nombre, medida.." id="bs-prod"/><br />
    </div>            
    </div><br />
            
    <div class="registros" id="agrega-registros"></div>
        <center>
            <ul class="pagination" id="pagination"></ul>
        </center>
    
    <div class="form-group">
    <div class="col-md-8"><br />
        <input class="form-control" type="text" placeholder="Busca por código, categoria, nombre, medida.." id="bs-prod"/><br />
    </div>          
      
    </div>
   	</div>
    </div><br /><br />
            
</div>
</div>
</div>
<script>
function ActDesactCampotipoFiltro()
{
    
   /*var filtro=document.formulario.categoria.value;
   //alert(filtro);
   if(filtro == "6")
     {
     // alert(filtro);
      document.formulario.filtro.disabled=false;
      document.formulario.medida.disabled=false;
      document.formulario.viscosidad.disabled=false;  
    } else {
      document.formulario.filtro.value='';
      document.formulario.medida.value='';
      document.formulario.viscosidad.value='';
      document.formulario.filtro.disabled=true;
      document.formulario.medida.disabled=true; 
      document.formulario.viscosidad.disabled=true;
     }   
  }  
  function ActDesactCampotipoAceite(){
   var aceite=document.formulario.categoria.value;
   //alert(aceite);
   if(aceite == "7" || aceite == "10"){
      document.formulario.aceite.disabled=false;
      document.formulario.viscosidad.disabled=false;
      document.formulario.present.disabled=false;
      document.formulario.litros.disabled=false;
    } else {
      document.formulario.aceite.value='';
      document.formulario.viscosidad.value='';
      document.formulario.aceite.disabled=true;
      document.formulario.viscosidad.disabled=true;
      document.formulario.present.value='';
      document.formulario.present.disabled=true;
      document.formulario.litros.value='';
      document.formulario.litros.disabled=true;
     }   
  }  */
</script>
