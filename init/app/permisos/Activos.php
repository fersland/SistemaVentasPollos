<?php
    require_once ("../../datos/db/connect.php");
    
    $cc = new DBSTART;
    $db = $cc->abrirDB();
    $empresa = $_SESSION['id_empresa'];
    $cid = $_SESSION['correo'];
    
    //  S E G U R I D A D
    $seguridad = $db->prepare("SELECT * FROM c_modulos_items WHERE id_empresa='$empresa' AND nivelacceso='$cid' 
                                        AND idmodulo='3' AND estado='ACTIVO'");
    $seguridad->execute();
    $all_seg_count = $seguridad->rowCount();
    
    if ($all_seg_count > 0 ) { ?>
       <li>
            <a href="#"><i class="fa fa-sign-out"></i> Activos Fijos<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="?cid=activos/frm_activos"><i class="fa fa-sign-out"></i> Ingreso de Activos</a></li>
                </ul>
       </li>
    <?php } ?>