<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';
	
	$id_vuelo=$_GET['id_vuelo'];
	$codigo_vuelo=$_GET['codigo_vuelo'];

	//Actualizar el numero de valijas en vuelo
	$db->prepare("UPDATE vuelos SET codigo_vuelo=:codigo WHERE id_vuelos=:id");
	$db->execute(array(':id' => $id_vuelo, ':codigo' => $codigo_vuelo));
		

	header("location: ".$conf['path_host_url']."/miami/vuelos/editar_vuelo/editar_vuelo.php?vuelo=$id_vuelo");
		
?>