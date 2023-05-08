<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-my-tlc.php';
	require $conf['path_host'].'/include/include_sesion.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';

	$id_usu=$_SESSION['numero_cliente'];

	$id=$_GET['id_paquete'];

	$db->prepare("UPDATE paquete SET cancelado=1, status=8 WHERE id_paquete=:id ",true);
	$db->execute(array(':id'=>$id));

	$db->prepare("INSERT INTO status_log SET
		id_paquete=:id,
		id_tipo_status='8',
		id_usuario=:usuario,
		id_lugar='1',
		fecha=:fecha
	",true);
	$db->execute(
		array(
			':id' => $id,
			':usuario' => $id_usu,
			':fecha' => $fecha_actual
	));

	// fin registro tabla log
    header("location: tracking.php");
?>