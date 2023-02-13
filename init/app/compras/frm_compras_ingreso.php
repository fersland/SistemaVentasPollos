<?php

    $eply = $_SESSION["empleado"];

    $session_usuario    = $_SESSION["usuario"];

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

<script type="text/javascript" src="../js/consulta_venta_codigo.js"></script>

<!--<script type="text/javascript" src="../js/consulta_mercaderia.js"></script>-->

<?php

    $empresa = 1;

        

    // Categorias    

    $sql1 = $db->prepare("SELECT * FROM c_categoria WHERE estado = 'A'");

    $sql1->execute();

    $all1 = $sql1->fetchAll(PDO::FETCH_ASSOC);

    

    // Proveedores

    $sql4 = $db->prepare("SELECT * FROM c_proveedor WHERE estado = 'A' ORDER BY nombreproveedor ASC");

    $sql4->execute();

    $all4 = $sql4->fetchAll(PDO::FETCH_ASSOC);

    

    // BUSCAR CODIGO DE PRODUCTO

    $registro = $db->prepare("select * from c_categoria where estado = 'A' ORDER BY id_categoria DESC");

    $registro->execute();

    $all = $registro->fetchAll(PDO::FETCH_ASSOC);

    

    // BUSCAR SUCURSALES DISPONIBLES

    $regsuc = $db->prepare("select * from c_sucursal where id_estado = 1 ORDER BY id_sucursal ASC");

    $regsuc->execute();

    $allsuc = $regsuc->fetchAll(PDO::FETCH_ASSOC);

?>

<script type="text/javascript">
    function duplicar()

{

var numero1 = parseFloat(document.formulario.ccajas.value);

var Resultado = numero1 * 2;

document.formulario.pcajas.value= Resultado;

}

 function residuo()

{

var numero1 = parseFloat(document.formulario.pneto.value);
var numero2 = parseFloat(document.formulario.pcajas.value);

var Resultado = numero1 - numero2;

document.formulario.stock.value= Resultado;

}
</script>

