<?php

  

  $ver = $db->prepare("SELECT * FROM access WHERE a_perfil='$session_usuario' AND a_modulo=2 AND a_item=22");

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



<div class="content-wrapper">

    <section class="content-header">

      <h1>ADMINISTRACI&Oacute;N / <b>PORCENTAJE VENTAS </b></h1>



    </section>

<section class="content" style="margin-top: -40px;">

<div class="row">

        <div class="col-md-12">

<?php if (isset($_POST['register'])) {

        require_once ("../../controlador/c_porcentaje/for_comprasvn.php");

} 

$compras = $db->prepare("SELECT * FROM tablerovn");
  $compras->execute();
  $icompras = $compras->fetch();?>

       <div class="alert alert-dismissible fade show" role="alert">

        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

       </div>

    

          

            

    <div class="col-md-5">

        <div class="box box-success">

        

        <div class="box-body">
        <div class="col-md-12">
            <div class="box-header with-border">
              <h3 class="box-title"><b>Importante:</b>  Los campos con (*) son obligatorios</h3>
            </div>

    

    <form id="formulario" method="post" class="form-horizontal" >

        <div class="box-body">   



        <div class="form-group">

            <label class="col-md-5">INGRESO DATO PATA (*)</label>

            <div class="col-md-7">

            <input type="text" name="pata" class="form-control" value="<?php echo $icompras['pata'] ?>" />

            </div>

        </div>   

        

        <div class="form-group">

            <label class="col-md-5"> INGRESO DATO MOLLEJA</label>

            <div class="col-md-7">

            <input type="text" name="molleja" class="form-control" value="<?php echo $icompras['molleja'] ?>" />

            </div>

        </div>

        

        <div class="form-group">

            <label class="col-md-5"> INGRESO DATO HIGADO (*)</label>

            <div class="col-md-7">

            <input type="" name="higado" class="form-control" required="" value="<?php echo $icompras['higado'] ?>" />

            </div>

        </div>

        

        <div class="form-group">

            <label class="col-md-5"> CANTIDADES UNIDADES DE POLLO DE CAJA 105 (*)</label>

            <div class="col-md-7">

            <input type="text" name="cinco" class="form-control" required="" value="<?php echo $icompras['de_cinco'] ?>" />

            </div>

        </div>


        <div class="form-group">

            <label class="col-md-5"> CANTIDADES UNIDADES DE POLLO DE CAJA 106, 107, 108, 109 (*)</label>

            <div class="col-md-7">

            <input type="text" name="seis" class="form-control" required="" value="<?php echo $icompras['de_seis'] ?>" />

            </div>

        </div>

        <div class="form-group">

            <label class="col-md-5"> PESO DE CAJA EN KILOS (*)</label>

            <div class="col-md-7">

            <input type="text" name="kilos" class="form-control" />

            </div>

        </div>



        </div>



    <div class="box-footer">

        <a href="#tab_1-1" class="btn bg-navy" data-toggle="tab"><i class="fa fa-reply"></i> Volver</a>

        <button type="reset" class="btn btn-default"><i class="fa fa-refresh"></i> Cancelar</button>

        <button type="submit" class="btn btn-danger pull-right" value="Registrar" name="register" <?php echo @$ss ?> ><i class="fa fa-check-square-o"></i> Guardar Datos</button>

    </div>

    </form>

            </div>

            </div>

            </div><!-- /.tab-pane -->

                </div>

                

                

    <div class="col-md-7">

                    <div class="box box-warning">

                        <div class="box-body">

                            <?php // require_once ('./'."../../controlador/c_moneda/paginarMoneda.php"); ?>

                        </div>

                    </div>

                </div>







            

          

        </div><!-- /.col -->

      </div><!-- /.row -->

  </section>

</div>