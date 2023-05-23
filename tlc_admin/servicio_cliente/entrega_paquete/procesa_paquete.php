<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';
	
	$id=$_POST['id_paquete'];
	$forma_pago=$_POST['forma_pago'];
	$id_usu=$_SESSION['id_usu'];

	$db->prepare("UPDATE paquete SET status=6, envio_entregado=1, forma_pago=:pago WHERE id_paquete=:id");
	$db->execute(array(':id' => $id, ':pago' => $forma_pago));

	$db->prepare("INSERT INTO status_log SET
		id_paquete=:id,
		id_tipo_status=6,
		id_usuario=:usuario,
		id_lugar=5,
		fecha=:fecha
	",true);
	$db->execute(
		array(
			':id' => $id,
			':usuario' => $id_usu,
			':fecha' => $fecha_actual
	));

	header("location: mostrar_paquete.php?id=$id&msg=1");
?>