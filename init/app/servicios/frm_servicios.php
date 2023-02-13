<?php
	require_once ("../../../datos/db/connect.php");
	$env = new DBSTART;
	$cc = $env::abrirDB();
?>
<style>
.ast{color:red}
</style>
<?php $empresa = $_SESSION['id_empresa']; ?>
<script type="text/javascript" src="../../js/consulta_servicios.js"></script>
<div id="page-wrapper">
<br />
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">Config. y Administración</li>
    <li class="breadcrumb-item active"><i class="fa fa-bolt"></i> Servicios</li>
  </ol>
</nav>

    <div class="row">
        <div class="col-lg-5">
            <p>Los campos con (*) son obligatorios</p><hr />
<?php
	if (isset($_POST['register'])) {
	   require_once ("../../../controlador/c_servicios/reg_servicios.php");
       }
 ?>

            <form id="formulario" method="post">
                <input type="hidden" required="required" readonly="readonly" id="pro" name="pro"/>
                <input type="hidden" name="idempresa" value="<?php echo $empresa ?>" />
                
                
                   
                <div class="form-group">
                    <label> Nombre del Servicio</label>
                    <input type="text" id="_servicio" name="servicio" class="form-control" />
                </div>
                
                <div class="form-group">
                    <label> Observación</label>
                    <input type="text" id="_obs" name="obs" class="form-control" />
                </div>
                
              <div class="form-group">
                <input type="submit" value="Registrar" name="register" class="btn btn-primary btn-small" id="reg"/>
                <input type="reset" value="Nuevo" name="register" class="btn btn-warning btn-small"/>
              </div>
            </form>
            <br />

       <br /><br />
        </div>
        <div class="col-lg-7">            
            <span style="float: right;">Ver reporte en 
                <a target="_blank" href="../../../datos/clases/excel/ex_servicios.php"><img src="../../img/excel.png" width="40" /></a>&nbsp;&nbsp;&nbsp;
                <a target="_blank" href="../../../datos/clases/pdf/servicios.php"><img src="../../img/pdf.png" width="40" /></a></span>
            <br /><br /><br />           
            <div class="form-group">
            <div class="col-md-6">
                <input class="form-control" type="text" placeholder="Busca por nombre de servicio.." id="bs-prod"/>
            </div>
            </div><br /><br />
            <div class="registros" id="agrega-registros"></div>            
            <center>
                <ul class="pagination" id="pagination"></ul>
            </center>
     	</div>
	</div>
</div><br /><br /><br />