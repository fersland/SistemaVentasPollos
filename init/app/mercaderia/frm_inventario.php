<?php $empresa = $_SESSION['id_empresa'] ?>
<script type="text/javascript" src="../../js/consulta_inventario.js"></script>
<script type="text/javascript" src="../../js/consulta_compras_inventario.js"></script>

<?php
    require_once ("../../../datos/db/connect.php");
    $empresa = $_SESSION['id_empresa'];
    
    $env = new DBSTART;
    $db = $env->abrirDB();
    
    // Total de ventas
     $tventa = $db->prepare("SELECT sum(total) AS t1 FROM c_venta WHERE id_empresa='$empresa' AND estado='I'");
     $tventa->execute();
     $all = $tventa->fetchAll(PDO::FETCH_ASSOC);
     foreach ( (array) $all as $val) {
        $n1 = $val['t1'];
     }
     
     // Total de compras
     $tcompra_stmt = $db->prepare("SELECT sum(total) AS t2 FROM c_compra WHERE estado = 'A' AND id_empresa='$empresa'");
     $tcompra_stmt->execute();
     $all2 = $tcompra_stmt->fetchAll(PDO::FETCH_ASSOC);
     foreach ( (array) $all2 as $val2 ) {
        $tcompra = $val2['t2'];
        $plus = 40;
        $nuevo = 0;
        $nuevo = ($tcompra * $plus) / 100;
        $tcompraplus = $tcompra + $nuevo;
     }    
?>
<div id="page-wrapper"><br />
<?php setlocale(LC_MONETARY, 'en_US'); ?>
<nav aria-label="breadcrumb" style="margin-bottom: 0px;">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">Inventario</li>
    <li class="breadcrumb-item active">Perdidas y Ganancias</li>
  </ol>
</nav>
    <div class="row">
        
        <div class="col-lg-12">
            <div class="col-lg-4">
                <div style="float:left; font-size: 20px;">
                    <div class="alert alert-warning">
                        Total Compras: <span class="badge badge-info" style="background: orange; color:#fff; font-size:20px">
                        <?php //echo number_format ($n2, 0 , ' , ' ,  '.'); ?>
                        <?php echo '$' . number_format($tcompra, 2) ?></span><br />

                        
                        
                        <hr /><p style="font-size: 12px;">Previsi&oacute;n Total: <?php echo number_format($tcompraplus, 2) ?></p> 
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="alert alert-dark">
                    <?php 
                        if ($n1 >= $tcompra) {
                            $val = 0;
                            $val = ($n1 - $tcompra);
                            
                            echo '<h1 style="text-align:center; color:green; font-weight;bolder">Super&aacute;vit: +'.number_format($val,2).' </h1>';
                            
                          }else{
                            $vale = 0;
                            $vale = ($tcompra - $n1);
                            echo '<h1 style="text-align:center; color:red; font-weight;bolder">D&eacute;ficit: '.number_format($vale,2).' </h1>';
                        }
                    ?>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div style="float:right; font-size: 20px;">
                    <div class="alert alert-info">
                    Total Venta: <span class="badge badge-success" style="background: blue; color:#fff; font-size:20px">
                        <?php //echo number_format ($n1, 0 , ' , ' ,  '.'); ?>
                        
                        <?php echo number_format($n1, 2); ?></span>
                        
                        <hr /><p style="font-size: 12px;">Previsi&oacute;n de Total de Ventas: <?php echo number_format($tcompraplus,2) ?></p>
                        <?php 
                            $total_ganancia_venta = 0;
                            $total_ganancia_venta = ($tcompraplus - $tcompra);
                        ?>
                        
                        <p style="font-size: 12px;">Previsi&oacute;n de Ganacias: <b> <?php echo number_format($total_ganancia_venta,2) ?> </b></p>
                        
                   </div> 
                </div>
            </div>    
        </div>
    </div>

    <div class="row">
        <div class="col-lg-5">
            <form action="../../../datos/clases/pdf/inventario_anual.php" target="_blank" method="POST">
                <div class="form-row">
                    <p>Para ver un informe anual, especifique el a&ntilde;o, por ejemplo: 2019</p>
                    <label class="col-sm-4">Ingrese el a&ntilde;o : </label>
                    <div class="col-sm-5">
                        <input type="text" name="anio" class="form-control" />
                    </div>
                    <div class="col-sm-3">
                        <input type="submit" name="anual" class="btn btn-success" value="Ver Informe" />
                    </div>
                </div>
            </form>
        </div>
        
        <div class="col-lg-4">
        </div>
        
        <div class="col-lg-4">
        </div>
    </div>
    <div class="row">
    	<div class="col-md-6">
        <h4 style="background: #272525d9; color:#b1ffbb;padding: 8px;border-radius: 2px;">Movimientos Compras (Entrada)</h4>
    <input class="form-control" type="text" placeholder="Busca por numero de compra, proveedor.." id="bs-prods"/>
            <div class="registros" id="agrega-registro"></div>            
            <center>
                <ul class="pagination" id="pagination"></ul>
            </center>
     	</div>
        
               
        <div class="col-md-6">
            <!--<span style="float: right;">Ver reporte en 
                <a target="_blank" href="../../../controlador/c_empleados/reportexcel.php"><img src="../../img/excel.png" width="40" /></a>
                <a target="_blank" href="../../../datos/clases/pdf/empleados.php"><img src="../../img/pdf.png" width="40" /></a></span>-->
            
     <h4 style="background: #272525d9; color:lightblue;padding: 8px;border-radius: 2px;">Movimientos Ventas (Salida)</h4>
    <input class="form-control" type="text" placeholder="Busca por numero de venta o c&eacute;dula de cliente" id="bs-prod"/>
            <div class="registros" id="agrega-registros"></div>
            
            <center>
                <ul class="pagination" id="pagination"></ul>
            </center>
     	</div>
    </div>
</div>
    