<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';
	
	set_time_limit(0);

	$id=$_GET['id_vuelo'];
	$id_usu=$_SESSION['id_usu'];

	$db->prepare("SELECT 
		id_paquete

		FROM paquete

		WHERE id_vuelo=:id 
		AND en_aeropuerto=0 
		AND envio_entregado=0 
		AND cancelado=0 
		ORDER BY id_paquete DESC
	");

	$db->execute(array(':id' => $id));
	$sql_paquete=$db->get_results();

	if (empty($sql_paquete)) {
		die("Los paquetes de este vuelo ya se encuentran confirmados");
	}else{
		foreach ($sql_paquete as $key => $paquete) {
			$id_paquete=$paquete->id_paquete;

			$db->prepare("UPDATE paquete SET status=4, en_aeropuerto=1 WHERE id_paquete=:id");
			$db->execute(array(':id' => $id_paquete));

			$db->prepare("INSERT INTO status_log SET
				id_paquete=:id,
				id_tipo_status=4,
				id_usuario=:usuario,
				id_lugar=4,
				fecha=:fecha
			");
			$db->execute(array(
				':id' => $id_paquete,
				':usuario' => $id_usu,
				':fecha' => $fecha_actual
			));
		}
	}

	//vuelo confirmado en chile
	$db->prepare("UPDATE vuelos SET id_status_vuelo=1 WHERE id_vuelos=:id");
	$db->execute(array(':id' => $id));

	header("location: mostrar_archivo_manifiesto.php?vuelo=$id");
?>