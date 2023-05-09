<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	include $conf['path_host'].'/miami/etiqueta/etiqueta_barcode.php';
    
    $id=$_GET['paquete'];
    $numero_piezas=$_GET['total'];
    $tracking_garve=$_GET['barcode'];

	barcode($tracking_garve);

	header("location: ".$conf['path_host_url']."/miami/etiqueta/etiqueta_pdf.php?paquete=$id&total=$numero_piezas");
?>

					
				