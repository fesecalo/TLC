<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';

	$id_usu=$_SESSION['id_usu'];

	$id_paquete=$_POST['id_paquete'];
	$id_estado=$_POST['id_estado'];
	$id_lugar=$_POST['id_lugar_enviar'];
	$cometario=$_POST['cometario'];

	if($id_estado==6 || $id_estado==16){
		$db->prepare("UPDATE paquete SET status=:status, envio_entregado=1, cancelado=0 WHERE id_paquete=:paquete");
		$db->execute(array(':status' => $id_estado, ':paquete' => $id_paquete));
	}elseif($id_estado==8 || $id_estado==9 || $id_estado==17){
		$db->prepare("UPDATE paquete SET status=:status, envio_entregado=0, cancelado=1 WHERE id_paquete=:paquete");
		$db->execute(array(':status' => $id_estado, ':paquete' => $id_paquete));
	}else{
		$db->prepare("UPDATE paquete SET status=:status, envio_entregado=0, cancelado=0 WHERE id_paquete=:paquete");
		$db->execute(array(':status' => $id_estado, ':paquete' => $id_paquete));
	}

	$db->prepare("INSERT INTO status_log SET
		id_paquete=:id,
		id_tipo_status=20,
		id_usuario=:usuario,
		id_lugar=5,
		visible_cliente=0,
		fecha=:fecha
	");
	$db->execute(array(
		':id' => $id_paquete,
		':usuario' => $id_usu,
		':fecha' => $fecha_actual
	));

	$db->prepare("INSERT INTO status_log SET
		id_paquete=:id,
		id_tipo_status=:id_tipo_status,
		id_usuario=:usuario,
		id_lugar=:id_lugar,
		visible_cliente=1,
		comentario=:comentario,
		fecha=:fecha
	");
	$db->execute(array(
		':id' => $id_paquete,
		':usuario' => $id_usu,
		':id_tipo_status' => $id_estado,
		':id_lugar' => $id_lugar,
		':comentario' => $cometario,
		':fecha' => $fecha_actual
	));
	
	header("location: editar_estado.php?id=$id_paquete");
?>