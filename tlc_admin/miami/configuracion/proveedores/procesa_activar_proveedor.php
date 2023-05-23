<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$id_proveedor=$_GET['id_proveedor'];

	$db->prepare("UPDATE data_proveedor SET status=1 where id_proveedor=:id_proveedor");
	$db->execute(array(':id_proveedor' => $id_proveedor));

	header("location: ".$conf['path_host_url']."/miami/configuracion/proveedores/proveedor.php");
?>