<?php

  @$user = $_SESSION["correo"];
  
  
  $ver = $db->prepare("SELECT * FROM access WHERE a_perfil='$user' AND a_modulo=2 AND a_item=6");
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
  
  
  $ver_empleados = $db->prepare("SELECT * FROM c_empleados WHERE estado='A'");
  $ver_empleados->execute();
  $fetch_empleados = $ver_empleados->fetchAll(PDO::FETCH_ASSOC);
  
  $ver_sucursal = $db->prepare("SELECT * FROM c_sucursal WHERE id_estado=1");
  $ver_sucursal->execute();
  $fetch_sucursal = $ver_sucursal->fetchAll(PDO::FETCH_ASSOC);
?>

  <div class="content-wrapper">
    <section class="content-header">
      <h1>ADMINISTRACI&Oacute;N / <b>EMPLEADOS</b> / <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-default">
                <i class="fa fa-plus"></i> Nuevo
              </button> /  <a class="<?php echo @$pp ?>" href="../../datos/clases/pdf/pdfempleados.php" target="_blank"><img src="../img/pdf.png" width="30" /> Ver Informe</a></h1>
    </section>

<section class="content">
<div class="row">
    <div class="col-md-12">
<?php
    if (isset($_POST['register'])) { require_once ("../../controlador/c_empleados/reg_empleados.php"); }
    
    if (isset($_POST['args'])) { require_once ("../../controlador/c_empleados/reg_pagos.php"); }

 ?>

