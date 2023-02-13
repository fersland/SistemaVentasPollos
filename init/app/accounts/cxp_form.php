<?php
 session_start();
 if(isset($_SESSION["acceso"])) {
	require_once ('./'."../head_unico.php");
?>
<script type="text/javascript">

function sumar()
{
var numero1 = parseFloat(document.form1.uno.value);
var numero2 = parseFloat(document.form1.dos.value);
var Resultado = numero1 * numero2;
document.form1.res.value= Resultado;
}
/*
function cambio()
{
var numero1 = parseFloat(document.form1.rec.value);
var numero2 = parseFloat(document.form1.dos.value);
var Resultado = numero1 - numero2;
document.form1.cam.value= Resultado;
}*/
</script>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Contabilidad / <b>Cuentas por pagar</b></h1>

    </section>
<section class="content">
<div class="row"><br />
  <div class="col-md-12">
<?php
 if (isset($_POST['update'])) { // Actualizar datos

    $upd_id             = $_POST['p_id'];
    $upd_cant_cuotas    = $_POST['uno'];
    $upd_valores        = $_POST['res'];
    $upd_recibido       = $_POST['rec'];
    $upd_estado         = 1;
    $meses_pendientes   = $_POST['p_meses_pendientes'];
    $los_meses_totales  = $_POST['losmeses'];
    $cuotas_pagadas     = $_POST['cuotas_pagadas'];
    $forma = $_POST['forma'];
    
    $mensaje = $meses_pendientes - $upd_cant_cuotas;
    $meses_restantes = $meses_pendientes - $upd_cant_cuotas;
    $los_meses_pagados = $cuotas_pagadas + $upd_cant_cuotas;
    
    if ($mensaje == 0) {
        $estado_mensaje = 'CANCELADO';
    }else if ($mensaje > 0){
        $estado_mensaje = 'DEBE';
    }
    
    
    if ($upd_cant_cuotas > $meses_pendientes){
        echo '<div class="alert alert-danger">
                        <b><i class="fa fa-remove"></i> Error, los meses a pagar no debe ser mayor a los meses de deuda!</b>
                    </div>';
    }else{
    
    if ($forma == 'Efectivo') {
    
        if ($upd_recibido < $upd_valores){
            echo '<div class="alert alert-warning">
                <b>El pago es insuficiente.. </b>
                </div>'; 
        }else{
            
            $upd_cambio = $upd_recibido - $upd_valores;
    
           $stmt = $db->prepare("INSERT INTO c_cxp_detalle (account, num_cuotas, valor_cuotas, recibido, cambio, meses_restantes, meses_pagados, estado, forma)
                     VALUES ('$upd_id', '$upd_cant_cuotas', '$upd_valores', '$upd_recibido', '$upd_cambio','$meses_restantes', '$los_meses_pagados', '$upd_estado', '$forma') ");
           if ($stmt->execute(array($upd_id)) ) {
            // Debitar cxc
            $restar = $db->prepare("UPDATE c_cxp SET saldo=saldo-'$upd_valores', cuotas_pagadas=cuotas_pagadas+'$upd_cant_cuotas', 
            cuotas_pendientes='$meses_restantes', estado='$estado_mensaje' WHERE id_cxp='$upd_id'");
            $restar->execute();
             echo '<div class="alert alert-success">
                        <b>Pago realizado correctamente! <a href="../in.php?cid=accounts/cxp">Volver</a></b>
                    </div>'; 
           }else{
             echo '<div class="alert alert-danger">
                        <b>Error al pagar!</b>
                    </div>';
           }
       }
   }
   
   if($forma == 'Cheque'){
        $upd_cambio = 0;
        $upd_recibido = $upd_valores;
        
        $stmt = $db->prepare("INSERT INTO c_cxp_detalle (account, num_cuotas, valor_cuotas, recibido, cambio, meses_restantes, meses_pagados, estado, forma)
                     VALUES ('$upd_id', '$upd_cant_cuotas', '$upd_valores', '$upd_recibido', '$upd_cambio','$meses_restantes', '$los_meses_pagados', '$upd_estado', '$forma') ");
           if ($stmt->execute(array($upd_id)) ) {
            // Debitar cxc
            $restar = $db->prepare("UPDATE c_cxp SET saldo=saldo-'$upd_valores', cuotas_pagadas=cuotas_pagadas+'$upd_cant_cuotas', 
            cuotas_pendientes='$meses_restantes', estado='$estado_mensaje' WHERE id_cxp='$upd_id'");
            $restar->execute();
             echo '<div class="alert alert-success">
                        <b><i class="fa fa-check"></i> Pago en '.$forma.' realizado correctamente! <a href="../in.php?cid=accounts/cxp">Volver</a></b>
                    </div>'; 
           }else{
             echo '<div class="alert alert-danger">
                        <b>Error al pagar!</b>
                    </div>';
           }
        
   }
   
   if($forma == 'Tarjeta'){
        $upd_cambio = 0;
        $upd_recibido = $upd_valores;
        
        $stmt = $db->prepare("INSERT INTO c_cxp_detalle (account, num_cuotas, valor_cuotas, recibido, cambio, meses_restantes, meses_pagados, estado, forma)
                     VALUES ('$upd_id', '$upd_cant_cuotas', '$upd_valores', '$upd_recibido', '$upd_cambio','$meses_restantes', '$los_meses_pagados', '$upd_estado', '$forma') ");
           if ($stmt->execute(array($upd_id)) ) {
            // Debitar cxc
            $restar = $db->prepare("UPDATE c_cxp SET saldo=saldo-'$upd_valores', cuotas_pagadas=cuotas_pagadas+'$upd_cant_cuotas', 
            cuotas_pendientes='$meses_restantes', estado='$estado_mensaje' WHERE id_cxp='$upd_id'");
            $restar->execute();
             echo '<div class="alert alert-success">
                        <b><i class="fa fa-check"></i> Pago en '.$forma.' realizado correctamente! <a href="../in.php?cid=accounts/cxp">Volver</a></b>
                    </div>'; 
           }else{
             echo '<div class="alert alert-danger">
                        <b>Error al pagar!</b>
                    </div>';
           }
        
   }
   
   }
}

   $laid = isset($_GET['cid']) ? $_GET['cid'] : 0;

    $sql = $db->prepare("SELECT * FROM c_cxp cc INNER JOIN c_proveedor c ON c.id_proveedor = cc.id_proveedor  WHERE cc.id_cxp = ?");
    $sql->execute(array($laid));
    $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $key => $value) {
      $cid_id         = $value['id_cxp'];
      $cid_ced        = $value['ruc'];
      $cid_nom        = $value['nombreproveedor'];
      $cid_total      = $value['total'];
      $cid_diferido   = $value['diferido'];
      $cid_meses      = $value['cuotas_pendientes'];
      $cid_saldo      = $value['saldo'];
      $cid_max              = $value['cuotas_pendientes'];
      $las_cuotas_pagadas   = $value['cuotas_pagadas'];
      $los_meses            = $value['meses'];
    }
?>
  </div>
    <div class="col-md-12">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Efectuar pago de la cuenta</h3>
            </div>
            <form method="POST" class="form-horizontal" id="form1" name="form1">
                <div class="box-body">
                    
                <div class="form-row">
                    <div class="form-group">
                    <input type="hidden" name="p_id" value="<?php echo $cid_id ?>" />
                          <label for="inputEmail3" class="col-sm-2 control-label">CI/NIT </label>
                          <div class="col-sm-2">
                            <input type="text" name="p_cedula" value="<?php echo $cid_ced ?>" class="form-control" onkeypress="return soloNumeros(event)" readonly="" />
                          </div>
                        
                          <label for="inputEmail3" class="col-sm-2 control-label">Nombres y Apellidos </label>
                          <div class="col-sm-3">
                            <input type="text" name="p_nombres" value="<?php echo $cid_nom ?>" class="form-control" onkeypress="return caracteres(event)" readonly="" />
                          </div>
                          
                          <input type="hidden" name="cuotas_pagadas" value="<?php echo $las_cuotas_pagadas ?>" />
                          <input type="hidden" name="losmeses" value="<?php echo $los_meses ?>" />
                          
                          <label for="inputEmail3" class="col-sm-1 control-label">Venta </label>
                          <div class="col-sm-2">
                            <input type="text" name="p_correo" value="<?php echo number_format($cid_total, 2) ?>" class="form-control" readonly="" />
                          </div>
                    </div>
                </div>
                <div class="form-row">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Meses </label>
                  <div class="col-sm-2">
                    <input type="text" name="p_meses_pendientes" value="<?php echo $cid_meses ?>" onkeypress="return soloNumeros(event)"  class="form-control" readonly="" />
                  </div>
                
                  <label for="inputEmail3" class="col-sm-2 control-label">Saldo Pendiente </label>
                  <div class="col-sm-2">
                    <input type="text" name="p_direccion" value="<?php echo number_format($cid_saldo,2) ?>" class="form-control" readonly="" />
                  </div>
                  
                  <label for="inputEmail3" class="col-sm-2 control-label">Valor Cuota </label>
                  <div class="col-sm-2">
                    <input type="text" name="dos" id="dos" value="<?php echo number_format($cid_diferido, 2) ?>" onkeypress="return soloNumeros(event)"  class="form-control" readonly="" />
                  </div>
                </div>
                </div>
            </div>
              <div class="box-footer">
              <div class="form-row">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Forma Pago </label>
                      <div class="col-sm-2">
                        <select class="form-control" name="forma">
                            <option>Efectivo</option>
                            <option>Tarjeta</option>
                            <option>Cheque</option>
                        </select>
                      </div>
                  <label for="inputEmail3" class="col-sm-1 control-label">Cuotas </label>
                  <div class="col-sm-1">
                    <input type="text" value="1" name="uno" id="uno" onkeyup="sumar();" min="1" max="<?php echo $cid_max ?>" onkeypress="return soloNumeros(event)"  class="form-control" />
                  </div>
                
                  <label for="inputEmail3" class="col-sm-1 control-label">Valor </label>
                  <div class="col-sm-2">
                    <input type="text" name="res" id="res" onkeyup="sumar();" value="<?php echo number_format($cid_diferido,2) ?>" class="form-control" readonly="" />
                  </div>
                  
                  <label for="inputEmail3" class="col-sm-2 control-label">Recibido </label>
                  <div class="col-sm-1">
                    <input type="text" name="rec" id="rec" class="form-control" />
                  </div>
                  
                  <!--
                  <label for="inputEmail3" class="col-sm-2 control-label">Cambio </label>
                  <div class="col-sm-2">
                    <input type="text" name="cam" id="cam"  class="form-control" />
                  </div>-->
                </div>
              </div>
              
              
                <a href="../in.php?cid=accounts/cxp" class="btn bg-navy"><i class="fa fa-reply"></i> Volver</a>
                <button type="reset" class="btn btn-default"><i class="fa fa-refresh"></i> Cancelar</button>
                <button type="submit" class="btn btn-warning pull-right" name="update"><i class="fa fa-check-square-o"></i> REALIZAR PAGO DE CUOTA</button>
              </div>
    </form>
</div>
</div>
</div>
</section>
</div>
<?php
require_once ('./'."../foot_unico.php");
}else{
    session_unset();
    session_destroy();
    header('Location:  ../../../index.php');
}?>