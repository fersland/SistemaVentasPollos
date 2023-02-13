<?php 

	if (isset($_POST['cid'])) {
		$param = $_POST['cid'];
		
		header('Location: permisos.php?cid='.$param);
		/*echo '<script type="text/javascript">
                        window.location.href = "permisos.php?cid="'.$param.';
                    </script>';*/
	}