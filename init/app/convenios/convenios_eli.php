<?php
 session_start();
 if(isset($_SESSION["acceso"])) {
    require_once ("../head_unico.php");
?>

  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Administración / 
        <b>Eliminar Convenio</b>
      </h1>
      <ol class="breadcrumb">
        <li><a href="../in.php?cid=dashboard/init"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Inventario</a></li>
        <li class="active"><a href="#">Eliminar Convenio</a></li>
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

    
     $stmt = $db->prepare("DELETE FROM c_convenios WHERE id=:id");
     $stmt->bindParam(':id', $id, PDO::PARAM_INT);
          
     if ( $stmt->execute() ){

     echo '<div class="alert alert-success">
                <b>Cambios guardados!</b>
            </div>';
            }else{
                echo '<div class="alert alert-warning">
                <b>Error al guardar los cambios!</b>
            </div>';
            }    
}

        $laid = isset($_GET['cid']) ? $_GET['cid'] : 0;
        $laproducto = isset($_GET['producto']) ? $_GET['producto'] : 0;
        $lacodigo = isset($_GET['codigo']) ? $_GET['codigo'] : 0;

        $sql = $db->prepare("SELECT t1.pnuevo, concat(t3.nombres) elcliente, t2.nombreproducto, t1.id
                                FROM c_convenios t1 INNER JOIN c_mercaderia t2 ON t1.producto = t2.idp
                                        INNER JOIN c_clientes t3 ON t1.cliente = t3.cedula
                                        WHERE id = '$laid' AND id_estado=1");
        $sql->execute();
        $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $key => $value) {
            $id           = $value['id'];
            $producto     = $value['nombreproducto'];
            $precio       = $value['pnuevo'];
            $elcliente    = $value['elcliente'];
        }
 ?>
  </div>
    <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Eliminar datos del Convenio</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" class="form-horizontal">
                <div class="box-body">
                    <input type="hidden" name="_id" value="<?php echo $id ?>" />
            
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Producto (*)</label>
                  <div class="col-sm-8">
                    <input type="text" name="_nombres" value="<?php echo $producto?>" class="form-control" required="" readonly="" />
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">CLIENTE (*)</label>
                  <div class="col-sm-8">
                    <input type="text" name="_nombres" value="<?php echo $elcliente?>" class="form-control" required="" readonly="" />
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Precio Actual Para Cliente</label>
                  <div class="col-sm-8">
                    <input type="text" name="precionuevo" value="<?php echo $precio?>" class="form-control" readonly="" />
                  </div>
                </div>
                
                </div>
                <!-- /.box-body -->
              <div class="box-footer">
                <a href="../../../init/app/convenios/newconvenios.php?cid=<?php echo $laproducto ?>&codigo=<?php echo $lacodigo ?>" class="btn bg-navy">Volver</a>
                <button type="reset" class="btn btn-default">Cancelar</button>
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