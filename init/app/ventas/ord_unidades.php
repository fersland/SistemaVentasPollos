<?php
    session_start();
    date_default_timezone_set('America/Guayaquil');
    if(isset($_SESSION["acceso"])) {
        
        $solofecha = date('Y-m-d');
        
        $eply = $_SESSION["empleado"];
        
        
        require_once ("../head_unico.php");
        $laid = isset($_GET['cid']) ? $_GET['cid'] : 0;

        // Extraer el token generado por el empleado
        $token = $db->prepare("SELECT * FROM c_tokens WHERE id_usuario = '$session_usuario'");
        $token->execute();
        $fetch = $token->fetchAll(PDO::FETCH_ASSOC);

        foreach((array) $fetch as $ttoken){
            $eltoken = $ttoken['ntoken'];
        }

        // SI EL CARRITO TIENE PRODUCTOS
        $sql = $db->prepare("SELECT * FROM c_venta_detalle vd WHERE vd.num_orden = '$laid'");
        $sql->execute();
        $cant_suprema = $sql->rowCount();
        
        $registro = $db->prepare("select * from c_mercaderia e 
                                                    
                                                    inner join c_categoria cc on cc.id_categoria = e.categoria
                                                    where e.estado = 'A'  AND e.ok = 1 ORDER BY e.existencia DESC");
        $registro->execute();
        $all = $registro->fetchAll(PDO::FETCH_ASSOC);
        
        setlocale(LC_MONETARY, 'en_US');
        
        // LISTA CLIENTES MODAL
        $recl = $db->prepare("select * from c_clientes e where e.estado = 'A' ORDER BY e.id_cliente DESC");
        $recl->execute();
        $allcl = $recl->fetchAll(PDO::FETCH_ASSOC);
        
        // CONSULTAR EL CLIENTE DE ESTA ORDEN
        
        $orden = $db->prepare("SELECT * FROM c_clientes WHERE orden='$laid'");
        $orden->execute();
        $cant_orden = $orden->rowCount();
        $orden_fetch = $orden->fetchAll(PDO::FETCH_ASSOC);
        
        if ($cant_orden == 0) {
            $lacedula = "";
            $elnombre = "";
        }else{
            foreach ((array) $orden_fetch as $fff) {
                $lacedula = $fff['cedula'];
                $elnombre = $fff['nombres'];
            }
        }
        
        
        $money = $db->prepare("SELECT * FROM c_empresa t1 INNER JOIN c_moneda t2 ON t1.money = t2.id");
        $money->execute();
        $allmoney = $money->fetchAll();
        
        foreach((array) $allmoney as $values_currencys) :
        
            $decimals = $values_currencys['decimales'];
            $signus = $values_currencys['signo'];
        endforeach;
        
        
// VERIFICAR ESTADO DE CAJA
  
  $stddb = $db->prepare("SELECT * FROM c_caja WHERE fecha='$solofecha'");
  $stddb->execute();
  $std_args = $stddb->fetchAll(PDO::FETCH_ASSOC);
  
  foreach((array) $std_args as $std_args_datos) {
    $disp = $std_args_datos['disponibilidad'];
    $util = $std_args_datos['utilidad'];
  }
  
  // VERIFICAR ESTADO DE CAJA EN TABLA EMPRESA
  
  $fempresa = $db->prepare("SELECT * FROM c_empresa WHERE fcaja='$solofecha' AND scaja='SI'");
  $fempresa->execute();
  //$std_empresa = $fempresa->fetchAll(PDO::FETCH_ASSOC);
  $cantos = $fempresa->rowCount();
  
  /*foreach((array) $std_empresa as $emp) {
    $pp_fecha = $emp['fcaja'];
    $pp_caja = $emp['scaja'];
  }*/

?>
<style type="text/css">
    .form-control{height:32px}.form-control{height:27px}
    #barcodevideo, #barcodecanvas, #barcodecanvasg{height: 400px;}
    #barcodecanvasg{position: absolute; top:0px; left:0px}
    #result{position: absolute;font-family:verdana; font-size: 1.8em; top:68px; left:354px;color:red}
    #barcode{position: absolute; width:100vh; height: 100%;margin: 0 auto; justify-content:center; align-items:center; top: 100px;}
    #barcodecanvas{display: none;}
</style>
<script>
$(function () {
    $(".custom-close").on('click', function() {
        $('#myModal').modal('hide');
    });
});

$(function () {
    $(".custom-close-cl").on('click', function() {
        $('#myModalCliente').modal('hide');
    });
});

/* PARA EL LECTOR DE CODIGO DE BARRAS**/
/*
var sound = new Audio("../../plugins/barcode.wav");

$(document).ready(function(){
    barcode.config.start = 0.1;
    barcode.config.end = 0.9;
    barcode.config.video = '#barcodevideo';
    barcode.config.canvas = '#barcodecanvas';
    barcode.config.canvasg = '#barcodecanvasg';
    barcode.setHandler(function(barcode){
        $('#result').html(barcode);
    })
    
    barcode.init();
    
    $('#result').bind('DOMSubtreeModified', function(e){
        sound.play();
    });
});*/
</script>






<div class="modal fade" id="myModalCliente">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-users "></i> CLIENTES </h4>
              </div>
              <div class="modal-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                      <li class="active"><a href="#tab_1" data-toggle="tab">LISTA DE CLIENTES</a></li>
                      <li><a href="#tab_2" data-toggle="tab">NUEVO CLIENTE</a></li>
        
                      <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                    </ul>
                    <div class="tab-content">
                      <div class="tab-pane active" id="tab_1">
                            <table id="example2" class="table table-bordered table-striped table-hover table-responsive">
                               <thead>
                                    <tr>
                                        <th>CI/RUC</th>
                                        <th>Nombres</th>
                                        <th>Correo</th>
                                        <th></th> 
                                    </tr>
                                </thead>
                            
                                <?php foreach($allcl as $registro2){
                                    if (strlen($registro2['cedula']) > 9) { ?>
                                <tbody>
                                <tr>
                                    <td><?php echo $registro2['cedula'] ?></td>
                                    <td><?php echo $registro2['nombres']?></td>
                                    <td><?php echo $registro2['correo'] ?></td>
                                    <td ><a href="javascript:param(<?php echo $registro2['id_cliente'] ?>)"
                                            <span class="custom-close-cl" > AGREGAR <i class="fa fa-check-circle" ></i></span></a></td>
                                </tr>
                                </tbody>
                                <?php }} ?>
                                
                            </table>
                        </div><!-- FIN PANEL 1 -->
  

<div class="tab-pane" id="tab_2">
    <form action="../../../controlador/c_clientes/nuevo_cliente_ventas.php" id="formulario" method="post" class="form-horizontal" >

        <div class="form-group">
            <input name="laorden" type="hidden" value="<?php echo $laid ?>">
            <label class="col-md-5">C??dula / RUC <span class="ast">(*)</span></label>
            <div class="col-md-7">
            <input type="text" minlength="8" maxlength="13" id="_cedula" name="cedula" class="form-control" onkeypress="return soloNumeros(event)" required="" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-5">Nombres y Apellidos <span class="ast">(*)</span></label>
            <div class="col-md-7">
            <input type="text" id="_nombres" name="nombres" class="form-control" onkeypress="return caracteres(event)" />
            </div>
        </div>        
        
        <div class="form-group">
            <label class="col-md-5"> Correo Electr??nico</label>
            <div class="col-md-7">
            <input type="text" id="_correo" name="correo" class="form-control" />
            </div>
        </div>                    
        <div class="form-group">
            <label class="col-md-5"> Tel??fono</label>
            <div class="col-md-7">
            <input type="text" id="_telefono" name="telefono" class="form-control" onkeypress="return soloNumeros(event)"  />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-5"> Celular</label>
            <div class="col-md-7">
            <input type="text" id="_celular" name="celular" class="form-control" onkeypress="return soloNumeros(event)"  />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-5">Direcci??n</label>
            <div class="col-md-7">
            <input type="text" id="_direccion" name="direccion" class="form-control" />
            </div> 
        </div>
    
            <button type="reset" class="btn btn-default">Cancelar</button>
            <button type="submit" class="btn btn-success pull-right" value="Registrar" name="register" <?php echo $ss ?>>Guardar Datos</button>
            </form>
                      </div><!-- FIN PANEL 2-->
                    </div> <!-- FIN CONTENT -->
                  </div><!-- FIN DEL BODY-->
              </div>
    </div>
</div>
        </div>
        
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size:35px">
                  <span aria-hidden="true">&times;</span></button>
                    <div class="alert alert-danger">
                        <h4 class="modal-title"><i class="fa fa-cubes"></i> Buscar Producto</h4>
                    </div>
            </div>
            <div class="modal-body">
               <table id="example3" class="table table-bordered table-striped table-hover">
                   <thead>
                        <tr>
                            
                            <th>CATEGORIA</th>
                            <th>CODIGO</th>
                            <th>DESCRIPCION</th>                            
                            <th>SELECCION</th>
                        </tr>
                    </thead>
                 
                    <tbody>
                        <?php foreach($all as $regist){ ?>
                        <tr>
                            
                            <td><?php echo $regist['nombre'] ?></td>
                            <td><?php echo $regist['codproducto'] ?></td>
                            <td><?php echo $regist['nombreproducto'] ?></td>
                            <td ><a href="javascript:editarProducto(<?php echo $regist['idp'] ?>)">
                                    <span class="custom-close" > <i class="fa fa-check-circle" >A??adir</i></span></a></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                
                </table>
            </div>
            <div class="modal-footer">
                <!--<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>




<div class="modal fade" id="myModalBarras">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size:35px">
                  <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-cubes"></i> Lector de C&oacute;digo de Barras</h4>
            </div>
            <div class="modal-body">
               <div id="barcode">
                   <video id="barcodevideo" autoplay></video>
                   <canvas id="barcodecanvasg"></canvas> 
                </div>
                
                <canvas id="barcodecanvas"></canvas>
                <div id="result"></div>
            </div>
            <div class="modal-footer">
                <!--<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>



<script type="text/javascript" src="../../js/consulta_venta_codigo.js"></script>
<script type="text/javascript" src="../../js/consulta_cliente.js"></script>

<div class="content-wrapper">
    <section class="content-header">
      <h1>VENTAS / <b>FACTURACI&Oacute;N</b> </h1>

      <ol class="breadcrumb">
        <li><a href="?cid=dashboard/init"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <!--<li><a href="../in.php?cid=ventas/show_pendientes">Pendientas y M??s</a></li>-->
        <li><a href="../in.php?cid=ventas/frm_ver_ventas">Historial Ventas</a></li>
        <li><a href="../in.php?cid=ventas/frm_ventas_anuladas">Historial Ventas Anuladas</a></li>
        <li class="active"><a href="#">Facturaci??n</a></li>
      </ol>
    </section>
    

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-info">
                <p>- Seleccione el producto desde el boton c&oacute;digo. <button class="btn btn-warning btn-sm"><i class="fa fa-cubes"></i></button></p>
                <p>- Debe especificar el tipo de unidad y que este tipo tenga los campos llenos de Cantidad y Precio</p>
                <p>- La cantidad del campo en verde, ser&aacute; por el tipo de unidad que escogi&oacute;</p>
            </div>
        </div>
    
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box box-header with-border">
            <h3 class="box-title">Productos y carrito de compras </h3>
        </div>
    <div class="box-body">
<form class="form-horizontal" id="formulario" action="../../../controlador/c_ventas/reg_carrito.php" method="post" name="formulario">
        <input type="hidden" name="norden" value="<?php echo $laid ?>" />
        <input type="hidden" name="token" value="<?php echo $eltoken ?>" />
        <input class="form-control" type="hidden" name="empleado" value="<?php echo @$session_empleado ?>" />

        <div class="form-group">        
            <label class="col-md-3">C??digo</label>
            <div class="col-md-9">
                 <div class="input-group">
                   <input type="text" class="form-control" name="code" id="code" readonly="" required="" />
                   <span class="input-group-btn">
                        <button class="btn btn-warning btn-small" type="button" data-toggle="modal" data-target="#myModal" style="height:27px; line-height:10px"><i class="fa fa-cubes"></i>&nbsp;</button>
                        <!--<button class="btn btn-danger btn-small" type="button" data-toggle="modal" data-target="#myModalBarras" style="height:27px; line-height:10px"><i class="fa fa-barcode"></i>&nbsp;</button>-->
                   </span>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3">Nombre</label>
            <div class="col-md-9">
                <input type="text" class="form-control" id="_desc" name="desc" readonly="" required="" />
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3">Cant* Unidad</label>
            <div class="col-md-3">
                <input class="form-control" type="text" name="_stock" id="_stock" readonly="" required="" onkeypress="return soloNumeros(event)" />
            </div>
            
            <label class="col-md-3">Precio Unidad</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="_precio" id="_price" readonly="" required="" />
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3">Cant* Kilos</label>
            <div class="col-md-3">
                <input class="form-control" type="text" name="_kilo" id="_kilo" readonly="" required="" />
            </div>
            
            <label class="col-md-3">Precio Kilo</label>
            <div class="col-md-3">
                <input class="form-control" type="text" name="pkg" id="_price_kg" readonly="" />
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3">Cant* Libra</label>
            <div class="col-md-3">
                <input class="form-control" type="text" name="_libra" id="_libra" readonly="" required="" />
            </div>
            
            <label class="col-md-3">Precio Libra</label>
            <div class="col-md-3">
                <input class="form-control" type="text" name="plb" id="_price_lb" readonly="" />
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3">Cant* Gramos</label>
            <div class="col-md-3">
                <input class="form-control" type="text" name="_gramo" id="_gramo" readonly="" required="" />
            </div>
            
            <label class="col-md-3">Precio Gramo</label>
            <div class="col-md-3">
                <input class="form-control" type="text" name="pgr" id="_price_gr" readonly="" />
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3">Cant* Litros</label>
            <div class="col-md-3">
                <input class="form-control" type="text" name="_litro" id="_litro" readonly="" required="" />
            </div>
            
            <label class="col-md-3">Precio Litro</label>
            <div class="col-md-3">
                <input class="form-control" type="text" name="plt" id="_price_lt" readonly="" />
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3">Elegir</label>
            <div class="col-md-3">
               <select style="width: 100%;" name="elegir">
                    <option>-- Seleccione --</option>
                    <option>Unidad</option>
                    <option>Kilos </option>
                    <option>Libras</option>
                    <option>Gramos</option>
                    <option>Litros</option>
               </select>
            </div>
        
            <label class="col-md-3">Cantidad</label>
            <div class="col-md-3">
               <input type="number" step="0.01" class="form-control" name="_cantidad" required="" style="background: #7fff00ad;" />
            </div>
        </div>
        
         <div class="form-group">
            <label class="col-md-5">C&oacute;digo Promocional</label>
            <div class="col-md-7">
               <input type="text" class="form-control" name="promo" style="background: #7fff00ad;" placeholder="Opcional" />
            </div>
        </div>
            
            <div class="col-md-12">
                <center><button type="submit" name="register" class="btn btn-success"><i class="fa fa-check"></i> Agregar producto al carrito! &nbsp;</button></center>
            </div>        
</form>

 
<?php // Orden actual datos !!
    $datos = $db->prepare("SELECT * FROM c_venta_detalle v INNER JOIN c_mercaderia m ON m.codproducto = v.codigo 
                                    WHERE v.num_orden='$laid' AND v.estado='A'");
    $datos->execute();
    $all_datos = $datos->fetchAll();
 ?>
</div>
    
  </div>
        
        
        </div> <!-- FIN COL-MD-4 -->
        
        

<div id="contenido">
<?php if ($cant_suprema == 0) { ?>
<div class="col-md-6">
    <div class="box box-default">
        <!--<div class="box box-header with-border">
            <h3 class="box-title">Lista de productos en carrito</h3>
        </div>-->
    <div class="box-body">
        
    <table id="example" class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>DESCRIPCI??N</th>
                <th>PRECIO</th>
                <th>CANTIDAD</th>
                <th>IMPORTE</th>
                <th></th>
                <th></th>
           </tr> 
        </thead>
        
        <tbody>
            <?php foreach ($all_datos as $send) {
                $norden = $send['num_orden'];
                $laidel = $send['idventa']; ?>
            <tr>
                <td><?php echo @$send['nombreproducto'] ?></td>
                <td><?php echo @$send['precio'] ?></td>
                <td><?php echo @$send['cantidad'] ?></td>
                <td><?php echo @$send['importe'] ?></td>
                <td><span class="badge bg-yellow"><a style="color:white" href="vdu.php?cid=<?php echo $send['idventa'] ?>">
                    <i class="fa fa-edit" style="padding: 2px;"> </i> </a></span></td>
                <td><span class="badge bg-red"><a style="color:white" href="vde.php?cid=<?php echo $send['idventa'] ?>">
                    <i class="fa fa-trash" style="padding: 2px;"> </i></a></span></td>
            </tr>
        <?php } ?>
        </tbody>
        </table>
        </div>
    </div>
        
        
    <div class="box box-warning">
        <div class="box-body" style="background: #3e3e3e;color: #fff;">
            <label class="col-md-6">Importe Parcial:</label><label class="col-md-6"><strong><?php echo $signus. '0.00'; ?> </strong></label>
            <label class="col-md-6">Importe IVA <?php echo @$iva_valor ?>%:</label><label class="col-md-6"><?php echo $signus. '0.00'; ?></strong></label>
            <!--<label class="col-md-6">Descuento:</label><label class="col-md-6"><strong>$ 0</strong></label>-->
            <h3 class="col-md-6"><b>TOTAL:</b></h3><h3 class="col-md-6"><strong><?php echo $signus. '0.00'; ?></strong></h3>
        </div>
    </div>
</div>
<?php }elseif ($cant_suprema != 0) { ?>
    
    <?php
        $sql = $db->prepare("SELECT sum(importe) as imp FROM c_venta_detalle WHERE num_orden = '$laid'  AND estado = 'A'");
        $sql->execute();
        $rows = $sql->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $values) {
            $totalparcial = $values['imp'];
    
        // Consulta si los precios incluyen IVA
        $sqle = $db->prepare("SELECT * FROM c_iva WHERE estado = 'A'");
        $sqle->execute();
        $rowse = $sqle->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rowse as $valuese) {
            $incluye    = $valuese['incluido'];
            $iva_valor  = $valuese['valor'];
            
        }

        if ($incluye == 'SI') {
            $par = ($totalparcial * $iva_valor) / 100; // SOLO LA CANTIDAD GENERADA DEL IVA
            $pars = $totalparcial - $par; // EL PARCIAL CON EL IVA EN SI            
            
            $iva_dato = 0;
            $iva_dato = ($totalparcial * $iva_valor / 100);
            $total_a_pagar = $totalparcial;
        }else if ($incluye == 'NO'){
            $pars = $totalparcial; // EL PARCIAL CON EL IVA EN NO
            
            $iva_dato = 0;
            $iva_dato = ($totalparcial * $iva_valor) / 100;
            $total_a_pagar = ($totalparcial + $iva_dato);
        }
    }
?>    

<div class="col-md-6">
    <div class="box box-default">
        <!--<div class="box box-header with-border">
            <h3 class="box-title">Lista de productos en carrito</h3>
        </div>-->
    <div class="box-body">
        
    <table id="example" class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>DESCRIPCI??N</th>
                <th>PRECIO</th>
                <th>CANTIDAD</th>
                <th>IMPORTE</th>
                <th></th>
                <th></th>
           </tr> 
        </thead>
        
        <tbody>
            <?php foreach ($all_datos as $send) {
                $norden = $send['num_orden'];
                $laidel = $send['idventa']; ?>
            <tr style="background: #fdbf11bf;">
                <td><?php echo @$send['nombreproducto'] ?></td>
                <td><?php echo @$send['precio'] ?></td>
                <td><?php echo @$send['cantidad'] ?></td>
                <td><?php echo @$send['importe'] ?></td>
                <td><a href="vdu.php?cid=<?php echo $send['idventa'] ?>">
                    <span class="btn btn-default"><i class="fa fa-edit" style="padding: 2px;"> </i></span> </a></td>
                <td><a href="vde.php?cid=<?php echo $send['idventa'] ?>">
                    <span class="btn btn-default"><i class="fa fa-trash" style="padding: 2px;"> </i></span></a></td>
            </tr>
        <?php } ?>
        </tbody>
        </table>
        </div>
    </div>
    <div class="box box-warning">
        <div class="box-body" style="background: #3e3e3e;color: #fff;">
            <label class="col-md-6">Importe Parcial:</label><label class="col-md-6"><strong> <?php echo $signus. ' '. number_format($pars,$decimals) ?></strong></label>
            <label class="col-md-6">Importe IVA <?php echo $iva_valor ?>%:</label><label class="col-md-6"> <?php echo $signus. ' '. number_format(@$iva_dato,$decimals) ?></strong></label>
            <!--<label class="col-md-6">Descuento:</label><label class="col-md-6"><strong>$ 0</strong></label>-->
            <h3 class="col-md-6"><b>TOTAL:</b></h3><h3 class="col-md-6"><strong> <?php echo $signus. ' '. number_format(@$total_a_pagar, $decimals) ?></strong></h3>
        </div>
        <br />
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#fventa"><i class="fa fa-key"></i> FINALIZAR VENTA</button>
        
        <button class="btn btn-info" type="button" data-toggle="modal" data-target="#myModalCliente"><i class="fa fa-users"></i> BUSCAR CLIENTE</button>
    </div>
    
    
            
        
</div> <!-- FIN COL-MD-4-->

    </div> <!-- FIN CONTENIDO -->

</div> <!-- FIN ROW -->

<div class="modal fade" id="fventa">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <div class="alert alert-danger">
                    <h4 class="modal-title">FINALIZAR VENTA</h4>
                    <p>Si el cliente no se identifica, solo rellene los campos de Efectivo o Diferido</p>
                </div>
                
              </div>
              <div class="modal-body">
                <form method="post" action="../../../controlador/c_ventas/reg_facturar.php" class="form-horizontal">
        <input step="0.01" type="hidden" name="total_a_pagar" value="<?php echo $total_a_pagar ?>" />
        <input type="hidden" name="lafactura" value="<?php echo $laid ?>" />
        <input type="hidden" name="el_iva" value="<?php echo $iva_dato ?>" />
        <input type="hidden" name="iva_num" value="<?php echo $iva_valor ?>" />
        <input type="hidden" name="el_importe" value="<?php echo $pars ?>" />
        <input type="hidden" name="anio" class="form-control" value="<?php echo $year_zone ?>" />
      <input type="hidden" name="mes" class="form-control" value="<?php echo abs($month_zone) ?>" />
      <input type="hidden" name="dia" class="form-control" value="<?php echo $day_zone ?>" />
      
      <input type="hidden" name="eply" value="<?php echo $eply ?>" />
      
      
        <div class="form-group">
            <label for="inputEmail3" class="col-md-4 col-form-label">Identificaci&oacute;n </label>
            <div class="col-md-8">
                <input type="text" placeholder="C??dula" id="cedula" name="cliente_fc" class="form-control" onkeypress="return soloNumeros(event)" value="<?php echo $lacedula ?>" />
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-md-4 col-form-label">Nombres </label>
            <div class="col-md-8">
                <input type="text" placeholder="Nombre cliente" id="cliente" name="nombrecliente" class="form-control" onkeypress="return caracteres(event)" value="<?php echo $elnombre ?>" />
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-4">Forma (*)</label>
            <div class="controls">
                <div class="col-md-8">
                    <td> <select id="selectpago" name="selectpago" class="form-control" style="height: 35px">
                            <option value="Efectivo">Efectivo</option>
                            <option value="Diferido">Diferido</option>
                        </select>
                    </td>
                </div>
            </div>
       
    
        <div id="Efectivo" class="vehicle">

                <label for="inputEmail3" class="col-md-4 col-form-label">Efectivo </label>
                <div class="col-md-8">
                    <input type="number" step="0.01" placeholder="$" name="efectivo" id="efectivo" class="form-control" />                    
                </div>
        </div>            
                         
        <div id="Diferido" class="vehicle" style="display:none;">
                <label for="inputEmail3" class="col-md-4 col-form-label">Meses </label>    
                <div class="col-md-8">
                    <select name="meses" id="meses" class="form-control" style="height: 35px">
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
        <label for="inputEmail3" class="col-md-4 col-form-label">Descuento </label>
        <div class="col-md-8">
            <input type="number" step="0.01" min="0" placeholder="$" name="desc" class="form-control" />
        </div>
    </div>
    
    
    
    </div>
    
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">CERRAR</button>
                <button type="submit" name="facturare" class="btn btn-success" style="float: right;"><i class="fa fa-cart-plus"></i> FINALIZAR VENTA</button>
              </div>
            </div>
            
            </form>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

<?php } ?>
</section> <!-- FIN SECTION CONTENT -->

</div>


<?php
require_once ("../foot_unico.php");
}else{
    session_unset();
    session_destroy();
    header('Location:  ../../../index.php');
}?>

<script type="text/javascript">
    
    $(document).ready(function() {
    $('#exampleventas').DataTable( {
        "scrollY":        "320px",
        "scrollCollapse": true,
        "paging":         false
    } );
} );

    $(document).ready(function() {
    $('#example').DataTable( {
        "scrollY":        "120px",
        "scrollCollapse": true,
        "paging":         true
    } );
} );

$(document).ready(function() {
    $('#example3').DataTable( {
        "scrollY":        "600px",
        "scrollCollapse": true,
        "paging":         false
    } );
} );

$(document).ready(function() {
    $('#example2').DataTable( {
        
    } );
} );
</script>

<script type="text/javascript">
	$(document).ready(function(){
		$('#code').blur(function(){
			$.ajax({
				type:"POST",
				data:"idpro=" + $('#codes').val(),
				url:"../../../controlador/c_ventas/llenar.php",
				success:function(r){
					dato=jQuery.parseJSON(r);

					$('#nombrecliente').val(dato['nombres']);
				}
			});
		});
	});
</script>