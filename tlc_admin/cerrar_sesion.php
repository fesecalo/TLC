<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/funciones/fecha_actual.php';

	session_start();
	$fecha_actual=date("Y-m-d H:i:s",strtotime('-5 minute',strtotime($fecha_actual)));
	$id_usu=$_SESSION['id_usu'];

	// REGISTRO EN LA TABLA LOG DEL SISTEMA
	$db->prepare("INSERT INTO log SET 
		id_usuario=:usuario,
		accion=:accion,
		fecha=:fecha
	");

	$db->execute(array(
		':usuario' => $id_usu,
		':accion' => 'termino_sesion',
		':fecha' => $fecha_actual
	));
	// FIN REGISTRO TABLA LOG

	// ACTUALIZACION TABLA SESIONES ACTIVAS
	$db->prepare("UPDATE sesion SET ultima_sesion=:fecha WHERE id_usuario=:id ");
	$db->execute(array(
		':id' => $id_usu,
		':fecha' => $fecha_actual
	));
	// FIN ACTUALIZACION TABLA SESIONES ACTIVAS

	// REGISTRO ULTIMO INICIO DE SESION DEL USUARIO
	$db->prepare("UPDATE gar_usuarios SET ultima_sesion=:fecha WHERE id_usuario=:id ");
	$db->execute(array(
		':id' => $id_usu,
		':fecha' => $fecha_actual
	));
	// FIN REGISTRO ULTIMO INICIO DE SESION DEL USUARIO

	session_destroy(); 

	header("location: index.php")
?>