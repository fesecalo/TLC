<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';
	
	$id_usu=$_SESSION['id_usu'];
	$id_vuelo=$_GET['vuelo'];
	$codigo_vuelo=$_GET['codigo'];

	$db->prepare("SELECT id_paquete FROM paquete WHERE id_vuelo=:id");
	$db->execute(array(':id' => $id_vuelo));
	$sql_paquete=$db->get_results();

	foreach ($sql_paquete as $key => $paquete) {
		$db->prepare("INSERT INTO status_log SET
			id_paquete=:id,
			id_tipo_status=3,
			id_usuario=:usuario,
			id_lugar=3,
			visible_cliente=1,
			fecha=:fecha
		",true);
		$db->execute(
			array(
				':id' => $paquete->id_paquete,
				':usuario' => $id_usu,
				':fecha' => $fecha_actual
		));
	}

	// ststua vuelo 3 = a vuelo cerrado y en espera de envio a santiago
	$db->prepare("UPDATE vuelos SET id_status_vuelo=2, fecha_salida=:fecha WHERE id_vuelos=:id");
	$db->execute(array(':id' => $id_vuelo, ':fecha' => $fecha_actual));

	header("location: ".$conf['path_host_url']."/miami/vuelos/buscar_vuelo/ver_vuelo.php?vuelo=$id_vuelo&codigo=$codigo_vuelo");
		
?>