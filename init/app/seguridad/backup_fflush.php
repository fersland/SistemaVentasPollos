<?php
  
  $mysql = $db->prepare("UPDATE c_tokens SET modulo='2', item='5', active='A' WHERE id_usuario='$session_usuario' AND ntoken='$session_token'");
  $mysql->execute();
  
  $ver = $db->prepare("SELECT * FROM access WHERE a_perfil='$session_acceso' AND a_modulo=2 AND a_item=5");
  $ver->execute();
  $fetch = $ver->fetchAll(PDO::FETCH_ASSOC);

  foreach ($fetch as $key => $value) {
    $save = $value['sav'];
    $edit = $value['edi'];
    $dele = $value['del'];
    $prin = $value['pri'];
  }
  if (@$save == 'A') {
    $ss = '';
  }elseif (@$save == 'I'){
    $ss = "disabled";
  }

  if (@$prin == 'A'){
    $pp = '';
  }elseif (@$prin == 'I'){
    $pp = 'disabled';
  }

  if (@$edit == 'A'){
    $ee = '';
  }elseif (@$edit == 'I'){
    $ee = 'disabled';
  }

  if (@$dele == 'A'){
    $dd = '';
  }elseif (@$dele == 'I'){
    $dd = 'disabled';
  }
  
    $get_all_table_query = "SHOW TABLES";
    $statement = $db->prepare($get_all_table_query);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        SEGURIDAD / 
        <b>RESPALDO DE BASE DE DATOS</b>
      </h1>
      <ol class="breadcrumb">

      </ol>
    </section>

<!-- Main content -->
<section class="content">
<div class="row"><br />
    <div class="col-md-12">

    </div>
    <div class="col-md-6">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Seleccione las tablas a respaldar</h3>
            </div>
                <form action="../../controlador/c_seguridad/bd_exportar.php" id="export_form" method="post">
                    <div class="box-body">
                    <label class="conta"><input type="checkbox" id="all" /><span class="checkmark"></span> Seleccionar Todo &nbsp;&nbsp;</label>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                
                                <?php foreach($result as $table) { ?>
                                     <div class="checkbox">
                                      <label class="conta"><input type="checkbox" class="checkbox_table case1" name="table[]" value="<?php echo $table["Tables_in_sorymart_sorymarth"]; ?>" /> <span class="checkmark"></span> &nbsp;&nbsp;<?php echo $table["Tables_in_sorymart_sorymarth"]; ?></label>
                                     </div><br />
                                <?php } ?>
                            </div>
                        </div>
                        
                    </div>
                    <div class="box-footer">
                    <a href="?cid=dashboard/init" class="btn bg-navy">Volver</a>
                    <button type="reset" class="btn btn-default">Cancelar</button>
                    <input type="submit" name="submit" id="submit" class="btn btn-danger" value="Exportar Ahora!" />
                  </div>
                </form>
              </div>
          </div>
        </div>
  </section>
</div>

<script>
$(document).ready(function(){
 $('#submit').click(function(){
  var count = 0;
  $('.checkbox_table').each(function(){
   if($(this).is(':checked'))
   {
    count = count + 1;
   }
  });
  if(count > 0)
  {
   $('#export_form').submit();
  }
  else
  {
   alert("Por favor, seleccione al menos una tabla para exportar");
   return false;
  }
 });
});
</script>