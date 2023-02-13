<?php
    require_once ("../../../datos/db/connect.php");
    $solofecha = date('Y-m-d');
    $cc = new DBSTART;
    $db = $cc->abrirDB();    
    
    $abir = $db->prepare("SELECT * FROM c_empresa");
    $abir->execute();
    $count_abir = $abir->fetchAll(PDO::FETCH_BOTH);
    
    foreach((array) $count_abir as $aver) {
        $cajaabierta = $aver['caja_abierta'];
    }
    
    
    //  C O N F I G
    $admins = $db->prepare("SELECT DISTINCT(nombreitem), src_hu, icons FROM access p INNER join c_modulos_items m ON m.idcm = p.a_item
                                    WHERE p.a_perfil='$session_acceso' AND p.a_modulo='4' AND p.estado='A' ORDER BY m.idcm ASC");
    $admins->execute();
    $all_seg_count = $admins->rowCount();
    
    
        /***************************************************/
    // Evaluar que venta prosigue
    /***************************************************/
    
    $s = $db->prepare("SELECT MAX(num_secuencial_orden) as dato FROM c_secuencial");
    $s->execute();
    $all = $s->fetchAll(PDO::FETCH_ASSOC);

    foreach ($all as $key => $value) {
        $secuencial = $value['dato'];

        if($secuencial == 0 || $secuencial == ''){
            $nn = 1;
        }else{
            $nn = $secuencial + 1;
        }
    }
    
    /****************************************************/
        // FIN VENTA EVALUACI脫N
    /****************************************************/
    
    
    /****************************************************/
        // FIN VENTA EVALUACIÓN
    /****************************************************/
    
    // VERIFICAR ESTADO DE CAJA
      
      $stddb = $db->prepare("SELECT * FROM c_caja WHERE fecha='$solofecha'");
      $stddb->execute();
      $std_args = $stddb->fetchAll(PDO::FETCH_ASSOC);
      
      foreach((array) $std_args as $std_args_datos) {
        $disp = $std_args_datos['disponibilidad'];
      }
    
    if ($all_seg_count > 0 ) { ?>
        <li class="treeview"> <?php $rows = $admins->fetchAll(PDO::FETCH_ASSOC); ?>
          <a href="#">
            <i class="fa fa-cart-plus"></i>
            <span>Ventas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

                <?php if ($cajaabierta == 'NO' ){ ?>
            <li><a href="#" ><i class="fa fa-circle-o text-yellow"></i> Facturación <span style="float: right; color: red;">Caja Cerrada</span></a></li>
            
          <?php }
          
          
    
    if($cajaabierta  == 'SI' ){ ?>
    
    <li><a href="../ventas/ord.php?cid=<?php echo $nn ?>"><i class="fa fa-circle-o text-yellow"></i> Facturación</a></li>
    
    <?php } ?>  
                <li><a href="../in.php?cid=ventas/frm_ver_ventas"><i class="fa fa-circle-o text-yellow"></i> Historial Ventas</a></li>
                <li><a href="../in.php?cid=ventas/frm_ventas_anuladas"><i class="fa fa-circle-o text-yellow"></i> Historial Ventas Anuladas</a></li>
                <li><a href="../in.php?cid=ventas/frm_detalle"><i class="fa fa-circle-o text-yellow"></i> Detalles de Merma</a></li>
            </ul>
        </li>
    <?php } ?>