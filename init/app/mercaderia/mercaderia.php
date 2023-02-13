<script>
$(function () {
    $(".custom-close").on('click', function() {
        $('#myModal').modal('hide');
    });
});
<?php

    // Categorias    
    $sql1 = $db->prepare("SELECT * FROM c_categoria WHERE estado = 'A'");
    $sql1->execute();
    $all1 = $sql1->fetchAll(PDO::FETCH_ASSOC);
    
    // Proveedores
    $sql4 = $db->prepare("SELECT * FROM c_proveedor WHERE estado = 'A' ORDER BY nombreproveedor ASC");
    $sql4->execute();
    $all4 = $sql4->fetchAll(PDO::FETCH_ASSOC);
    
    $sqlsucursal = $db->prepare("SELECT * FROM c_sucursal WHERE id_estado = 1");
    $sqlsucursal->execute();
    $allsucursal = $sqlsucursal->fetchAll();
?>
</script>

  <div class="content-wrapper">
    <section class="content-header">
      <h1>INVENTARIO / <b>KARDEX</b> </h1>
      <ol class="breadcrumb">
        <li><a href="?cid=dashboard/init"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active"><a href="?cid=mercaderia/mercaderia">Mercaderia</a></li>
      </ol>
    </section>

<div class="col-md-12">
    <!--<div class="alert alert-warning">
        <b><i class="fa fa-info"></i> PRECAUCI&Oacute;N</b>
        <p>- Al ingresar un producto, se hara una operaci&oacute;n aritmetica.
        por ejemplo: si usted elije ingresar Papel carta y en el tipo de unidad elige "Gramos" en la cantidad del tipo pone 20 le saldr&aacute; 20, pero en kilo, libra no reflejar&aacute; nada.</p>
        <p>- Si ingresa un producto en kilos, se proceder&aacute; a hacer una conversi&oacute;n, para vender en kilos, libras y gramos.</p>
        <p>- La fila C*_ se refiere a la cantidad disponible de kilo, libra, etc..</p>
    </div>
    
    -->
    <ul class="nav nav-tabs pull-right">  
    <li><form method="request" action="../../datos/clases/pdf/historial_inventario_param.php" target="_blank">
        Inventario Para : 
        <select onchange='this.form.submit()' name="sucursal">
            <option>- Seleccione -</option>
            <?php foreach((array) $allsucursal as $modelcase) : ?>
                <option value="<?php echo $modelcase['id_sucursal'] ?>"><?php echo $modelcase['nombre'] ?></option>
            <?php endforeach; ?>
        </select>
    </form></li>
    <li>
    <form method="request" action="../../datos/clases/pdf/pdfcad.php" target="_blank">
        Por Caducar : 
        <select onchange='this.form.submit()' name="sucursal">
            <option>- Seleccione -</option>
            <?php foreach((array) $allsucursal as $modelcase) : ?>
                <option value="<?php echo $modelcase['id_sucursal'] ?>"><?php echo $modelcase['nombre'] ?></option>
            <?php endforeach; ?>
        </select>
    </form>
    
    </li>
              
              </ul>
              <br />
</div>
<div class="col-md-12">
<?php
    /*if (isset($_POST['register'])) {
       require_once ("../../controlador/c_mercaderia/reg_producto.php");
    }*/
    
    
 ?>
</div>
<script type="text/javascript" src="../js/consulta_merca.js"></script>
<style>div.container {
        width: 80%;
    }</style>

