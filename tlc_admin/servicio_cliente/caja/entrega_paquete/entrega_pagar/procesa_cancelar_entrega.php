<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';
	
	$codigo=$_GET['codigo'];

	$db->prepare("UPDATE paquete SET id_transaccion=0 WHERE id_transaccion=:id");
	$db->execute(array(':id' => $codigo));

	header("location: entregar_paquete.php");
?>