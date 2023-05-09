<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';
	
	$id_usu=$_SESSION['id_usu'];
	$id_valija=$_GET['id_valija'];
	$id_vuelo=$_GET['id_vuelo'];

	//devolver la valija a estado anterior para meter en otro vuelo
	$db->prepare("UPDATE valijas SET id_vuelo=0, status_valija=1 WHERE id_valija=:id");
	$db->execute(array(':id' => $id_valija));

	// seleccionar todos los paquetes de la valija que tienen el id del vuelo
	$db->prepare("SELECT * FROM paquete WHERE id_valija=:id");
	$db->execute(array(':id' => $id_valija));
	$sql_paquete=$db->get_results();

	foreach ($sql_paquete as $key => $paquete) {

		//eliminar id_vuelo de los paquetes de la valija 
		$db->prepare("UPDATE paquete SET id_vuelo=0 WHERE id_valija=:id");
		$db->execute(array(':id' => $id_valija));

		//agregar estado embarque cancelado
		$db->prepare("INSERT INTO status_log SET
			id_paquete=:id,
			id_tipo_status=15,
			id_usuario=:usuario,
			id_lugar=3,
			visible_cliente=0,
			fecha=:fecha
		");
		$db->execute(array(
			':id' => $paquete->id_paquete,
			':usuario' => $id_usu,
			':fecha' => $fecha_actual
		));
	}

	// Selecciona el vuelo para restar una valija
	$db->prepare("SELECT * FROM vuelos WHERE id_vuelos=:id");
	$db->execute(array(':id' => $id_vuelo));
	$sql_vuelo=$db->get_results();

	$cantidad_valijas=$sql_vuelo[0]->cantidad_valijas;
	$cantidad_valijas=$cantidad_valijas-1;

	//Actualizar el numero de valijas en vuelo
	$db->prepare("UPDATE vuelos SET cantidad_valijas=:valijas WHERE id_vuelos=:id");
	$db->execute(array(':id' => $id_vuelo, ':valijas' => $cantidad_valijas));
		

	header("location: ".$conf['path_host_url']."/miami/vuelos/editar_vuelo/editar_vuelo.php?vuelo=$id_vuelo");
		
?>