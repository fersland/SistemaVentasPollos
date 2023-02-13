<?php
 session_start();
 if(isset($_SESSION["acceso"]))  {

require_once ("../head_unico.php");

if (isset($_REQUEST['cid'])){
        $laid = $_REQUEST['cid'];

        $sql = $db->prepare("SELECT sum(cantidad) as lacantidad, sum(cantidad_litros) as loslitros,ncompra,id_empresa,codigo,bodega_compra 
                                                FROM c_compra_detalle WHERE ncompra = '$laid'");
        $sql->execute();
        $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $key => $value) {
            $idv         = $value['ncompra'];
            $empresa     = $value['id_empresa'];
            $cod         = $value['codigo'];
            $cant_s      = $value['lacantidad'];
            $cant_l      = $value['loslitros'];
            $bod         = $value['bodega_compra'];
        }
    }



 // Actualizar datos
 if (isset($_POST['update'])) {
    $id    		= $_POST['_idventa'];
 	$em    		= $_POST['_empresa'];
    $cant_st    = $_POST['cantidad_stock'];
    $cant_li    = $_POST['cantidad_litros'];
    $code    	= $_POST['codi'];
    $bodeg 		= $_POST['_bode'];

    // Actualizar el stock en mercaderia
    $stmt = $db->prepare("UPDATE c_compra SET estado='X' WHERE ncompra='$id'");
    if ( $stmt->execute() ){
        // Devolver el stock original
        $stmt = $db->prepare("UPDATE c_mercaderia
                                                SET
                                                        estado = 'X'
                                                WHERE   ncompra='$id'");
        $stmt->execute();
        
        // Inactivar el detalle de la factura que se eliminó
        $del = $db->prepare("UPDATE c_compra_detalle SET estado = 'X' WHERE ncompra = '$id' and estado = 'I'");
        $del->execute();

        echo '<script type="text/javascript">
                    window.location.href = "../in.php?cid=compras/frm_ver_compras";
              </script>';
    }else{
        echo '<div class="alert alert-warning">
                  <b>Error al eliminar!</b></div>';
    }
}
?>

            <!--<img src="../../../inicializador/img/iva.png" class="img" width="100% " />-->

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Historial Compras
        <small>Eliminar compra facturada</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?cid=dashboard/init"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Compras</a></li>
        <li><a href="#">Historial de compras</a></li>
        <li class="active"><a href="#">Eliminar compra</a></li>
      </ol>
    </section>

<!-- Main content -->
<section class="content">
<div class="row"><br>
    <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Eliminar compra</h3>
            </div>
            <form action="#" id="formulario" method="post">
                <div class="box-body">
            <input type="hidden" name="_empresa" value="<?php echo $empresa?>" class="form-control" />
            <input type="hidden" name="_bode" value="<?php echo $bod?>" class="form-control" />
               
                <div class="form-row">
                <div class="form-group col-md-12">
                    <label>Numero de factura de compra <span class="ast">(*)</span></label>
                    <input type="hidden" name="codi" value="<?php echo $cod?>" class="form-control" readonly="" />
                    <input type=""  name="_idventa" class="form-control" value="<?php echo $idv ?>" readonly="" />
                </div>
                </div>

                <input type="hidden" name="cantidad_stock" value="<?php echo $cant_s ?>" class="form-control" />
                <input type="hidden" name="cantidad_litros" value="<?php echo $cant_l ?>" class="form-control" />
            
            </div>
                <div class="box-footer">
                <a href="../in.php?cid=compras/frm_ver_compras" class="btn bg-navy">Volver</a>
                <button type="submit" class="btn btn-danger pull-right" value="Guardar Datos" name="update">Eliminar Datos</button>
              </div>
            </form>
              </div>
          </div>
        </div><!-- /.col -->
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