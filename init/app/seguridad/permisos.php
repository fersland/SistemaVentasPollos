<?php
    session_start();
    if(isset($_SESSION["acceso"]))  {
    
        require_once ("../head_unico.php");
        $cid = isset($_GET['cid']) ? $_GET['cid'] : 0;

        $sentencia = $db->prepare("SELECT * FROM c_roles WHERE idrol='$cid' AND estado= 'A'");
        $sentencia->execute();
        $name = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ( (array) $name as $all ) {
            $in = $all['idrol'];
            $na = $all['nombrerol'];
        }
        
        $upd = $db->prepare("select * from c_roles WHERE estado='A'");
        $upd->execute();
        $all_upd = $upd->fetchAll(PDO::FETCH_ASSOC);
        
        //Mostrar usuarios que pertenezcan al perfil
        $profile = $db->prepare("SELECT * FROM c_usuarios WHERE nivelacceso='$cid'");
        $profile->execute();
        $all_profile = $profile->fetchAll(PDO::FETCH_ASSOC);
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<link rel="stylesheet" href="../../dist/css/nativo.css" />

<div class="content-wrapper">
    <section class="content-header">
      <h1>Seguridad<small>Permisos</small></h1>
      <ol class="breadcrumb">
        <li><button><a href="../in.php?cid=seguridad/profile"><i class="fa fa-reply"></i> Volver</a></button></li>
        
      </ol>
    </section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="callout callout-success">
                <h4>Permisos!</h4>
                Asignar permisos del sistema para este perfil (<?php echo $na ?>)
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title"><i class="fa fa-star"></i> Nombre del Perfil</h3>
                </div>
                <center><h3><?php echo $na ?></h3></center><br />            
            </div>
        </div> <!-- FIN COL-MD-4 -->

        <div class="col-md-4">
            <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-user"></i> Usuarios</h3>
            </div>
                <center><?php foreach((array) $all_profile as $end) {
                echo ' <p>- <cite title="Source Title">'. $end['correo'].'<i class="icon-map-marker"></i></cite></p>';
                } ?></center>
            <br>
            </div>
            <br>
        </div> <!-- FIN COL-MD-4 -->
    </div>

<form action="../../../controlador/c_seguridad/cambiar_permisos.php" method="post">
    <input type="hidden" name="id_perfil" value="<?php echo $cid ?>" />   
<div class="row">
<div class="col-md-6">
    <div class="box box-primary">
            <div class="box-header with-border">
              <h3><i class="fa fa-shield"></i> SEGURIDAD <label class="conta"><input type="checkbox" id="todo1"><span class="checkmark"></span> Seleccionar Todo </label></h3>
            </div>
<?php
    $module = $db->prepare("SELECT * FROM access a INNER JOIN c_modulos_items mi ON mi.idcm = a.a_item 
                                                WHERE a.a_modulo = 1 AND a.a_perfil='$cid' ORDER BY a.a_item ASC ");
    $module->execute();
    $stmt = $module->fetchAll(PDO::FETCH_ASSOC); ?>

    <table class="table table-hover table-striped">
        <thead>
            <th>MODULE</th>
            <th>Read</th>
            <th>Save</th>
            <th>Edit</th>
            <th>Remove</th>
            <th>Print</th>
        </thead>
        
    <?php foreach ( (array) $stmt as $key => $value){
        if ($value['cs'] =='A') {
            $check = "checked";
        }else{
            $check = "unchecked";
        }

        if ($value['sav'] =='A') {
            $check_read = "checked";
        }else{
            $check_read = "unchecked";
        }
        
        if ($value['edi'] =='A') {
            $check_edi = "checked";
        }else{
            $check_edi = "unchecked";
        }
        
        if ($value['del'] =='A') {
            $check_del = "checked";
        }else{
            $check_del = "unchecked";
        }
        
        if ($value['pri'] =='A') {
            $check_pri = "checked";
        }else{
            $check_pri = "unchecked";
        }
    ?>
    <tbody>
    <tr>
    <td><?php echo $value['nombreitem'] ?></td>

    <td><label class="conta">
      <input type="checkbox" class="case1" name="val_seguridad[]" value="<?php echo $value['a_item'] ?>" <?php echo $check?> />
      <span class="checkmark"></span>
    </label></td>
    
    <td><label class="conta"><input class="case1" type="checkbox" name="val_re_seguridad[]" value="<?php echo $value['a_item']?>" <?php echo $check_read?>><span class="checkmark"></span></label> </td>
    <td><label class="conta"><input class="case1" type="checkbox" name="val_ed_seguridad[]" value="<?php echo $value['a_item']?>" <?php echo $check_edi?> ><span class="checkmark"></span></label> </td>
    <td><label class="conta"><input class="case1" type="checkbox" name="val_de_seguridad[]" value="<?php echo $value['a_item']?>" <?php echo $check_del?> ><span class="checkmark"></span></label> </td>
    <td><label class="conta"><input class="case1" type="checkbox" name="val_pi_seguridad[]" value="<?php echo $value['a_item']?>" <?php echo $check_pri?> ><span class="checkmark"></span></label> </td>
    </tr>
<?php } ?>
        </tbody>
    </table>
</div>
</div>

<div class="col-md-6">
    <div class="box box-info">
            <div class="box-header with-border">
              <h3><i class="fa fa-wrench"></i> ADMINISTRACIÓN <label class="conta"><input type="checkbox" id="todo2"><span class="checkmark"></span> Seleccionar Todo &nbsp;&nbsp;</label></h3>
            </div>
     
    <?php
                $module = $db->prepare(
                "SELECT * FROM access a INNER JOIN c_modulos_items mi ON mi.idcm = a.a_item WHERE a.a_modulo = 2 AND a.a_perfil='$cid' ORDER BY a.a_item ASC ");
                $module->execute();
                $stmt = $module->fetchAll(PDO::FETCH_ASSOC); ?>                

    <table class="table table-hover table-striped">
        <thead>
            <th>MODULE</th>
            <th>Read</th>
            <th>Save</th>
            <th>Edit</th>
            <th>Remove</th>
            <th>Print</th>
        </thead>
        
        
        <!--<button onClick="window.location.href=window.location.href" class="btn btn-warning main"> <span class="sub"></span><i class="fa fa-retweet"></i>  Reset</button>-->
        
    <?php foreach ( (array) $stmt as $key => $value){
        if ($value['cs'] =='A') {
            $check = "checked";
        }else{
            $check = "unchecked";
        }

        if ($value['sav'] =='A') {
            $check_read = "checked";
        }else{
            $check_read = "unchecked";
        }
        
        if ($value['edi'] =='A') {
            $check_edi = "checked";
        }else{
            $check_edi = "unchecked";
        }
        
        if ($value['del'] =='A') {
            $check_del = "checked";
        }else{
            $check_del = "unchecked";
        }
        
        if ($value['pri'] =='A') {
            $check_pri = "checked";
        }else{
            $check_pri = "unchecked";
        }
    ?>
    <tbody>
    <tr>
    <td><?php echo $value['nombreitem'] ?></td>
    <td><label class="conta"><input type="checkbox" class="case2" name="val_ad[]" value="<?php echo $value['a_item'] ?>" <?php echo $check?> /><span class="checkmark"></span></label></td>
    
    <td><label class="conta"><input type="checkbox" class="case2" name="val_re_ad[]" value="<?php echo $value['a_item']?>" <?php echo $check_read?>><span class="checkmark"></span></label> </td>
    <td><label class="conta"><input type="checkbox" class="case2" name="val_ed_ad[]" value="<?php echo $value['a_item']?>" <?php echo $check_edi?> ><span class="checkmark"></span></label> </td>
    <td><label class="conta"><input type="checkbox" class="case2" name="val_de_ad[]" value="<?php echo $value['a_item']?>" <?php echo $check_del?> ><span class="checkmark"></span></label> </td>
    <td><label class="conta"><input type="checkbox" class="case2" name="val_pi_ad[]" value="<?php echo $value['a_item']?>" <?php echo $check_pri?> ><span class="checkmark"></span></label> </td>
    </tr>
<?php } ?>
        </tbody>
    </table>
</div>
</div>
</div> <!-- FIN  ROW -->

<div class="row">
    <div class="col-md-6">
    <div class="box box-warning">
            <div class="box-header with-border">
              <h3><i class="fa fa-cc"></i> COMPRAS <label class="conta"><input type="checkbox" id="todo3" /><span class="checkmark"></span> Seleccionar Todo &nbsp;&nbsp;</label></h3>
            </div>
     
    <?php
                $module = $db->prepare(
                "SELECT * FROM access a INNER JOIN c_modulos_items mi ON mi.idcm = a.a_item WHERE a.a_modulo = 3 AND a.a_perfil='$cid' ORDER BY a.a_item ASC ");
                $module->execute();
                $stmt = $module->fetchAll(PDO::FETCH_ASSOC); ?>                

    <table class="table table-hover table-striped">
        <thead>
            <th>MODULE</th>
            <th>Read</th>
            <th>Save</th>
            <th>Edit</th>
            <th>Remove</th>
            <th>Print</th>
        </thead>        
        
        <!--<button onClick="window.location.href=window.location.href" class="btn btn-warning main"> <span class="sub"></span><i class="fa fa-retweet"></i>  Reset</button>-->
        
    <?php foreach ( (array) $stmt as $key => $value){
        if ($value['cs'] =='A') {
            $check = "checked";
        }else{
            $check = "unchecked";
        }

        if ($value['sav'] =='A') {
            $check_read = "checked";
        }else{
            $check_read = "unchecked";
        }
        
        if ($value['edi'] =='A') {
            $check_edi = "checked";
        }else{
            $check_edi = "unchecked";
        }
        
        if ($value['del'] =='A') {
            $check_del = "checked";
        }else{
            $check_del = "unchecked";
        }
        
        if ($value['pri'] =='A') {
            $check_pri = "checked";
        }else{
            $check_pri = "unchecked";
        }
    ?>
    <tbody>
    <tr>
    <td><?php echo $value['nombreitem'] ?></td>
    <td><label class="conta"><input type="checkbox" class="case3" name="val_compras[]" value="<?php echo $value['a_item'] ?>" <?php echo $check?> /><span class="checkmark"></span></label></td>
    <td><label class="conta"><input type="checkbox" class="case3" name="val_re_compras[]" value="<?php echo $value['a_item']?>" <?php echo $check_read?>> <span class="checkmark"></span></label></td>
    <td><label class="conta"><input type="checkbox" class="case3" name="val_ed_compras[]" value="<?php echo $value['a_item']?>" <?php echo $check_edi?> > <span class="checkmark"></span></label></td>
    <td><label class="conta"><input type="checkbox" class="case3" name="val_de_compras[]" value="<?php echo $value['a_item']?>" <?php echo $check_del?> > <span class="checkmark"></span></label></td>
    <td><label class="conta"><input type="checkbox" class="case3" name="val_pi_compras[]" value="<?php echo $value['a_item']?>" <?php echo $check_pri?> > <span class="checkmark"></span></label></td>
    </tr>
<?php } ?>
            </tbody>
        </table>
</div>
</div>

<!--  F I N   C O M P R A S -->


<!--  I N I C I O   V E N T A S  -->
<div class="col-md-6">
    <div class="box box-success">
            <div class="box-header with-border">
              <h3><i class="fa fa-cart-plus"></i> VENTAS <label class="conta"><input type="checkbox" id="todo4" <?php echo $checkedid ?>><span class="checkmark"></span> Seleccionar Todo &nbsp;&nbsp;</label></h3>
            </div>
<?php
$module = $db->prepare(
"SELECT * FROM access a INNER JOIN c_modulos_items mi ON mi.idcm = a.a_item WHERE a.a_modulo = 4 AND a.a_perfil='$cid' ORDER BY a.a_item ASC ");
$module->execute();
$stmt = $module->fetchAll(PDO::FETCH_ASSOC);
// Consultar si todos los items estan seleccionados 

$todo4 = $db->prepare("SELECT * FROM access WHERE a_modulo=4 AND a_perfil='$cid' AND estado='A' ");
$todo4->execute();
$cant_t4 = $todo4->rowCount();
if ($cant_t4 == 3) {
    $checkedid = "checked";
}else{
    $checkedid = "unchecked";
}
?>                

    <table class="table table-hover table-striped">
        <thead>
            <th>MODULE</th>
            <th>Read</th>
            <th>Save</th>
            <th>Edit</th>
            <th>Remove</th>
            <th>Print</th>
        </thead>
        
        
        <!--<button onClick="window.location.href=window.location.href" class="btn btn-warning main"> <span class="sub"></span><i class="fa fa-retweet"></i>  Reset</button>-->
        
    <?php foreach ( (array) $stmt as $key => $value){
        if ($value['cs'] =='A') {
            $check = "checked";
        }else{
            $check = "unchecked";
        }

        if ($value['sav'] =='A') {
            $check_read = "checked";
        }else{
            $check_read = "unchecked";
        }
        
        if ($value['edi'] =='A') {
            $check_edi = "checked";
        }else{
            $check_edi = "unchecked";
        }
        
        if ($value['del'] =='A') {
            $check_del = "checked";
        }else{
            $check_del = "unchecked";
        }
        
        if ($value['pri'] =='A') {
            $check_pri = "checked";
        }else{
            $check_pri = "unchecked";
        }
    ?>
    <tbody>
    <tr>
    <td><?php echo $value['nombreitem'] ?></td>
    <td><label class="conta"><input type="checkbox" class="case4" name="val_ventas[]" value="<?php echo $value['a_item'] ?>" <?php echo $check?>><span class="checkmark"></span></label></td>
    
    <td><label class="conta"><input type="checkbox" class="case4" name="val_re_ventas[]" value="<?php echo $value['a_item']?>" <?php echo $check_read?>> <span class="checkmark"></span></label></td>
    <td><label class="conta"><input type="checkbox" class="case4" name="val_ed_ventas[]" value="<?php echo $value['a_item']?>" <?php echo $check_edi?> > <span class="checkmark"></span></label></td>
    <td><label class="conta"><input type="checkbox" class="case4" name="val_de_ventas[]" value="<?php echo $value['a_item']?>" <?php echo $check_del?> > <span class="checkmark"></span></label></td>
    <td><label class="conta"><input type="checkbox" class="case4" name="val_pi_ventas[]" value="<?php echo $value['a_item']?>" <?php echo $check_pri?> > <span class="checkmark"></span></label></td>
    </tr>
<?php } ?>
            </tbody>
        </table>
</div>
</div>
</div>

<div class="row">
    <div class="col-md-6">
    <div class="box box-danger">
            <div class="box-header with-border">
            <h3><i class="fa fa-bar-chart"></i> INVENTARIO <label class="conta"><input type="checkbox" id="todo5" /><span class="checkmark"></span> Seleccionar Todo &nbsp;&nbsp;</label></h3>
            </div>
     
    <?php
                $module = $db->prepare(
                "SELECT * FROM access a INNER JOIN c_modulos_items mi ON mi.idcm = a.a_item 
                    WHERE a.a_modulo = 5 AND a.a_perfil='$cid' AND mi.estado = 'ACTIVO' ORDER BY a.a_item ASC ");
                $module->execute();
                $stmt = $module->fetchAll(PDO::FETCH_ASSOC); ?>                

    <table class="table table-hover table-striped">
        <thead>
            <th>MODULE</th>
            <th>Read</th>
            <th>Save</th>
            <th>Edit</th>
            <th>Remove</th>
            <th>Print</th>
        </thead>
        
        
        <!--<button onClick="window.location.href=window.location.href" class="btn btn-warning main"> <span class="sub"></span><i class="fa fa-retweet"></i>  Reset</button>-->
        
    <?php foreach ( (array) $stmt as $key => $value){
        if ($value['cs'] =='A') {
            $check = "checked";
        }else{
            $check = "unchecked";
        }

        if ($value['sav'] =='A') {
            $check_read = "checked";
        }else{
            $check_read = "unchecked";
        }
        
        if ($value['edi'] =='A') {
            $check_edi = "checked";
        }else{
            $check_edi = "unchecked";
        }
        
        if ($value['del'] =='A') {
            $check_del = "checked";
        }else{
            $check_del = "unchecked";
        }
        
        if ($value['pri'] =='A') {
            $check_pri = "checked";
        }else{
            $check_pri = "unchecked";
        }
    ?>
    <tbody>
    <tr>
    <td><?php echo $value['nombreitem'] ?></td>
    <td><label class="conta"><input type="checkbox" class="case5" name="val_inventario[]" value="<?php echo $value['a_item'] ?>" <?php echo $check?> /><span class="checkmark"></span></label></td>
    
    <td><label class="conta"><input type="checkbox" class="case5" name="val_re_inventario[]" value="<?php echo $value['a_item']?>" <?php echo $check_read?>><span class="checkmark"></span></label> </td>
    <td><label class="conta"><input type="checkbox" class="case5" name="val_ed_inventario[]" value="<?php echo $value['a_item']?>" <?php echo $check_edi?> ><span class="checkmark"></span></label> </td>
    <td><label class="conta"><input type="checkbox" class="case5" name="val_de_inventario[]" value="<?php echo $value['a_item']?>" <?php echo $check_del?> ><span class="checkmark"></span></label> </td>
    <td><label class="conta"><input type="checkbox" class="case5" name="val_pi_inventario[]" value="<?php echo $value['a_item']?>" <?php echo $check_pri?> ><span class="checkmark"></span></label> </td>
    </tr>
<?php } ?>
            </tbody>
        </table>
</div>
</div>
<!--  F I N   I N V E N T A R I O -->


<!--  I N I C I O   C O N T A B I L I D A D  -->

    <div class="col-md-6">
    <div class="box box-danger">
            <div class="box-header with-border">
            <h3><i class="fa fa-book"></i> CONTABILIDAD <label class="conta"><input type="checkbox" id="todo6" /><span class="checkmark"></span> Seleccionar Todo &nbsp;&nbsp;</label></h3>
            </div>
     
    <?php
        $module = $db->prepare(
                "SELECT * FROM access a INNER JOIN c_modulos_items mi ON mi.idcm = a.a_item 
                    WHERE a.a_modulo = 6 AND a.a_perfil='$cid' AND mi.estado = 'ACTIVO' ORDER BY a.a_item ASC ");
                $module->execute();
                $stmt = $module->fetchAll(PDO::FETCH_ASSOC); ?>                

    <table class="table table-hover table-striped">
        <thead>
            <th>MODULE</th>
            <th>Read</th>
            <th>Save</th>
            <th>Edit</th>
            <th>Remove</th>
            <th>Print</th>
        </thead>
        
        
        <!--<button onClick="window.location.href=window.location.href" class="btn btn-warning main"> <span class="sub"></span><i class="fa fa-retweet"></i>  Reset</button>-->
        
    <?php foreach ( (array) $stmt as $key => $value){
        if ($value['cs'] =='A') {
            $check = "checked";
        }else{
            $check = "unchecked";
        }

        if ($value['sav'] =='A') {
            $check_read = "checked";
        }else{
            $check_read = "unchecked";
        }
        
        if ($value['edi'] =='A') {
            $check_edi = "checked";
        }else{
            $check_edi = "unchecked";
        }
        
        if ($value['del'] =='A') {
            $check_del = "checked";
        }else{
            $check_del = "unchecked";
        }
        
        if ($value['pri'] =='A') {
            $check_pri = "checked";
        }else{
            $check_pri = "unchecked";
        }
    ?>
    <tbody>
    <tr>
    <td><?php echo $value['nombreitem'] ?></td>
    <td><label class="conta"><input type="checkbox" class="case6" name="val_contable[]" value="<?php echo $value['a_item'] ?>" <?php echo $check?> /><span class="checkmark"></span></label></td>
    
    <td><label class="conta"><input type="checkbox" class="case6" name="val_re_contable[]" value="<?php echo $value['a_item']?>" <?php echo $check_read?>><span class="checkmark"></span></label> </td>
    <td><label class="conta"><input type="checkbox" class="case6" name="val_ed_contable[]" value="<?php echo $value['a_item']?>" <?php echo $check_edi?> ><span class="checkmark"></span></label> </td>
    <td><label class="conta"><input type="checkbox" class="case6" name="val_de_contable[]" value="<?php echo $value['a_item']?>" <?php echo $check_del?> ><span class="checkmark"></span></label> </td>
    <td><label class="conta"><input type="checkbox" class="case6" name="val_pi_contable[]" value="<?php echo $value['a_item']?>" <?php echo $check_pri?> ><span class="checkmark"></span></label> </td>
    </tr>
<?php } ?>
            </tbody>
        </table>
</div>
</div>


<!--  I N I C I O   V E H I C U L O S  -->

    <div class="col-md-6">
    <div class="box box-danger">
            <div class="box-header with-border">
            <h3><i class="fa fa-book"></i> VEHICULOS <label class="conta"><input type="checkbox" id="todo7" /><span class="checkmark"></span> Seleccionar Todo &nbsp;&nbsp;</label></h3>
            </div>
     
    <?php
        $module = $db->prepare(
                "SELECT * FROM access a INNER JOIN c_modulos_items mi ON mi.idcm = a.a_item 
                    WHERE a.a_modulo = 7 AND a.a_perfil='$cid' AND mi.estado = 'ACTIVO' ORDER BY a.a_item ASC ");
                $module->execute();
                $stmt = $module->fetchAll(PDO::FETCH_ASSOC); ?>                

    <table class="table table-hover table-striped">
        <thead>
            <th>MODULE</th>
            <th>Read</th>
            <th>Save</th>
            <th>Edit</th>
            <th>Remove</th>
            <th>Print</th>
        </thead>
        
        
        <!--<button onClick="window.location.href=window.location.href" class="btn btn-warning main"> <span class="sub"></span><i class="fa fa-retweet"></i>  Reset</button>-->
        
    <?php foreach ( (array) $stmt as $key => $value){
        if ($value['cs'] =='A') {
            $check = "checked";
        }else{
            $check = "unchecked";
        }

        if ($value['sav'] =='A') {
            $check_read = "checked";
        }else{
            $check_read = "unchecked";
        }
        
        if ($value['edi'] =='A') {
            $check_edi = "checked";
        }else{
            $check_edi = "unchecked";
        }
        
        if ($value['del'] =='A') {
            $check_del = "checked";
        }else{
            $check_del = "unchecked";
        }
        
        if ($value['pri'] =='A') {
            $check_pri = "checked";
        }else{
            $check_pri = "unchecked";
        }
    ?>
    <tbody>
    <tr>
    <td><?php echo $value['nombreitem'] ?></td>
    <td><label class="conta"><input type="checkbox" class="case7" name="val_vehiculos[]" value="<?php echo $value['a_item'] ?>" <?php echo $check?> /><span class="checkmark"></span></label></td>
    
    <td><label class="conta"><input type="checkbox" class="case7" name="val_re_vehiculos[]" value="<?php echo $value['a_item']?>" <?php echo $check_read?>><span class="checkmark"></span></label> </td>
    <td><label class="conta"><input type="checkbox" class="case7" name="val_ed_vehiculos[]" value="<?php echo $value['a_item']?>" <?php echo $check_edi?> ><span class="checkmark"></span></label> </td>
    <td><label class="conta"><input type="checkbox" class="case7" name="val_de_vehiculos[]" value="<?php echo $value['a_item']?>" <?php echo $check_del?> ><span class="checkmark"></span></label> </td>
    <td><label class="conta"><input type="checkbox" class="case7" name="val_pi_vehiculos[]" value="<?php echo $value['a_item']?>" <?php echo $check_pri?> ><span class="checkmark"></span></label> </td>
    </tr>
<?php } ?>
            </tbody>
        </table>
</div>
</div>



<!--  I N I C I O    C O N V E N I O S  -->

    <div class="col-md-6">
    <div class="box box-danger">
            <div class="box-header with-border">
            <h3><i class="fa fa-book"></i> CONVENIOS <label class="conta"><input type="checkbox" id="todo8" /><span class="checkmark"></span> Seleccionar Todo &nbsp;&nbsp;</label></h3>
            </div>
     
    <?php
        $module = $db->prepare(
                "SELECT * FROM access a INNER JOIN c_modulos_items mi ON mi.idcm = a.a_item 
                    WHERE a.a_modulo = 8 AND a.a_perfil='$cid' AND mi.estado = 'ACTIVO' ORDER BY a.a_item ASC ");
                $module->execute();
                $stmt = $module->fetchAll(PDO::FETCH_ASSOC); ?>                

    <table class="table table-hover table-striped">
        <thead>
            <th>MODULE</th>
            <th>Read</th>
            <th>Save</th>
            <th>Edit</th>
            <th>Remove</th>
            <th>Print</th>
        </thead>
        
        
        <!--<button onClick="window.location.href=window.location.href" class="btn btn-warning main"> <span class="sub"></span><i class="fa fa-retweet"></i>  Reset</button>-->
        
    <?php foreach ( (array) $stmt as $key => $value){
        if ($value['cs'] =='A') {
            $check = "checked";
        }else{
            $check = "unchecked";
        }

        if ($value['sav'] =='A') {
            $check_read = "checked";
        }else{
            $check_read = "unchecked";
        }
        
        if ($value['edi'] =='A') {
            $check_edi = "checked";
        }else{
            $check_edi = "unchecked";
        }
        
        if ($value['del'] =='A') {
            $check_del = "checked";
        }else{
            $check_del = "unchecked";
        }
        
        if ($value['pri'] =='A') {
            $check_pri = "checked";
        }else{
            $check_pri = "unchecked";
        }
    ?>
    <tbody>
    <tr>
    <td><?php echo $value['nombreitem'] ?></td>
    <td><label class="conta"><input type="checkbox" class="case8" name="val_conv[]" value="<?php echo $value['a_item'] ?>" <?php echo $check?> /><span class="checkmark"></span></label></td>
    
    <td><label class="conta"><input type="checkbox" class="case8" name="val_re_conv[]" value="<?php echo $value['a_item']?>" <?php echo $check_read?>><span class="checkmark"></span></label> </td>
    <td><label class="conta"><input type="checkbox" class="case8" name="val_ed_conv[]" value="<?php echo $value['a_item']?>" <?php echo $check_edi?> ><span class="checkmark"></span></label> </td>
    <td><label class="conta"><input type="checkbox" class="case8" name="val_de_conv[]" value="<?php echo $value['a_item']?>" <?php echo $check_del?> ><span class="checkmark"></span></label> </td>
    <td><label class="conta"><input type="checkbox" class="case8" name="val_pi_conv[]" value="<?php echo $value['a_item']?>" <?php echo $check_pri?> ><span class="checkmark"></span></label> </td>
    </tr>
<?php } ?>
            </tbody>
        </table>
</div>
</div>
</div>
<div style="clear: both;"></div>
        <input type="submit" name="yeah" class="btn btn-success" value="Guardar Cambios" />
</form>
</section>
</div>
<?php
require_once ("../foot_unico.php");

}else{
    session_unset();
    session_destroy();
    header('Location:  ../../../index.php');
}?>