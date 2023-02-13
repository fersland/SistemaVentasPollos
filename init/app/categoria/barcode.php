<?php 

	//$db = new PDO('mysql:host=localhost;dbname=pruebas_barcode','root',''); ?>

<html>
<head>
<style>
p.inline {display: inline-block;}
span { font-size: 13px;}
</style>
<style type="text/css" media="print">
    @page 
    {
        size: auto;   /* auto is the initial value */
        margin: 0mm;  /* this affects the margin in the printer settings */

    }
</style>
</head>
<body onload="window.print();">
	<div style="margin-left: 5%">
		<?php
		require_once ('./'."../../../datos/db/connect.php");

    $cc = new DBSTART;

    $db = $cc->abrirDB();
		include 'barcode128.php';

		$stmt = $db->prepare("SELECT * FROM c_categoria");
		$stmt->execute();
		$all = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$count = $stmt->rowCount();

		foreach ($all as $key => $value) {
			$id = $value['id_categoria'];
			$nombre = $value['nombre'];
			$codigo = $value['nombre'];

			echo "<p class='inline'><span ><b>Item: $nombre </b></span>".bar128(stripcslashes($codigo))."<span ><span></p>&nbsp&nbsp&nbsp&nbsp";
		
		}

		

		?>
	</div>
</body>
</html>