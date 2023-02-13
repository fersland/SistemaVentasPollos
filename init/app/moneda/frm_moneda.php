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

      <h1>ADMINISTRACI&Oacute;N / <b>MONEDA</b></h1>



    </section>

<section class="content" style="margin-top: -40px;">

<div class="row">

        <div class="col-md-12">

<?php if (isset($_POST['register'])) {

        require_once ("../../controlador/c_moneda/reg_moneda.php");

} ?>

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

            <label class="col-md-5">Nombre (*)</label>

            <div class="col-md-7">

            <input type="text" name="nombre" class="form-control" onkeypress="return caracteres(event)" />

            </div>

        </div>   

        

        <div class="form-group">

            <label class="col-md-5"> Abreviatura</label>

            <div class="col-md-7">

            <input type="text" name="abrv" class="form-control" />

            </div>

        </div>

        

        <div class="form-group">

            <label class="col-md-5"> Decimales (*)</label>

            <div class="col-md-7">

            <input type="number" name="dec" class="form-control" required="" />

            </div>

        </div>

        

        <div class="form-group">

            <label class="col-md-5"> Signo (*)</label>

            <div class="col-md-7">

            <input type="text" name="signo" class="form-control" required="" />

            </div>

        </div>



        </div>



    <div class="box-footer">

        <a href="#tab_1-1" class="btn bg-navy" data-toggle="tab"><i class="fa fa-reply"></i> Volver</a>

        <button type="reset" class="btn btn-default"><i class="fa fa-refresh"></i> Cancelar</button>

        <button type="submit" class="btn btn-success pull-right" value="Registrar" name="register" <?php echo @$ss ?>><i class="fa fa-check-square-o"></i> Guardar Datos</button>

    </div>

    </form>

            </div>

            </div>

            </div><!-- /.tab-pane -->

                </div>

                

                

    <div class="col-md-7">

                    <div class="box box-warning">

                        <div class="box-body">

                            <?php require_once ('./'."../../controlador/c_moneda/paginarMoneda.php"); ?>

                        </div>

                    </div>

                </div>







            

          

        </div><!-- /.col -->

      </div><!-- /.row -->

  </section>

</div>