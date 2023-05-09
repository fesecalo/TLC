<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';
	require $conf['path_host'].'/funciones/enviar_correo.php';

	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';
	
	$id_recibo=$_POST['id_recibo'];
	$numero_recibo=$_POST['numero_recibo'];
	$email=$_POST['email'];

	// $numero_recibo='GS1016';
	// $email='axel.lanas@hotmail.cl';

	enviarCorreoAdjunto($email,'Detalle de entrega TLC Courier','Archivo adjunto en formato PDF con detalle de los paquetes entregados.',$conf['path_files_comprobante'].'/',$numero_recibo.'.pdf');

	header("location: detalle_entrega.php?num_recibo=$id_recibo&msj=1");
?>