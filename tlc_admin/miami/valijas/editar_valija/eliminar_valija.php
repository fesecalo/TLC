<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';

	$id_valija=$_GET['valija'];
	$id_usu=$_SESSION['id_usu'];

	$db->prepare("SELECT id_paquete FROM paquete WHERE id_valija=:id_valija");
	$db->execute(array(':id_valija' => $id_valija));
	$resPaquete=$db->get_results();

	if (empty($resPaquete)) {
		$db->prepare("UPDATE valijas SET 
			eliminado=1,
			usuario_eliminado=:usuario_eliminado,
			fecha_eliminado=:fecha_eliminado

			WHERE id_valija=:id_valija
		");
		$db->execute(array(
			':id_valija' => $id_valija,
			':usuario_eliminado' => $id_usu,
			':fecha_eliminado' => $fecha_actual
		));
	}else{
		foreach ($resPaquete as $key => $paquete) {
			$db->prepare("UPDATE paquete SET id_valija=0 WHERE id_paquete=:id_paquete");
			$db->execute(array(':id_paquete' => $paquete->id_paquete));
		}

		$db->prepare("UPDATE valijas SET 
			eliminado=1,
			usuario_eliminado=:usuario_eliminado,
			fecha_eliminado=:fecha_eliminado

			WHERE id_valija=:id_valija
		");
		$db->execute(array(
			':id_valija' => $id_valija,
			':usuario_eliminado' => $id_usu,
			':fecha_eliminado' => $fecha_actual
		));
	}
	

	header("location: ".$conf['path_host_url']."/miami/valijas/editar_valija/editar_valija.php?valija=$id_valija");
?>