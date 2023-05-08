<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-my-tlc.php';
    require $conf['path_host'].'/EasyPDO/conexionPDO.php';
    require $conf['path_host'].'/include/include_sesion.php';
    require $conf['path_host'].'/funciones/fecha_actual.php';
	
	set_time_limit(0);

	$id=$_GET['idManifiesto'];
	$id_vuelo=$_GET['id_vuelo'];

	$db->prepare("UPDATE manifiesto SET eliminado=1 WHERE id_manifiesto=:id");
	$db->execute(array(':id' => $id));

	header("location: mostrar_archivo_manifiesto.php?vuelo=$id_vuelo");
?>