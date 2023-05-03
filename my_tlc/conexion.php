<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-my-tlc.php';
	$db_host=$conf['db_hostname'];
	$db_usuario=$conf['db_username'];
	$db_password=$conf['db_password'];
	$db_nombre=$conf['db_name'];

	$conexion = mysqli_connect($db_host, $db_usuario, $db_password, $db_nombre);
	mysqli_query($conexion ,"SET NAMES 'utf8'");
?>