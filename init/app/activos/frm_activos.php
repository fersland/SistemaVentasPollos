<?php
  $ver = $db->prepare("SELECT * FROM access WHERE a_perfil='$session_acceso' AND a_modulo=5 AND a_item=28");
  $ver->execute();
  $fetch = $ver->fetchAll(PDO::FETCH_ASSOC);

  foreach ($fetch as $key => $value) {
    $save = $value['sav'];
    $edit = $value['edi'];
    $dele = $value['del'];
    $prin = $value['pri'];
  }
  if ($save == 'A') {
    $ss = '';
  }elseif ($save == 'I'){
    $ss = "disabled";
  }

  if ($prin == 'A'){
    $pp = '';
  }elseif ($prin == 'I'){
    $pp = 'disabled';
  }

  if ($edit == 'A'){
    $ee = '';
  }elseif ($edit == 'I'){
    $ee = 'disabled';
  }

  if ($dele == 'A'){
    $dd = '';
  }elseif ($dele == 'I'){
    $dd = 'disabled';
  }
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Inventario
        <small>Activos</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?cid=dashboard/init"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="?cid=mercaderia/mercaderia">Mercaderia</a></li>
        <li><a href="?cid=herramientas/frm_herramientas">Herramientas</a></li>
        <li class="active"><a href="?cid=activos/frm_activos">Activos</a></li>
      </ol>
    </section>
<!-- Main content -->
<section class="content">
<div class="row"><br>
    <div class="col-md-12">
<?php
    if (isset($_POST['register'])) {
       require_once ("../../controlador/c_activos/reg_activos.php");
    }
 ?>
    </div>
        <div class="col-md-12">
          <!-- Custom Tabs (Pulled to the right) -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs pull-right">
              <li><a href="#tab_2-2" data-toggle="tab">Nuevo Activo</a></li>
              <li class="active"><a href="#tab_1-1" data-toggle="tab">Ver Activos</a></li>
              <!--<li><a href="../../../datos/clases/excel/ex_clientes.php"><img src="../../img/excel.png" width="30" /></a></li>-->
              <li><a class="<?php echo $pp ?>" href="../../datos/clases/pdf/pdfactivos.php" target="_blank"><img src="../img/pdf.png" width="30" /></a></li>
              <li class="pull-left header"><i class="fa fa-th"></i></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1-1">
                <?php require_once ("../../controlador/c_activos/paginarActivos.php"); ?>
              </div>

<div class="tab-pane" id="tab_2-2">
<div class="box box-success">
    <div class="box-body">
    <div class="col-md-6">
        <div class="box-header with-border">
            <h3 class="box-title"><b>Importante:</b>  Los campos con (*) son obligatorios</h3>
        </div>
    
    <form id="formulario" method="post" class="form-horizontal" >
        <input type="hidden" name="usuario" value="<?php echo $use ?>" />             
        
        <div class="form-group">
            <label class="col-md-5">Proveedor <span class="ast">*</span></label>
            <div class="col-md-7">
            <input class="form-control" type="text" id="_proveedor" name="proveedor" placeholder="" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-5">Fecha Adquisici??n <span class="ast">*</span></label>
            <div class="col-md-7">
            <input class="form-control" type="date" id="_fecha" name="fecha" placeholder=""/>
            </div>
        </div>        
        
        <div class="form-group">
            <label class="col-md-5"> N??mero de Factura <span class="ast">*</span></label>
            <div class="col-md-7">
            <input class="form-control" type="text" id="_nfactura" name="nfactura" placeholder="" />
            </div>
        </div>                    
        <div class="form-group">
            <label class="col-md-5"> Descripci??n del bien</label>
            <div class="col-md-7">
            <input class="form-control" type="text" id="_descripcion" name="descripcion" required="" />
            </div>
        </div>
    
        <div class="form-group">
            <label class="col-md-5"> Valor Adquisici??n</label>
            <div class="col-md-7">
            <input class="form-control" type="text" id="_valor" name="valor" required="" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-5"> Estado f??sico actual <span class="ast">*</span></label>
            <div class="col-md-7">
            <input class="form-control" type="text" id="_estado_f" name="estado_f" />
            </div> 
        </div>    
         
        <div class="form-group">
            <label class="col-md-5"> Ubicaci??n f??sica del bien</label>
            <div class="col-md-7">
            <input class="form-control" type="text" id="_ubicacion" name="ubicacion"  placeholder=""  />
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-5"> C??digo de la empresa</label>
            <div class="col-md-7">
            <input class="form-control" type="text" id="_codigo_e" name="codigo_e"  placeholder=""  />
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-5"> Persona Responsable</label>
            <div class="col-md-7">
            <input class="form-control" type="text" id="_ubicacion" name="persona"  placeholder=""  />
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-5"> Cantidad</label>
            <div class="col-md-7">
            <input class="form-control" type="text" id="_codigo_e" name="stock"  placeholder="" onkeypress="return soloNumeros(event)"  />
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-5"> Observaci&oacute;n</label>
            <div class="col-md-7">
            <input class="form-control" type="text" id="_codigo_e" name="obs"  placeholder=""  />
            </div>
        </div>
        
        <div class="form-group">
            <input type="submit" value="Registrar" name="register" class="btn btn-success" <?php echo $ss ?> />
            <input type="reset" value="Nuevo" class="btn btn-warning"/>
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