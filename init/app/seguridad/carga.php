<?php
    require_once ("../../../../datos/db/connect.php");
    require_once ("../head_unico.php");

    if (isset($_REQUEST['cid'])) {
        $cid = $_REQUEST['cid'];

        // Buscar que rol entro al modulo carga
    $sql = DBSTART::abrirDB()->prepare("SELECT * FROM c_roles WHERE idrol = '$cid'");
    $sql->execute();
    $all = $sql->fetchAll(PDO::FETCH_ASSOC);
    foreach ($all as $key => $val) {
        $name = $val['nombrerol'];
    }
    
    // Mostrar todos los items del módulo mercaderia
    $sql_mer = DBSTART::abrirDB()->prepare("SELECT * FROM c_modulos_items WHERE idmodulo = 3");
    $sql_mer->execute();
    $rows_mer = $sql_mer->fetchAll(PDO::FETCH_ASSOC);

    // Mostrar todos los items del módulo ventas
    $sql_ventas = DBSTART::abrirDB()->prepare("SELECT * FROM c_modulos_items WHERE idmodulo = 2");
    $sql_ventas->execute();
    $rows_ventas = $sql_ventas->fetchAll(PDO::FETCH_ASSOC);

    // Mostrar todos los items del módulo compras
    $sql_compras = DBSTART::abrirDB()->prepare("SELECT * FROM c_modulos_items WHERE idmodulo = 4");
    $sql_compras->execute();
    $rows_compras = $sql_compras->fetchAll(PDO::FETCH_ASSOC);
}
?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-danger" style="margin-top: 10px">
              <strong>Carga de módulos para: <?php echo $name ?></strong>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
    
    <!-- M E R C A D E R I A -->

    <form method="post" name="frm" action="../../../../controlador/c_seguridad/cargar.php" enctype="multipart/form-data">
        <div class="form-group">
            <input type="hidden" name="_idrol" value="<?php echo $cid ?>">
        </div>

          <div style="display: inline;">
            <p><strong>MERCADERIA </strong></p><br>
            <?php foreach ($rows_mer as $key => $value): ?>
                <input type="hidden" name="elmodulo" value="<?php echo $value['idmodulo'] ?>">
                <li style="float: left; list-style: none; margin-right: 14px">
                <label class="customcheck"><?php echo $value['nombreitem'] ?>
                
                <?php if ($value['nivelacceso'] == $cid): ?>
                    <input type="checkbox" checked="checked" name="michek[]" value="<?php echo $value['nombreitem'] ?>" >
                  <span class="checkmark"></span>
                  <?php else: ?>
                    <input type="checkbox" name="michek[]" value="<?php echo $value['nombreitem'] ?>" >
                  <span class="checkmark"></span>
                <?php endif ?>

                </label>
                </li>
            <?php endforeach ?><br><br>
            </div>
          <div class="modal-footer">
                <button type="submit" id="register" name="register" class="btn btn-info"> <i class="fa fa-check"></i> Guardar Cambios </button>
                <button type="reset" class="btn btn-warning" > <i class="fa fa-times"></i> Cancelar</button>
           </div>
    </form>

    <!-- V E N T A S -->

    <form method="post" name="frm" action="../../../controlador/c_seguridad/clave_update.php" enctype="multipart/form-data">
        <div class="form-group">
            <input type="hidden" name="_idrol" value="<?php echo $cid ?>">
        </div>
    
          <div style="display: inline;">
            <p><strong>VENTAS  </strong></p><br>
            <?php foreach ($rows_ventas as $key => $venta): ?>
                <li style="float: left; list-style: none; margin-right: 14px">
                <label class="customcheck"><?php echo $venta['nombreitem'] ?>
                <?php if ($venta['nivelacceso'] == $cid): ?>
                    <input type="checkbox" checked="checked" name="item">
                  <span class="checkmark"></span>
                  <?php else: ?>
                    <input type="checkbox" name="itemno">
                  <span class="checkmark"></span>
                <?php endif ?>
                  
                </label>
                </li>
            <?php endforeach ?><br><br>
            </div>
        

          <div class="modal-footer">
                <button type="submit" id="register" name="register" class="btn btn-info"> <i class="fa fa-check"></i> Guardar Cambios </button>
                <button type="reset" class="btn btn-warning" > <i class="fa fa-times"></i> Cancelar</button>
           </div>
    </form>


    <!-- C O M P R A S -->

    <form method="post" name="frm" action="../../../controlador/c_seguridad/clave_update.php" enctype="multipart/form-data">
        <div class="form-group">
            <input type="hidden" name="_iduser" value="<?php echo $iduser ?>">
        </div>
    
          <div style="display: inline;">
            <p><strong>COMPRAS  </strong></p><br>
            <?php foreach ($rows_compras as $key => $venta): ?>
                <li style="float: left; list-style: none; margin-right: 14px">
                <label class="customcheck"><?php echo $venta['nombreitem'] ?>
                <?php if ($venta['nivelacceso'] == $cid): ?>
                    <input type="checkbox" checked="checked">
                  <span class="checkmark"></span>
                  <?php else: ?>
                    <input type="checkbox">
                  <span class="checkmark"></span>
                <?php endif ?>
                  
                </label>
                </li>
            <?php endforeach ?><br><br>
            </div>
        

          <div class="modal-footer">
                <button type="submit" id="register" name="register" class="btn btn-info"> <i class="fa fa-check"></i> Guardar Cambios </button>
                <button type="reset" class="btn btn-warning" > <i class="fa fa-times"></i> Cancelar</button>
           </div>
    </form>

</div>
</div>
</div>


<?php require_once ("../foot_unico.php"); ?>