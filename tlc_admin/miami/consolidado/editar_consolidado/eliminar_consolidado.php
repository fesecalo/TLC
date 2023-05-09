<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';

	$id_consolidado=$_GET['id_consolidado'];
	$id_usu=$_SESSION['id_usu'];

	$db->prepare("SELECT id_paquete FROM paquete WHERE id_consolidado=:id_consolidado");
	$db->execute(array(':id_consolidado' => $id_consolidado));
	$resPaquete=$db->get_results();

	if (empty($resPaquete)) {
		$db->prepare("UPDATE consolidado SET 
			eliminado=1,
			usuario_eliminado=:usuario_eliminado,
			fecha_eliminado=:fecha_eliminado

			WHERE id_consolidado=:id_consolidado
		");
		$db->execute(array(
			':id_consolidado' => $id_consolidado,
			':usuario_eliminado' => $id_usu,
			':fecha_eliminado' => $fecha_actual
		));
	}else{
		foreach ($resPaquete as $key => $paquete) {
			$db->prepare("UPDATE paquete SET id_consolidado=0 WHERE id_paquete=:id_paquete");
			$db->execute(array(':id_paquete' => $paquete->id_paquete));
		}

		$db->prepare("UPDATE consolidado SET 
			eliminado=1,
			usuario_eliminado=:usuario_eliminado,
			fecha_eliminado=:fecha_eliminado

			WHERE id_consolidado=:id_consolidado
		");
		$db->execute(array(
			':id_consolidado' => $id_consolidado,
			':usuario_eliminado' => $id_usu,
			':fecha_eliminado' => $fecha_actual
		));
	}

	header("location: editar_consolidado.php?id_consolidado=$id_consolidado");
?>