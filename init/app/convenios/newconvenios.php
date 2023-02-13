<?php
 session_start();
 if(isset($_SESSION["acceso"])) {
	require_once ("../head_unico.php");

    $laid = isset($_GET['cid']) ? $_GET['cid'] : 0; // id del cliente

    $ci = isset($_GET['ci']) ? $_GET['ci'] : 0; // Cedula del cliente

    // NOMBRE DEL CLIENTE CON CONVENIOS
    $si = $db->prepare("SELECT * FROM c_clientes WHERE cedula = '$ci'");
    $si->execute();
    $isi = $si->fetch();

    // EXTRAER LOS PRECIOS DE CONVENIOS EN EMPRESA
    $lamepresa = $db->prepare("SELECT * FROM c_empresa");
    $lamepresa->execute();
    $iempresa = $lamepresa->fetch();
?>



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
</script>

<script type="text/javascript" src="../../js/consulta_cliente.js"></script>

  <div class="content-wrapper">

    <section class="content-header"><h1>Inventario / <b>Convenios</b> <a href="../in.php?cid=convenios/frm_convenios" class="btn btn-warning" style="float:right"><i class="fa fa-reply"></i> Volver</a> </h1> <hr />

     Nombre de Cliente: <strong><?php echo $isi['nombres']; ?></strong>   </section>

<section class="content">

<div class="row">

   <!-- <div class="col-md-12">

        <div class="alert alert-info">

            <b><i class="fa fa-info"></i> Para realizar un nuevo precio a algun producto para este cliente, debe ingresar en los campos en verde y establecer la caducidad del convenio.</b>

        </div>

    </div>-->

  <div class="col-md-12">

<?php // Eliminar datos


// REGISTRAR NUEVO CONVENIOS *****************
if (isset($_POST['procesar'])) { require_once ("../../../controlador/c_convenios/registrarConvenios.php"); }

// UPDATE CONVENIOS *****************

if (isset($_POST['convenir'])) { require_once ("../../../controlador/c_convenios/actualizarConvenios.php"); }

    

    // PRIMERA LISTA DE MERCADERIA

    $registro = $db->prepare("
                                SELECT t1.existencia, t1.kilo, t1.idp, t1.codproducto, t1.categoria, t1.nombreproducto
                                      FROM c_mercaderia t1
                                     WHERE NOT EXISTS (SELECT NULL
                                                         FROM c_convenios t2
                                                        WHERE t2.codigo = t1.codproducto AND t2.cliente = '$ci')");
    $registro->execute();
    $all = $registro->fetchAll(PDO::FETCH_ASSOC);

    // SEGUNDA LISTA DE CONVENIOS 

    $scond = $db->prepare("SELECT * FROM c_convenios t1 WHERE t1.cliente = '$ci'");
    $scond->execute();
    $iscond = $scond->fetchAll(PDO::FETCH_ASSOC);

 ?>

  </div>


<div class="col-md-12">
    <div class="box">
        <div class="box box-header">
            <p>LISTADO DE PRODUCTOS PARA ACTUALIZAR</p>
        </div>
    <div class="box-body">
        <table id="example" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>CODIGO</th>
                    <th>CATEGORIA</th>
                    <th>PRODUCTO</th>
                    <th>PRECIO_UNIT</th>
                    <th>PRECIO_KG</th>
                    <th>NUEVO_PRECIO_UNT OTROS</th>
                    <th>NUEVO_PRECIO_KG RAU</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>

            <?php foreach( (array) $iscond as $key => $registro3){ ?>

            <form method="POST">
                <tr>
                    <td><?php echo @$registro3['codigo']; ?></td>
                    <td><?php echo @$registro3['categoria']; ?></td>
                    <td><?php echo @$registro3['nombreproducto']; ?></td>
                    <td><?php echo @$registro3['pnuevo']; ?></td>
                    <td><?php echo @$registro3['pkilo']; ?></td>
                    <input type="hidden" name="idp" value="<?php echo $registro3['id']; ?>" />
                    <td><input style="background: coral;" type="number" step="0.01" name="punidad" value="<?php echo $registro3['pnuevo']; ?>" /></td>
                    <td><input style="background: coral;" type="number" step="0.01" name="pkilo" value="<?php echo $registro3['pkilo']; ?>" /></td>
                    <td><button type="submit" class="btn btn-success btn-sm" name="convenir"><i class="fa fa-check-square-o"></i> ACTUALIZAR</button></td>
                </tr>
            </form>

                <?php } ?>  

            </tbody>

                           

        </table>

    </div>

</div>

</div>


<!-- INICIO LISTA DE DOS DE MERCADERIAS -->

<div class="col-md-12">



    <div class="box">
        <div class="box box-header">
            <p>LISTADO DE PRODUCTOS PARA REALIZAR CONVENIOS</p>
        </div>
    <div class="box-body">

        <table id="example" class="table table-bordered table-striped table-hover">

            <thead>

                <tr>
                    <th>CODIGO</th>
                    <th>CATEGORIA</th>
                    <th>PRODUCTO</th>

                    <th>NUEVO PRECIO UNT OTROS</th>

                    <th>NUEVO PRECIO KG RAU</th>
                    <th></th>

                </tr>

            </thead>

            

            <tbody>

            <?php foreach( (array) $all as $registro2) {?>

            <form method="post">

                <tr>
                    <td><?php echo @$registro2['codproducto']; ?></td>
                    <td><?php echo @$registro2['categoria']; ?></td>
                    <td><?php echo @$registro2['nombreproducto']; ?></td>
                    <input type="hidden" name="catel" value="<?php echo $registro2['categoria']; ?>" />
                    <input type="hidden" name="codconvenio" value="<?php echo $registro2['cod']; ?>" />

                    <input type="hidden" name="coder" value="<?php echo $registro2['codproducto']; ?>" />

                    <input type="hidden" name="cliente" value="<?php echo $ci ?>" />

                    <input type="hidden" name="nombreproducto" value="<?php echo $registro2['nombreproducto']; ?>" />

                    <input type="hidden" name="cantexistencia" value="<?php echo $registro2['existencia']; ?>" />

                    <input type="hidden" name="cantkilo" value="<?php echo $registro2['kilo']; ?>" />

                    <input type="hidden" name="idp" value="<?php echo $registro2['idp']; ?>" />
                    <input type="hidden" name="fechacaduca" value="<?php echo $iempresa['fechacaduca']; ?>" />

                    <td><input style="background: lightgreen;" type="number" step="0.01" name="punidad" value="<?php echo $iempresa['punit']; ?>" /></td>

                    <td><input style="background: lightgreen;" type="number" step="0.01" name="pkilo" value="<?php echo $iempresa['pkg']; ?>" /></td>

                    <td><button class="btn btn-warning btn-sm" name="procesar"> <i class="fa fa-check"></i> NUEVO</button></td>    

                </tr>

            </form>

                <?php } ?>  

            </tbody> 

            <tfoot>
                <tr>
                    <th>CODIGO</th>
                    <th>CATEGORIA</th>
                    <th>PRODUCTO</th>

                    <th>NUEVO PRECIO UNT OTROS</th>

                    <th>NUEVO PRECIO KG RAU</th>

                    <th></th>

                </tr>
            </tfoot>                    

        </table>

    </div>

</div>

</div>

<!-- FIN COL 2 -->


</div>
</section>

</div>

<?php require_once ("../foot_unico.php");

}else{

    session_unset();

    session_destroy();

    header('Location:  ../../../../index.php');

}?>