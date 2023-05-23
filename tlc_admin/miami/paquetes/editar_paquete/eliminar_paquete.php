<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';

	$id_paquete=$_GET['id_paquete'];
	$id_usu=$_SESSION['id_usu'];

	$db->prepare("UPDATE paquete SET eliminado=1 where id_paquete=:id_paquete");
	$db->execute(array(':id_paquete' => $id_paquete));

	$db->prepare("INSERT INTO status_log SET
				id_paquete=:id,
				id_tipo_status=21,
				id_usuario=:usuario,
				id_lugar=2,
				visible_cliente=0,
				fecha=:fecha
			");
			$db->execute(
				array(
					':id' => $id_paquete,
					':usuario' => $id_usu,
					':fecha' => $fecha_actual
			));

	header("location: ".$conf['path_host_url']."/miami/paquetes/editar_paquete/editar_paquete.php?paquete=$id_paquete");
?>