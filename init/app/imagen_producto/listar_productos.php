<?php $empresa = $_SESSION['id_empresa'] ?>

<script type="text/javascript" src="../../js/consulta_imagen.js"></script>
<div id="page-wrapper">
<br />
<nav aria-label="breadcrumb">
  <ol class="breadcrumb" style="float: right;">
    <li class="breadcrumb-item">Config. y Administración</li>
    <li class="breadcrumb-item active">Imagen Producto</li>

  </ol>
</nav>
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-warning" style="margin-top: 10px">
              <strong>Administración de imágenes de producto</strong>
            </div>
        </div>
    </div>

    <div class="row">
    	
<?php
    if (isset($_POST['submit'])) {
        require_once ("../../../controlador/c_lineas/reg_linea.php");
    }
?>

        <div class="col-lg-8">
            
            <!--<span style="float: right;">Ver reporte en 
                <a target="_blank" href="../../../controlador/c_empleados/reportexcel.php"><img src="../../img/excel.png" width="40" /></a>
                <a target="_blank" href="../../../datos/clases/pdf/empleados.php"><img src="../../img/pdf.png" width="40" /></a></span>-->
            
            <div class="form-group">
            <div class="col-md-6">

                <input class="form-control" type="text" placeholder="Busca por nombre de producto.." id="bs-prod"/>
                
            </div>
                
            </div><br /><br />
            <div class="registros" id="agrega-registros"></div>
            
            <center><ul class="pagination" id="pagination"></ul></center>
     	</div>        
    </div>
</div>