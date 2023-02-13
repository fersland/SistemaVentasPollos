<?php
  require_once ("../../../datos/db/connect.php");

  $sql = DBSTART::abrirDB()->prepare("SELECT * FROM c_mercaderia_lineas WHERE estado = 'A' ORDER BY id_linea DESC");
  $sql->execute();
  $all = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<?php foreach ($all as $key => $value): ?>	

<div class="list-group">
        <a href="#" class="list-group-item">
            <i class="fa fa-arrow-down"></i> <?php echo $value['nombrelinea'] ?>
            <span class="pull-right text-muted small"><em><?php echo $value['fecharegistro'] ?></em>
            </span>
        </a>
    </div>
<?php endforeach ?>