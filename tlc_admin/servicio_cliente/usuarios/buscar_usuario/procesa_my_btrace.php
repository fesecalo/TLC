<?php
	// se inicia sesion
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$id_cliente=$_GET['num_cliente'];

	// VARIABLES DE SESION CLIENTE MY GARVE
	$_SESSION['numero_cliente']=$id_cliente;
	// FIN VARIABLES DE SESION CLIENTE MY GARVE

	// DIRECCIONA A LA PAGINA PRINCIPAL
	header("location: ".$conf['path_host_url_my_btrace']."/tracking/tracking.php");
?>