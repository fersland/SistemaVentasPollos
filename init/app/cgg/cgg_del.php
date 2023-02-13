<?php
 session_start();
 if(isset($_SESSION["acceso"])) {
    require_once ("../head_unico.php");
?>

  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        <b>Caja Chica </b> / Eliminar dato incorrecto</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="../in.php?cid=dashboard/init"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Caja Chica</a></li>
        <li class="active"><a href="#">Eliminar </a></li>
      </ol>
    </section>

<!-- Main content -->
<section class="content">
<div class="row">
  <div class="col-md-12">
   <?php 
 // Actualizar datos
 if (isset($_POST['update'])) {

    $id       = $_POST['_id'];
    $elparam_       = htmlspecialchars(strtoupper($_POST['elparam']));
    $elvalor_       = htmlspecialchars(strtoupper($_POST['_valor']));

    if ($elvalor_ == "") {
        echo '<div class="alert alert-warning">
                <b>Debe asignar un valor!</b>
            </div>';
    }else{
         $stmt = $db->prepare("UPDATE c_resumen_gasto SET id_estado = 2 WHERE id=:id");     
         $stmt->bindParam(':id', $id, PDO::PARAM_INT);
              
         if ( $stmt->execute() ){
            if ($elparam_ == 1) {
                $stmt2 = $db->prepare("UPDATE c_saldo SET saldo = saldo - '$elvalor_'");
                $stmt2->execute();       
            }elseif($elparam_ == 2) {
                $stmt2 = $db->prepare("UPDATE c_saldo SET saldo = saldo + '$elvalor_'");
                $stmt2->execute();
            }
    
         echo '<div class="alert alert-success">
                    <b>Cambios guardados!</b>
                </div>';
                }else{
                    echo '<div class="alert alert-warning">
                    <b>Error al guardar los cambios!</b>
                </div>';
                }    
    }
}

        $laid = isset($_GET['cid']) ? $_GET['cid'] : 0;

        $sql = $db->prepare("SELECT t1.id, t1.param, t1.valor, t2.nombre FROM c_resumen_gasto t1 INNER JOIN c_tipo_gastos t2 ON t1.tipo = t2.id WHERE t1.id = '$laid' AND t1.id_estado=1");
        $sql->execute();
        $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $key => $value) {
            $id          = $value['id'];
            $valor     = $value['valor'];
            $nombre         = $value['nombre'];
            $param = $value['param']; // 1 si es ingreso - 2 si es egreso
        }
 ?>
  </div>
    <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Eliminar el datos incorrecto</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" class="form-horizontal">
                <div class="box-body">
                    <input type="hidden" name="_id" value="<?php echo $id ?>" />
                    <input type="hidden" name="elparam" value="<?php echo $param ?>" />
            
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Nombre (*)</label>
                  <div class="col-sm-8">
                    <input type="text" name="_nombres" value="<?php echo $nombre?>" class="form-control" required="" readonly="" />
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Valor</label>
                  <div class="col-sm-8">
                    <input type="text" name="_valor" value="<?php echo $valor?>" class="form-control" readonly="" />
                  </div>
                </div>
                

                
                </div>
                <!-- /.box-body -->
              <div class="box-footer">
                <a href="../in.php?cid=cgg/cgg_view" class="btn bg-navy">Volver</a>
                <button type="submit" class="btn btn-danger pull-right" name="update">Eliminar Datos</button>
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