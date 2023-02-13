<?php
  $ver = $db->prepare("SELECT * FROM access WHERE a_perfil='$session_acceso' AND a_modulo=2 AND a_item=30");
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
      <h1>SEGURIDAD / <b>USUARIOS</b> </h1>
    <ol class="breadcrumb">
        
        
    </ol>
  </section>

<!-- Main content -->
<section class="content">
<div class="row"><br />
  <div class="col-md-12">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs pull-right">
        <!--<li><a href="#tab_2-2" data-toggle="tab">Cambiar Clave</a></li>-->
        <li><a href="#tab_2-3" data-toggle="tab"><i class="fa fa-photo"></i> Foto de Perfil</a></li>
        <li class="active"><a href="#tab_1-1" data-toggle="tab"><i class="fa fa-server"></i> Listado Usuarios</a></li>
        <li><a class="<?php echo @$pp ?>" href="../../datos/clases/pdf/pdfusuarios.php" target="_blank"><img src="../img/pdf.png" width="30" /></a></li>
        <li class="pull-left header"><i class="fa fa-th"></i> </li>
      </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="tab_1-1">
        <?php require_once ("../../controlador/c_usuarios/paginarUsuarios.php"); ?>
      </div>

    <div class="tab-pane" id="tab_2-3">
<div class="box box-success">
    <div class="box-body">

    <div class="col-md-6">
            <div class="box-header with-border">
              <h3 class="box-title"><b>Actualizar Imagen de Perfil:</b></h3>
            </div>
    
    <form method="post" class="form-horizontal" enctype="multipart/form-data" action="../../controlador/c_usuarios/edit_imagen.php">
        <div class="box-body">
                    
        <input type="hidden" value="<?php echo $_SESSION["usuario"] ?>" name="usuario" />
        <div class="form-group">
            <label class="col-md-5">Ingresar Imagen (*)</label>
            <div class="col-md-7">
            <input type="file" name="img" class="form-control" required="" />
            </div>
        </div>
       </div>

    <div class="box-footer">
        <a href="#tab_1-1" class="btn bg-navy" data-toggle="tab"><i class="fa fa-reply"></i> Volver</a>
        <button type="submit" class="btn btn-success pull-right" name="foto" <?php echo @$ss ?> ><i class="fa fa-check-square"></i> Guardar Datos</button>
    </div>
    </form>
            </div>
            </div>
        </div><!-- /.tab-pane -->
    </div><!-- /.tab-content -->
          </div><!-- nav-tabs-custom -->
        </div><!-- /.col -->
      </div><!-- /.row -->
  </section>
</div>