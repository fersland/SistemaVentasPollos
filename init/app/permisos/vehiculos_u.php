<?php    
    //  C O N F I G
    $admins = $db->prepare("SELECT DISTINCT(nombreitem), src_hu, icons FROM access p INNER join c_modulos_items m ON m.idcm = p.a_item
                                    WHERE p.a_perfil='$session_acceso' AND p.a_modulo='7' AND p.estado='A' ORDER BY m.idcm ASC");
    $admins->execute();
    $all_seg_count = $admins->rowCount();
    
    if ($all_seg_count > 0 ) { ?>
        <li class="treeview"> <?php $rows = $admins->fetchAll(PDO::FETCH_ASSOC); ?>
          <a href="#">
            <i class="fa fa-wrench"></i>
            <span>Veh&iacute;culos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                <?php foreach ((array) $rows as $values) { ?>
                <li><a href="<?php echo $values['src_hu'] ?>"><i class="fa fa-circle-o text-aqua"></i> <?php echo $values['nombreitem'] ?></a></li>
                <?php } ?>
          </ul>
        </li>
    <?php } ?>