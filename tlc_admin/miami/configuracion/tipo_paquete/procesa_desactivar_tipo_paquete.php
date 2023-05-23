<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$id_tipo_paquete=$_GET['id_tipo_paquete'];

	$db->prepare("UPDATE data_tipo_paquete SET status=0 where id_tipo_paquete=:id_tipo_paquete");
	$db->execute(array(':id_tipo_paquete' => $id_tipo_paquete));

	header("location: ".$conf['path_host_url']."/miami/configuracion/tipo_paquete/tipo_paquete.php");
?>

					
				