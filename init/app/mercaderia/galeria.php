<?php
    session_start();
    if(isset($_SESSION["correo"]))  {
	require_once ("../head_unico.php");
	require_once ("../../../../datos/db/connect.php");
    
    $empresa = $_SESSION['id_empresa'];

	$sql2 = DBSTART::abrirDB()->prepare("SELECT * FROM c_mercaderia WHERE id_empresa = '$empresa' AND estado = 'A'");
    $sql2->execute();
    $rows2 = $sql2->fetchAll(PDO::FETCH_ASSOC);
?>

<div id="page-wrapper">
	<div class="row">
        <div class="col-lg-12">
            <div class="alert alert-danger" style="margin-top: 10px; height: 50px">
              <p style="float:left"><strong>Galeria de Imágenes</strong></p>
              
            </div>
        </div>
    </div>


  <div class="row">
    <div class="col-lg-12">
            
      <?php foreach ($rows2 as $key => $values): ?>
        
            <div class='col-sm-3 col-xs-3 col-md-3 col-lg-3' style="width:15%; height:100px; padding: 5px; border: 3px solid lightgray; margin-right: 10px; ">
                <a class="thumbnail fancybox" rel="ligthbox" href="results.php?cid=<?php echo $values['codproducto'] ?>">
                    <img  
                    class="img-responsive" alt="" src="../../../img/<?php echo $values['ruta'] ?>"/ style="width:50px; height: 50px">
                    <div class='text-right'>
                        <small class='text-muted'><?php echo $values['nombreproducto'] ?></small>
                        (<small class='text-muted'><?php echo $values['existencia'] ?></small>)
                    </div>
                </a>
            </div>

      <?php endforeach ?>
    </div></div>

</div>
<?php 

require_once ("../foot_unico.php");

}else{
    session_unset();
    session_destroy();
    header('Location:  ../../../../index.php');
}
?>