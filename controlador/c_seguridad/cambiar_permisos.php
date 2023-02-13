<?php
	require_once ("../../datos/db/connect.php");
	$env = new DBSTART;
	$db = $env->abrirDB();
    
if (isset($_POST['yeah'])) {
    
        // SEGURIDAD
		$emp      = $_POST['val_seguridad'];                // ITEM DEL MODULO
        $emp2     = $_POST['val_re_seguridad'];             // READ
        $edi      = $_POST['val_ed_seguridad'];             // EDIT
        $del1     = $_POST['val_de_seguridad'];             // DELETED
        $print    = $_POST['val_pi_seguridad'];             // PRINT
        
        // ADMINISTRACIÓN
        $emp_ad      = $_POST['val_ad'];
        $emp2_ad     = $_POST['val_re_ad'];
        $edi_ad      = $_POST['val_ed_ad'];
        $del1_ad     = $_POST['val_de_ad'];
        $print_ad    = $_POST['val_pi_ad'];

        // COMPRAS
        $emp_co      = $_POST['val_compras'];
        $emp2_co     = $_POST['val_re_compras'];
        $edi_co      = $_POST['val_ed_compras'];
        $del1_co     = $_POST['val_de_compras'];
        $print_co    = $_POST['val_pi_compras'];
        
        // VENTAS
        $emp_ve      = $_POST['val_ventas'];
        $emp2_ve     = $_POST['val_re_ventas'];
        $edi_ve      = $_POST['val_ed_ventas'];
        $del1_ve     = $_POST['val_de_ventas'];
        $print_ve    = $_POST['val_pi_ventas'];

        // INVENTARIO
        $emp_inv      = $_POST['val_inventario'];
        $emp2_inv     = $_POST['val_re_inventario'];
        $edi_inv      = $_POST['val_ed_inventario'];
        $del1_inv     = $_POST['val_de_inventario'];
        $print_inv    = $_POST['val_pi_inventario'];
        
        // CONTABILIDAD
        $emp_cot        = $_POST['val_contable'];
        $emp2_cot       = $_POST['val_re_contable'];
        $edi_cot        = $_POST['val_ed_contable'];
        $del1_cot       = $_POST['val_de_contable'];
        $print_cot      = $_POST['val_pi_contable'];
        
        // VEHICULOS
        $emp_veh        = $_POST['val_vehiculos'];
        $emp2_veh       = $_POST['val_re_vehiculos'];
        $edi_veh        = $_POST['val_ed_vehiculos'];
        $del1_veh       = $_POST['val_de_vehiculos'];
        $print_veh      = $_POST['val_pi_vehiculos'];
                
        // CONVENIOS
        $emp_conv        = $_POST['val_conv'];
        $emp2_conv       = $_POST['val_re_conv'];
        $edi_conv        = $_POST['val_ed_conv'];
        $del1_conv       = $_POST['val_de_conv'];
        $print_conv      = $_POST['val_pi_conv'];
        
        $perfil   = $_POST['id_perfil']; // PRINCIPAL

		// 1. Elimino los datos del usuarios
		$del = $db->prepare("DELETE FROM access WHERE a_perfil ='$perfil'");
		$del->execute();

		// 2. Lo inserto nuevamennte con esatdo I
		$insert = $db->prepare("INSERT INTO access (a_perfil, a_modulo, a_item, cs, sav, edi, del, pri, estado) VALUES
                                                   ('$perfil', 1, 		1,  	'I','I', 'I', 'I', 'I', 'I'),
                                                   ('$perfil', 1, 		2,  	'I','I', 'I', 'I', 'I', 'I'),
                                                   ('$perfil', 1, 		3,  	'I','I', 'I', 'I', 'I', 'I'),
                                                   
                                                   ('$perfil', 2, 		4,  	'I','I', 'I', 'I', 'I', 'I'),
                                                   ('$perfil', 2, 		5,  	'I','I', 'I', 'I', 'I', 'I'),
                                                   ('$perfil', 2, 		6,  	'I','I', 'I', 'I', 'I', 'I'),
                                                   ('$perfil', 2, 		7,  	'I','I', 'I', 'I', 'I', 'I'),
                                                   ('$perfil', 2, 		8,  	'I','I', 'I', 'I', 'I', 'I'),
                                                   ('$perfil', 2, 		9, 	    'I','I', 'I', 'I', 'I', 'I'),
                                                   ('$perfil', 2, 		22, 	'I','I', 'I', 'I', 'I', 'I'),
                                                   ('$perfil', 2, 		23, 	'I','I', 'I', 'I', 'I', 'I'),
                                                   ('$perfil', 2, 		29, 	'I','I', 'I', 'I', 'I', 'I'),
                                                   ('$perfil', 2, 		30, 	'I','I', 'I', 'I', 'I', 'I'),

                                                   ('$perfil', 3, 		10, 	'I','I', 'I', 'I', 'I', 'I'),
                                                   ('$perfil', 3, 		11, 	'I','I', 'I', 'I', 'I', 'I'),
                                                   ('$perfil', 3, 		12, 	'I','I', 'I', 'I', 'I', 'I'),
                                                   
                                                   ('$perfil', 4, 		13, 	'I','I', 'I', 'I', 'I', 'I'),
                                                   ('$perfil', 4, 		14, 	'I','I', 'I', 'I', 'I', 'I'),
                                                   ('$perfil', 4, 		15, 	'I','I', 'I', 'I', 'I', 'I'),
                                                   ('$perfil', 4, 		16, 	'I','I', 'I', 'I', 'I', 'I'),
                                                   
                                                   ('$perfil', 5, 		17, 	'I','I', 'I', 'I', 'I', 'I'),
                                                   
                                                   ('$perfil', 6, 		20, 	'I','I', 'I', 'I', 'I', 'I'),
                                                   ('$perfil', 6, 		21, 	'I','I', 'I', 'I', 'I', 'I'),
												   ('$perfil', 6, 		27, 	'I','I', 'I', 'I', 'I', 'I'),

												   ('$perfil', 7, 		24, 	'I','I', 'I', 'I', 'I', 'I'),
                                                   ('$perfil', 8, 		28, 	'I','I', 'I', 'I', 'I', 'I'),

                                                   ('$perfil', 4, 		31, 	'I','I', 'I', 'I', 'I', 'I'),
                                                   ('$perfil', 2, 		32, 	'I','I', 'I', 'I', 'I', 'I'),
                                                   ('$perfil', 2, 		33, 	'I','I', 'I', 'I', 'I', 'I'),
												   ('$perfil', 2, 		34, 	'I','I', 'I', 'I', 'I', 'I')


                                                   ");
		$insert->execute();
        
        /*************************************************
                    UPDATE PARA SEGURIDAD // 26/06/2019
        **************************************************/

		// 3. Lo actualizo solo con los elegidos
		foreach($emp as $datos){
			$stmt1 = $db->prepare("UPDATE access SET cs='A', estado='A' WHERE a_perfil='$perfil' AND a_modulo=1 AND a_item='$datos'");
			$stmt1->execute();
		}

		foreach($emp2 as $datos2){
			$stmt1 = $db->prepare("UPDATE access SET sav='A' WHERE a_perfil='$perfil' AND a_modulo=1 AND a_item='$datos2'");
			$stmt1->execute();
		}
        
        foreach($edi as $datos3){
			$stmt1 = $db->prepare("UPDATE access SET edi='A' WHERE a_perfil='$perfil' AND a_modulo=1 AND a_item='$datos3'");
			$stmt1->execute();
		}
        
        foreach($del1 as $datos4){
			$stmt1 = $db->prepare("UPDATE access SET del='A' WHERE a_perfil='$perfil' AND a_modulo=1 AND a_item='$datos4'");
			$stmt1->execute();
		}
        
        foreach($print as $datos5){
			$stmt1 = $db->prepare("UPDATE access SET pri='A' WHERE a_perfil='$perfil' AND a_modulo=1 AND a_item='$datos5'");
			$stmt1->execute();
		}
        
        /***************************************************
                    UPDATE PARA ADMINISTRACIÓN // 26/06/2019
        ****************************************************/

		// 3. Lo actualizo solo con los elegidos
		foreach($emp_ad as $datos_banks){
			$stmt2 = $db->prepare("UPDATE access SET cs='A', estado='A' WHERE a_perfil='$perfil' AND a_modulo=2 AND a_item='$datos_banks'");
			$stmt2->execute();
		}

		foreach($emp2_ad as $datos2_banks){
			$stmt2 = $db->prepare("UPDATE access SET sav='A' WHERE a_perfil='$perfil' AND a_modulo=2 AND a_item='$datos2_banks'");
			$stmt2->execute();
		}
        
        foreach($edi_ad as $datos3_banks){
			$stmt2 = $db->prepare("UPDATE access SET edi='A' WHERE a_perfil='$perfil' AND a_modulo=2 AND a_item='$datos3_banks'");
			$stmt2->execute();
		}
        
        foreach($del1_ad as $datos4_banks){
			$stmt2 = $db->prepare("UPDATE access SET del='A' WHERE a_perfil='$perfil' AND a_modulo=2 AND a_item='$datos4_banks'");
			$stmt2->execute();
		}
        
        foreach($print_ad as $datos5_banks){
			$stmt2 = $db->prepare("UPDATE access SET pri='A' WHERE a_perfil='$perfil' AND a_modulo=2 AND a_item='$datos5_banks'");
			$stmt2->execute();
		}
        
        /*********************************************
                    UPDATE PARA COMPRAS // 05/07/2019
        **********************************************/

		// 3. Lo actualizo solo con los elegidos
		foreach($emp_co as $datos_ope){
			$stmt = $db->prepare("UPDATE access SET cs='A', estado='A' WHERE a_perfil='$perfil' AND a_modulo=3 AND a_item='$datos_ope'");
			$stmt->execute();
		}

		foreach($emp2_co as $datos2_ope){
			$stmt2 = $db->prepare("UPDATE access SET sav='A' WHERE a_perfil='$perfil' AND a_modulo=3 AND a_item='$datos2_ope'");
			$stmt2->execute();
		}
        
        foreach($edi_co as $datos3_ope){
			$stmt2 = $db->prepare("UPDATE access SET edi='A' WHERE a_perfil='$perfil' AND a_modulo=3 AND a_item='$datos3_ope'");
			$stmt2->execute();
		}
        
        foreach($del1_co as $datos4_ope){
			$stmt2 = $db->prepare("UPDATE access SET del='A' WHERE a_perfil='$perfil' AND a_modulo=3 AND a_item='$datos4_ope'");
			$stmt2->execute();
		}
        
        foreach($print_co as $datos5_ope){
			$stmt2 = $db->prepare("UPDATE access SET pri='A' WHERE a_perfil='$perfil' AND a_modulo=3 AND a_item='$datos5_ope'");
			$stmt2->execute();
		}

		/*********************************************
                    UPDATE PARA VENTAS // 05/07/2019
        **********************************************/

		// 3. Lo actualizo solo con los elegidos
		foreach($emp_ve as $datos_ope){
			$stmt = $db->prepare("UPDATE access SET cs='A', estado='A' WHERE a_perfil='$perfil' AND a_modulo=4 AND a_item='$datos_ope'");
			$stmt->execute();
		}

		foreach($emp2_ve as $datos2_ope){
			$stmt2 = $db->prepare("UPDATE access SET sav='A' WHERE a_perfil='$perfil' AND a_modulo=4 AND a_item='$datos2_ope'");
			$stmt2->execute();
		}
        
        foreach($edi_ve as $datos3_ope){
			$stmt2 = $db->prepare("UPDATE access SET edi='A' WHERE a_perfil='$perfil' AND a_modulo=4 AND a_item='$datos3_ope'");
			$stmt2->execute();
		}
        
        foreach($del1_ve as $datos4_ope){
			$stmt2 = $db->prepare("UPDATE access SET del='A' WHERE a_perfil='$perfil' AND a_modulo=4 AND a_item='$datos4_ope'");
			$stmt2->execute();
		}
        
        foreach($print_ve as $datos5_ope){
			$stmt2 = $db->prepare("UPDATE access SET pri='A' WHERE a_perfil='$perfil' AND a_modulo=4 AND a_item='$datos5_ope'");
			$stmt2->execute();
		}

		/*********************************************
                    UPDATE PARA INVENTARIO // 05/07/2019
        **********************************************/

		// 3. Lo actualizo solo con los elegidos
		foreach($emp_inv as $datos_ope){
			$stmt = $db->prepare("UPDATE access SET cs='A', estado='A' WHERE a_perfil='$perfil' AND a_modulo=5 AND a_item='$datos_ope'");
			$stmt->execute();
		}

		foreach($emp2_inv as $datos2_ope){
			$stmt2 = $db->prepare("UPDATE access SET sav='A' WHERE a_perfil='$perfil' AND a_modulo=5 AND a_item='$datos2_ope'");
			$stmt2->execute();
		}
        
        foreach($edi_inv as $datos3_ope){
			$stmt2 = $db->prepare("UPDATE access SET edi='A' WHERE a_perfil='$perfil' AND a_modulo=5 AND a_item='$datos3_ope'");
			$stmt2->execute();
		}
        
        foreach($del1_inv as $datos4_ope){
			$stmt2 = $db->prepare("UPDATE access SET del='A' WHERE a_perfil='$perfil' AND a_modulo=5 AND a_item='$datos4_ope'");
			$stmt2->execute();
		}
        
        foreach($print_inv as $datos5_ope){
			$stmt2 = $db->prepare("UPDATE access SET pri='A' WHERE a_perfil='$perfil' AND a_modulo=5 AND a_item='$datos5_ope'");
			$stmt2->execute();
		}
        
        /*********************************************
                    UPDATE PARA CONTABLE // 28/12/2019
        **********************************************/

		// 3. Lo actualizo solo con los elegidos
		foreach($emp_cot as $datos_ope){
			$stmt = $db->prepare("UPDATE access SET cs='A', estado='A' WHERE a_perfil='$perfil' AND a_modulo=6 AND a_item='$datos_ope'");
			$stmt->execute();
		}

		foreach($emp2_cot as $datos2_ope){
			$stmt2 = $db->prepare("UPDATE access SET sav='A' WHERE a_perfil='$perfil' AND a_modulo=6 AND a_item='$datos2_ope'");
			$stmt2->execute();
		}
        
        foreach($edi_cot as $datos3_ope){
			$stmt2 = $db->prepare("UPDATE access SET edi='A' WHERE a_perfil='$perfil' AND a_modulo=6 AND a_item='$datos3_ope'");
			$stmt2->execute();
		}
        
        foreach($del1_cot as $datos4_ope){
			$stmt2 = $db->prepare("UPDATE access SET del='A' WHERE a_perfil='$perfil' AND a_modulo=6 AND a_item='$datos4_ope'");
			$stmt2->execute();
		}
        
        foreach($print_cot as $datos5_ope){
			$stmt2 = $db->prepare("UPDATE access SET pri='A' WHERE a_perfil='$perfil' AND a_modulo=6 AND a_item='$datos5_ope'");
			$stmt2->execute();
		}
		
		/*********************************************
                    UPDATE PARA VEHICULOS // 8/11/2021
        **********************************************/

		// 3. Lo actualizo solo con los elegidos
		foreach($emp_veh as $datos_ope){
			$stmt = $db->prepare("UPDATE access SET cs='A', estado='A' WHERE a_perfil='$perfil' AND a_modulo=7 AND a_item='$datos_ope'");
			$stmt->execute();
		}

		foreach($emp2_veh as $datos2_ope){
			$stmt2 = $db->prepare("UPDATE access SET sav='A' WHERE a_perfil='$perfil' AND a_modulo=7 AND a_item='$datos2_ope'");
			$stmt2->execute();
		}
        
        foreach($edi_veh as $datos3_ope){
			$stmt2 = $db->prepare("UPDATE access SET edi='A' WHERE a_perfil='$perfil' AND a_modulo=7 AND a_item='$datos3_ope'");
			$stmt2->execute();
		}
        
        foreach($del1_veh as $datos4_ope){
			$stmt2 = $db->prepare("UPDATE access SET del='A' WHERE a_perfil='$perfil' AND a_modulo=7 AND a_item='$datos4_ope'");
			$stmt2->execute();
		}
        
        foreach($print_veh as $datos5_ope){
			$stmt2 = $db->prepare("UPDATE access SET pri='A' WHERE a_perfil='$perfil' AND a_modulo=7 AND a_item='$datos5_ope'");
			$stmt2->execute();
		}
          
        
        /*********************************************
                    UPDATE PARA CONVENIOS // 8/11/2021
        **********************************************/

		// 3. Lo actualizo solo con los elegidos
		foreach($emp_conv as $datos_ope){
			$stmt = $db->prepare("UPDATE access SET cs='A', estado='A' WHERE a_perfil='$perfil' AND a_modulo=8 AND a_item='$datos_ope'");
			$stmt->execute();
		}

		foreach($emp2_conv as $datos2_ope){
			$stmt2 = $db->prepare("UPDATE access SET sav='A' WHERE a_perfil='$perfil' AND a_modulo=8 AND a_item='$datos2_ope'");
			$stmt2->execute();
		}
        
        foreach($edi_conv as $datos3_ope){
			$stmt2 = $db->prepare("UPDATE access SET edi='A' WHERE a_perfil='$perfil' AND a_modulo=8 AND a_item='$datos3_ope'");
			$stmt2->execute();
		}
        
        foreach($del1_conv as $datos4_ope){
			$stmt2 = $db->prepare("UPDATE access SET del='A' WHERE a_perfil='$perfil' AND a_modulo=8 AND a_item='$datos4_ope'");
			$stmt2->execute();
		}
        
        foreach($print_conv as $datos5_ope){
			$stmt2 = $db->prepare("UPDATE access SET pri='A' WHERE a_perfil='$perfil' AND a_modulo=8 AND a_item='$datos5_ope'");
			$stmt2->execute();
		}        
        header('Location: ../../init/app/seguridad/permisos.php?cid='.$perfil);
}