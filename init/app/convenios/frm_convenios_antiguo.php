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
    </section>

<!-- Main content -->
<section class="content">
<div class="row">
    <div class="col-md-12">
        <?php if (isset($_POST['register'])) { require_once ("../../controlador/c_categorias/reg_categoria.php"); }?>
    </div><br />
        
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-body">
                    <div class="col-md-12">      
                        <?php require_once ("../../controlador/c_convenios/paginarConvenios.php"); ?>
                    </div>
                </div>
            </div>
        </div>
        
        
  </section>
</div>
