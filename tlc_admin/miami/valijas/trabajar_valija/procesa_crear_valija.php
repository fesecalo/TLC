<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';
	
	$id_usu=$_SESSION['id_usu'];

	$db->prepare("INSERT INTO valijas SET fecha=:fecha_registro, id_usuario=:usuario ",true);
	$db->execute(array(':fecha_registro'=>$fecha_actual, ':usuario'=>$id_usu));

	// fin registro tabla log
    header("location: valijas.php");
?>