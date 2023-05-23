<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';
	
	$id=$_POST['id_paquete'];
	$id_estado=$_POST['estado'];
	$id_usu=$_SESSION['id_usu'];

	$db->prepare("SELECT * FROM paquete WHERE id_paquete=:id AND envio_entregado=0 AND cancelado=0 ORDER BY id_paquete LIMIT 1");
	$db->execute(array(':id' => $id));
	$sql_paquete=$db->get_results();

	if (empty($sql_paquete)) {
		die("No existen paquetes con este codigo o ya fue procesado");
	}else{
		foreach ($sql_paquete as $key => $paquete) {
			$id_paquete=$paquete->id_paquete;

			$db->prepare("UPDATE paquete SET status=:estado WHERE id_paquete=:id",true);
			$db->execute(array(':id' => $id_paquete, ':estado' => $id_estado));

			$db->prepare("INSERT INTO status_log SET
				id_paquete=:id,
				id_tipo_status=:estado,
				id_usuario=:usuario,
				id_lugar='4',
				fecha=:fecha
			",true);
			$db->execute(
				array(
					':id' => $id_paquete,
					':estado' => $id_estado,
					':usuario' => $id_usu,
					':fecha' => $fecha_actual
			));
		}
	}

	header("location: ver_paquete.php?id_paquete=$id");
?>