<?php
 session_start();
 if(isset($_SESSION["acceso"]))  {
    require_once ("../head_unico.php");
 ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Inventario
        <small>Actualizar Herramienta</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="../in.php?cid=dashboard/init"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="../in.php?cid=mercaderia/mercaderia">Inventario</a></li>
        <li><a href="../in.php?cid=activos/frm_activos">Activos</a></li>
        <li><a href="../in.php?cid=herramientas/frm_herramientas">Herramientas</a></li>
        <li class="active"><a href="#">Actualizar Herramientas</a></li>
      </ol>
    </section>

<!-- Main content -->
<section class="content">
<div class="row"><br>
  <div class="col-md-12">
<?php
 // Actualizar datos
 if (isset($_POST['update'])) {
                
    $upd_id        = $_POST['p_id'];
    
    $upd_pro       = htmlspecialchars(strtoupper($_POST['p_proveedor']));
    $upd_fec       = htmlspecialchars(strtoupper($_POST['p_fecha']));
    $upd_num       = htmlspecialchars(strtoupper($_POST['p_num']));
    $upd_des       = htmlspecialchars(strtoupper($_POST['p_desc']));
    $upd_val       = htmlspecialchars(strtoupper($_POST['p_val']));
    $upd_est       = htmlspecialchars(strtoupper($_POST['p_estadof']));    
    $upd_ubi       = htmlspecialchars(strtoupper($_POST['p_ubic']));
    
    $upd_cod       = htmlspecialchars(strtoupper($_POST['p_codigo']));
    $upd_per       = htmlspecialchars(strtoupper($_POST['p_persona']));
    $upd_can       = htmlspecialchars($_POST['p_cant']);
    $upd_obs       = htmlspecialchars(strtoupper($_POST['p_obs']));

     $stmt = $db->prepare(
        "UPDATE c_herramientas
                                SET
                                    proveedor=:prov,
                                    fecha_adq=:fecq,
                                    numero_factura=:nfac,
                                    descripcion=:desc,
                                    valor=:valo,
                                    estado_fisico=:estf,
                                    ubicacion_fisica=:ubif,
                                    codigo=:codi, 
                                    persona_resp=:pers,
                                    cantidad=:cant,
                                    observacion=:obse
                                
                                WHERE id_herramientas=:id");
     
                                 $stmt->bindParam(':prov', $upd_pro, PDO::PARAM_STR);
                                 $stmt->bindParam(':fecq', $upd_fec, PDO::PARAM_STR);
                                 $stmt->bindParam(':nfac', $upd_num, PDO::PARAM_STR);
                                 $stmt->bindParam(':desc', $upd_des, PDO::PARAM_STR);
                                 $stmt->bindParam(':valo', $upd_val, PDO::PARAM_STR);
                                 $stmt->bindParam(':estf', $upd_est, PDO::PARAM_STR);
                                 $stmt->bindParam(':ubif', $upd_ubi, PDO::PARAM_STR);
                                 $stmt->bindParam(':codi', $upd_cod, PDO::PARAM_STR);
                                 $stmt->bindParam(':pers', $upd_per, PDO::PARAM_STR);
                                 $stmt->bindParam(':cant', $upd_can, PDO::PARAM_STR);
                                 $stmt->bindParam(':obse', $upd_obs, PDO::PARAM_STR);
                                 
                                 $stmt->bindParam(':id', $upd_id, PDO::PARAM_INT);
     
     if ($stmt->execute() ) {
       echo '<div class="alert alert-success">
                <b>Cambios guardados!</b>
            </div>'; 
     }else{
       echo '<div class="alert alert-danger">
                <b>Error al cambiar datos!</b>
            </div>';
     }
}

        $laid = isset($_GET['cid']) ? $_GET['cid'] : 0;

        $sql = $db->prepare("SELECT * FROM c_herramientas WHERE id_herramientas = '$laid'");
        $sql->execute();
        $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $key => $value) {
            $cid_id         = $value['id_herramientas'];
            $cid_prov       = $value['proveedor'];
            $cid_fec        = $value['fecha_adq'];
            $cid_num        = $value['numero_factura'];
            $cid_des        = $value['descripcion'];
            $cid_val        = $value['valor'];
            $cid_estf       = $value['estado_fisico'];
            $cid_ubi        = $value['ubicacion_fisica'];
            $cid_cod        = $value['codigo'];
            $cid_per        = $value['persona_resp'];
            $cid_can        = $value['cantidad'];
            $cid_obs        = $value['observacion'];
        }
 ?>
  </div>
    <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Actualizar datos de la herramienta</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" class="form-horizontal">
                <div class="box-body">
                    <input type="hidden" name="p_id" value="<?php echo $cid_id ?>" />
            
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Proveedor</label>
                  <div class="col-sm-8">
                    <input type="text" name="p_proveedor" value="<?php echo $cid_prov ?>" class="form-control" />
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Fecha Adquirido </label>
                  <div class="col-sm-8">
                    <input type="text" name="p_fecha" value="<?php echo $cid_fec ?>" class="form-control" />
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Numero Factura</label>
                  <div class="col-sm-8">
                    <input type="text" name="p_num" value="<?php echo $cid_num ?>" class="form-control" />
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Descripción (*)</label>
                  <div class="col-sm-8">
                    <input type="text" name="p_desc" value="<?php echo $cid_des ?>" class="form-control" required="" />
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Valor (*)</label>
                  <div class="col-sm-8">
                    <input type="text" name="p_val" value="<?php echo $cid_val ?>" class="form-control" required="" />
                  </div>
                </div>
                <div class="form-group">    
                  <label for="inputEmail3" class="col-sm-4 control-label">Estado Físico (*)</label>
                  <div class="col-sm-8">
                    <input type="text" name="p_estadof" value="<?php echo $cid_estf ?>" class="form-control" required="" />
                  </div>
                </div>
                <div class="form-group">    
                  <label for="inputEmail3" class="col-sm-4 control-label">Ubicación (*)</label>
                  <div class="col-sm-8">
                    <input type="text" name="p_ubic" value="<?php echo $cid_ubi ?>" class="form-control" required="" />
                  </div>
                </div>
                
                <div class="form-group">    
                  <label for="inputEmail3" class="col-sm-4 control-label">Código empresa (*)</label>
                  <div class="col-sm-8">
                    <input type="text" name="p_codigo" value="<?php echo $cid_cod ?>" class="form-control" required="" />
                  </div>
                </div>

                <div class="form-group">    
                  <label for="inputEmail3" class="col-sm-4 control-label">Responsable </label>
                  <div class="col-sm-8">
                    <input type="text" name="p_persona" value="<?php echo $cid_per ?>" class="form-control" />
                  </div>
                </div>

                <div class="form-group">    
                  <label for="inputEmail3" class="col-sm-4 control-label">Cantidad (*)</label>
                  <div class="col-sm-8">
                    <input type="text" name="p_cant" value="<?php echo $cid_can ?>" class="form-control" required="" onkeypress="return soloNumeros(event)" />
                  </div>
                </div>

                <div class="form-group">    
                  <label for="inputEmail3" class="col-sm-4 control-label">Observación </label>
                  <div class="col-sm-8">
                    <input type="text" name="p_obs" value="<?php echo $cid_obs ?>" class="form-control" />
                  </div>
                </div>
                
                </div>
                <!-- /.box-body -->
              <div class="box-footer">
                <a href="../in.php?cid=herramientas/frm_herramientas" class="btn bg-navy">Volver</a>
                <button type="reset" class="btn btn-default">Cancelar</button>
                <button type="submit" class="btn btn-warning pull-right" value="ACTUALIZAR DATOS AHORA" name="update">Actualizar Datos</button>
              </div>
            </form>
</div>
</div>
</div>
</section>
</div>

<?php 
require_once ("../foot_unico.php");

}else{
    session_unset();
    session_destroy();
    header('Location:  ../../../index.php');
} 

 ?>