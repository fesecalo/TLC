<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';
	
	$id_usu=$_SESSION['id_usu'];

    //var_dump("INSERT INTO vuelos SET fecha_creacion='".$fecha_actual."', id_usuario_creacion='".$id_usu."'");die();


	$db->prepare("INSERT INTO vuelos SET fecha_creacion=:fecha_registro, id_usuario_creacion=:usuario, nombre_archivo='' ",true);
	$db->execute(array(':fecha_registro'=>$fecha_actual, ':usuario'=>$id_usu));

	// fin registro tabla log
    header("location: vuelos.php");
?>