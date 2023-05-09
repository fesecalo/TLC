<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';
	
	$id_transaccion=$_GET['codigo'];
	$id=$_GET['id_paquete'];

	$db->prepare("UPDATE paquete SET id_transaccion=0 WHERE id_paquete=:id");
	$db->execute(array(':id' => $id));

	// selecciona los paquetes en la transaccion para obtener el total a pagar
	$db->prepare("SELECT 
		
		sum(cargo.total) AS subtotal,
		sum(cargo.aduana) AS total_aduana

		FROM paquete 
		LEFT JOIN gar_usuarios AS usuario ON usuario.id_usuario=paquete.id_usuario
		INNER JOIN cargos AS cargo ON cargo.id_cargo=paquete.id_cargo

		WHERE paquete.id_transaccion=:id_transaccion
		ORDER BY id_paquete DESC
	");
	$db->execute(array(':id_transaccion' => $id_transaccion));
	$resSub=$db->get_results();

	$subtotal=$resSub[0]->subtotal;
	$subtotalAduana=$resSub[0]->total_aduana;
	//  fin selecciona los paquetes en la transaccion para obtener el total a pagar

	// actualiza el numero de recibo y el total de la transaccion
	$db->prepare("UPDATE transaccion SET 
		total=:total,
		total_aduana=:total_aduana
		WHERE id_transaccion=:id_transaccion
	");
	$db->execute(array(
		':total' => $subtotal,
		':total_aduana' => $subtotalAduana,
		':id_transaccion' => $id_transaccion
	));
	// fin actualiza el numero de recibo y el total de la transaccion

	header("location: confirmar_entrega.php?codigo=$id_transaccion");
?>