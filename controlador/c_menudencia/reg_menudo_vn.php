<?php
	require_once ("../../datos/db/connect.php");

	$env = new DBSTART;
	$cc = $env->abrirDB();

    $nfact = htmlspecialchars($_POST['factura']);
    $cant_pollo = htmlspecialchars($_POST['five_pollo']);
    $cinco_pata = htmlspecialchars($_POST['five_pata']);
    $cinco_molleja = htmlspecialchars($_POST['five_molleja']);
    $cinco_higado = htmlspecialchars($_POST['five_higado']);

    $seis_pata = htmlspecialchars($_POST['six_pataTwo']);
    $seis_molleja = htmlspecialchars($_POST['six_mollejaTwo']);
    $seis_higado = htmlspecialchars($_POST['six_menudenciaTwo']);

    $ud_pata = htmlspecialchars($_POST['ud_pata']);
    $ud_molleja = htmlspecialchars($_POST['ud_molleja']);
    $ud_higado = htmlspecialchars($_POST['ud_menudo']);

    $sumapata = htmlspecialchars($_POST['suma1']);
    $sumamolleja = htmlspecialchars($_POST['suma2']);
    $sumahigado = htmlspecialchars($_POST['suma3']);
    $total = htmlspecialchars($_POST['total_menudo']);

   // $prov = htmlspecialchars($_POST['proveedor']);

    $args = $cc->prepare("INSERT INTO menudenciavn (nfactura, nnum, cero5cant, cero5pata, cero5molleja, cero5higado,
                                                cero6pata, cero6molleja, cero6higado,
                                                ceroudpata, ceroudmolleja, ceroudhigado, id_estado) VALUES 
                            ('$nfact', '$nfact', '$cant_pollo', '$cinco_pata', '$cinco_molleja', '$cinco_higado',
                                '$seis_pata', '$seis_molleja', '$seis_higado',
                                '$ud_pata', '$ud_molleja', '$ud_higado', 1)");
    if ($args->execute()) {
        //  A MENU

        $menu = $cc->prepare("INSERT INTO menuvn (nfactura, nnum, sumapata, sumamolleja, sumahigado, sumakg, id_estado) VALUES 
                                                ('$nfact', '$nfact', '$sumapata', '$sumamolleja', '$sumahigado', '$total', 1)");
        $menu->execute();

        echo '<div class="alert alert-success">Guardo con exito!</div>';
    }else{
        echo '<div class="alert alert-danger">Error al guardar!</div>';
    }