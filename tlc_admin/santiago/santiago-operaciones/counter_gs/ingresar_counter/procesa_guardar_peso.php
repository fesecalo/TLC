<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';

	$id_paquete=$_GET['id_paquete'];
	$peso=$_GET['peso'];
	$id_usu=$_SESSION['id_usu'];

	// selecciona el peso del paquete ingresado
	$db->prepare("SELECT peso FROM paquete WHERE id_paquete=:id ORDER BY id_paquete DESC LIMIT 1");
	$db->execute(array(':id' => $id_paquete));
	$sql_paquete=$db->get_results();

	$peso_old=$sql_paquete[0]->peso;
	// fin selecciona el peso del paquete ingresado

	// compara el peso registrado con el nuevo peso
	if ($peso_old==$peso) {
		header("location: counter_gs.php");
	}else{
		$db->prepare("UPDATE paquete SET peso=:peso WHERE id_paquete=:id");
		$db->execute(array(':id' => $id_paquete, ':peso' => $peso));

		$db->prepare("INSERT INTO status_log SET
			id_paquete=:id,
			id_tipo_status=14,
			id_usuario=:usuario,
			id_lugar= 5,
			visible_cliente=0,
			fecha=:fecha
		");
		
		$db->execute(array(
			':id' => $id_paquete,
			':usuario' => $id_usu,
			':fecha' => $fecha_actual
		));

		header("location: counter_gs.php");
	}
	// compara el peso registrado con el nuevo peso
?>