<section class="content">
<div class="row">
    <div class="col-md-12">
        <?php if (isset($_POST['regkardex'])){require_once("../../controlador/c_mercaderia/reg_nuevo_producto.php");} ?>
    </div>

        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs pull-right">              
              <!--<li><a href="#tab_4-4" data-toggle="tab"><i class="fa fa-star"></i> Ingresar Compra al Stock</a></li>-->
              <li><a href="#tab_3-3" data-toggle="tab"><i class="fa fa-sort-up"></i> Salida</a></li>
              <li><a href="#tab_2-2" data-toggle="tab"><i class="fa fa-sort-desc"></i> Entrada</a></li>
              <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-default">
                <i class="fa fa-cubes"></i> NUEVO
              </button>

              <button class="btn" style="background: lightgreen">DISPONIBLES</button>
              <button class="btn" style="background: coral">NO DISPONIBLES</button>
              <li class="active"><a href="#tab_1-1" data-toggle="tab"><i class="fa fa-server"></i> Inventario</a></li>
              
              
              
              
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1-1">
                    <?php require_once ("../../controlador/c_mercaderia/paginarMerca.php"); ?>
                 </div>
    
                <div class="tab-pane" id="tab_2-2">
                    <?php require_once ("../../controlador/c_mercaderia/paginarMercaEntrada.php"); ?>
                </div>
                
                <div class="tab-pane" id="tab_3-3">
                    <?php require_once ("../../controlador/c_mercaderia/paginarMercaSalida.php"); ?>
                </div>
                
                <!--<div class="tab-pane" id="tab_4-4">
                <div class="alert alert-warning">
                    <p>Aqu&iacute; podr&aacute; seleccionar una compra completa y que los productos comprados de la compra que
                    seleccione, pasen directamente a estar disponibles en ventas.</p>
                </div>
                    <?php //require_once ("../../controlador/c_mercaderia/paginarCompra.php"); ?>
                </div>-->
                

                </div>
          </div><!-- nav-tabs-custom -->
        </div><!-- /.col -->
      </div><!-- /.row -->
  </section>
  
  
   <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <div class="alert alert-success">
                    <h4 class="modal-title"><i class="fa fa-cubes"></i> REGISTRAR NUEVO PRODUCTO</h4>
                    
                </div>
              </div>
            <form id="formulario" method="post" name="formulario" class="form-horizontal" enctype="multipart/form-data">
              <div class="modal-body" style="height: 350px; overflow-y: scroll;">

    <div class="box-body">
    	
    	<div class="form-group">

                    <label class="col-md-4">Seleccione la Sucursal </label>
                    <div class="col-md-8">
                    <select class="form-control" name="sucursal">
                            <?php foreach ( (array) $allsucursal as $allscurusal ) { ?>
                            <option value="<?php echo $allscurusal['id_sucursal'] ?>"> <?php echo strtoupper($allscurusal['nombre']); ?></option>\n";
                            <?php } ?>
                    </select>
                    </div>
            </div>

        <div class="form-group">
            <label class="col-md-4">Proveedor </label>
            <div class="col-md-8">
                <select id="id_prov" name="proveedor" class="form-control" <?php echo $readonly ?> required="" />
                    <?php foreach ($all4 as $key => $dd){ ?>
                    <?php if ($dd['id_proveedor'] == $datoprov) { ?>
                        <option style="background-color: turquoise" value="<?php echo $dd['id_proveedor'] ?>" selected><?php echo strtoupper($dd['nombreproveedor']); ?></option>
                    <?php }else{ ?>
                        <option value="<?php echo $dd['id_proveedor'] ?>"><?php echo strtoupper($dd['nombreproveedor']); ?></option>                    
                    <?php } } ?>
                </select>
            </div>
            </div>
            <div class="form-group">

                    <label class="col-md-4">Categoria </label>
                    <div class="col-md-8">
                    <select class="form-control" id="_cate" name="categoria">
                            <?php foreach ( (array) $all1 as $res ) { ?>
                            <option value="<?php echo $res['nombre'] ?>"> <?php echo strtoupper($res['nombre']); ?></option>\n";
                            <?php } ?>
                    </select>
                    </div>
            </div>
            <div class="form-group">
                    <label class="col-md-4">Tipo de Unidad</label>
                    <div class="col-md-8">
                        <select name="tipo" class="form-control">
                            <option value="1">Unidad </option>
                            <option value="2">Kilos</option>
                            <option value="3">Caja</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-4">Cantidad del Tipo</label>
                    <div class="col-md-8">
                    <input class="form-control" type="number" step="0.01" name="tunidad" required="" />
                    </div>
                </div>
            
            
            
            <div class="form-group">
                            <label class="col-md-4">C&oacute;digo</label>
                    <div class="col-md-8">
                    <input class="form-control" type="text" id="code" name="codigo" required="" placeholder="C&oacute;digo" />
                    </div>
            </div>
            
            <div class="form-group">
                    <label class="col-md-4">Descripci&oacute;n </label>
                    <div class="col-md-8">
                    <input type="text" id="_desc" name="nombre" class="form-control" required="" />
                    </div>
                 
                </div>
                
                <div class="form-group">
                            <label class="col-md-4">Peso Neto</label>
                    <div class="col-md-8">
                    <input class="form-control" type="number" step="0.01" name="pneto" required="" />
                    </div>
            </div>
            
            <div class="form-group">
                            <label class="col-md-4">Peso Merma</label>
                    <div class="col-md-8">
                    <input class="form-control" type="number" step="0.01" name="pmerma" required="" />
                    </div>
            </div>
                                
                <div class="form-group">
                    <label class="col-md-4">Precio x Unidad </label>
                    <div class="col-md-8">
                    <input type="number" step="0.01" class="form-control" name="precio_venta" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-4">Precio x Kilo </label>
                    <div class="col-md-8">
                    <input type="number" step="0.01" class="form-control" name="precio_kg" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-4">Imagen</label>
                    <div class="col-md-8">
                    <input type="file" class="form-control" name="img" />
                    </div>    
                </div>
                </div>
            </div>
            
        
        
              <div class="modal-footer">
                <a href="?cid=dashboard/init" class="btn btn-warning"><i class="fa fa-reply"></i> REGRESAR</a>
                <button type="submit" class="btn btn-success" name="regkardex" <?php echo @$ss ?>><i class="fa fa-check">AGREGAR PRODUCTO</i> </button>
              </div>
            </div>
            </form>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        
        
       <!-- MODAL PARA MOSTRAR INFORMACION DEL PRODUCTO -->
       <div class="modal fade" id="modal-info">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <div class="alert alert-warning">
                    <h4 class="modal-title"><i class="fa fa-eye"></i> INFORMACI&Oacute;N DEL PRODUCTO</h4>
                    
                </div>
              </div>
            <form id="formulario" method="post" name="formulario" class="form-horizontal" enctype="multipart/form-data">
              <div class="modal-body" >

    <div class="box-body">
        <div class="form-group">
            <label class="col-md-2">Proveedor </label>
            <div class="col-md-4">
                <input id="_prov" readonly="" />
            </div>
            
            <label class="col-md-2">Categoria </label>
            <div class="col-md-4">
                <input id="_nca" readonly="" />
            </div>    
        </div>
            <div class="form-group">
                    <label class="col-md-2">C&oacute;digo</label>
                    <div class="col-md-4">
                        <input id="_cod" readonly="" style="width: 100%;" />                    
                    </div>
            
                    <label class="col-md-2">Descripci&oacute;n </label>
                    <div class="col-md-4">
                    <input id="_nom" readonly="" style="width: 100%;" />
                    </div>     
            </div>
                
            <div class="form-group">
                    <label class="col-md-3">Cant* Unidad </label>
                    <div class="col-md-3">
                    <input readonly="" id="_exi" style="width: 100%;" />
                    </div>
                    
                    <label class="col-md-3">Precio Unidad </label>
                    <div class="col-md-3">
                    <input readonly="" id="_pve" style="width: 100%;" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3">Cant* x Kilo </label>
                    <div class="col-md-3">
                        <input id="_kil" readonly="" style="width: 100%;" />
                    </div>
                    
                    <label class="col-md-3">Precio x Kilo </label>
                    <div class="col-md-3">
                        <input id="_pkg" readonly="" style="width: 100%;" />
                    </div>
                </div>                
                
                </div>
            </div>
            
        
        
              
            </div>
            </form>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
       <!-- FIN MUESTRA DE INFORMACION DEL PRODUCTO--> 
</div>

<script>

$(document).ready(function() {
    $('#entrada').DataTable( {

    } );
} );

$(document).ready(function() {
    $('#salida').DataTable( {

    } );
} );
</script>