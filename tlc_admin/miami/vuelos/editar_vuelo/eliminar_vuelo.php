<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';

	$id_vuelo=$_GET['vuelo'];
	$id_usu=$_SESSION['id_usu'];

	$db->prepare("SELECT id_valija FROM valijas WHERE id_vuelo=:id_vuelo");
	$db->execute(array(':id_vuelo' => $id_vuelo));
	$resValija=$db->get_results();

	if (empty($resValija)) {
		$db->prepare("UPDATE vuelos SET 
			eliminado=1,
			usuario_eliminado=:usuario_eliminado,
			fecha_eliminado=:fecha_eliminado

			WHERE id_vuelos=:id_vuelo
		");
		$db->execute(array(
			':id_vuelo' => $id_vuelo,
			':usuario_eliminado' => $id_usu,
			':fecha_eliminado' => $fecha_actual
		));
	}else{
		foreach ($resValija as $key => $valija) {
			$db->prepare("UPDATE valijas SET id_vuelo=0, status_valija=1 WHERE id_valija=:id_paquete");
			$db->execute(array(':id_paquete' => $valija->id_valija));
		}

		$db->prepare("UPDATE vuelos SET 
			eliminado=1,
			usuario_eliminado=:usuario_eliminado,
			fecha_eliminado=:fecha_eliminado

			WHERE id_vuelos=:id_vuelo
		");
		$db->execute(array(
			':id_vuelo' => $id_vuelo,
			':usuario_eliminado' => $id_usu,
			':fecha_eliminado' => $fecha_actual
		));
	}
	

	header("location: ".$conf['path_host_url']."/miami/vuelos/editar_vuelo/editar_vuelo.php?vuelo=$id_vuelo");
?>