<div class="modal fade" id="myModal">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size:35px">

                  <span aria-hidden="true">&times;</span></button>

                    <h4 class="modal-title"><i class="fa fa-cubes"></i> BUSCAR POR CATEGORIAS</h4>

            </div>

            <div class="modal-body">

               <table id="lamerca" class="table table-bordered table-striped table-hover table-condensed table-responsive">

                   <thead>

                        <tr>

                            <th>CATEGORIA</th>

                            <th>DESCRIPCION</th>

                            <th></th>

                        </tr>

                    </thead>

             

                <tbody>

                    <?php foreach($all as $registro2){ ?>

                    <tr>

                        <td><?php echo $registro2['nombre']?></td>

                        <td><?php echo $registro2['observacion'] ?></td>

                            <td ><a href="javascript:categorias(<?php echo $registro2['nombre'] ?>)">

                                <span class="custom-close" >SELECCIONAR <i class="fa fa-check-circle" ></i></span></a></td>

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



<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper" >

    <section class="content-header">

      <h1><b>Compras</b> / Ingreso de mercaderia por factura de Compra  <?php //echo $session_usuario ?></small></h1>

      <ol class="breadcrumb">

        <li><a href="?cid=dashboard/init"><i class="fa fa-dashboard"></i> Inicio</a></li>

        <li><a href="#">Compras</a></li>

        <li class="active">Ingreso de mercaderia</li>

      </ol>

    </section>



<!-- Main content -->

<section class="content">

<div class="row">

    <div class="col-md-12">
    
<?php

echo '<br />';

 if (isset($_POST['register']) && $_SERVER['REQUEST_METHOD'] === 'POST' ){ require_once ("../../controlador/c_compras/reg_compra_detalle.php"); }else{}

 if(isset($_GET["success"]) &&  $_GET["success"] == true){
    echo '<div class="alert alert-success">
        <b><i class="fa fa-check"></i> Añadido a la lista!</b>
    </div>';
    
    //$_SESSION["success"] = false;
 }else{}

if (isset($_POST['comprar'])){ require_once ("../../controlador/c_compras/reg_compra.php"); }

    $com = DBSTART::abrirDB()->prepare("SELECT * FROM c_compra_detalle c WHERE c.estado = 'A' AND c.id_usuario='$session_usuario'");

    $com->execute();

    $rowslista = $com->fetchAll(PDO::FETCH_ASSOC);

    $verifica_compra_activa = $com->rowCount();



    

    foreach ($rowslista as $deures) { // extraer el número de compra

        $nco = $deures['ncompra'];    // Extraer el el numero de compra

        $pid = $deures['id_prov_cd']; // Extraer el proveedor

        $ivas = $deures['iva']; // Extraer el IVA

        $fechaco = $deures['fechac']; // Extraer Fecha

    }



    // Si existe la compra con el mismo proveedor

    if ($verifica_compra_activa > 0) {

        $readonly = "readonly";

        @$datoncompra = $nco;

        if ( $pid == 0 ) {

            $datoprov = "0";

        }else{

            $datoprov = $pid;

        }

    }else{

        @$datoncompra = "";

        $pid = 0;

        $readonly = "";

    }


// NUEVA TRANSACCION DE COMPRAS DETALLE 12/NOV/22
$thenew = DBSTART::abrirDB()->prepare("SELECT * FROM c_iva");
    $thenew->execute();
    $ithenew = $thenew->fetch();
    $el_impuesto = $ithenew['impuesto'];

    // La lista de compras

    $list = $db->prepare("SELECT * FROM c_compra_detalle cd 
                            WHERE cd.ncompra = '$datoncompra'
                                AND cd.estado = 'A' AND cd.id_usuario='$session_usuario' ORDER BY cd.idcompra DESC");
    $list->execute();
    $all_list = $list->fetchAll(PDO::FETCH_ASSOC);
    $nuevonum = $list->rowCount();

    // Totales parciales
    $parc = $db->prepare("SELECT SUM(cc.importe) AS import, SUM(cc.descuento) AS thedesc, cc.iva, cc.fechac, cc.imaxn, SUM(cc.falta) as lafalta, cc.sidescuento
                                    FROM c_compra_detalle cc
                                            WHERE cc.ncompra = '$datoncompra' AND cc.estado = 'A' AND cc.id_usuario='$session_usuario'");
    $parc->execute();
    $all_parc = $parc->fetchAll(PDO::FETCH_ASSOC);

    foreach ( (array) $all_parc as $insertion ) {
        $elparcial = $insertion['import'];
        $iva_valor = $insertion['iva'];
        $parcial_sin_iva = ($elparcial * $iva_valor) / 100;
        $par = $elparcial - $parcial_sin_iva;
        $eldescuen = $insertion['thedesc'];
        $valor_en_iva = $elparcial * $iva_valor / 100;
        $total_comprado = 0;
        $total_comprado = $elparcial - $eldescuen;
        $fechacc = $insertion['fechac'] ;
        $imaxn = $insertion['imaxn'];
        $lafalta = $insertion['lafalta'];

        $sunset = $total_comprado - $eldescuen; // NUEVO RESULTADO DE TOTAL Y SUBTOTALES
        $sidescuento = $insertion['sidescuento'];

        if ($sidescuento == 1) {
            $valor_supremo = $lafalta; //  antes => $sunset
        }elseif($sidescuento == 2){
            $valor_supremo = $sunset;
        }
    }

    

?>


   </div>

<div class="col-md-12">

      <!--<div class="callout callout-info" >

        <h4><i class="fa fa-info"></i> Importante!:</h4>

        <p>Los productos que se listen aqu&iacute; no estar&aacute;n disponibles para la venta hasta que usted lo seleccione y lo ponga en stock en el m&oacute;dulo kardex.</p>

      </div>-->

</div>

   

    

           
    




<div class="col-md-12">
        <div class="box box-info">
<form id="formulario" method="post" name="formulario" class="form-horizontal" enctype="multipart/form-data">

    <input type="hidden" required="required" readonly="readonly" id="pro" name="pro"/>

    <input type="hidden" name="idempresa" value="<?php echo $empresa ?>" />

    <input value="<?php echo $session_usuario ?>" name="usuario_session" type="hidden" />

    

    <input type="hidden" name="anio" class="form-control" value="<?php echo $year_zone ?>" />

      <input type="hidden" name="mes" class="form-control" value="<?php echo abs($month_zone) ?>" />

      <input type="hidden" name="dia" class="form-control" value="<?php echo $day_zone ?>" />


     <div class="box-header with-border">

              <h3 class="box-title"><b>Ingreso de mercaderia</b></h3>

              <p>Los campos en amarillo, se llenan sola una vez por factura de compra. (<span style="color:red">Para separar decimales utilizar punto no coma, por ejemplo: 9.50</span>)
                <button type="submit" class="btn btn-success btn-small pull-right" name="register" <?php echo @$ss ?>><i class="fa fa-check"></i> Agregar Producto a la lista</button></p>

            </div>

    <div class="box-body">

        <div class="form-group">

            <label class="col-md-1">No.de Factura </label>

            <div class="col-md-2">

                <input style="background:gold" class="form-control" type="text" id="_ncompra" name="ncompra" placeholder="# de Compra" value="<?php echo @$datoncompra ?>" <?php echo $readonly ?> required="" >

            </div>

                    

            <label class="col-md-1">Fecha </label>

            <div class="col-md-2">

                <input style="background:gold" class="form-control" type="date" name="fechacompra" value="<?php echo @$fechaco ?>" <?php echo $readonly ?> required="" />

            </div>
        

            <label class="col-md-1">Proveedor </label>

            <div class="col-md-3">

                <select id="id_prov" style="background:gold" name="proveedor" class="form-control" <?php echo $readonly; ?> required="" >

                    <?php foreach ($all4 as $key => $dd){ ?>

                    <?php if ($dd['id_proveedor'] == $datoprov) { ?>

                        <option style="background-color: turquoise" value="<?php echo $dd['id_proveedor']; ?>" selected><?php echo $dd['nombreproveedor']; ?></option>

                    <?php }else{ ?>

                        <option value="<?php echo $dd['id_proveedor']; ?>"><?php echo strtoupper($dd['nombreproveedor']); ?></option>                    

                    <?php } } ?>

                </select>

            </div>

            <label class="col-md-1">IVA</label>

                    <div class="col-md-1">

                    <input style="background:gold" class="form-control" type="text" name="iva" value="<?php echo @$ivas ?>" <?php echo $readonly ?> required="" onkeypress="return soloNumeros(event)" />

            </div>

        
</div>

        <div class="form-group">
            <label class="col-md-1"># de Código</label>

                <div class="col-md-2">

                    <input class="form-control" type="text" id="code" name="codigo" required="" placeholder="Código" />
                        
                </div>

            <label class="col-md-1">Categoria</label>
            <div class="col-md-2">
                <div class="input-group">
                    <select class="form-control" id="_cate" name="categoria">

                            <option value="0"> Seleccione </option>;

                            <?php foreach ( (array) $all1 as $res ) { ?>

                            <option value="<?php echo $res['nombre']; ?>"> <?php echo $res['observacion']; ?></option>\n";

                            <?php } ?>

                    </select>

                    

                    <span class="input-group-btn">

                    <button class="btn btn-warning btn-small" type="button" data-toggle="modal" data-target="#myModal" style="height:30px; line-height:10px"><i class="fa fa-search"></i>&nbsp;</button>

                    </span>

                </div>

            </div>            

            

                    <label class="col-md-1">Descripción </label>

                    <div class="col-md-2">

                    <input type="text" id="_desc" name="nombre" class="form-control" required="" />

                    </div>

          

                    <label class="col-md-1">Precio Compra </label>

                    <div class="col-md-2">

                    <input type="text" class="form-control" id="_price" name="precio_compra" required="" placeholder="$./" />

                    </div>                    

              </div>

                <div class="form-group">
	                <label class="col-md-1">Otros Impuestos </label>
	                <div class="col-md-2">
	                    <input type="" value="<?php echo $el_impuesto; ?>" name="valorz" >
	                    <input type="checkbox" name="el_impuesto" id="botoncheck" /> Activar
	                </div>
	            </div>

                

                <div class="form-group">

                    <!--<label class="col-md-2">Precio Venta </label>

                    <div class="col-md-4">

                    <input type="text" class="form-control" id="_pricev" name="precio_venta" required="" placeholder="$./" />

                    </div>-->



                    <label class="col-md-1">Tipo</label>

                    <div class="col-md-2">

                        <select name="tipo" class="form-control">

                            <option value="1">Unidad </option>

                            <option value="2">Kilos</option>

                            <option value="3">Caja</option>

                        </select>

                    </div>


                      <label class="col-md-1">Cantidad/Unidad</label>

                    <div class="col-md-2">

                    <input type="number" class="form-control" name="cantunidades" id="cantunidades" step="0.01" />

                    </div>
                    
                    
                    
                    <label class="col-md-1">Peso Neto SC-UY</label>

                    <div class="col-md-2">

                    <input type="number" class="form-control" name="pneto" id="pneto" step="0.01" required="" />

                    </div>
                    
                    
                      <label class="col-md-1">Cant. Cajas</label>

                    <div class="col-md-2">

                    <input type="text" class="form-control" name="ccajas" id="ccajas"  />

                    </div>
                    </div>

                    <div class="form-group">

                        <label class="col-md-1">Unidades Totales</label>

                    <div class="col-md-2">

                    <input type="number" class="form-control" name="utotales" id="utotales" step="0.01" />

                    </div>

                      <label class="col-md-1">Peso Cajas</label>

                    <div class="col-md-2">

                    <input type="text" class="form-control" onclick="duplicar();" name="pcajas" id="pcajas" />

                    </div>
                    
                                        
                    <label class="col-md-1">P.Mer.SC-UY </label>

                    <div class="col-md-2">

                    <input class="form-control" type="number" id="_stock" name="stock" onclick="residuo();" required="" step="0.01" />

                    </div>                

                    
                    <label class="col-md-1">Peso Merma UY </label>

                    <div class="col-md-2">

                        <input class="form-control" type="number" name="pmerma" id="pmerma" step="0.01" required="" />

                    </div>

        </div>
        

        <div class="form-group">
            <label class="col-md-1">Descuento </label>

            <div class="col-md-2">

                <input type="text" id="_desc" name="desc" class="form-control" placeholder="En dólares del precio x cantidad" value="0" />

            </div>    



            <label class="col-md-1">Imagen de producto</label>

            <div class="col-md-2">

                <input type="file" class="form-control" name="img" id="_ruta" />

            </div>


            <label class="col-md-1">F.Caducidad </label>

            <div class="col-md-2">

                <input type="date" name="caduca" class="form-control" id="caduca" required />

            </div> 


            <label class="col-md-1">Lote </label>

            <div class="col-md-2">

                <input type="" minlength="3" maxlength="10" name="lote" id="lote" class="form-control" />

            </div>    



            </div>

            
        </div>
        </form>

</div><!-- FIN BOX-INFO-->

    </div> <!-- FIN COL-MD-12 -->



</div>

<?php 
    

 ?>

<?php 

if ($nuevonum > 0) { ?>

<div class="row">
    <div class="col-md-12">
        <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title"><b>Listado de la compra</b></h3>
        </div>

        <div class="box-body">

              <table id="example" class="table table-bordered table-striped table-hover table-responsive">
                <thead>
                <tr>
                    <th>PCAJAS</th>
                    <th>CCAJAS</th>
                    <th>DESCRIPCION</th>
                    <th>LOTE</th>
                    <th>P.N.SC.UY</th>
                    <th>PREC. UNIT</th>
                    <th>P.N.SC</th>
                    <th>PS.MER.UY</th>
                    <th>IMPOR.-2.5%</th>
                    <th>PRECIO FINAL</th>
                    <th>2.5%</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ( (array) $all_list as $allset ) :
                    if ($allset['tipo'] == 1) {
                        $lacantidad = $allset['cantidad'];
                    }elseif($allset['tipo'] == 2){
                        $lacantidad = $allset['ckg'];
                    }elseif($allset['tipo'] == 3 ){
                        $lacantidad = $allset['cja'];
                    }
                ?>
                    <tr>
                        <td><?php echo $allset['pesocajas']; ?></td>
                        <td><?php echo $allset['cantcajas']; ?></td>
                        <td><?php echo $allset['descripcion']; ?></td>
                        <td><?php echo $allset['lote']; ?></td>
                        <td><?php echo $lacantidad; ?></td>
                        <td><?php echo $allset['precio_compra']; ?></td>
                        <td><?php echo $allset['pneto']; ?></td>
                        <td><?php echo $allset['pmerma']; ?></td>
                        <td><?php echo $allset['falta']; ?></td>
                        <td><?php echo $allset['importe']; ?></td>
                        <td><?php echo $allset['menosvalor']; ?></td>
                        <!--<td><a href="compras/frm_compras_edit.php?cid=<?php //echo $allset['idcompra'] ?>"><i style="font-size: 20px; color:turquoise" class="fa fa-edit"></i> </a>-->
                    <td>
                        <a href="compras/frm_compras_eli.php?cid=<?php echo $allset['idcompra'] ?>"><i style="font-size: 20px; color:crimson" class="fa fa-remove"></i> </a></td>

                    

                </tr>

        <?php endforeach; ?>

        <tfoot>
            <?php foreach ($all_list as $key => $value_send): ?>
                
            <?php endforeach ?>
        </tfoot>

        </tbody>

    </table>

    </div>

    </div> <!-- FIN HEADER COLORES RULZ -->
</div>
</div>
<?php } ?>

<div class="row">

<div class="col-md-3"></div>
<div class="col-md-6">

    <div class="box box-success">
            <form method="post" enctype="multipart/form-data">
            <div class="box-body">

                <input type="hidden" value="<?php echo $sidescuento ?>" name="sidescuento">

                        <input type="hidden" name="elprove" value="<?php echo $datoprov ?>" required="" />

                        <input type="hidden" class="form-control" name="ncompra" value="<?php echo $datoncompra ?>" required="" />

                        <input type="hidden" class="form-control" name="nempresa" value="<?php echo $empresa ?>" />

                        <input type="hidden" name="fecha" value="<?php echo $fechacc ?>" />

                        <input type="hidden" name="iva" value="<?php echo $iva_valor ?>" />

                        <input type="hidden" name="total_comprado" value="<?php echo $valor_supremo; ?>" />

                        <input type="hidden" name="anio" class="form-control" value="<?php echo $year_zone ?>" />

                        <input type="hidden" name="mes" class="form-control" value="<?php echo abs($month_zone) ?>" />

                        <input type="hidden" name="dia" class="form-control" value="<?php echo $day_zone ?>" />

                        <input type="hidden" name="eply" value="<?php echo $session_usuario ?>" />
                        <input type="hidden" name="imaxn" value="<?php echo $imaxn ?>" />

                            <div class="form-group">

                                <label class="col-md-5">Sub Total</label>

                                <div class="col-md-7">

                                    <input type="text" class="form-control" readonly="" id="_st" name="importe" value="<?php echo number_format($valor_supremo, 2); ?>"  required="" />

                                </div>

                            </div>

                            <div class="form-group">

                                <label class="col-md-5">En IVA</label>

                                <div class="col-md-7">

                                    <input type="text" class="form-control input-sm" readonly="" id="Display" name="dinero_iva" value="<?php echo number_format($valor_en_iva,2) ?>" required="" />

                                </div>

                            </div>                        

                            

                            <div class="form-group">

                                <label class="col-md-5">Descuento</label>

                                <div class="col-md-7">

                                <input type="text" class="form-control input-sm" name="desc" readonly="" value="<?php echo number_format($eldescuen,2) ?>" />

                                </div>

                            </div>

                            

                            <div class="form-group">

                                <label class="col-md-5">Forma</label>

                                <div class="col-md-7">

                                <select id="selectpago" class="form-control input-sm" name="forma">

                                    <option>Efectivo</option>

                                    <option>Diferido</option>

                                </select>

                                </div>

                            </div>

                

                            <div class="form-group">

                                <div class="col-md-12">

                                <div id="Efectivo" class="vehicle">

                                    <!--<div class="form-group">

                                        <label class="col-md-5">Efectivo</label>

                                        <div class="col-md-7">

                                            <input type="text" class="form-control input-sm" name="efectivo" value="0" />

                                        </div>

                                    </div>-->

                                </div>

                        

                                <div id="Diferido" class="vehicle" style="display:none;">

                                    <div class="form-group">

                                    <label class="col-md-5">Diferido</label>

                                    <div class="col-md-7">

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

                                </div>

                            </div>
                
                        </div>

                        <div style="background: black;color: chartreuse; padding: 2px;">

                            <center><h1><b>TOTAL: <?php echo number_format($valor_supremo, 2); ?></b></h1></center>

                        </div>

                <?php if ($nuevonum > 0) { ?>

                        <div class="form-row">

                <br />

                            <center><div class="form-group">

                                <div class="form-group">

                                    <label>Elija la sucursal donde se ingresaran los productos</label>

                                    <div class="">

                                        <select class="form-control" name="sucursal">

                                            <?php foreach((array) $allsuc as $values_sucursales): ?>

                                                <option value="<?php echo $values_sucursales['id_sucursal']; ?>"><?php echo $values_sucursales['nombre']; ?></option>

                                            <?php endforeach; ?>

                                        </select>

                                    </div>

                                </div>

                                <div class="form-group">
                                    <input type="file" class="form-control" name="fichero" id="_ruta" />
                                </div>

                                <button type="submit" class="btn btn-success btn-block" name="comprar" value="Finalizar"><i class="fa fa-check"></i> FINALIZAR COMPRA</button>

                            </div></center>

                        </div>

                <?php } ?>

                    </form>
            </div>    

            <div class="col-md-3"></div>

    </div>

    

</div><!-- FIN ROW -->

<script type="text/javascript">

$(document).ready(function() {
    $('#search').DataTable( {        

    } );
} );

// LLENAR DESCRIPCION POR SELECCION DE CATEGORIA

$(document).ready(function(){
		$('#_cate').blur(function(){
			$.ajax({
				type:"POST",
				data:"idpro=" + $('#_cate').val(),

				//url:"../../controlador/c_compras/llenar.php",

				success:function(r){
					dato=jQuery.parseJSON(r);
					//$('#_desc').val(dato['nombreproducto']);

				}
			});
		});
	});



// FOR JS AJAX THEM EXECUTION TRIM POST

$(document).ready(function() {
    $("#botoncheck").change(function() {
        if (!this.checked) {
            $("#ccajas").removeAttr('disabled');
            $("#ccajas").removeAttr('readonly');   

            $("#pcajas").removeAttr('disabled');
            $("#pcajas").removeAttr('readonly');            

            $("#cantunidades").removeAttr('disabled');
            $("#cantunidades").removeAttr('readonly');

            //$("#pneto").attr('disabled', 'disabled');       
            //$("#pneto").attr('readonly', 'true');  
            //$("#_stock").attr('disabled', 'disabled');       
            //$("#_stock").attr('readonly', 'true');  
            //$("#pmerma").attr('disabled', 'disabled');       
            //$("#pmerma").attr('readonly', 'true');  

			$("#caduca").removeAttr('disabled');
            $("#caduca").removeAttr('readonly'); 

            $("#lote").removeAttr('disabled');
            $("#lote").removeAttr('readonly'); 

            //$("#utotales").removeAttr('disabled');
            //$("#utotales").removeAttr('readonly');            

            
            
        
        }else { // SI ESTA ACTIVADO EL DESCUENTO 2.5%

        	/*$("#ccajas").attr('disabled', 'disabled');
            $("#ccajas").attr('readonly', 'true');           

            $("#pcajas").attr('disabled', 'disabled');
            $("#pcajas").attr('readonly', 'true');           

            $("#cantunidades").attr('disabled', 'disabled');
            $("#cantunidades").attr('readonly', 'true');    
        
            $("#pneto").removeAttr('disabled');
            $("#pneto").removeAttr('readonly');
            $("#_stock").removeAttr('disabled');
            $("#_stock").removeAttr('readonly');
            $("#pmerma").removeAttr('disabled');
            $("#pmerma").removeAttr('readonly');
            $("#caduca").attr('disabled', 'disabled');       
            $("#caduca").attr('readonly', 'true');  

            $("#lote").attr('disabled', 'disabled');       
            $("#lote").attr('readonly', 'true');

            //$("#utotales").attr('disabled', 'disabled');       
            //$("#utotales").attr('readonly', 'true');  */

            $("#ccajas").removeAttr('disabled');
            $("#ccajas").removeAttr('readonly');   

            $("#pcajas").removeAttr('disabled');
            $("#pcajas").removeAttr('readonly');            

            $("#cantunidades").removeAttr('disabled');
            $("#cantunidades").removeAttr('readonly');

            //$("#pneto").removeAttr('disabled');
            //$("#pneto").removeAttr('readonly');
            //$("#_stock").removeAttr('disabled');
            //$("#_stock").removeAttr('readonly');
            //$("#pmerma").removeAttr('disabled');
            //$("#pmerma").removeAttr('readonly');

            $("#caduca").removeAttr('disabled');
            $("#caduca").removeAttr('readonly'); 

            $("#lote").removeAttr('disabled');
            $("#lote").removeAttr('readonly'); 

            
        }
    });

    //triger change event in case checkbox checked when user accessed page
    $("#botoncheck").trigger("change")
});
</script>

</section>                    

<!-- ******** FIN DETALLE DE LA COMPRA ************** -->

</div>

<!--
<div class="row">

    <div class="col-12">
        <form id="formulario" method="post" name="formulario" class="form-horizontal" enctype="multipart/form-data">
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-success btn-small pull-right" name="register" <?php //echo @$ss ?>><i class="fa fa-check"></i> Agregar Producto a la lista test</button></p>
                </div>
            </div>
        </form>
    </div>
    
</div>
-->