<?php

  

  $ver = $db->prepare("SELECT * FROM access WHERE a_perfil='$session_acceso' AND a_modulo=8 AND a_item=28");

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

    $ee = '';

  }elseif (@$edit == 'I'){

    @$ee = 'disabled';

  }



  if (@$dele == 'A'){

    @$dd = '';

  }elseif (@$dele == 'I'){

    @$dd = 'disabled';

  }

  

  $cliente = $db->prepare("SELECT distinct(t1.cliente), t1.cliente, t2.nombres FROM c_convenios t1 INNER JOIN c_clientes t2 ON t1.cliente = t2.cedula

                            WHERE t1.id_estado = 1");

  $cliente->execute();

  $fetcho = $cliente->fetchAll(PDO::FETCH_ASSOC);

  

?>



<div class="content-wrapper">

    <section class="content-header">

      <h1>Convenios / <b>Mantenimientos</b> </h1>

  

     

        <ol class="breadcrumb">

            <li>

                <form class="form-horizontal" action="../../datos/clases/pdf/pdf_convenios_param.php" target="_blank" method="post">

                    Seleccione el cliente

                    <select name="cliente">

                        <?php foreach((array) $fetcho as $results): ?>

                            <option value="<?php echo $results['cliente'] ?>"><?php echo $results['nombres'] ?></option>

                        <?php endforeach; ?>

                    </select>

                    <button class="btn btn-success btn-sm" name="success">Ver Reporte</button>

                    </form> </li>

            <li> <a class="<?php echo @$pp ?>" href="../../datos/clases/pdf/pdf_convenios_all.php" target="_blank"><img src="../img/pdf.png" width="30" /> GENERAL </a></li>

        </ol>

        <br>
        
    </section>



<!-- Main content -->

<section class="content">

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">

                <div class="box-body">
        <?php if (isset($_POST['new'])){
            $newfecha = htmlspecialchars($_POST['newfecha']);
            $punit = htmlspecialchars($_POST['punit']);
            $pkg = htmlspecialchars($_POST['pkg']);

            $process = $db->prepare("UPDATE c_empresa SET fechacaduca='$newfecha', punit='$punit', pkg='$pkg'");
            if($process->execute()){
                $tekken = $db->prepare("UPDATE c_convenios SET fechacaduca='$newfecha', pnuevo='$punit', pkilo='$pkg'");
                $tekken->execute();
                echo '<div class="alert alert-success"> <i class="fa fa-check"></i> PARAMETROS ACTUALIZADOS!!</div>';
            }else{
                echo '<div class="alert alert-warning">Error al cambiar la fecha. </div>';
            }
        } ?>
    

        <?php 
            // FECHA DE CADUCIDAD DE CONVENIO
            $thedate = $db->prepare("SELECT * FROM c_empresa");
            $thedate->execute();
            $ithedate = $thedate->fetch();
        ?>
            

<form method="post" class="form-horizontal">
    <div class="form-group">
        <label class="col-md-2">FECHA CADUCIDAD</label>
        <div class="col-md-6">
            <input type="date" class="form-control" name="newfecha" value="<?php echo $ithedate['fechacaduca']; ?>">
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-2">PRECIO UNIDAD</label>
    <div class="col-md-6">
                   <input type="decimal" step="0.01" class="form-control" name="punit" value="<?php echo $ithedate['punit']; ?>">
                
    </div>
    </div>

    <div class="form-group">
    <label class="col-md-2">PRECIO KG</label>
    <div class="col-md-6">
                   <input type="decimal" step="0.01" class="form-control" name="pkg" value="<?php echo $ithedate['pkg']; ?>">
                   
    </div>
    </div>
<button type="submit" name="new" class="btn btn-warning" style="height:27px; line-height:10px"><i class="fa fa-check"></i>&nbsp; ACTUALIZAR PARAMETROS DE CONVENIO</button>
    </form>
</div>
</div>
    <div class="col-md-12">

        <?php if (isset($_POST['register'])) { require_once ("../../controlador/c_categorias/reg_categoria.php"); }?>

    </div><br />

        

        <div class="col-md-12">

            <div class="box box-success">

                <div class="box-body">

                    <div class="col-md-12">      

                        <?php require_once ("../../controlador/c_convenios/pageConvenios.php"); ?>

                    </div>

                </div>

            </div>

        </div>

        

        

  </section>

</div>





?>