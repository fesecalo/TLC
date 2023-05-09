<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$id_direccion=$_GET['id_direccion'];

	$db->prepare("UPDATE data_direccion SET status=1 where id_direccion=:id_direccion");
	$db->execute(array(':id_direccion' => $id_direccion));

	header("location: ".$conf['path_host_url']."/administracion/direcciones/registro_direcciones.php");
?>