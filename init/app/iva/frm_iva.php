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
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        ADMINISTRACI&Oacute;N / <b>VALOR DEL IVA</b> / Activar o Inactivar el impuesto en "Ventas"</h1>
      <ol class="breadcrumb">
        
      </ol>
    </section>

<!-- Main content -->
<section class="content">
<div class="row"><br />
    <div class="col-md-12">
<?php
    if (isset($_POST['update'])) {
     require_once ("../../controlador/c_iva/act_iva.php");
  }

// Buscar el valor actual del IVA
    $stmt = DBSTART::abrirDB()->prepare("SELECT * FROM c_iva WHERE estado ='A'");
    $stmt->execute();
    $item = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $cant_item = $stmt->rowCount();

    //if($cant_item == 0 )
    
    foreach ( (array) $item as $last ){
        $nameiva = $last['valor'];
        $check = $last['incluido'];
        $imp = $last['impuesto'];

        if ($check == 'SI') {
          $son = 'checked';
        }elseif ($check == 'NO'){
          $son = 'unchecked';          
        }
    }
  ?>
    </div>
    <div class="col-md-6">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Actualizar el valor del IVA</h3>
              <hr />
              <p>Si marca la casilla, el precio de venta tendrán incluido ya el IVA</p>
              <p>Si no la marca, se le aumentará el impuesto desde el precio de venta asignado.</p>
            </div>
            <form id="formulario" method="post">
                <div class="box-body">
            <input type="hidden" required="required" readonly="readonly" id="pro" name="pro"/>
               <input type="hidden" name="idempresa" value="<?php echo $empresa ?>" />
               
                
                <div class="form-row">   
                    <div class="form-group col-md-12">
                        <label> Nuevo Valor</label>
                        <input type="text" name="iva" class="form-control" onkeypress="return soloNumeros(event)"  value="<?php echo $nameiva ?>" required="" />
                    </div>
                </div>

                <div class="form-row">   
                    <div class="form-group col-md-12">
                        <label> % MERMA TRASLADO SANTA CRUZ-UYUNI</label>
                        <input type="text" name="imp" class="form-control" value="<?php echo $imp ?>" required="" />
                    </div>
                </div>

                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="inc" <?php echo @$son ?> /> ¿ Los productos incluyen IVA ? 
                      </label>
                    </div>
                  </div>
                </div>
                
            </div>
                <div class="box-footer">
                <a href="?cid=dashboard/init" class="btn bg-navy"><i class="fa fa-reply"></i> Volver</a>
                <button type="reset" class="btn btn-default"><i class="fa fa-refresh"></i> Cancelar</button>
                <button type="submit" class="btn btn-warning pull-right" name="update" <?php echo @$ee ?>><i class="fa fa-check-square"></i> Actualizar Datos</button>
              </div>
            </form>
              </div>
          </div>
        </div>
  </section>
</div>