<div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Registro Nuevo Empleado</h4>
              </div>
              <div class="modal-body">
              <div class="box box-success">
    <div class="box-body">
    <div class="col-md-12">
            <div class="box-header with-border">
              <h3 class="box-title"><b>Importante:</b>  Los campos con (*) son obligatorios</h3>
            </div>
    
    <form id="formulario" method="post" class="form-horizontal" >

        <div class="box-body">    
        
        <div class="form-group">
            <label class="col-md-5">Fecha de Ingreso (*)</label>
            <div class="col-md-7">
            <input type="date" id="ingreso" name="ingreso" class="form-control" required="" />
            </div>
        </div>  
        <div class="form-group">
            <label class="col-md-5">Elegir Sucursal (*)</label>
            <div class="col-md-7">
	            <select class="form-control" name="sucursal" >
	                <?php	                        
	                    foreach ($fetch_sucursal as $valuesu) { ?> 
	                        <option value="<?php echo $valuesu['id_sucursal'] ?>"><?php echo $valuesu['nombre'] ?></option>
	                    <?php } ?>
	            </select>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-5">Elegir Perfil (*)</label>
            <div class="col-md-7">
	            <select class="form-control" id="acceso" name="acceso" >
	                <option value="0">EMPLEADO SIN ACCESO AL SISTEMA</option>
	                <?php 
	                    $stmt = $db->prepare("SELECT * FROM c_roles WHERE estado='A'");
	                    $stmt->execute();
	                    $all = $stmt->fetchAll();
	                        
	                    foreach ($all as $value) { ?> 
	                        <option value="<?php echo $value['idrol'] ?>"><?php echo $value['nombrerol'] ?></option>
	                    <?php } ?>
	            </select>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-5">CI/NIT (*)</label>
            <div class="col-md-7">
            <input type="text" id="cedula" name="cedula" class="form-control" required="" onkeypress="return soloNumeros(event)" />
            </div>
        </div>   

        <div class="form-group">
            <label class="col-md-5">Nombres  (*)</label>
            <div class="col-md-7">
            <input type="text" onkeypress="return caracteres(event)" name="nombres" class="form-control" required="" />
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-5">Apellidos (*)</label>
            <div class="col-md-7">
            <input type="text" onkeypress="return caracteres(event)" id="apellidos" name="apellidos" class="form-control" required="" />
            </div>
        </div>  
        
        <div class="form-group">
            <label class="col-md-5"> Sueldo</label>
            <div class="col-md-7">
            <input type="number" step="0.01" id="sueldo" maxlength="13" name="sueldo" class="form-control" />
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-5"> Correo Electrónico</label>
            <div class="col-md-7">
            <input type="email" id="correo" name="correo" class="form-control" />
            </div>
        </div> 
        
        <div class="form-group">
            <label class="col-md-5">Carnet </label>
            <div class="col-md-7">
            <input type="text" name="carnet" class="form-control" />
            </div>
        </div> 
        
        <div class="form-group">
            <label class="col-md-5">Lugar Nacimiento </label>
            <div class="col-md-7">
            <input type="text" onkeypress="return caracteres(event)" id="lugnac" name="lugnac" class="form-control" />
            </div>
        </div>  

        <div class="form-group">
            <label class="col-md-5">Fecha Nacimiento </label>
            <div class="col-md-7">
            <input type="date"  id="fecnac" name="fecnac" onchange="calcularEdad()" class="form-control" />
            </div>
        </div>  

        <div class="form-group">
            <label class="col-md-5"> Edad</label>
            <div class="col-md-7">
            <input type="text" id="edad" maxlength="3" name="edad" class="form-control" readonly="" onkeypress="return soloNumeros(event)" />
            </div>
        </div>
                           
        <div class="form-group">
            <label class="col-md-5"> Teléfono</label>
            <div class="col-md-7">
            <input type="text" id="telefono" maxlength="13" name="telefono" class="form-control" onkeypress="return soloNumeros(event)" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-5"> Celular</label>
            <div class="col-md-7">
            <input type="text" id="celular" maxlength="13" name="celular" class="form-control" onkeypress="return soloNumeros(event)" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-5">Dirección</label>
            <div class="col-md-7">
            <input type="text" id="direccion" name="direccion" class="form-control" />
            </div> 
        </div>
        <!--<div class="form-group">
            <label class="col-md-5">Estado Civil</label>
            <div class="col-md-7">
            <select id="estciv" name="estciv" class="form-control ">
                                <option value="0">Seleccione</option>
                                <option value="S"> Soltero/a </option>
                                <option value="C"> Casado/a </option>
                                <option value="U"> Unido/a </option>
                                <option value="D"> Divorcidado/a </option>
                                <option value="V"> Viudo/a </option>
                            </select>
            </div> 
        </div>
        <div class="form-group">
            <label class="col-md-5">Tipo Sangre</label>
            <div class="col-md-7">
            <select  id="tiposangre" name="tiposangre" class="form-control ">
                                <option value="0">Seleccione</option>
                                <option value="AB+"> AB (Positivo) </option>
                                <option value="AB-"> AB (Negativo) </option>
                                <option value="A+"> A (Positivo) </option>
                                <option value="A-"> A (Negativo) </option>
                                <option value="B+"> B (Positivo) </option>
                                <option value="B-"> B (Negativo) </option>
                                <option value="O+"> O (Positivo)</option>
                                <option value="O-"> O (Negativo)</option>
                            </select>
            </div> 
        </div>-->

        </div>


    
            </div>
            </div>
            </div><!-- /.tab-pane -->
              </div>
              <div class="modal-footer">
              <a href="#tab_1-1" class="btn bg-navy" data-toggle="tab"><i class="fa fa-reply"></i> Volver</a>
              <button type="reset" class="btn btn-default"><i class="fa fa-refresh"></i> Cancelar</button>
              <button type="submit" class="btn btn-success pull-right" name="register" <?php echo @$ss ?> ><i class="fa fa-check-square-o"></i> Guardar Datos</button>
              </div>
            </div>
            </form>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
<!-- /.modal -->

                <?php require_once ("../../controlador/c_empleados/paginarEmpleados.php"); ?>
      </div><!-- /.row -->
  </section>
</div>


<script>
    function calcularEdad() {
        var fecha =document.getElementById('fecnac').value;
        var hoy = new Date();
        var cumpleanos = new Date(fecha);
        var edad = hoy.getFullYear() - cumpleanos.getFullYear();
        var m = hoy.getMonth() - cumpleanos.getMonth();

    if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
        edad--;
    }
         document.getElementById('edad').value= edad;
        //return edad;
        //alert(edad);
}
</script>
