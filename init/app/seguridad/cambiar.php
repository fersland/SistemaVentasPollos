<?php require_once ("../../../datos/db/connect.php"); ?>

<?php
    $iduser = $_SESSION['usuario'];
    $cid = $_SESSION['correo'];
    $empresa = $_SESSION['id_empresa'];

    // Verifica si el nivel que entró aquí, tiene una clave protegida, sino la tiene, se le pide que genere una.
    // Si la tiene, se le ofrece el cambio de clave. 

    $sql = DBSTART::abrirDB()->prepare("SELECT * FROM c_usuarios WHERE nivelacceso = '$cid' AND estado='A' AND id_empresa='$empresa'");
    $sql->execute();
    $all = $sql->fetchAll(PDO::FETCH_ASSOC);
    foreach ($all as $key => $value) {
        $lacedul = $value['cedula_user'];
        $lapassw = $value['passw'];
    }

    if ( $lapassw == $lacedul ) {
        $mensaje = "El usuario actual, no posee una clave protegida, genere una en el siguiente formulario.";
    }else{
        $mensaje = "Si desea cambiar la clave, llene el siguiente formulario";
    }
 
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-12">
            <div class="alert alert-danger" style="margin-top: 10px">
              <h4>Generador de Claves</h4><hr />
              <strong>Atención: </strong> <?php echo $mensaje ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
    <fieldset class="field">
        <legend class="ley">LLenar el formulario</legend>
    <form method="post" name="frm" action="../../../controlador/c_seguridad/clave_update.php">
        <div class="form-group">
            <input type="" name="_iduser" value="<?php echo $iduser ?>" />
        </div>
        
        <div class="form-group">
            <label for="inputPassword4">Clave Actual</label>
            <input type="password" name="_actual" placeholder="Ingrese su clave actual" class="form-control" />
        </div>
        
        <div class="form-group">
          <label for="inputAddress">Nueva Clave</label>
          <input type="password" class="form-control" name="_nueva" required="" />
        </div>
        <div class="form-group">
            <label for="inputAddress2">Repita su nueva clave</label>
            <input class="form-control" type=password name="_rnueva" placeholder="" required="" />
        </div>

          <div class="modal-footer">
                <button type="submit" id="register" name="register" class="btn btn-success"> <i class="fa fa-check"></i>Actualizar </button>
                <button type="reset" class="btn btn-warning" > <i class="fa fa-times"></i> Cancelar</button>
           </div>
    </form>
</fieldset>
</div>
</div>
</div>